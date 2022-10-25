<?php


use ValueAuth\Adapter;
use ValueAuth\ApiClient;
use ValueAuth\ApiResult\ApiError;
use ValueAuth\Enum\AccessTokenRole;

require_once( 'ValueAuthSetting.php' );
require_once( 'ValueAuthUser.php' );
require_once( 'VA_Flash.php' );


class ValueAuthAdapter {
	const ApiUrl = "https://api.valueauth.jp";
	const AuthTokenCookieName = 'vauth-2fa-auth-token';
	const AccessTokenCookieName = 'vauth-auth-access-token';

	/**
	 * @var ApiClient
	 */
	protected $accessToken;
	protected $adapter;
	protected $apiVersion = "v2";
	protected $debug = false;

	function __construct() {

		add_action( 'admin_menu', [ $this, "addAdminMenu" ] );
		add_action( 'admin_post_va_enable', [ $this, 'enable' ] );
		add_action( 'admin_post_va_disable', [ $this, 'disable' ] );
		add_action( 'admin_post_va_update_api_key', [ $this, 'updateApiKey' ] );


		if ( ValueAuthSetting::verified() ) {
			$this->adapter = new \ValueAuth\Adapter( ValueAuthSetting::apiKey(), ValueAuthSetting::authCode(), ValueAuthSetting::publicKey(), self::ApiUrl, $this->apiVersion, $this->debug );
			$this->adapter->initializeApiClient();
			remove_action( 'authenticate', 'wp_authenticate_username_password', 20 );
			remove_action( 'authenticate', 'wp_authenticate_email_password', 20 );
			add_action( 'authenticate', [ $this, 'checkLoginAvailability' ], 10, 3 );
			add_action( 'login_errors', [ $this, 'loginError' ] );
			add_action( 'wp_login_failed', [ $this, 'handle2FARedirect' ] );
			add_action( 'init', [ $this, 'customRedirects' ] );
		}

		add_action( 'wp_logout', [ $this, 'clear2FAAuthToken' ] );
		VA_Flash::initialize();

		add_action( 'wp_enqueue_scripts', [$this, 'my_va_front_scripts']);
		add_action( 'admin_enqueue_scripts', [$this, 'my_va_admin_scripts']);
		add_action( 'init', [ $this, 'rewriteRule' ], 10, 0 );

	}

	function clear2FAAuthToken() {
		setcookie( self::AuthTokenCookieName, null );
	}

	function my_va_front_scripts(){
		wp_enqueue_style( 'vauth-style', plugins_url( 'public/css/style.css', __FILE__ ) );
		wp_enqueue_script( 'vauth-code-input', plugins_url( 'public/dist/js/codeInput.js', __FILE__ ) );
	}

	function my_va_admin_scripts(){
		wp_enqueue_style( 'vauth-style', plugins_url( 'public/css/style.css', __FILE__ ) );
		wp_enqueue_script( 'vauth-management-console', plugins_url( 'public/dist/js/managementConsole.js', __FILE__ ) );
	}

	function customRedirects() {
		if ( isset( $_GET['vauth_2fa_input'] ) ) {
			$this->codeInputView();
		} else if ( isset( $_GET['vauth_2fa_submit'] ) ) {
			$this->handle2FASubmit();
			die;
		}

	}

	function has_prefix($string, $prefix) {
		return substr($string, 0, strlen($prefix)) == $prefix;
	}

	function rewriteRule() {
		if (isset($_GET['page']) && $this->has_prefix($_GET['page'], 'vauth_twofactor_admin/')){
			wp_redirect(admin_url('admin.php?page=vauth_twofactor_admin'));
			die;
		}
	}

	function addAdminMenu() {
		$wpUser = wp_get_current_user();

		add_menu_page( 'vauth_twofactor', 'ValueAuth', 'read', "vauth_twofactor", [
			$this,
			'edit2FASetting'
		], 'dashicons-lock' );
		if ( in_array( 'administrator', $wpUser->roles ) ) {
			add_submenu_page( 'vauth_twofactor', 'vauth_twofactor_admin', '認証設定', 'read', 'vauth_setting',
				[ $this, 'editApiKey' ] );
		}
		add_submenu_page( 'vauth_twofactor', 'vauth_twofactor_admin', '2段階認証', 'read', 'vauth_twofactor_setting',
			[ $this, 'edit2FASetting' ] );
		add_submenu_page( 'vauth_twofactor', 'vauth_twofactor_admin', 'ログインの管理', 'read', 'vauth_twofactor_admin',
			[ $this, 'managementConsole' ] );
		remove_submenu_page( 'vauth_twofactor', 'vauth_twofactor' );

		add_menu_page( 'vauth_twofactor_input', 'vauth_twofactor', 'read', 'vauth_twofactor_input', [
			$this,
			'inputTwofactor'
		] );

		remove_menu_page( 'vauth_twofactor_input' );
	}

	function edit2FASetting() {
		$this->addStylesheet();
		$verified = ValueAuthSetting::verified();
		$enabled  = $this->vaUser()->is2FAEnabled();
		require_once __DIR__ . '/elements/views/2fa_setting.php';
	}

	function vaUser() {
		$wpUser = wp_get_current_user();
		$vaUser = ValueAuthUser::findOrCreate( $wpUser->ID );

		return $vaUser;
	}

	function editApiKey( $authCode = null, $apiKey = null, $publicKey = null ) {
		if ( $this->administratorGuard() ) {
			return;
		}
		$this->addStylesheet();
		$authCode  = empty( $authCode ) ? ValueAuthSetting::authCode() : $authCode;
		$apiKey    = empty( $apiKey ) ? ValueAuthSetting::apiKey() : $authCode;
		$publicKey = empty( $publicKey ) ? ValueAuthSetting::publicKey() : $publicKey;
		require_once __DIR__ . '/elements/views/api_key_setting.php';
	}

	function administratorGuard() {
		$user = wp_get_current_user();
		if ( ! in_array( 'administrator', $user->roles ) ) {
			VA_Flash::addFlashNotice( "権限がありません。", "error", true );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			return true;
		} else {
			return false;
		}
	}


	function updateApiKey() {
		if ( $this->administratorGuard() ) {
			return;
		}
		$apiKey    = sanitize_textarea_field($_POST['api_key']);
		$authCode  = sanitize_text_field($_POST['auth_code']);
		$publicKey = sanitize_textarea_field($_POST['public_key']);
		$publicKey = str_replace("\r\n","\n",$publicKey)."\n";
		if(empty($apiKey) || empty($authCode) || empty($publicKey)){
			VA_Flash::addFlashNotice( "全ての認証情報の入力が必要です。", "error", true );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
			die;
		}
		$verified  = Adapter::checkCredentials( self::ApiUrl, $apiKey, $authCode,$publicKey, $this->apiVersion, $this->debug );
		if ( $verified ) {
			ValueAuthSetting::setApiKey( $apiKey );
			ValueAuthSetting::setAuthCode( $authCode );
			ValueAuthSetting::setPublicKey( $publicKey );
			ValueAuthSetting::setVerified( true );
			VA_Flash::addFlashNotice( "サイト情報が検証できました。", "info", true );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
		} else {
			ValueAuthSetting::setVerified( false );
			VA_Flash::addFlashNotice( "サイト情報が正しくありません。", "error", true );
			wp_redirect( $_SERVER['HTTP_REFERER'] );
		}
	}

	function enable() {
		$this->vaUser()->enable2FA();
		wp_redirect( $_SERVER['HTTP_REFERER'] );
	}

	function disable() {
		$this->vaUser()->disable2FA();
		wp_redirect( $_SERVER['HTTP_REFERER'] );
	}

	function managementConsole() {
		$accessToken = null;
		$verified    = ValueAuthSetting::verified();
		if ( $verified ) {
			$result = $this->adapter->fetchAccessToken( wp_get_current_user()->ID, AccessTokenRole::Api );
			if ( $result instanceof ApiError ) {
				VA_Flash::addFlashNotice( "APIエラーが発生しました。" , "error", true );
				wp_redirect( $_SERVER['HTTP_REFERER'] );
				die;
			} else {
				$accessToken = $result->results->access_token;
			}
		}
		wp_enqueue_script( 'vauth-management-console' );
		$apiUrl = self::ApiUrl;
		require_once __DIR__ . '/elements/views/management_console.php';
	}

	function handle2FARedirect() {
		if ( $this->accessToken ) {
			wp_redirect( home_url( '?vauth_2fa_input' ) );
			die;
		}
	}

	function handle2FASubmit() {
		$_2FAAuthToken = sanitize_text_field($_COOKIE[ self::AuthTokenCookieName ]);
		$this->clearAuthAccessToken();
		if ( $_2FAAuthToken ) {
			$customerKey = Adapter::extractCustomerKey( $_2FAAuthToken );
			$lastLogin   = new  DateTime( ValueAuthUser::find( $customerKey )->last_login );
			list( $verified, $customerKey ) = $this->adapter->verifyAuthToken( $_2FAAuthToken, $lastLogin );
			if ( ! $verified ) {
				wp_safe_redirect( wp_login_url() );
			} else {
				wp_clear_auth_cookie();
				wp_set_current_user( $customerKey );
				wp_set_auth_cookie( $customerKey );
				wp_safe_redirect( user_admin_url() );
			}
		} else {
			wp_safe_redirect( wp_login_url() );
		}
	}

	function codeInputView() {
		$accessToken = sanitize_textarea_field($_COOKIE[ self::AccessTokenCookieName ]);
		if ( !$accessToken ) {
			wp_safe_redirect( wp_login_url() );
		}

		wp_enqueue_script( 'vauth-code-input' );
		add_filter('template_include', function() use($accessToken){
			$verified = ValueAuthSetting::verified();
			$apiUrl   = self::ApiUrl;
			$redirect = home_url( '?vauth_2fa_submit' );
			wp_head().require_once (__DIR__ . '/elements/views/code_input.php');
		}, 99);
	}

	function addStylesheet() {
		wp_enqueue_style( 'vauth-style' );
	}

	static function install() {
		global $va_db_version;
		ValueAuthSetting::install();
		ValueAuthUser::install();
		add_option( 'va_db_version', $va_db_version );
	}

	static function uninstall() {
		ValueAuthSetting::uninstall();
		ValueAuthUser::uninstall();
		delete_option( 'va_db_version' );
	}

	function clearAuthAccessToken() {
		setcookie( self::AccessTokenCookieName, null );
	}

	function checkLoginAvailability( $user, $username, $password ) {
		if ( empty( $username ) || empty( $password ) ) {
			if ( is_wp_error( $user ) ) {
				$this->clearAuthAccessToken();

				return $user;
			}

			$error = new WP_Error();

			if ( empty( $username ) ) {
				$error->add( 'empty_username', __( '<strong>Error</strong>: The username field is empty.' ) );
			}

			if ( empty( $password ) ) {
				$error->add( 'empty_password', __( '<strong>Error</strong>: The password field is empty.' ) );
			}
			$this->clearAuthAccessToken();

			return $error;
		}

		$wpUser = get_user_by( 'login', $username );
		if ( ! $wpUser ) {
			$this->adapter->postCheckLogin( null );
			$this->clearAuthAccessToken();

			return new WP_Error(
				'invalid_username',
				__( 'Unknown username. Check again or try your email address.' )
			);
		}

		$user = apply_filters( 'wp_authenticate_user', $user, $password );
		if ( is_wp_error( $user ) ) {
			$this->clearAuthAccessToken();

			return $user;
		}
		$customerKey = $wpUser->ID ?? null;
		$result      = $this->adapter->postCheckLogin( $customerKey );
		if ( $result instanceof ApiError ) {
			$this->clearAuthAccessToken();

			return new WP_Error(
				'invalid_configuration',
				__( 'Falied to check login availability' )
			);
		}
		$loginKey = $result->results->login_key;
		$loggedIn = wp_check_password( $password, $wpUser->user_pass, $wpUser->ID );
		$result   = $this->adapter->postLoginLog( $loggedIn, $loginKey, $customerKey );
		if ( $result instanceof ApiError ) {
			$this->clearAuthAccessToken();

			return $wpUser;
		}
		if ( ! $loggedIn ) {
			$this->clearAuthAccessToken();

			return $this->wpErrorFor( $username );
		} else {

			$vaUser = ValueAuthUser::findOrCreate( $wpUser->ID );
			$vaUser->updateLastLogin();
			if ( $vaUser->is2FAEnabled() ) {
				$result = $this->adapter->fetchAccessToken( $customerKey, AccessTokenRole::Auth, $loginKey );
				if ( $result instanceof ApiError ) {
					$this->clearAuthAccessToken();

					return $wpUser;
				} else {
					$accessToken = $result->results->access_token;
					$result      = $this->adapter->publish2FACode( $accessToken );
					if ( $result instanceof ApiError ) {
						$this->clearAuthAccessToken();

						return $wpUser;
					} else {
						$this->accessToken = $accessToken;
						setcookie( self::AccessTokenCookieName, $accessToken );

						return $this->wpErrorFor( $username );
					}
				}

			} else {
				$this->clearAuthAccessToken();

				return $wpUser;
			}
		}
	}

	/**
	 * @param string $userName
	 *
	 * @return WP_Error
	 */
	public function wpErrorFor( string $username ) {
		return new WP_Error(
			'incorrect_password',
			sprintf(
			/* translators: %s: User name. */
				__( '<strong>Error</strong>: The password you entered for the username %s is incorrect.' ),
				'<strong>' . $username . '</strong>'
			) .
			' <a href="' . wp_lostpassword_url() . '">' .
			__( 'Lost your password?' ) .
			'</a>'
		);
	}

	function loginError( $error ) {
		return 'ログイン出来ません';
	}

	function apiVerifiedGuard() {
		return ! ValueAuthSetting::verified();
	}

}
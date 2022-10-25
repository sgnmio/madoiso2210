<?php


namespace ValueAuth;


use DateTime;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use ValueAuth\ApiInput\Get2FACodeInput;
use ValueAuth\ApiInput\GetAccessTokenInput;
use ValueAuth\ApiInput\GetSiteSettingInput;
use ValueAuth\ApiInput\PostLoginCheckInput;
use ValueAuth\ApiInput\PostLoginLogInput;
use ValueAuth\ApiResult\AccessTokenResult;
use ValueAuth\ApiResult\ApiError;
use ValueAuth\ApiResult\LoginCheckResult;
use ValueAuth\ApiResult\LoginLogResult;
use ValueAuth\ApiResult\SiteSettingResult;
use ValueAuth\Enum\AccessTokenRole;
use ValueAuth\Enum\AuthenticationStatus;

class Adapter
{
    const ApiUrl = "https://api.valueauth.jp";
    /**
     * @var string
     */
    public $publicKey;

    /**
     * @var string
     */
    public $apiKey;
    /**
     * @var string
     */
    public $authCode;
    /**
     * @var ApiClient
     */
    public $client;
    /**
     * @var string
     */
    public $apiUrl = self::ApiUrl;

    /**
     * @var bool
     */
    public $debug = false;

    /**
     * @var string
     */
    public $apiVersion = "v2";


    /**
     * Adapter constructor.
     * @param string $apiKey
     * @param string $authCode
     * @param string $publicKey
     */
    function __construct(string $apiKey, string $authCode, string $publicKey, ?string $apiUrl = null, ?string $apiVersion = null, ?bool $debug = null)
    {
        $this->apiKey = $apiKey;
        $this->authCode = $authCode;
        $this->publicKey = $publicKey;
        $this->apiUrl = $apiUrl ?? $this->apiKey;
        $this->debug = $debug ?? $this->debug;
        $this->apiVersion = $apiVersion ?? $this->apiVersion;
        $this->initializeApiClient();

    }

    /**
     * @param string $accessToken
     * @return \Lcobucci\JWT\Token
     */
    static function parseAccessToken(string $accessToken)
    {
        $parser = new Parser();
        $parsed = $parser->parse($accessToken);
        return $parsed;
    }

    /**
     * @param string $accessToken
     * @return string|int
     */
    static function extractCustomerKey(string $accessToken)
    {
        $parsed = self::parseAccessToken($accessToken);
        return $parsed->getClaim('aud');
    }

    /**
     * @param string $accessToken
     * @return DateTime
     */
    static function extractIssuedAt(string $accessToken)
    {
        $parsed = self::parseAccessToken($accessToken);
        $issuedAt = new DateTime();
        $issuedAt->setTimestamp((int)$parsed->getClaim('iat'));
        return $issuedAt;
    }

    /**
     * @param string $token
     * @param DateTime $lastLogin
     * @return array [bool $verified, string $customerKey]
     */
    function verifyAuthToken(string $token, DateTime $lastLogin)
    {
        $parsed = $this->parseAccessToken($token);
        $customerKey = $parsed->getClaim('aud');
        $pubKey = new Key($this->publicKey);
        $signer = new Sha256();
        $issuedAt = new DateTime();
        $issuedAt->setTimestamp((int)$parsed->getClaim('iat'));
        $verified = $parsed->verify($signer, $pubKey);
        $publishedAfterLogin = $lastLogin < $issuedAt;

        return [$verified && $publishedAfterLogin, $customerKey];
    }

    /**
     * @param $customerKey
     * @return LoginCheckResult | ApiError
     */
    function postCheckLogin($customerKey)
    {

        $input = new PostLoginCheckInput();
        $input->ip = $this->getClientIp();
        $input->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $input->customer_key = $customerKey;
        /**
         * @var $result LoginCheckResult
         */
        $result = $this->client->process($input)->wait();

        return $result;
    }

    /**
     * @return string|null
     */
    static function getClientIp()
    {
        $ip = null;
        foreach (
            array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR'
            ) as $key
        ) {
            if (array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if ((bool)filter_var($ip, FILTER_VALIDATE_IP,
                        FILTER_FLAG_IPV4 |
                        FILTER_FLAG_NO_PRIV_RANGE |
                        FILTER_FLAG_NO_RES_RANGE)) {
                        break;
                    }
                }
            }
        }

        return $ip;
    }

    /**
     * @param $customerKey
     * @param string $role
     * @param string|null $loginKey
     * @return AccessTokenResult
     */
    function fetchAccessToken($customerKey, string $role, ?string $loginKey = null)
    {
        $input = new GetAccessTokenInput();
        $input->customer_key = $customerKey;
        $input->role = $role;
        $input->login_key = $loginKey;
        /**
         * @var $result AccessTokenResult
         */
        $result = $this->client->process($input)->wait();

        return $result;
    }


    /**
     * @param string $apiUrl
     * @param string $apiKey
     * @param string $authCode
     * @param string $version
     * @param bool $debug
     * @return bool
     */
    static function checkCredentials(string $apiUrl, string $apiKey, string $authCode, string $publicKey, string $version = "v2", bool $debug = false)
    {
        $client = new ApiClient($apiKey, $authCode, null, $debug, $version, $apiUrl);
        $result = $client->process(new GetSiteSettingInput())->wait();
        return ($result instanceof SiteSettingResult && $result->results->site_setting->public_key === $publicKey) ;
    }


    /**
     * @param bool $loginWillSuccess
     * @param string $loginKey
     * @param string $customerKey
     * @return LoginLogResult
     */
    function postLoginLog(bool $loginWillSuccess, string $loginKey, string $customerKey)
    {
        /**
         * @var $input PostLoginLogInput
         */
        $input = new PostLoginLogInput();
        $input->is_logged_in = $loginWillSuccess;
        $input->login_key = $loginKey;
        $input->customer_key = $customerKey;
        /**
         * @var $result LoginLogResult
         */
        $result = $this->client->process($input)->wait();
        return $result;
    }

    /**
     * @param string $accessToken
     * @return ApiResult\TwoFactorAuthSendResult
     */
    function publish2FACode(string $accessToken)
    {
        $accessTokenClient = new ApiClient(null, null, $accessToken, $this->client->debug, $this->apiVersion, $this->apiUrl);
        /**
         * @var $input Get2FACodeInput
         */
        $parsed = $this->parseAccessToken($accessToken);
        $customerKey = $parsed->getClaim('aud');

        $input = new Get2FACodeInput();
        $input->customer_key = $customerKey;
        /**
         * @var $result \ValueAuth\ApiResult\TwoFactorAuthSendResult
         */
        $result = $accessTokenClient->process($input)->wait();
        return $result;
    }

    /**
     *
     */
    function initializeApiClient(): void
    {
        $this->client = new ApiClient($this->apiKey, $this->authCode, null, $this->debug, $this->apiVersion, $this->apiUrl);
    }

    /**
     * @param string $customerKey
     * @param bool $loginWillSuccess
     * @param bool $is2FAEnabled
     * @param callable $lastLoginUpdateCallback (string $customerKey, bool $loginWillSuccess, bool $is2FAEnabled, DateTime $now)
     * @return AuthenticationStatus
     */
    function checkLoginAvailability(string $customerKey, bool $loginWillSuccess, bool $is2FAEnabled, callable $lastLoginUpdateCallback): AuthenticationStatus
    {
        $result = $this->postCheckLogin($customerKey);
        if ($result instanceof ApiError) {
            $error = AuthenticationStatus::ApiError();
            $error->reason = $result;
            return $error;
        }
        $loginKey = $result->results->login_key;
        $result = $this->postLoginLog($loginWillSuccess, $loginKey, $customerKey);
        if ($result instanceof ApiError) {
            $error = AuthenticationStatus::ApiError();
            $error->reason = $result;
            return $error;
        }
        if (!$loginWillSuccess) {
            return AuthenticationStatus::Failed();
        } else {
            $lastLoginUpdateCallback($customerKey, $loginWillSuccess, $is2FAEnabled, new DateTime());
            if ($is2FAEnabled) {
                /**
                 * @var $result \ValueAuth\ApiResult\AccessTokenResult
                 */
                $result = $this->fetchAccessToken($customerKey, AccessTokenRole::Auth, $loginKey);
                if ($result instanceof ApiError) {
                    $error = AuthenticationStatus::ApiError();
                    $error->reason = $result;
                    return $error;
                } else {
                    $accessToken = $result->results->access_token;
                    /**
                     * @var $result \ValueAuth\ApiResult\TwoFactorAuthSendResult
                     */
                    $result = $this->publish2FACode($accessToken);
                    if ($result instanceof ApiError) {
                        /**
                         * @var $response AuthenticationStatus
                         */

                        $error = AuthenticationStatus::ApiError();
                        $error->reason = $result;
                        $error->accessToken = $accessToken;
                        return $error;
                    } else {
                        /**
                         * @var $response AuthenticationStatus
                         */
                        $response = AuthenticationStatus::Pending2FA();
                        $response->reason = $result;
                        $response->accessToken = $accessToken;
                        return $response;
                    }
                }

            } else {
                return AuthenticationStatus::Succeeded();
            }
        }
    }
}
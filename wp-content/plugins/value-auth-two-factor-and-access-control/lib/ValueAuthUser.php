<?php


class ValueAuthUser {

	protected $object;

	function __construct( $object ) {
		$this->object = $object;
	}

	public function __get( $property_name ) {
		return $this->object->$property_name;
	}

	public function __set( $property_name, $value ) {
		$this->object->$property_name = $value;
	}

	static function tableName() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'value_auth_users';

		return $table_name;
	}

	static function install() {
		global $wpdb;

		$table_name = self::tableName();
		if ( ! in_array( $table_name, $wpdb->tables ) ) {
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		wp_user_id bigint NOT NULL,
		last_login timestamp,
		is_2fa_enabled boolean NOT NULL default FALSE,
		PRIMARY KEY  (id) 
		) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}

	static function uninstall() {
		global $wpdb;
		$tableName = self::tableName();
		$sql       = "DROP TABLE $tableName;";
		$wpdb->query( $sql );
	}

	static function findOrCreate( $wpUserId ) {
		global $wpdb;

		$tableName = self::tableName();
		$result    = self::find( $wpUserId );
		if ( empty( $result ) ) {
			$wpdb->insert( $tableName, [ 'wp_user_id' => $wpUserId ] );
			$wpdb->print_error();

			return self::find( $wpUserId );
		} else {
			return $result;
		}
	}

	static function find( $wpUserId ) {
		global $wpdb;

		$tableName = self::tableName();
		$sql       = $wpdb->prepare( "SELECT * from $tableName WHERE wp_user_id = %d;", $wpUserId );
		$results   = $wpdb->get_results( $sql );
		if ( empty( $results ) ) {
			return null;
		} else {
			return new  ValueAuthUser( $results[0] );
		}


	}

	function save() {
		global $wpdb;

		$tableName = self::tableName();
		$data      = (array) $this->object;
		unset( $data['id'] );

		return $wpdb->update( $tableName, $data, [ 'id' => $this->id ] );
	}

	function enable2FA() {
		$this->is_2fa_enabled = true;
		$this->save();
	}

	function disable2FA() {
		$this->is_2fa_enabled = false;
		$this->save();
	}

	function is2FAEnabled() {
		return $this->is_2fa_enabled;
	}

	function updateLastLogin() {
		$now = new DateTime('NOW');
		$this->object->last_login = $now->format(DateTime::ISO8601);
		$this->save();
	}

}
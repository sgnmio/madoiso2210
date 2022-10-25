<?php


class ValueAuthSetting {
	static function tableName() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'value_auth_settings';

		return $table_name;
	}

	static function install() {
		global $wpdb;


		$table_name = self::tableName();
		if ( ! in_array( $table_name, $wpdb->tables ) ) {

			$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL UNIQUE ,
			value text NOT NULL,
			PRIMARY KEY  (id) 
			) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			$wpdb->insert( $table_name,
				[
					'name'  => 'auth_code',
					'value' => ''
				] );

			$wpdb->insert( $table_name,
				[
					'name'  => 'api_key',
					'value' => ''
				] );

			$wpdb->insert( $table_name,
				[
					'name'  => 'public_key',
					'value' => ''
				] );

			$wpdb->insert( $table_name,
				[
					'name'  => 'verified',
					'value' => false
				] );
		}

	}

	static function uninstall() {
		global $wpdb;
		$table_name = self::tableName();
		$sql        = "DROP TABLE $table_name ;";
		$wpdb->query( $sql );
	}

	static function getValue( $key ) {
		global $wpdb;
		$tableName = self::tableName();
		$sql       = $wpdb->prepare( "SELECT value from $tableName WHERE name = %s;", $key );
		$result    = $wpdb->get_results( $sql )[0];

		return $result->value;
	}

	static function setValue( $key, $value ) {
		global $wpdb;
		$tableName = self::tableName();
		$result    = $wpdb->update( $tableName, [ 'value' => $value ], [ 'name' => $key ] );

		return $result;
	}


	static function authCode() {
		return self::getValue( 'auth_code' );
	}

	static function apiKey() {
		return self::getValue( 'api_key' );
	}

	static function setAuthCode( $authCode ) {
		return self::setValue( 'auth_code', $authCode );
	}

	static function setApiKey( $apiKey ) {
		return self::setValue( 'api_key', $apiKey );
	}

	static function publicKey() {
		return self::getValue( 'public_key' );
	}

	static function verified() {
		return self::getValue( 'verified' );
	}

	static function setPublicKey( $publicKey ) {
		return self::setValue( 'public_key', $publicKey );
	}

	static function setVerified( $verified ) {
		return self::setValue( 'verified', $verified );
	}
}
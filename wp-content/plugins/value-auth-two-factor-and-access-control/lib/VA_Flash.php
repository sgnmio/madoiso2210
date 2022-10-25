<?php


class VA_Flash {
	const OptionKey = "va_flash_notices";

	public static function addFlashNotice( $notice = "", $type = "warning", $dismissible = true ) {
		// Here we return the notices saved on our option, if there are not notices, then an empty array is returned
		$notices = get_option( self::OptionKey, [] );

		$dismissible_text = ( $dismissible ) ? "is-dismissible" : "";

		// We add our new notice.
		array_push( $notices, [
			"notice"      => $notice,
			"type"        => $type,
			"dismissible" => $dismissible_text
		] );

		// Then we update the option with our notices array
		update_option( self::OptionKey, $notices );
	}

	public static function displayFlashNotice() {
		$notices = get_option( self::OptionKey, [] );

		// Iterate through our notices to be displayed and print them.
		foreach ( $notices as $notice ) {
			printf( '<div class="notice notice-%1$s %2$s"><p>%3$s</p></div>',
				$notice['type'],
				$notice['dismissible'],
				$notice['notice']
			);
		}

		// Now we reset our options to prevent notices being displayed forever.
		if ( ! empty( $notices ) ) {
			delete_option( self::OptionKey );
		}
	}

	public static function initialize() {
		add_action( 'admin_notices', [ VA_Flash::class, 'displayFlashNotice' ], 12 );
	}

}
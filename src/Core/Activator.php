<?php

namespace WpPagespeedScore\Core;

use WpPagespeedScore\Common as Common;

// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Activator::class ) ) {
	/**
	 * Fired during plugin activation
	 *
	 * This class defines all code necessary to run during the plugin's activation.
	 **/
	class Activator {

		/**
		 * Short Description.
		 *
		 * Long Description.
		 */
		public static function activate() {
			$settings = new Common\Settings\Main();
			$moskito_website_id_option_name = $settings->get_prefixed_option_key("website_id");

			if (get_option( $moskito_website_id_option_name )) {
			} else {
				$website_id = Common\Utilities\Crypto::generate_random_string();
				update_option( $moskito_website_id_option_name, $website_id );
			}
		}
	}
}

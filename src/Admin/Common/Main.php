<?php

declare( strict_types=1 );

namespace WpPagespeedScore\Admin\Common;

use WpPagespeedScore\PluginData as PluginData;
use WpPagespeedScore\Common\Common as Common;
use WpPagespeedScore\Common\Settings\Main as Common_Settings;
use WpPagespeedScore\Common\Utilities\Debug as Debug;
use WP_Screen;

// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Main::class ) ) {
	/**
	 * The admin-specific settings.
	 */
	class Main {

		/**
		 * The Common instance.
		 *
		 * @var Common
		 */
		public $common;

		/**
		 * Get the Settings instance from Common.
		 *
		 * @var Common_Settings
		 */
		private $settings;

		/**
		 * Initialize the class and set its properties.
		 */
		public function __construct() {
			$this->common = new Common();
			$this->settings = new Common_Settings();
		}

		/**
		 * Register the JavaScript for all admin pages.
		 */
		public function enqueue_settings_page_assets() {
			$moskito_website_id_option_name = $this->settings->get_prefixed_option_key("website_id");
			$moskito_info = [
				"website_id" => get_option( $moskito_website_id_option_name ),
			];

			wp_register_script(PluginData::plugin_text_domain(), false);
			wp_enqueue_script(PluginData::plugin_text_domain());

			wp_localize_script(
				PluginData::plugin_text_domain(),
				'moskitoInfo', // Only loads when on the page so shouldn't be a conflicting name.
				$moskito_info
			);

		}
	}
}

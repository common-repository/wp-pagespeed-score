<?php

namespace WpPagespeedScore\Core;

use WpPagespeedScore\Admin as Admin;
use WpPagespeedScore\Common as Common;
use WpPagespeedScore\PluginData as PluginData;

// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Init::class ) ) {
	/**
	 * The core plugin class.
	 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
	 */
	class Init {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @var      Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * Initialize and define the core functionality of the plugin.
		 */
		public function __construct() {
			$this->load_dependencies();
			$this->set_locale();
			$this->define_common_hooks();
			$this->define_admin_hooks();
		}

		/**
		 * Loads the following required dependencies for this plugin.
		 *
		 * - Loader - Orchestrates the hooks of the plugin.
		 * - I18n - Defines internationalization functionality.
		 * - Admin - Defines all hooks for the admin area.
		 * - Frontend - Defines all hooks for the public side of the site.
		 */
		private function load_dependencies(): void {
			$this->loader = new Loader();
		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the I18n class in order to set the domain and to register the hook
		 * with WordPress.
		 */
		private function set_locale(): void {
			$i18n = new I18n();

			$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );
		}

		/**
		 * Register all of the hooks related to both the admin area and the public-facing functionality of the plugin.
		 */
		private function define_common_hooks(): void {
			// $common = new Common\Common();
			// Example: $this->loader->add_filter( 'gform_currencies', $common, 'gf_currency_usd_whole_dollars', 50 );

			// Settings Fields must not be behind an `is_admin()` check, since it's too late.
			$settings = new Common\Settings\Main();
		}

		/**
		 * Register all of the hooks related to the admin area functionality of the plugin.
		 * Also works during Ajax.
		 */
		private function define_admin_hooks(): void {
			$common = new Common\Common();

			if ( ! $common->current_request_is( 'admin' ) ) {
				return;
			}

			$edit_page = new Admin\EditPage\Main();
			$common_admin = new Admin\Common\Main();

			$this->loader->add_action("admin_enqueue_scripts", $common_admin, "enqueue_settings_page_assets");
			$this->loader->add_action("admin_enqueue_scripts", $edit_page, "enqueue_edit_page_page_assets");

			// Edit page meta box
			$this->loader->add_action( 'add_meta_boxes', $edit_page, 'add_plugin_edit_page_meta_box' );
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 */
		public function run(): void {
			$this->loader->run();
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @return Loader Orchestrates the hooks of the plugin.
		 */
		public function get_loader(): Loader {
			return $this->loader;
		}
	}
}

<?php

declare( strict_types=1 );

namespace WpPagespeedScore\Admin\EditPage;

use WpPagespeedScore\Common\Assets as Assets;
use WpPagespeedScore\PluginData as PluginData;
use WpPagespeedScore\Common\Common as Common;
use WpPagespeedScore\Common\Utilities\Debug as Debug;
use WpPagespeedScore\Common\Settings\Main as Common_Settings;
use WP_Screen;

// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Main::class ) ) {
	/**
	 * The admin-specific edit_page.
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
		private $edit_page;

		/**
		 * Initialize the class and set its properties.
		 */
		public function __construct() {
			$this->common = new Common();
			$this->edit_page = new Common_Settings();
		}

		/**
		 * Add the Settings page to the wp-admin menu.
		 */
		public function add_plugin_edit_page_meta_box(): void {
            add_meta_box(
                'wp-pagespeed-score-meta-box1',
                PluginData::get_plugin_display_name(),
                [ $this, 'edit_page_page' ],
                'page',
                'normal',
                'high'
            );
            add_meta_box(
                'wp-pagespeed-score-meta-box1',
                PluginData::get_plugin_display_name(),
                [ $this, 'edit_page_page' ],
                'post',
                'normal',
                'high'
            );

            $this->enqueue_edit_page_page_assets();
		}

		/**
		 * Register the JavaScript for the admin Settings Page area.
		 */
		public function enqueue_edit_page_page_assets() {
			$assets = new Assets();
			
			

			$wp_page = get_post();


			if (!empty($wp_page)) {
				// We are in edit page screen.
				// Vue JS bundle
				wp_enqueue_script(
					PluginData::get_asset_handle( 'admin-edit-page' ),
					Assets::get_assets_url_base() . 'js/edit-page.js',
					[
						'wp-api',
						'wp-i18n',
						'wp-components',
						'wp-element',
					],
					PluginData::plugin_version(),
					true
				);
				// Vue CSS
				$assets->register_style("css/edit-page", PluginData::get_asset_handle( 'admin-edit-page' ));
				$assets->enqueue_style(PluginData::get_asset_handle( 'admin-edit-page' ));

				$permalink = get_permalink( $wp_page );
				$wp_page->permalink = $permalink;
			} else {
				$wp_page = new \stdClass();
			}

			wp_localize_script(
				PluginData::get_asset_handle( 'admin-edit-page' ),
				'moskitoPageInfo', // Only loads when on the page so shouldn't be a conflicting name.
				get_object_vars($wp_page)
			);
		}

		/**
		 * Outputs HTML for the plugin's Settings page.
		 */
		public function edit_page_page(): void {
			if ( ! current_user_can( $this->common->required_capability() ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wp-pagespeed-score' ) );
			}

			

			printf(
				'<div class="wrap" id="wp-pagespeed-score-edit-page"></div>',
				PluginData::plugin_text_domain()
			);
		}

	}
}

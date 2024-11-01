<?php

namespace WpPagespeedScore;

// Abort if this file is called directly.
use WpPagespeedScore\Core as Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Bootstrap::class ) ) {
	/**
	 * The file that gets things going.
	 */
	class Bootstrap {
		/**
		 * Begins execution of the plugin.
		 *
		 * Since everything within the plugin is registered via hooks, then kicking off the plugin from this point in the file
		 * does not affect the page life cycle.
		 *
		 * Also returns copy of the app object so 3rd party developers can interact with the plugin's hooks contained within.
		 *
		 * @return Bootstrap|null
		 */
		public function init(): ?self {
			$plugin = new self();

			if ( $plugin->is_ready() ) {
				$core = new Core\Init();
				$core->run();

				return $plugin;
			} else {
				return null;
			}
		}
		

		/**
		 * Output a message about unsatisfactory version of PHP.
		 */
		public function notice_old_php_version(): void {
			$help_link = sprintf( '<a href="%1$s" target="_blank">%1$s</a>', 'https://wordpress.org/about/requirements/' );

			$message = sprintf(
				// translators: 1: plugin display name, 2: required minimum PHP version, 3: current PHP version, help link
				__( '%1$s requires at least PHP version %2$s in order to work. You have version %3$s. Please see %4$s for more information.', 'wp-pagespeed-score' ),
				'<strong>' . PluginData::get_plugin_display_name() . '</strong>',
				'<strong>' . PluginData::required_min_php_version() . '</strong>',
				'<strong>' . PHP_VERSION . '</strong>',
				$help_link
			);

			$this->do_admin_notice( $message );
		}

		/**
		 * Output a wp-admin notice.
		 *
		 * @param string $message
		 * @param string $type
		 */
		public function do_admin_notice( string $message, string $type = 'error' ): void {
			$class = sprintf( '%s %s', $type, sanitize_html_class( PluginData::plugin_text_domain() ) );

			printf( '<div class="%s"><p>%s</p></div>', $class, $message );
		}

		/**
		 * Check if we have everything that is required.
		 *
		 * @return bool
		 */
		public function is_ready(): bool {
			$success = true;

			if ( version_compare( PHP_VERSION, PluginData::required_min_php_version(), '<' ) ) {
				add_action( 'admin_notices', [ $this, 'notice_old_php_version' ] );
				$success = false;
			}
			return $success;
		}
	}
}

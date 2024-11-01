<?php
/**
 * The plugin bootstrap file.
 *
 * https://github.com/cliffordp/wp-pagespeed-score#plugin-structure
 * Introduction to the structure of this plugin's files:
 *
 * wp-pagespeed-score/src/class-PluginData.php - hard-coded information about the plugin, such as plugin-slug and plugin_slug.
 * wp-pagespeed-score/src/class-Bootstrap.php - gets the plugin going, including setting required/recommended plugin dependencies
 *
 * wp-pagespeed-score/src/Admin - admin-specific functionality
 * wp-pagespeed-score/src/Common - functionality shared between the admin area and the public-facing parts
 *
 * wp-pagespeed-score/src/Common/Utilities - generic functions for things like debugging, processing multidimensional arrays, handling datetimes, etc.
 * wp-pagespeed-score/src/Core - plugin core to register hooks, load files etc
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           WpPagespeedScore
 *
 * @wordpress-plugin
 * Plugin Name:       WP Pagespeed Score
 * Plugin URI:        https://www.grepstadnilsen.no/
 * Description:       PageSpeed is a super important part of your website success. A faster website equals better conversion rates. Make your site super fast with WP PageSpeed Score.
 * Version:           1.0.1
 * Author:            Grepstad Nilsen
 * Author URI:        https://www.grepstadnilsen.no/
 * License:           GPL version 3 or any later version
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wp-pagespeed-score
 * Domain Path:       /languages
 *
 ***
 *
 *     This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *     GNU General Public License for more details.
 *
 ***
 *
 *     This plugin was helped by Clifford Paulick's Plugin Boilerplate,
 *     available free at https://github.com/cliffordp/wp-pagespeed-score
 *     You are invited to use it for your own WordPress projects.
 */

declare( strict_types=1 );

namespace WpPagespeedScore;

// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoloading, via Composer.
 *
 * @link https://getcomposer.org/doc/01-basic-usage.md#autoloading
 */
require_once( 'vendor/autoload.php' );

// Define Constants

/**
 * Register Activation and Deactivation Hooks
 * This action is documented in src/Core/class-Activator.php
 */
register_activation_hook( __FILE__, [ __NAMESPACE__ . '\Core\Activator', 'activate' ] );

/**
 * The code that runs during plugin deactivation.
 * This action is documented src/Core/class-Deactivator.php
 */
register_deactivation_hook( __FILE__, [ __NAMESPACE__ . '\Core\Deactivator', 'deactivate' ] );

// Begin execution of the plugin.
( new Bootstrap() )->init();
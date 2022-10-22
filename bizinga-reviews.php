<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Bizinga
 *
 * @wordpress-plugin
 * Plugin Name:       Bizinga Reviews Plugin
 * Plugin URI:        http://example.com/bizinga-uri/
 * Description:       Business Reviews for pages/posts
 * Version:           1.0.0
 * Author:            SS Technologies
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bizinga
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Bizinga_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bizinga-activator.php
 */
function activate_bizinga() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bizinga-activator.php';
	Bizinga_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bizinga-deactivator.php
 */
function deactivate_bizinga() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bizinga-deactivator.php';
	Bizinga_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bizinga' );
register_deactivation_hook( __FILE__, 'deactivate_bizinga' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bizinga.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bizinga() {

	$plugin = new Bizinga_Reviews();
	$plugin->run();

}
run_bizinga();

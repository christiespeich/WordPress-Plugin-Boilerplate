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
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Plugin Boilerplate
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
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
if ( ! defined( 'PLUGIN_NAME_VERSION' ) ) {
	define( 'PLUGIN_NAME_VERSION', '1.0.0' );
}

if ( ! defined( 'PLUGIN_NAME_PLUGIN_VERSION_KEY' ) ) {
	define( 'PLUGIN_NAME_PLUGIN_VERSION_KEY', 'plugin_name_version' );
}

if ( ! defined( 'PLUGIN_NAME_PLUGIN_DIR' ) ) {
	define( 'PLUGIN_NAME_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( ! defined( 'PLUGIN_NAME_PLUGIN_URL' ) ) {
	define( 'PLUGIN_NAME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Root File
if ( ! defined( 'PLUGIN_NAME_PLUGIN_FILE' ) ) {
	define( 'PLUGIN_NAME_PLUGIN_FILE', __FILE__ );
}






/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once PLUGIN_NAME_PLUGIN_DIR . 'includes/class-plugin-name-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once PLUGIN_NAME_PLUGIN_DIR . 'includes/class-plugin-name-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require PLUGIN_NAME_PLUGIN_DIR . 'includes/class-plugin-name.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	// plugin dependencies
	if ( plugin_name_dependencies_satisfied() ) {
		$plugin = new Plugin_Name();
		$plugin->run();
	}
}
add_action( 'plugins_loaded', 'run_plugin_name');


function plugin_name_dependencies_satisfied() {
	require_once PLUGIN_NAME_PLUGIN_DIR . 'includes/vendor/mooberry-dreams/class-plugin-name-dependency-manager.php';
	$dependencies = new Plugin_Name_Dependency_Manager();
	// add dependencies like this:  the activation function name is a good one to use
	//$dependencies->add( 'mbdbai_activate' );

	return $dependencies->check();

}
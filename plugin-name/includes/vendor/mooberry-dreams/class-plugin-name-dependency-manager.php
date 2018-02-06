<?php
/**
 * Checks if required plugin is installed.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/vendor/mooberry-dreams
 */

/**
 * Checks if required plugin is installed.
 *
 * Maintain a list of all plugins that are required in order to
 * use this plugin, and check if they are activated. Call the
 * check() function to test if the plugin is active.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/vendor/mooberry-dreams
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Dependency_Manager {


	/**
	 * The array of plugins this plugin requires
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $plugins    The plugins this plugin requires
	 */
	private $plugins;

	/**
	 * Initialize the collection used to maintain the required plugins.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugins = array();
	}

	/**
	 * Add a new plugin to the collection of required plugins.
	 *
	 * @since    1.0.0
	 * @param    string               $function_name    The name of a function used in required plugin (the activation function is a good choice)
	 */
	public function add( $function_name ) {
		$this->plugins[] = $function_name;
	}

	/**
	 * Checks if the plugin is activated
	 *
	 * @since    1.0.0
	 * @param    string               $function_name    The name of a function used in required plugin (the activation function is a good choice)
	 * @return   bool                                   true if plugin is activated, false otherwise
	 */
	private function plugin_activated( $function_name ) {
		return function_exists( $function_name );
	}

	/**
	 * Runs through the list of required plugins and checks if they are activated
	 *
	 * @since    1.0.0
	 * @return   bool                                   true if ALL plugins are activated, false otherwise
	 */
	public function check() {

		// check dependencies
		foreach ( $this->plugins  as $plugin ) {
			if ( ! $this->plugin_activated( $plugin ) ) {
				return false;
			}
		}
		return true;

	}

}
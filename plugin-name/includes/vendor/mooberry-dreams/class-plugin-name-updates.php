<?php
/**
 * Runs plugin updates
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/vendor/mooberry-dreams
 */

/**
 * Runs plugin updates
 *
 * See if the plugin needs to run updates. Update the version stored
 * in the database after updates are finished
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes/vendor/mooberry-dreams
 * @author     Your Name <email@example.com>
 */
class Plugin_Name_Updates {

	/**
	 * The current version of the plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_version    The current version of the plugin
	 */
	private $plugin_version;

	/**
	 * The version of the plugin installed on the server before updating
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $installed_version    The previous version of the plugin
	 */
	private $installed_version;


	/**
	 * Initialize the current version of the plugin and the current version in the database
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_version ) {
		$this->plugin_version = $plugin_version;

		$this->installed_version = get_option( PLUGIN_NAME_PLUGIN_VERSION_KEY, '1.0.0' );
	}

	/**
	 * Run update routines and then update the database
	 * with the current version number
	 *
	 * @since    1.0.0
	 */
	public function check_for_updates() {
		$this->run();
		$this->update_version();
	}


	/**
	 * Run update routines for any version that needs them
	 *
	 * @since    1.0.0
	 */
	private function run() {

		// add a call to check_for_update for each version that needs update script run
		// then add a function update_to_{version_number} where . are replaced with _
		$this->run_update( '1.1' );

	}

	/**
	 * Update the version stored in the database to reflect that the update scripts have run
	 *
	 * @since    1.0.0
	 */
	private function update_version() {
		update_option( PLUGIN_NAME_PLUGIN_VERSION_KEY, $this->plugin_version );
	}

	/**
	 * If the installed version is lower than the current version, run an update
	 *
	 * @since    1.0.0
	 * @param   $version    string      the newer version that requires update scripts to run
	 */
	private function run_update( $version ) {

		if (version_compare($this->installed_version, $version, '<')) {
			// ex, update_to_1_1
			$function_name = 'update_to_' . str_replace( '.', '_', $version );
			if ( method_exists( $this, $function_name ) )  {
				call_user_func( array( $this, $function_name ) );
			}
		}

	}

	// add update functions as needed called update_to_{version_number} where . are replaced with _

}
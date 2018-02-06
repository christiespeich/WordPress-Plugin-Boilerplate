<?php
/**
 * Class SampleTest
 *
 * @package Boilerplate
 */

/**
 * Sample test case.
 */
class AdminNoticesTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_empty_notices_option_has_zero_notices() {
		// Replace this with some actual testing code.
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();

		$this->assertEquals( 0, $notice_manager->count_notices());
	}

	function test_adding_notice_adds_one_to_count() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );

		$this->assertEquals( 1, $notice_manager->count_notices() );
	}

	function test_removing_notice_removes_one_from_count() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );
		$notice_manager->dismiss( 'test' );

		$this->assertEquals( 0, $notice_manager->count_notices() );
	}

	function test_adding_notice_adds_it_to_database() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );

		// load fresh from the database
		$notice_manager2 = new Plugin_Name_Admin_Notice_Manager();

		$this->assertEquals(1, $notice_manager2->count_notices() );
	}

	function test_removing_notice_removes_it_from_database() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );
		$notice_manager->dismiss( 'test' );

		// load fresh from the database
		$notice_manager2 = new Plugin_Name_Admin_Notice_Manager();

		$this->assertEquals( 0, $notice_manager2->count_notices() );
	}

	function test_display_notice() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );

		$expected = "<div class='notice info' id='test'><p>Test Message</p></div>";

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( $expected, $output );
	}

	function test_display_multple_notices() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Test Message', 'info', 'test' );
		$notice_manager->add_new( 'Test Message2', 'warning', 'test2' );

		$expected = "<div class='notice info' id='test'><p>Test Message</p></div>";
		$expected .= "<div class='notice warning' id='test2'><p>Test Message2</p></div>";

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( $expected, $output );
	}

	function test_display_no_notices() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( "", $output );
	}

	function test_invalid_notice_in_options() {
		update_option('plugin_name_admin_notices', 'Testing Bad Message' );
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();

		$this->assertEquals( 1, $notice_manager->count_notices());

	}

	function test_invalid_notice_does_not_display() {
		update_option('plugin_name_admin_notices', 'Testing Bad Message' );
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( "", $output);

	}

	function test_one_invalid_notice_one_valid_notice() {
		update_option('plugin_name_admin_notices', 'Testing Bad Message' );
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'Valid Message', 'info', 'test');

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( "<div class='notice info' id='test'><p>Valid Message</p></div>", $output);
	}

	function test_two_notices_same_key_second_one_overwrites() {
		$notice_manager = new Plugin_Name_Admin_Notice_Manager();
		$notice_manager->add_new( 'First Message', 'warning', 'test');
		$notice_manager->add_new( 'Second Message', 'info', 'test');

		ob_start();
		$notice_manager->display_notices();
		$output = ob_get_clean();

		$this->assertEquals( "<div class='notice info' id='test'><p>Second Message</p></div>", $output);
	}
}

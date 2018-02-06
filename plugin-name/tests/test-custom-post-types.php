<?php
/**
 * Class SampleTest
 *
 * @package Boilerplate
 */

/**
 * Sample test case.
 */
class CustomPostTypesTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_create_custom_post_type() {
		$post_type = new MOOBD_Custom_Post_Type( 'test', 'Test', 'Tests' );
		$post_type->register();

		$this->assertTrue( post_type_exists( 'test' ) );
	}

	function test_create_taxonomy() {
		$taxonomy = new MOOBD_Custom_Taxonomy( 'test_taxonomy', 'post', 'Test', 'Tests');
		$taxonomy->register();

		$this->assertTrue( taxonomy_exists( 'test_taxonomy' ) );

	}

}

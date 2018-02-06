<?php
/**
 * Class SampleTest
 *
 * @package Boilerplate
 */

/**
 * Sample test case.
 */
class MetaboxTests extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function display( $values ) {
		print_r( $values );
	}

	function test_adding_field() {
		$metabox = new MOOBD_Metabox( 'test metabox', 'Test Metabox', array( $this, 'display') );
		$metabox->set_nonce_field( 'nonce_field' );
		$metabox->set_nonce_value( 'nonce_value' );

		$post_id = $this->factory()->post->create();
		$post = get_post( $post_id );
		update_post_meta( $post_id, 'field1', 'my value');

		$field = new MOOBD_Metabox_Field( 'field1' );
		$metabox->add_field( $field );

		$expected = '<input type="hidden" id="nonce_field" name="nonce_field" value="' . wp_create_nonce( 'nonce_value' ) .  '" /><input type="hidden" name="_wp_http_referer" value="" />' . print_r( array( 'field1' => 'my value') , true );

		ob_start();
		$metabox->display( $post );
		$result = ob_get_clean();

		$this->assertEquals( $expected, $result );
	}

	function test_save_single_field() {
		$metabox = new MOOBD_Metabox( 'test metabox', 'Test Metabox', array( $this, 'display') );
		$metabox->set_nonce_field( 'nonce_field' );
		$metabox->set_nonce_value( 'nonce_value' );

		$post_id = $this->factory()->post->create();
		update_post_meta( $post_id, 'field1', 'initial value');

		$field = new MOOBD_Metabox_Field( 'field1' );
		$metabox->add_field( $field );

		$editor_id = $this->factory->user->create([
			'role' => 'editor',
		]);
		wp_set_current_user( $editor_id );

		$_POST['field1'] = 'new value';
		$_POST['nonce_field'] = wp_create_nonce( 'nonce_value' );
		$metabox->save( $post_id );

		$new_value = get_post_meta( $post_id, 'field1', true );

		$this->assertEquals( 'new value', $new_value );
	}

	function test_save_multiple_field() {
		$metabox = new MOOBD_Metabox( 'test metabox', 'Test Metabox', array( $this, 'display') );
		$metabox->set_nonce_field( 'nonce_field' );
		$metabox->set_nonce_value( 'nonce_value' );

		$post_id = $this->factory()->post->create();
		add_post_meta( $post_id, 'field1', 'value 1');
		add_post_meta( $post_id, 'field1', 'value 2');
		add_post_meta( $post_id, 'field1', 'value 3');


		$field = new MOOBD_Metabox_Field( 'field1' );
		$field->set_multiple(true);
		$metabox->add_field( $field );


		$editor_id = $this->factory->user->create([
			'role' => 'editor',
		]);
		wp_set_current_user( $editor_id );

		$_POST['field1'] = array( 'value 1', 'value 2', 'value 3');
		$_POST['nonce_field'] = wp_create_nonce( 'nonce_value' );
		$metabox->save( $post_id );

		$new_value = get_post_meta( $post_id, 'field1', false );

		$this->assertEquals( array( 'value 1', 'value 2', 'value 3'), $new_value );
	}





}

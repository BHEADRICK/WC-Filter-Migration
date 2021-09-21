<?php
/**
 * WC_Filter_Migration.
 *
 * @since   0.0.0
 * @package WC_Filter_Migration
 */
class WC_Filter_Migration_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'WC_Filter_Migration') );
	}

	/**
	 * Test that our main helper function is an instance of our class.
	 *
	 * @since  0.0.0
	 */
	function test_get_instance() {
		$this->assertInstanceOf(  'WC_Filter_Migration', wc_filter_migration() );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  0.0.0
	 */
	function test_sample() {
		$this->assertTrue( true );
	}
}

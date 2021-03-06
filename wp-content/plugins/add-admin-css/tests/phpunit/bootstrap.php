<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Add_Admin_CSS
 */

define( 'ADD_ADMIN_CSS_PLUGIN_FILE', dirname( __FILE__, 3 ) . '/add-admin-css.php' );

ini_set( 'display_errors', 'on' );
error_reporting( E_ALL );

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/tests/phpunit/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require ADD_ADMIN_CSS_PLUGIN_FILE;
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/tests/phpunit/includes/bootstrap.php';

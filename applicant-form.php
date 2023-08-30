<?php
/**
 * Plugin Name: Applicant Form
 * Plugin URI: https://profiles.wordpress.org/nayanchamp7
 * Description: A simple form to collect applicant information.
 * Version: 1.0.0
 * Author: Nazrul Islam Nayan
 * Author URI: https://profiles.wordpress.org/nayanchamp7
 * Text Domain: applicant-form
 * Domain Path: /i18n/languages/
 *
 * WP Requirement & Test
 * Requires at least: 4.4
 * Tested up to: 6.3
 * Requires PHP: 5.6
 *
 * @package Applicant_Form
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'AFM_VERSION' ) ) {
	/**
	 * Plugin Version
	 * @var string
	 * @since 1.0.0
	 */
	define( 'AFM_VERSION', '1.0.0' );
}

if ( ! defined( 'AFM_FILE' ) ) {
    define( 'AFM_FILE', __FILE__ );
}

if ( ! defined( 'AFM_BASENAME' ) ) {
    define( 'AFM_BASENAME', plugin_basename(__FILE__) );
}

if ( ! defined( 'AFM_FILE_DIR' ) ) {
    define( 'AFM_FILE_DIR', dirname( __FILE__ ) );
}

if ( ! defined( 'AFM_PLUGIN_URL' ) ) {
    define( 'AFM_PLUGIN_URL', plugins_url( '', AFM_FILE ) );
}


// Include the main Applicant_Form class.
include_once AFM_FILE_DIR . '/includes/class-applicant-form.php';

/**
 * Returns the main instance of Applicant_Form.
 *
 * @since  1.0.0
 * @return Applicant_Form
 */
function afm_init() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
    return Applicant_Form::instance();
}

add_action('plugins_loaded', 'afm_plugins_loaded');
function afm_plugins_loaded() {
	// Global for backwards compatibility.
	if ( function_exists( 'afm_init' ) ) {
		$GLOBALS['afm_init'] = afm_init();
	}
}


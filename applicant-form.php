<?php
/**
 * Plugin Name: Applicant Form
 * Plugin URI: https://github.com/nayanchamp7/applicant-form
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
 * @category Plugin
 * @package  Applicant_Form
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 */

/**
 * Applicant Form
 *
 * @since    1.0.0
 * @category Admin
 */
defined('ABSPATH') || exit;

if (! defined('AFM_VERSION') ) {
    /**
     * Plugin Version
     *
     * @var   string
     * @since 1.0.0
     */
    define('AFM_VERSION', '1.0.0');
}

if (! defined('AFM_FILE') ) {
    define('AFM_FILE', __FILE__);
}

if (! defined('AFM_BASENAME') ) {
    define('AFM_BASENAME', plugin_basename(__FILE__));
}

if (! defined('AFM_FILE_DIR') ) {
    define('AFM_FILE_DIR', dirname(__FILE__));
}

if (! defined('AFM_PLUGIN_URL') ) {
    define('AFM_PLUGIN_URL', plugins_url('', AFM_FILE));
}

if (! defined('AFM_FORM_TABLE') ) {
    define('AFM_FORM_TABLE', "afm_form_entries");
}

// Include the main Applicant_Form class.
require_once AFM_FILE_DIR . '/includes/class-applicant-form.php';

/**
 * Returns the main instance of Applicant_Form.
 *
 * @since  1.0.0
 * @return Applicant_Form
 */
function afm_init()  // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
{
    return Applicant_Form::instance();
}

/**
 * Load `Applicant Form` Plugin when all plugins loaded
 * 
 * @return void
 */
function afm_plugins_loaded()
{
    // Global for backwards compatibility.
    if (function_exists('afm_init') ) {
        $GLOBALS['afm_init'] = afm_init();
    }
}
add_action('plugins_loaded', 'afm_plugins_loaded');

/**
 * Create database tables
 * 
 * @return void
 */
function afm_create_database_tables()
{

    global $wpdb;
    $attachment_post_table  = $wpdb->prefix . 'posts';
    $form_table = $wpdb->prefix . AFM_FORM_TABLE;
    $charset_collate  = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $form_table (
		id BIGINT(20) NOT NULL AUTO_INCREMENT,
		first_name VARCHAR(200) NOT NULL,
		last_name VARCHAR(200) NOT NULL,
		email VARCHAR(200) NOT NULL,
		mobile VARCHAR(200) NOT NULL,
		post_name VARCHAR(200) NOT NULL,
		present_address VARCHAR(200) NOT NULL,
		cv_attachment_id BIGINT(20) NOT NULL,
		submission_time DATETIME NOT NULL,
		PRIMARY KEY  (`id`)
	) $charset_collate;\n";

    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

}
register_activation_hook(AFM_FILE, 'afm_create_database_tables');


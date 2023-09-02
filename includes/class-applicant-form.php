<?php
/**
 * Applicant Form Class
 *
 * @category Base
 * @package  Applicant_Form
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form') ) {
    /**
     * Applicant_Form class
     *
     * @class Applicant_Form The class that holds the entire plugin
     *
     * @category Base
     * @package  Applicant_Form
     * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
     * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
     * @link     https://github.com/nayanchamp7/applicant-form
     * @property null|object $_instance Instance of the class
     */
    final class Applicant_Form
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form
         */
        private static $_instance = null;

        /**
         * Class constructor
         *
         * Sets up all the appropriate hooks and functions
         * within our plugin.
         *
         * @return void
         */
        public function __construct()
        {
            $this->dependency_inserter();
            $this->hooks();
            $this->init();
            do_action('afm_loaded', $this);
        }

        /**
         * Initializes class
         *
         * Checks for an existing instance
         * and if it doesn't find one, create it.
         * 
         * @return object
         */
        public static function instance()
        {
            if (is_null(self::$_instance) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Dependency things inserted first
         * 
         * @return void
         */
        public function dependency_inserter()
        {
            //include the autoload 
            include_once AFM_FILE_DIR . '/includes/autoload.php';
        }

        /**
         * All the executed hooks
         * 
         * @return void
         */
        public function hooks()
        {
            // Register with hook
            add_action('init', array( $this, 'language' ), 1);
        }

        /**
         * Initialize the classes
         * 
         * @return void
         */
        public function init()
        {

            if (is_admin()) {
                new Application_Form\Applicant_Form_Dashboard_Widget();
            }

            new Application_Form\Applicant_Form_Database();
            new Application_Form\Applicant_Form_Assets();
            new Application_Form\Applicant_Form_Shortcode();
            new Application_Form\Applicant_Form_Ajax();
            new Application_Form\Applicant_Form_Mail();
        }

        /**
         * Load text domain
         * 
         * @return void
         */
        public function language()
        {
            load_plugin_textdomain('applicant-form', false, plugin_basename(dirname(AFM_FILE)) . '/languages');
        }

        /**
         * File basename
         * 
         * @return string
         */
        public function basename()
        {
            return basename(dirname(AFM_FILE));
        }

        /**
         * Plugin basename
         * 
         * @return string
         */
        public function plugin_basename()
        {
            return plugin_basename(AFM_FILE);
        }

        /**
         * Plugin directory name
         * 
         * @return string
         */
        public function plugin_dirname()
        {
            return dirname(plugin_basename(AFM_FILE));
        }

        /**
         * Plugin directory path
         * 
         * @return string
         */
        public function plugin_path()
        {
            return untrailingslashit(plugin_dir_path(AFM_FILE));
        }

        /**
         * Plugin url
         * 
         * @return string
         */
        public function plugin_url()
        {
            return untrailingslashit(plugins_url('/', AFM_FILE));
        }
    }
}

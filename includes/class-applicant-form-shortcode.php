<?php
/**
 * Shortcode Class
 *
 * @category Shortcode
 * @package  Applicant_Form_Shortcode
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Shortcode') ) {
    /**
     * Applicant_Form class
     *
     * @class Applicant_Form_Shortcode The class that manages shortcodes
     *
     * @category Base
     * @package  Applicant_Form_Shortcode
     * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
     * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
     * @link     https://github.com/nayanchamp7/applicant-form
     * @property null|object $_instance Instance of the class
     */
    class Applicant_Form_Shortcode
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Shortcode
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
            $this->hooks();
            do_action('afm_shortcode_loaded', $this);
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
         * All the executed hooks
         * 
         * @return void
         */
        public function hooks()
        {
            // Register with hook
            add_action('init', array( $this, 'register_shortcode' ), 1);
        }

        /**
         * Register shortcodes
         * 
         * @return void
         */
        public function register_shortcode()
        {
            add_shortcode('applicant_form', array($this, 'applicant_form_callback'));
        }

        /**
         * Shortcode callback
         * 
         * @param array $args arguments
         * 
         * @return mixed
         */
        public function applicant_form_callback($args)
        {
            $attributes = shortcode_atts(
                array(
                'title' => false,
                ), $args 
            );

            // enqueue form style files.
            wp_enqueue_style('afm_styles');
            
            // enqueue form JS files.
            wp_enqueue_script('afm_script');
            
            ob_start();

            do_action('afm_before_form');
        
            include_once AFM_FILE_DIR . '/template/form-template.php';

            do_action('afm_after_form');
        
            return ob_get_clean();
        }
    }
}

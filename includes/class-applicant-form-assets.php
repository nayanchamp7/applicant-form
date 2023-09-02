<?php
/**
 * Assets Class
 *
 * @category Assets
 * @package  Applicant_Form_Assets
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Assets') ) {
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
    class Applicant_Form_Assets
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Assets
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
            do_action('afm_assets_loaded', $this);
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
            add_action('wp_enqueue_scripts', array( $this, 'register_public_styles' ), 999);
            add_action('wp_enqueue_scripts', array( $this, 'register_public_scripts' ), 999);
        }

        /**
         * Register styles.
         * 
         * @return void
         */
        public function register_public_styles()
        {

            // Register form style.
            wp_register_style('afm_styles', AFM_PLUGIN_URL . '/assets/public/css/style.min.css', array(), time());

        }
        
        /**
         * Register scripts.
         * 
         * @return void
         */
        public function register_public_scripts()
        {

            // Register form script.
            wp_register_script('afm_script', AFM_PLUGIN_URL . '/assets/public/js/script.js', array( 'jquery' ), time(), true);
            wp_localize_script(
                'afm_script', 'afm_script', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'form_messages' => array(
                        "email_invalid" => __("Invalid email", "application-form"),
                        "mobile_invalid" => __("Invalid mobile number", "application-form"),
                        "resume_invalid" => __("Please add (jpg, jpeg, png, gif, webp) file", "application-form"),
                        "empty" => __("Field can't be empty", "application-form"),
                    )
                ) 
            );

        }
    }
}

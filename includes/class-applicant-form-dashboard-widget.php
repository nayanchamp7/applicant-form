<?php
/**
 * Dashboard Widget Class
 *
 * @category Admin
 * @package  Applicant_Form_Dashboard_Widget
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Dashboard_Widget') ) {
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
    class Applicant_Form_Dashboard_Widget
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Dashboard_Widget
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
            do_action('afm_metabox_loaded', $this);
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
            add_action('wp_dashboard_setup', array( $this, 'dashboard_widgets' ));
        }

        /**
         * Dashboard widgets
         * 
         * @return void
         */
        function dashboard_widgets()
        {
            wp_add_dashboard_widget( 
                'afm-applcant-list',
                __('Recent Applicant List', 'applicant-form'),
                array($this, 'render_widget'),
                null,
                null,
                'normal',
                'high'
            );
        }

        /**
         * Render dashboard widget
         * 
         * @return void
         */
        public function render_widget()
        {
            $this->template();
        }

        /**
         * Dashboard widget content
         * 
         * @return mixed
         */
        public function template()
        {

            $attendee_list = Applicant_Form_Database::get_attendees([]);

            if (empty($attendee_list) ) {
                return;
            }
            
            ob_start();
            
            include_once AFM_FILE_DIR . '/template/widget-template.php';
            
            echo ob_get_clean();
        }
    }
}

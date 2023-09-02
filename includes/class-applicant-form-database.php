<?php
/**
 * Database Class
 *
 * @category Database
 * @package  Applicant_Form_Database
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Database') ) {
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
    class Applicant_Form_Database
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Database
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
            do_action('afm_database_loaded', $this);
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
         * Get recent attendee list
         * 
         * @param array $args arguments
         * 
         * @return mixed
         */
        public static function get_attendees( $args )
        {
            global $wpdb;
            $defaults = array(
                'limit' => 5,
                'offset' => 0,
            );
            $args = wp_parse_args($args, $defaults);
            $table = $wpdb->prefix . AFM_FORM_TABLE;

            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table} ORDER BY id DESC LIMIT %d, %d;",
                    $args['offset'],
                    $args['limit']
                ),
                OBJECT
            );
        }

        /**
         * Insert query
         * 
         * @param string $table  table name
         * @param array  $data   insert data
         * @param array  $format data format
         * 
         * @return boolean|int
         */
        public static function insert($table, $data, $format)
        {
            if (empty($table) ) {
                return false;
            }

            global $wpdb;

            //set the table name with prefix
            $prefix = $wpdb->prefix;
            $table = $prefix.$table;

            //insert query
            $inserted  = $wpdb->insert($table, $data, $format);
            
            $insert_id = false;
            if ($inserted ) {
                $insert_id = $wpdb->insert_id;
            } else {
                $wpdb->print_error();
            }

            return $insert_id;
        }
        
    }
}

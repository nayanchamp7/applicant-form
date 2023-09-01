<?php
namespace Application_Form;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Applicant_Form_Database' ) ) {
	class Applicant_Form_Database {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Database
         */
        private static $instance = null;

		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->init();
			do_action( 'afm_database_loaded', $this );
		}

		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function includes() {
			
		}

		public function hooks() {
            
		}

		public static function insert($table, $data, $format) {
			if( empty($table) ) {
				return false;
			}

            global $wpdb;

			//set the table name with prefix
            $prefix = $wpdb->prefix;
			$table = $prefix.$table;

			//insert query
			$inserted  = $wpdb->insert( $table, $data, $format );
			
			$insert_id = false;
			if( $inserted ) {
				$insert_id = $wpdb->insert_id;
			}else {
				$wpdb->print_error();
			}

			return $insert_id;
		}

		public function init() {
		}
        
	}
}

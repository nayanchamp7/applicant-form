<?php

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

		public function init() {
		}
        
	}
}

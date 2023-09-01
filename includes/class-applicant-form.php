<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Applicant_Form' ) ) {
	final class Applicant_Form {

        /**
         * Instance of self
         *
         * @var Applicant_Form
         */
        private static $instance = null;

		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->init();
			do_action( 'afm_loaded', $this );
		}

		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function includes() {
			require_once dirname( __FILE__ ) . '/class-applicant-form-database.php';
			require_once dirname( __FILE__ ) . '/class-applicant-form-assets.php';
			require_once dirname( __FILE__ ) . '/class-applicant-form-shortcode.php';
		}

		public function hooks() {
			// Register with hook
			add_action( 'init', array( $this, 'language' ), 1 );
		}

		public function init() {
			new Applicant_Form_Database();
			new Applicant_Form_Assets();
            new Applicant_Form_Shortcode();
		}

		public function language() {
			load_plugin_textdomain( 'applicant-form', false, plugin_basename( dirname( AFM_FILE ) ) . '/languages' );
		}

		public function basename() {
			return basename( dirname( AFM_FILE ) );
		}

		public function plugin_basename() {
			return plugin_basename( AFM_FILE );
		}

		public function plugin_dirname() {
			return dirname( plugin_basename( AFM_FILE ) );
		}

		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( AFM_FILE ) );
		}

		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', AFM_FILE ) );
        }
	}
}

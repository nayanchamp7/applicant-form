<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Applicant_Form_Assets' ) ) {
	class Applicant_Form_Assets {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Assets
         */
        private static $instance = null;

		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->init();
			do_action( 'afm_assets_loaded', $this );
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
            add_action( 'wp_enqueue_scripts', array( $this, 'register_public_styles' ), 999 );
            add_action( 'wp_enqueue_scripts', array( $this, 'register_public_scripts' ), 999 );
		}

		public function init() {
		}

        /**
         * Register styles.
         */
        public function register_public_styles() {

            // Register form style.
            wp_register_style( 'afm_styles', AFM_PLUGIN_URL . '/assets/public/css/style.min.css', array(), time() );

        }
        
        /**
         * Register scripts.
         */
        public function register_public_scripts() {

            // Register form script.
            wp_register_script( 'afm_script', AFM_PLUGIN_URL . '/assets/public/js/script.js', array( 'jquery' ), time(), true );

        }
	}
}

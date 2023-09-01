<?php
namespace Application_Form;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Applicant_Form_Shortcode' ) ) {
	class Applicant_Form_Shortcode {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Shortcode
         */
        private static $instance = null;

		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->init();
			do_action( 'afm_shortcode_loaded', $this );
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
			// Register with hook
			add_action( 'init', array( $this, 'register_shortcode' ), 1 );
		}

		public function init() {
		}

        public function register_shortcode() {
            add_shortcode( 'applicant_form', array($this, 'applicant_form_callback') );
        }

        public function applicant_form_callback($atts) {
            $attributes = shortcode_atts( array(
                'title' => false,
            ), $atts );

            // enqueue form style files.
            wp_enqueue_style( 'afm_styles' );
            
            // enqueue form JS files.
            wp_enqueue_script( 'afm_script' );
            
            ob_start();

            do_action('afm_before_form');
        
            include_once AFM_FILE_DIR . '/template/form-template.php';

            do_action('afm_after_form');
        
            return ob_get_clean();
        }
	}
}

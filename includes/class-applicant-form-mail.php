<?php
namespace Application_Form;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Applicant_Form_Mail' ) ) {
	class Applicant_Form_Mail {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Mail
         */
        private static $instance = null;

		public function __construct() {
			$this->includes();
			$this->hooks();
			$this->init();
			do_action( 'afm_mail_loaded', $this );
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
            add_action('afm_trigger_send_applicant_mail', array($this, 'sent_mail'));
		}

		public function init() {
		}

        public function sent_mail($contact_name, $email, $contact_message) {
            
        }
	}
}

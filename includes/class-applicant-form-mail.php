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

		public function get_mail_content($args) {
			ob_start();
			
			include_once AFM_FILE_DIR . '/template/email-template.php';
			
			return ob_get_clean();
		}

        public function sent_mail($args) {

			error_log("inside mail log");

			if( ! isset($args['email']) ) {
				return false;
			}
			
			if( ! isset($args['contact_name']) ) {
				return false;
			}
			
			if( ! isset($args['subject']) ) {
				return false;
			}
			
			if( isset($args['headers']) && !empty($args['headers']) ) {
				$headers = $args['headers'];
			}else {
				$headers = array('Content-Type: text/html; charset=UTF-8');
			}

			$email 		= sanitize_email( wp_unslash($args['email']) );
			$subject 	= sanitize_text_field( wp_unslash($args['subject']) );
			$contact_name = sanitize_text_field( wp_unslash($args['contact_name']) );

			//content arguments
			$content_args = [
				'reciever_name' => $contact_name,
				'email' => $email
			];

			//get mail content
			$content = $this->get_mail_content($content_args);
			
			//send mail
			wp_mail($email, $subject, $content, $headers);
        }
	}
}

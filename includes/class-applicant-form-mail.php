<?php
/**
 * Mail Class
 *
 * @category Mail
 * @package  Applicant_Form_Mail
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Mail') ) {
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
    class Applicant_Form_Mail
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Mail
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
            do_action('afm_mail_loaded', $this);
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
            add_action('afm_trigger_send_applicant_mail', array($this, 'send_mail'));
        }

        /**
         * Get the mail content
         * 
         * @param array|null $args arguments
         * 
         * @return mixed
         */
        public function get_mail_content($args)
        {
            ob_start();
            
            include_once AFM_FILE_DIR . '/template/email-template.php';
            
            return ob_get_clean();
        }

        /**
         * Send mail
         * 
         * @param array $args arguments
         * 
         * @return void
         */
        public function send_mail($args)
        {

            if (! isset($args['email']) ) {
                return false;
            }
            
            if (! isset($args['contact_name']) ) {
                return false;
            }
            
            if (! isset($args['subject']) ) {
                return false;
            }
            
            if (isset($args['headers']) && !empty($args['headers']) ) {
                $headers = $args['headers'];
            } else {
                $headers = array('Content-Type: text/html; charset=UTF-8');
            }

            $email         = sanitize_email(wp_unslash($args['email']));
            $subject     = sanitize_text_field(wp_unslash($args['subject']));
            $contact_name = sanitize_text_field(wp_unslash($args['contact_name']));

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

<?php
/**
 * Ajax Class
 *
 * @category Ajax
 * @package  Applicant_Form_Ajax
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
namespace Application_Form;

defined('ABSPATH') || exit;

if (! class_exists('Applicant_Form_Ajax') ) {
    /**
     * Applicant_Form_Ajax class
     *
     * @class Applicant_Form_Ajax The class that manages ajax requests
     *
     * @category Ajax
     * @package  Applicant_Form_Ajax
     * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
     * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
     * @link     https://github.com/nayanchamp7/applicant-form
     * @property null|object $_instance Instance of the class
     */
    class Applicant_Form_Ajax
    {

        /**
         * Instance of self
         *
         * @var Applicant_Form_Ajax
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
            do_action('afm_ajax_loaded', $this);
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
            add_action('wp_ajax_afm_submit_form_data', array($this, 'submit_form'));
            add_action('wp_ajax_nopriv_afm_submit_form_data', array($this, 'submit_form'));
        }

        /**
         * Submit form data.
         * 
         * @return void
         */
        public function submit_form()
        {

            //check and validate nonce
            if (! isset($_POST['_wpnonce']) || ! wp_verify_nonce(sanitize_key(wp_unslash($_POST['_wpnonce'])), 'afm_form_nonce') ) {
                wp_send_json_error(__('Invalid nonce', 'applicant-form'));
            }

            //check firstname value
            if (isset($_POST['first_name']) || ! empty($_POST['first_name'])  ) {
                $first_name = sanitize_text_field(wp_unslash($_POST['first_name']));
            } else {
                $message = __('Please provide your first name.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check lastname value
            if (isset($_POST['last_name']) || ! empty($_POST['last_name'])  ) {
                $last_name = sanitize_text_field(wp_unslash($_POST['last_name']));
            } else {
                $message = __('Please provide your last name.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check email value
            if (isset($_POST['email_address']) || ! empty($_POST['email_address'])  ) {
                $email = sanitize_email(wp_unslash($_POST['email_address']));

                // validate email
                if (!is_email($email) ) {
                    $message = __('Email address is not valid.', 'applicant-form');
                    wp_send_json_error($message);
                }
            } else {
                $message = __('Please provide your email.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check mobile value
            if (isset($_POST['mobile']) || ! empty($_POST['mobile'])  ) {
                $mobile = sanitize_text_field(wp_unslash($_POST['mobile']));
            } else {
                $message = __('Please provide your mobile.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check post name
            if (isset($_POST['post_name']) || ! empty($_POST['post_name'])  ) {
                $post_name = sanitize_text_field(wp_unslash($_POST['post_name']));
            } else {
                $message = __('Please provide your post name.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check present address
            if (isset($_POST['present_address']) || ! empty($_POST['present_address'])  ) {
                $present_address = sanitize_text_field(wp_unslash($_POST['present_address']));
            } else {
                $message = __('Please provide your present address.', 'applicant-form');
                wp_send_json_error($message);
            }
            
            //check and upload resume
            if (isset($_FILES['resume']["name"]) || ! empty($_FILES['resume']["name"])  ) {
                $resume_file = wp_unslash($_FILES['resume']);

                if (isset($resume_file["size"]) && $resume_file["size"] > 2000000 ) {
                    $message = __('File size must not be above 2mb.', 'applicant-form');
                    wp_send_json_error($message);
                }

                if (isset($resume_file["type"]) ) {
                    if (! in_array($resume_file["type"], ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp']) ) {
                        $message = __('Please select (jpeg, png, gif, webp) file.', 'applicant-form');
                        wp_send_json_error($message);
                    }
                }

                // Include image.php, file.php, media.php.
                include_once ABSPATH . 'wp-admin/includes/image.php';
                include_once ABSPATH . 'wp-admin/includes/file.php';
                include_once ABSPATH . 'wp-admin/includes/media.php';

                //insert resume attachment
                $cv_attachment_id = media_handle_upload("resume", 0);
                
            } else {
                $message = __('Please provide your resume.', 'applicant-form');
                wp_send_json_error($message);
            }

            //insert query data
            $data = [
                'first_name'    => $first_name,
                'last_name'     => $last_name,
                'email'         => $email,
                'mobile'        => $mobile,
                'post_name'     => $post_name,
                'present_address'   => $present_address,
                'cv_attachment_id'  => $cv_attachment_id,
                'submission_time'   => current_time('mysql'),
            ];
    
            //insert query data format
            $format = [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%s',
            ];
    
            // add data into database
            $insert_id = Applicant_Form_Database::insert(AFM_FORM_TABLE, $data, $format);
            
            // send mail after successfully data inserted
            if ($insert_id ) {
                //set mail arguments
                $args['email'] = $email;
                $args['contact_name'] = $first_name . " " . $last_name;
                $args['subject'] = __("Application Recieved!", "application-form");
                $args['contact_message'] = "";

                //send mail action
                do_action('afm_trigger_send_applicant_mail', $args);
                
                $message = __('Email sent successfully!', 'applicant-form');
                wp_send_json_success($message);
            }

        }
    }
}

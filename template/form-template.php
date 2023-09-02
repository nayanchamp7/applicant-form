<?php
/**
 * Form Template
 *
 * @category Template
 * @package  Template
 * @author   Nazrul Islam Nayan <nazrulislamnayan7@gmail.com>
 * @license  GPL3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link     https://github.com/nayanchamp7/applicant-form
 * @since    1.0.0
 */
?>
<div class="afm-wrapper">
    <div class="afm-container">
        <h2><?php esc_html_e('Applicant Form', 'application-form'); ?></h2>
        <div class="afm-loader afm-hide">
            <img src="<?php echo AFM_PLUGIN_URL . "/assets/public/images/loader.gif"; ?>" alt="<?php esc_html_e('Loader', 'application-form'); ?>">
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="afm-form-control">
                <label for="first_name"><?php esc_html_e('First Name', 'application-form'); ?></label>
                <input type="text" name="first_name" id="first_name" placeholder="<?php esc_html_e('John', 'application-form'); ?>">

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("First name can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="last_name"><?php esc_html_e('Last Name', 'application-form'); ?></label>
                <input type="text" name="last_name" id="last_name" placeholder="<?php esc_html_e('Doe', 'application-form'); ?>">

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("Last name can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="email_address"><?php esc_html_e('Email Address', 'application-form'); ?></label>
                <input type="email" name="email_address" id="email_address" placeholder="<?php esc_html_e('abc@gmail.com', 'application-form'); ?>">

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("Email can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="mobile"><?php esc_html_e('Mobile', 'application-form'); ?></label>
                <input type="tel" name="mobile" id="mobile" placeholder="<?php esc_html_e('019-00000000', 'application-form'); ?>">

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("Mobile number can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="post_name"><?php esc_html_e('Post Name', 'application-form'); ?></label>
                <select name="post_name" id="post_name">
                    <option value=""><?php esc_html_e('Select Post', 'application-form'); ?></option>
                    <option value="content_writer"><?php esc_html_e('Content Writer', 'application-form'); ?></option>
                    <option value="marketer"><?php esc_html_e('Digital Marketer', 'application-form'); ?></option>
                    <option value="designer"><?php esc_html_e('Graphics Designer', 'application-form'); ?></option>
                    <option value="developer"><?php esc_html_e('Web Developer', 'application-form'); ?></option>
                </select>

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("Post name can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="present_address"><?php esc_html_e('Present Address', 'application-form'); ?></label>
                <textarea name="present_address" id="present_address" cols="30" rows="10"></textarea>

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("Present can't be empty.", 'application-form'); ?></p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="resume"><?php esc_html_e('CV', 'application-form'); ?></label>
                <input type="file" name="resume" id="resume">

                <div class="afm-error-message afm-hide">
                    <p><?php esc_html_e("CV can't be empty.", 'application-form'); ?></p>
                </div>
            </div>

            <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce('afm_form_nonce'); ?>">
            <input type="submit" value="<?php esc_html_e('Apply', 'application-form'); ?>">
        </form>
    </div>
</div>

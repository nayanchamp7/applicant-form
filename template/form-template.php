<div class="afm-wrapper">
    <div class="afm-container">
        <h2>Applicant Form</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="afm-form-control">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="John">

                <div class="afm-error-message">
                    <p>First name can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Doe">

                <div class="afm-error-message">
                    <p>Last name can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="email_address">Email Address</label>
                <input type="email" name="email_address" id="email_address" placeholder="abc@gmail.com">

                <div class="afm-error-message">
                    <p>Email can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="mobile">Mobile</label>
                <input type="tel" name="mobile" id="mobile" placeholder="019-00000000">

                <div class="afm-error-message">
                    <p>Mobile number can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="post_name">Post Name</label>
                <select name="post_name" id="post_name">
                    <option value="content_writer">Content Writer</option>
                    <option value="marketer">Digital Marketer</option>
                    <option value="designer">Graphics Designer</option>
                    <option value="developer">Web Developer</option>
                </select>

                <div class="afm-error-message">
                    <p>Post name can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="present_address">Present Address</label>
                <textarea name="present_address" id="present_address" cols="30" rows="10"></textarea>

                <div class="afm-error-message">
                    <p>Present can't be empty.</p>
                </div>
            </div>
            
            <div class="afm-form-control">
                <label for="resume">CV</label>
                <input type="file" name="resume" id="resume">

                <div class="afm-error-message">
                    <p>CV can't be empty.</p>
                </div>
            </div>

            <input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo wp_create_nonce( 'afm_form_nonce' ); ?>">
            <input type="submit" value="Apply">
        </form>
    </div>
</div>
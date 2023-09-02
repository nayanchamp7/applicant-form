/**
 * Woocommerce FAQ Public JS
 *
 * Copyright (c) 2019 wpfeel
 * Licensed under the GPLv2+ license.
 */
jQuery(document).ready(
    function ($) {
        'use strict';

        $.applicantForm = {
            ajax_url: '',
            /**
             * Initialize and calling hooks and functions
             * 
             * @return void
             */
            init: function () {
                $(document).on('submit', '.afm-wrapper form', this.submitForm);
            },

            /**
             * Set and display error messages 
             * 
             * @return void
             */
            setError: function (input, message) {
                var errorInput = input.parents('.afm-form-control').find('.afm-error-message');
                errorInput.removeClass('afm-hide');
                errorInput.find('p').text(message);
            },

            /**
             * Submit form data 
             * 
             * @return void
             */
            submitForm: function (event) {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);
                const entries = Object.fromEntries(formData);

                //validate input fields
                const validated = $.applicantForm.validateInputs(entries);

                //add action hook to the form data
                formData.append("action", "afm_submit_form_data");

                if(validated ) {
                    //show loader
                    $(".afm-loader").removeClass("afm-hide");
                
                    $.ajax(
                        {
                            method: "POST",
                            url: afm_script.ajaxurl,
                            dataType: "json",
                            processData : false,
                            contentType: false,
                            data: formData,
                        }
                    )
                    .done(
                        function ( response ) {
                            //hide loader after a few while
                            setTimeout(
                                function () {
                                    $(".afm-loader").addClass("afm-hide");
                                    form.reset();
                                }, 1000
                            )
                    
                            if(!response.sucess ) {
                                alert(response.data);
                            }
                        }
                    );
                }

            },

            /**
             * Validate input fields
             * 
             * @return void
             */
            validateInputs: function (entries) {

                if(Object.keys(entries).length > 0 ) {
                    
                    var errorInputs = [];
                    for (const key in entries) {
                        var value       = entries[key];
                        var selector    = $('input[name='+ key +']');
                        var message     = afm_script.form_messages['empty'];
                        var error       = false;

                        if( value.length === 0 ) {
                            error = true;
                        }

                        //validate email
                        if(key === 'email_address' ) {
                            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value) === false) {
                                error = true;
                                //when value exist, but invalid value the show invalid message
                                if( value.length > 0 ) {
                                    message = afm_script.form_messages['email_invalid'];
                                }
                                
                            }
                        }
                        
                        //validate mobile
                        if(key === 'mobile' ) {
                            if (/^[0-9]*$/.test(value) === false) {
                                error = true;

                                //when value exist, but invalid value the show invalid message
                                if( value.length > 0 ) {
                                    message = afm_script.form_messages['mobile_invalid'];
                                }
                                
                            }
                        }

                        //present address selector
                        if( key === "present_address" ) {
                            selector = $('textarea[name=present_address]');
                        }
                        
                        //post name selector
                        if( key === "post_name" ) {
                            selector = $('select[name=post_name]');
                        }
                        
                        //validate resume file
                        if( key === "resume" ) {

                            if( value.name.length === 0 ) {
                                error = true;
                            } else if( value.type ) {
                                var accepted_file_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                                var resume_file_index = accepted_file_types.indexOf(value.type);

                                if( resume_file_index == -1 ) {
                                    error = true;
                                    message = afm_script.form_messages['resume_invalid'];
                                }
                            }
                        }
                        
                        //when error show error message, else hide the error message
                        if( error ) {
                            errorInputs.push(key);
                            $.applicantForm.setError(selector, message);
                        }else {
                            var targetInput = selector.parents('.afm-form-control').find('.afm-error-message');
                            targetInput.addClass('afm-hide');
                        }
                    }

                    //when no error exists return true
                    if( errorInputs.length === 0 ) {
                        return true;
                    }else {
                        return false;
                    }
                }
            }

        };

        // init the scripts
        $.applicantForm.init();
    }
);

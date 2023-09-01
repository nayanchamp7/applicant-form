/**
 * Woocommerce FAQ Public JS
 *
 * Copyright (c) 2019 wpfeel
 * Licensed under the GPLv2+ license.
 */
jQuery(document).ready(function ($) {
    'use strict';

    $.applicantForm = {
        ajax_url: '',
        init: function () {
            //ajax url

            $(document).on('submit', '.afm-wrapper form', this.submitForm);

        },
        setError: function (input, message) {
            const formControl = input.parentElement;
        },
        submitForm: function (event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const entries = Object.fromEntries(formData);

            const validated = $.applicantForm.validateInputs(entries);

            console.log(entries);
            console.log(entries.resume);

            console.log(typeof entries.resume);

            //add action hook to the form data
            formData.append("action", "afm_submit_form_data");

            if( validated ) {
                //show loader
                $(".afm-loader").removeClass("afm-hide");
                
                $.ajax({
                    method: "POST",
                    url: afm_script.ajaxurl,
                    dataType: "json",
                    processData : false,
                    contentType: false,
                    data: formData,
                })
                .done(function( response ) {
                    console.log(response);
                    //hide loader after a few while
                    setTimeout(function() {
                        $(".afm-loader").addClass("afm-hide");
                    }, 1000)
                    
                    if( !response.sucess ) {
                        alert(response.data);
                    }
                });
            }

        },
        validateInputs: function(entries) {

            if( Object. keys(entries).length > 0 ) {
                for (const key in entries) {
                    if( key === 'email' ) {
                        
                    }
                    //console.log(`${key}: ${entries[key]}`);
                }
            }

            return true;
        }

    };

    // init the scripts
    $.applicantForm.init();
});

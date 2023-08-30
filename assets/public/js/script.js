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

            $.applicantForm.validateInputs(entries);
        },
        validateInputs: function(entries) {

            if( Object. keys(entries).length > 0 ) {
                for (const key in entries) {
                    if( key === 'email' ) {
                        
                    }
                    console.log(`${key}: ${entries[key]}`);
                }
            }
        }

    };

    // init the scripts
    $.applicantForm.init();
});

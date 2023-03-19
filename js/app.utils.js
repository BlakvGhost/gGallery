jQuery(function($) {
    'use strict';

    const utils = {
        init: function() {
            this.passwordVisibility();
        },
        passwordVisibility: function() {
            $('.password-visible').on('click', function() {
                const $parent = $(this).prev('input');
                const $icon = $(this).children('i');

                if ($parent.is(':password')) {
                    $parent.attr('type', 'text');
                    $icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
                } else {
                    $parent.attr('type', 'password');
                    $icon.removeClass('mdi-eye-off-outline').addClass('mdi-eye-outline');
                }
            });
        }
    };
    utils.init();
});

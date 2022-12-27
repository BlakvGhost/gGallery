
jQuery(function() {
    (!function(){
        "use strict"
    
        const utils = (jQuery, {
            
            init: function() {
                this.passwordVisibility();                
            },
            passwordVisibility: function() {
                $('.password-visible').each(function() {

                    $(this).on('click', function() {
                        let $parent = $(this).prev('input');

                        if ($parent.is(':password')){                            
                            $parent.attr('type', 'text');
                            $(this).children('i').removeClass('mdi-eye-outline').addClass('mdi-eye-off-outline');
                        }else{
                            $parent.attr('type', 'password');
                            $(this).children('i').addClass('mdi-eye-outline').removeClass('mdi-eye-off-outline');
                        }
                    })                    
                })
            }
        }).init();
    }())
})
/*
 Project author:     ModelTheme
 File name:          Custom Popup JS
*/

jQuery(document).ready(function() {
        
      jQuery('#exit-popup').click(function(e) { 
        jQuery('.popup').fadeOut(1000);
        jQuery('.popup').removeClass("modeltheme-show");
      });

        var expireDate = jQuery('.popup').attr('data-expire');
        var timeShow = jQuery('.popup').attr('show');
        var visits = jQuery.cookie('visits') || 0;
        visits++;
        
        if(expireDate = 1) {
            jQuery.cookie('visits', visits, { expires: 1, path: '/' });
        } else if(expireDate = 3){
            jQuery.cookie('visits', visits, { expires: 3, path: '/' });
        } else if(expireDate = 7){
            jQuery.cookie('visits', visits, { expires: 7, path: '/' });
        } else if(expireDate = 30){
            jQuery.cookie('visits', visits, { expires: 30, path: '/' });
        } else {
            jQuery.cookie('visits', visits, { expires: 3000, path: '/' });
        }
        
        if ( jQuery.cookie('visits') > 1 ) {
            jQuery('.popup').removeClass("modeltheme-show");
            jQuery.cookie();
        } else {
            jQuery(function() {
                 setTimeout(function(){
                     showElement();
                  }, timeShow);
                 function showElement() {
                    jQuery('.popup').addClass("modeltheme-show");
                 }
            });
            
        }
});
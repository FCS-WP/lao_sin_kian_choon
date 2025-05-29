/*
 Project name:       groffer
 Project author:     ModelTheme
 File name:          Custom JS
*/

(function ($) {

    'use strict';
    
    $(document).ready(function() {

        //Instant search in header
        jQuery('.groffer-header-searchform input#keyword').on('blur', function(){
            jQuery('#datafetch').removeClass('focus');
        }).on('focus', function(){
            jQuery('#datafetch').addClass('focus');
        });

        if ( jQuery( ".slider-moving" ).length ) {
            //moving slider
            var scrollSpeed = 60;        // Speed in milliseconds
            var step = 1;               // How many pixels to move per step
            var current = 0;            // The current pixel row
            var imageWidth = 3473;      // Background image width
            var headerWidth = 1170;     // How wide the header is.

            //The pixel row where to start a new loop
            var restartPosition = -(imageWidth - headerWidth);

            function scrollBg(){
                //Go to next pixel row.
                current += step;
                
                //If at the end of the image, then go to the top.
                if (current == restartPosition){
                    current = 0;
                }
                
                //Set the CSS of the header.
                jQuery('.slider-moving').css("background-position",current+"px 0");
            }

            setInterval(scrollBg, scrollSpeed);
        }

        $("html").removeClass("html-has-lrm");

        jQuery('#signup-modal-content .show_if_seller input').each(function(){
            jQuery(this).prop('disabled', true);
        });

        jQuery('#signup-modal-content .user-role input[value="customer"]').click(function() {
            if(jQuery(this).is(':checked')) {
                jQuery('#signup-modal-content .show_if_seller').hide();
                jQuery('#signup-modal-content .show_if_seller input').each(function(){
                    jQuery(this).prop('disabled', true);
                });
            }
        });

        jQuery('#signup-modal-content .user-role input[value="seller"]').click(function() {
            if(jQuery(this).is(':checked')) {
                jQuery('#signup-modal-content .show_if_seller').show();
                jQuery('.modeltheme-modal.modeltheme-show').css("top","75%");
                jQuery('#signup-modal-content .show_if_seller input').each(function(){
                    jQuery(this).prop('disabled', false);
                });
            }
        });
        
        jQuery('.mt_field--input_datepicker input').each(function(){
            var date_format = jQuery( this ).attr('data-date-format');
            if (date_format != '') {
                jQuery( this ).datepicker({ dateFormat: date_format });
            }else{
                jQuery( this ).datepicker({ dateFormat: "yy/mm/dd" });
            }
        });

        jQuery('.widget_categories li .children').each(function(){
            jQuery(this).parent().addClass('cat_item_has_children');
        });
        jQuery('.widget_nav_menu li a').each(function(){
            if (jQuery(this).text() == '') {
                jQuery(this).parent().addClass('link_missing_text');
            }
        });
    
        // DOKAN MARKETPLACE Auctions settings
        jQuery( '.auction-checkbox .groffer_is_auction' ).on( "click", function() {
            if (jQuery('.auction-checkbox .groffer_is_auction').is(':checked')) {
                jQuery(".groffer-auction-settings").show();
            }else{
                jQuery(".groffer-auction-settings").hide();
            }
        });
        
        // WCFM MARKETPLACE Auctions settings
        jQuery( '#product_type' ).on('change', function() {
            var product_type_value = jQuery(this).val();
            if (product_type_value == 'auction') {
                jQuery(".groffer-auction-settings").show();
            }else{
                jQuery(".groffer-auction-settings").hide();
            }
        });

        if ( jQuery( ".single .grouped_form" ).length ) {
            if ( jQuery( ".single .wishlist-container" ).length ) {
                jQuery(".single .wishlist-container").insertAfter(".single_add_to_cart_button");
            }
        }


        //Begin: Validate and Submit contact form via Ajax
        jQuery("#modal-log-in #loginform").validate({
            //Ajax validation rules
            rules: {
                log: {
                    required: true,
                    minlength: 2
                },
                pwd: {
                    required: true,
                }
            },
            //Ajax validation messages
            messages: {
                log: {
                    required: "Please enter your username",
                },
                pwd: {
                    required: "Please enter your password",
                },
            },
        });

        //Begin: Validate and Submit contact form via Ajax
        jQuery("#contact_form").validate({
            //Ajax validation rules
            rules: {
                user_name: {
                    required: true,
                    minlength: 2
                },
                user_message: {
                    required: true,
                    minlength: 10
                },
                user_subject: {
                    required: true,
                    minlength: 5
                },
                user_email: {
                    required: true,
                    email: true
                }
            },
            //Ajax validation messages
            messages: {
                user_name: {
                    required: "Please enter a name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                user_message: {
                    required: "Please enter a message",
                    minlength: "Your message must consist of at least 10 characters"
                },
                user_subject: {
                    required: "Please provide a subject",
                    minlength: "Your subject must be at least 5 characters long"
                },
                user_email: "Please enter a valid email address"
            },
            //Submit via Ajax Form
            submitHandler: function() {
                jQuery('#contact_form').ajaxSubmit();
                jQuery('.success_message').fadeIn('slow');
            }
        });
        //End: Validate and Submit contact form via Ajax
        
        function applyResponsiveBehavior() {
            if (jQuery(window).width() < 1100) {
                var expand = '<span class="expand"><a class="action-expand"></a></span>';

                // Remove existing expand elements to avoid duplication
                jQuery('.navbar-collapse .expand').remove();

                // Append expand elements to the desired elements
                jQuery('.navbar-collapse .menu-item-has-children, .navbar-collapse .mega1column, .navbar-collapse .mega2columns, .navbar-collapse .mega3columns').append(expand);

                // Hide sub-menus initially
                jQuery('nav #navbar .sub-menu').hide();

                // Set up click event handlers for expanding menus
                jQuery(".menu-item-has-children .expand a").off("click").on("click", function() {
                    jQuery(this).parent().parent().find(' > ul').toggle();
                    jQuery(this).toggleClass("show-menu");
                });

                // Set up click event handlers for mega menus
                jQuery(".mega1column .expand a, .mega2columns .expand a, .mega3columns .expand a").off("click").on("click", function() {
                    jQuery(this).parent().parent().find(' > .cf-mega-menu').toggle();
                    jQuery(this).toggleClass("show-menu");
                });
            } else {
                // If the width is greater than or equal to 1100, you might want to reset any changes made
                jQuery('.navbar-collapse .expand').remove();
                jQuery('nav #navbar .sub-menu, .cf-mega-menu').show();
            }
        }

        // Run the function on document ready
        jQuery(document).ready(function() {
            applyResponsiveBehavior();
        });

        // Run the function on window resize
        jQuery(window).resize(function() {
            applyResponsiveBehavior();
        });

        
        //Begin: Sticky Head
        jQuery(function(){
           if (jQuery('body').hasClass('is_nav_sticky')) {
                jQuery(window).resize(function() {
                    if (jQuery(window).width() <= 768) {
                    } else {
                        jQuery("#groffer-main-head").sticky({
                            topSpacing:0
                        });
                    }
                });

                if (jQuery(window).width() >= 768) {
                    jQuery("#groffer-main-head").sticky({
                        topSpacing:0
                    });
                }
           }
        });

        (function() {
        [].slice.call( document.querySelectorAll( ".mt-tabs .tabs" ) ).forEach( function( el ) {
            new CBPFWTabs( el );
        });

        })();

        //End: Sticky Head
        jQuery('.cart-contents').hover(function() {
            /* Stuff to do when the mouse enters the element */
            jQuery('.header_mini_cart').addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery('.header_mini_cart').removeClass('visible_cart');
        });

        jQuery('.menu-product-cart img').hover(function() {
            /* Stuff to do when the mouse enters the element */
            jQuery('.header_mini_cart').addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery('.header_mini_cart').removeClass('visible_cart');
        });

        jQuery('.shop_cart').hover(function() {
            /* Stuff to do when the mouse enters the element */
            jQuery('.header_mini_cart').addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery('.header_mini_cart').removeClass('visible_cart');
        });

        jQuery('.header_mini_cart').hover(function() {
            /* Stuff to do when the mouse enters the element */
            jQuery(this).addClass('visible_cart');
        }, function() {
            /* Stuff to do when the mouse leaves the element */
            jQuery(this).removeClass('visible_cart');
        });


        if ( jQuery( ".woocommerce_categories" ).length ) {
            
            jQuery('.woocommerce_categories').each(function(){

                jQuery(this).find('.products_category .products_by_category:first').addClass("active");
                jQuery(this).find('.categories_shortcode .category:first').addClass("active");

                var selectShortcode = jQuery(this).attr('id');

                // alert(selectShortcode);
                // alert(jQuery(this).attr('class'));
                jQuery(this).find(".category a").click(function () {

                    // alert(jQuery(this).attr('class'));

                    var attr = jQuery(this).attr("class");
                    // alert(attr);

                    jQuery('#'+selectShortcode).find(".products_by_category").removeClass("active");
                    jQuery(attr).addClass("active");

                    jQuery('#'+selectShortcode).find('.category').removeClass("active");
                    jQuery(this).parent().addClass("active");

                });  
            });  

        }

        //knowledge list accordion
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            // Variables privadas
            var links = this.el.find('.link');
            // Evento
            links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
        }
        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
                $this = jQuery(this),
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                $el.find('.bot_nav_cat_wrap').not($next).slideUp().parent().removeClass('open');
            };
        }   
        var accordion = new Accordion(jQuery('#accordion'), false);
            //Begin: Search Form
            if ( jQuery( "#groffer-search" ).length ) {
                new UISearch( document.getElementById( 'groffer-search' ) );
            }
        //End: Search Form

        //Begin: WooCommerce Quantity
        jQuery( function( $ ) {
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function() {
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
            });
        });
         //End: WooCommerce Quantity

        /*Begin: Testimonials slider*/
        jQuery(".testimonials-container").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-1").owlCarousel({
            navigation      : false, // Show next and prev buttons
            navigationText  : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 400,
            paginationSpeed : 400,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   1],
                [700,   1],
                [1000,  1],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-2").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  2],
                [1200,  2],
                [1400,  2],
                [1600,  2]
            ]
        });
        jQuery(".testimonials-container-3").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   1],
                [600,   2],
                [700,   2],
                [1000,  3],
                [1200,  3],
                [1400,  3],
                [1600,  3]
            ]
        });
        /*End: Testimonials slider*/


        /*Begin: Products Carousel slider*/
        jQuery(".modeltheme_products_carousel").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
            itemsCustom : [
                [0,     1],
                [450,   2],
                [600,   2],
                [700,   4],
                [1000,  4],
                [1200,  4],
                [1400,  4],
                [1600,  4]
            ]
        });

        /*Begin: Portfolio single slider*/
        jQuery(".portfolio_thumbnails_slider").owlCarousel({
            navigation      : true, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            navigationText  : ["",""],
            singleItem      : true
        });
        /*End: Portfolio single slider*/

        /*Begin: Testimonials slider*/
        jQuery(".post_thumbnails_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        var owl = jQuery(".post_thumbnails_slider");
        jQuery(".next").click(function(){
            owl.trigger('owl.next');
        })
        jQuery(".prev").click(function(){
            owl.trigger('owl.prev');
        })
        /*End: Testimonials slider*/
        
        /*Begin: Testimonials slider*/
        jQuery(".testimonials_slider").owlCarousel({
            navigation      : false, // Show next and prev buttons
            pagination      : true,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : true
        });
        /*End: Testimonials slider*/

        jQuery(".related-clients").owlCarousel({
            navigation      : false, // Show next and prev buttons
            navigationText  : ["<i class='fa fa-angle-left' aria-hidden='true'></i>","<i class='fa fa-angle-right' aria-hidden='true'></i>"],
            pagination      : false,
            autoPlay        : true,
            slideSpeed      : 700,
            paginationSpeed : 700,
            itemsCustom : [
                [0,     1],
                [450,   3],
                [600,   3],
                [700,   6],
                [1000,  6],
                [1200,  6],
                [1400,  6],
                [1600,  6]
            ]
        });
        jQuery(".mt_members2").owlCarousel({
            navigation      : true, // Show next and prev buttons
            navigationText  : ["<i class='fas fa-arrow-left'></i>","<i class='fas fa-arrow-right'></i>"],
            pagination      : false,
            autoPlay        : false,
            slideSpeed      : 700,
            paginationSpeed : 700,
            singleItem      : false,
            itemsCustom : [
                [0,     2],
                [450,   2],
                [600,   2],
                [700,   2],
                [1000,  3],
                [1200,  4],
                [1400,  4],
                [1600,  4]
            ]
        });

        /* Animate */
        jQuery('.animateIn').animateIn();

        // browser window scroll (in pixels) after which the "back to top" link is shown
        var offset = 300,
            //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
            offset_opacity = 1200,
            //duration of the top scrolling animation (in ms)
            scroll_top_duration = 700,
            //grab the "back to top" link
            $back_to_top = jQuery('.back-to-top');

        //hide or show the "back to top" link
        jQuery(window).scroll(function(){
            ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('groffer-is-visible') : $back_to_top.removeClass('groffer-is-visible groffer-fade-out');
            if( jQuery(this).scrollTop() > offset_opacity ) { 
                $back_to_top.addClass('groffer-fade-out');
            }
        });

        //smooth scroll to top
        $back_to_top.on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, scroll_top_duration
            );
        });

        //Begin: Skills
        jQuery('.statistics').appear(function() {
            jQuery('.percentage').each(function(){
                var dataperc = jQuery(this).attr('data-perc');
                jQuery(this).find('.skill-count').delay(6000).countTo({
                    from: 0,
                    to: dataperc,
                    speed: 5000,
                    refreshInterval: 100
                });
            });
        });  
        //End: Skills 

        /*LOGIN MODAL */
        var ModalEffects = (function() {
                function init_modal() {

                    var overlay = document.querySelector( '.modeltheme-overlay' );

                    [].slice.call( document.querySelectorAll( '.modeltheme-trigger' ) ).forEach( function( el, i ) {

                        var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                            close = modal.querySelector( '.modeltheme-close' );

                        function removeModal( hasPerspective ) {
                            classie.remove( modal, 'modeltheme-show' );

                            if( hasPerspective ) {
                                classie.remove( document.documentElement, 'modeltheme-perspective' );
                            }
                        }

                        function removeModalHandler() {
                            removeModal( classie.has( el, 'modeltheme-setperspective' ) ); 
                        }

                        el.addEventListener( 'click', function( ev ) {
                            classie.add( modal, 'modeltheme-show' );
                            overlay.removeEventListener( 'click', removeModalHandler );
                            overlay.addEventListener( 'click', removeModalHandler );

                            if( classie.has( el, 'modeltheme-setperspective' ) ) {
                                setTimeout( function() {
                                    classie.add( document.documentElement, 'modeltheme-perspective' );
                                }, 25 );
                            }
                        });

                    } );

                }

            if (!jQuery("body").hasClass("login-register-page")) {
                init_modal();
            }

        })();

        jQuery("#dropdown-user-profile").on("hover", function(e){
          if(jQuery(this).hasClass("open")) {
            jQuery(this).removeClass("open");
          } else {
            jQuery(this).addClass("open");
          }
        });    

        jQuery("#member_hover").on("hover", function(e){
          if(jQuery(this).hasClass("open")) {
            jQuery(this).removeClass("open");
          } else {
            jQuery(this).addClass("open");
          }
        });

        jQuery('.mt-search-icon').on( "click", function() {
            jQuery('.fixed-search-overlay').toggleClass('visible');
        });

        jQuery('.fixed-search-overlay .icon-close').on( "click", function() {
            jQuery('.fixed-search-overlay').removeClass('visible');
        });
        jQuery(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                jQuery('.fixed-search-overlay').removeClass('visible');
                jQuery('.fixed-sidebar-menu').removeClass('open');
                jQuery('.fixed-sidebar-menu-overlay').removeClass('visible');
            }
        });
        
        jQuery('#DataTable-icondrops-active').dataTable( {
            responsive: true,
            "columns":[
              {
                  "sortable": false
                },
                {
                  "sortable": true
                },
                {
                  "sortable": false
                },
                {
                  "sortable": true
                },
                {
                  "sortable": true
                },
                {
                  "sortable": false
                },
                {
                  "sortable": false
                }
          ],
          "aoColumnDefs": [
            { "sType": "numeric" }
          ],
          language: {
              searchPlaceholder: "Search "
          },
        });
        
        jQuery("#modal-log-in #register-modal").on("click",function(){                       
            jQuery("#login-modal-content").fadeOut("fast", function(){
                jQuery("#signup-modal-content").fadeIn(500);
            });
        }); 
        jQuery("#modal-log-in .btn-login-p").on("click",function(){                       
            jQuery("#signup-modal-content").fadeOut("fast", function(){
                jQuery("#login-modal-content").fadeIn(500);
            });
        }); 

        jQuery("#login-content-shortcode .btn-register-shortcode").on("click",function(){                       
            jQuery("#login-content-shortcode").fadeOut("fast", function(){
               jQuery("#register-content-shortcode").fadeIn(500);
            });
        });    

        jQuery('#nav-menu-login').on("click",function(){ 
            jQuery(".modeltheme-show ~ .modeltheme-overlay").on("click",function(){ 
                jQuery("#signup-modal-content").fadeOut("fast");
                jQuery("#login-modal-content").fadeIn(500);
            });
        });

        var baseUrl = document.location.origin;
        if ($(window).width() < 768) { 
            jQuery("#dropdown-user-profile").on("click", function() {
                window.location.href = (baseUrl + '/my-account');
            });
        } 
        
        jQuery('#product-type').change(function() {
              if (jQuery(this).val() == "auction") {
                jQuery('.advanced_options').show();
              } else {
                jQuery('.advanced_options').hide();
              }
            });
        
        if( jQuery( '#yith-wcwl-popup-message' ).length == 0 ) {
            var message_div = jQuery( '<div>' )
                    .attr( 'id', 'yith-wcwl-message' ),
                popup_div = jQuery( '<div>' )
                    .attr( 'id', 'yith-wcwl-popup-message' )
                    .html( message_div )
                    .hide();

            jQuery( 'body' ).prepend( popup_div );
        }

        //accordeon footer
        if(jQuery(window).width() <= 991) {
            jQuery(".footer-row-1 .widget_text .widget").each(function(){
                var heading = jQuery(this).find('h3.widget-title');
                jQuery(heading).click(function(){
                    jQuery(heading).toggleClass("active");
                    var siblings = jQuery(this).nextAll();
                    jQuery(siblings).slideToggle();
                })
            });
        }

        // Responsive Set Height Products
        jQuery(function() {
            if (jQuery("body").hasClass("woocommerce-js")) {
                jQuery('.woocommerce ul.products li.product .archive-product-title, .modeltheme-product-wrapper .modeltheme-archive-product-title').matchHeight({
                    byRow: true
                });
            }
        });


    });
    
} (jQuery) );
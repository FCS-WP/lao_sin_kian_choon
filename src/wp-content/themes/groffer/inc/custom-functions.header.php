<?php
defined( 'ABSPATH' ) || exit;

/**
CUSTOM HEADER FUNCTIONS
*/
/**
* Lists all active social media accounts from the theme panel
*/
if (!function_exists('groffer_social_media_accounts')) {
	function groffer_social_media_accounts($float = ''){
		?>
	    <!-- SOCIAL LINKS -->
	    <ul class="social-links <?php echo esc_attr($float); ?>">
	      <?php if ( groffer_redux('groffer_social_fb') && groffer_redux('groffer_social_fb') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_fb') ) ?>"><i class="fa fa-facebook"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_tw') && groffer_redux('groffer_social_tw') != '' ) { ?>
	        <li><a target="_blank" href="https://twitter.com/<?php echo esc_attr( groffer_redux('groffer_social_tw') ) ?>"><i class="fa fa-twitter"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_pinterest') && groffer_redux('groffer_social_pinterest') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_pinterest') ) ?>"><i class="fa fa-pinterest"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_skype') && groffer_redux('groffer_social_skype') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_skype') ) ?>"><i class="fa fa-skype"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_linkedin') && groffer_redux('groffer_social_linkedin') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_linkedin') ) ?>"><i class="fa fa-linkedin"></i></a></li>
	      <?php } ?>
	      
	      <?php if ( groffer_redux('groffer_social_instagram') && groffer_redux('groffer_social_instagram') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_instagram') ) ?>"><i class="fa fa-instagram"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_dribbble') && groffer_redux('groffer_social_dribbble') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_dribbble') ) ?>"><i class="fa fa-dribbble"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_deviantart') && groffer_redux('groffer_social_deviantart') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_deviantart') ) ?>"><i class="fa fa-deviantart"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_digg') && groffer_redux('groffer_social_digg') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_digg') ) ?>"><i class="fa fa-digg"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_flickr') && groffer_redux('groffer_social_flickr') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_flickr') ) ?>"><i class="fa fa-flickr"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_stumbleupon') && groffer_redux('groffer_social_stumbleupon') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_stumbleupon') ) ?>"><i class="fa fa-stumbleupon"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_tumblr') && groffer_redux('groffer_social_tumblr') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_tumblr') ) ?>"><i class="fa fa-tumblr"></i></a></li>
	      <?php } ?>
	      <?php if ( groffer_redux('groffer_social_vimeo') && groffer_redux('groffer_social_vimeo') != '' ) { ?>
	        <li><a target="_blank" href="<?php echo esc_url( groffer_redux('groffer_social_vimeo') ) ?>"><i class="fa fa-vimeo-square"></i></a></li>
	      <?php } ?>
	    </ul>
	    <?php
	}
}
/**
||-> FUNCTION: GET SITE FONTS
*/
if (!function_exists('groffer_get_site_fonts')) {
	function groffer_get_site_fonts(){
	    global  $groffer_redux;
	    $fonts_string = '';
	    if (isset($groffer_redux['google_fonts_select'])) {
	        $i = 0;
	        $len = count($groffer_redux['google_fonts_select']);
	        foreach(array_keys($groffer_redux['google_fonts_select']) as $key){
	            $font_url = str_replace(' ', '+', $groffer_redux['google_fonts_select'][$key]);
	            
	            if ($i == $len - 1) {
	                // last
	                $fonts_string .= $font_url;
	            }else{
	                $fonts_string .= $font_url . '|';
	            }
	            $i++;
	        }
	        
	    }else{
	        $fonts_string = 'Space+Grotesk:200,300,regular,500,600,700,900,latin-ext,latin';
	    }
	    // fonts url
	        $fonts_url = add_query_arg( 'family', $fonts_string, "//fonts.googleapis.com/css" );
	        // enqueue fonts
	        wp_enqueue_style( 'groffer-fonts', $fonts_url, array(), '1.0.0' );
	}
	add_action('wp_enqueue_scripts', 'groffer_get_site_fonts');
}

/**
||-> FUNCTION: GET DYNAMIC CSS
*/
if (!function_exists('groffer_dynamic_css')) {
	add_action('wp_enqueue_scripts', 'groffer_dynamic_css' );
	function groffer_dynamic_css(){
		wp_enqueue_style(
		   'groffer-custom-style',
		    get_template_directory_uri() . '/css/custom-editor-style.css'
		);
	   	
	    $html = '';
	   	if (is_page()) {
		    $groffer_custom_page_skin_color_status = get_post_meta( get_the_ID(), 'groffer_custom_page_skin_color_status', true );
			$groffer_global_page_color = get_post_meta( get_the_ID(), 'groffer_global_page_color', true );
			$groffer_global_page_color_hover = get_post_meta( get_the_ID(), 'groffer_global_page_color_hover', true );
			list($r, $g, $b) = sscanf($groffer_global_page_color, "#%02x%02x%02x");
			if (isset($groffer_custom_page_skin_color_status) AND $groffer_custom_page_skin_color_status == 'yes') {
				$groffer_style_main_texts_color = $groffer_global_page_color;
				$groffer_style_main_backgrounds_color = $groffer_global_page_color;
				$groffer_style_main_backgrounds_color_hover = $groffer_global_page_color_hover;
				
				$back_to_top = $groffer_global_page_color;
				$html .= '	.back-to-top{
								background-color: '.esc_html($groffer_style_main_backgrounds_color).'; 
							}';
			}else{
	   			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
					$groffer_style_main_texts_color = groffer_redux("groffer_style_main_texts_color");
					$groffer_style_main_backgrounds_color = groffer_redux("groffer_style_main_backgrounds_color");
					$groffer_style_main_backgrounds_color_hover = groffer_redux("groffer_style_main_backgrounds_color_hover");
					$groffer_style_semi_opacity_backgrounds = groffer_redux('groffer_style_semi_opacity_backgrounds', 'alpha');
				}else{
					$groffer_style_main_texts_color = '#136450';
					$groffer_style_main_backgrounds_color = '#136450';
					$groffer_style_main_backgrounds_color_hover = '#ffffff';
					$groffer_style_semi_opacity_backgrounds = 'rgba(240, 34, 34, .95)';
				}
			}
			
	   	}else{
	   		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				$groffer_style_main_texts_color = groffer_redux("groffer_style_main_texts_color");
				$groffer_style_main_backgrounds_color = groffer_redux("groffer_style_main_backgrounds_color");
				$groffer_style_main_backgrounds_color_hover = groffer_redux("groffer_style_main_backgrounds_color_hover");
				$groffer_style_semi_opacity_backgrounds = groffer_redux('groffer_style_semi_opacity_backgrounds', 'alpha');
			}else{
				$groffer_style_main_texts_color = '#136450';
				$groffer_style_main_backgrounds_color = '#136450';
				$groffer_style_main_backgrounds_color_hover = '#ffffff';
				$groffer_style_semi_opacity_backgrounds = 'rgba(240, 34, 34, .95)';
			}
			$html .= '	.back-to-top{
							background-color: '.esc_html($groffer_style_main_backgrounds_color).'; 
						}';
	   	}


	   	// CUSTOM CSS
	   	if (groffer_redux('groffer_css_editor') != '') {
	    	$html .= groffer_redux('groffer_css_editor');
	   	}

	   	// Redux Option : Add extra padding to product grid
	   	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	   		if(groffer_redux('groffer-enable-padding-cont') == true) {
	   			$html .= '
	   				.woocommerce ul.products.grid {
    						margin: 0px -35px;
					}
					.overlay-components {
					    margin-right: 25px;
					    margin-top: 5px;
					}
	   			';
	   		}
	   	}
	    // THEME OPTIONS STYLESHEET - Responsive SmartPhones
	    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		    $html .= '
		    			@media only screen and (max-width: 767px) {
		    				body h1,
		    				body h1 span{
		    					font-size: '.groffer_redux('groffer_heading_h1_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h1_smartphones', 'line-height').' !important;
		    				}
		    				body h2{
		    					font-size: '.groffer_redux('groffer_heading_h2_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h2_smartphones', 'line-height').' !important;
		    				}
		    				body h3{
		    					font-size: '.groffer_redux('groffer_heading_h3_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h3_smartphones', 'line-height').' !important;
		    				}
		    				body h4{
		    					font-size: '.groffer_redux('groffer_heading_h4_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h4_smartphones', 'line-height').' !important;
		    				}
		    				body h5{
		    					font-size: '.groffer_redux('groffer_heading_h5_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h5_smartphones', 'line-height').' !important;
		    				}
		    				body h6{
		    					font-size: '.groffer_redux('groffer_heading_h6_smartphones', 'font-size').' !important;
		    					line-height: '.groffer_redux('groffer_heading_h6_smartphones', 'line-height').' !important;
		    				}
		    				.mega-menu-inline .menu-item-has-children{
		    					display: inline-block !important;
		    				}
		    			}
		    			';
		    // THEME OPTIONS STYLESHEET - Responsive Tablets
		    $html .= '
	    			@media only screen and (min-width: 768px) and (max-width: 1024px) {
	    				body h1,
	    				body h1 span{
	    					font-size: '.groffer_redux('groffer_heading_h1_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h1_tablets', 'line-height').' !important;
	    				}
	    				body h2{
	    					font-size: '.groffer_redux('groffer_heading_h2_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h2_tablets', 'line-height').' !important;
	    				}
	    				body h3{
	    					font-size: '.groffer_redux('groffer_heading_h3_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h3_tablets', 'line-height').' !important;
	    				}
	    				body h4{
	    					font-size: '.groffer_redux('groffer_heading_h4_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h4_tablets', 'line-height').' !important;
	    				}
	    				body h5{
	    					font-size: '.groffer_redux('groffer_heading_h5_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h5_tablets', 'line-height').' !important;
	    				}
	    				body h6{
	    					font-size: '.groffer_redux('groffer_heading_h6_tablets', 'font-size').' !important;
	    					line-height: '.groffer_redux('groffer_heading_h6_tablets', 'line-height').' !important;
	    				}

	    			}';
		}


	    // THEME OPTIONS STYLESHEET
	    $html .= '
	    		footer .menu .menu-item a,
	    		.contact-details span{
			    	color: '.groffer_redux('footer_bottom_color_links').';

			    }
			    .contact-details span a{
			    	color: '.groffer_redux('footer_bottom_color_links').';
			    }
			    .contact-details span i{
			    	color: '.groffer_redux('footer_bottom_color_icons').' !important;
			    }
    			.footer-top .widget-title, p.copyright{
			    	color: '.groffer_redux('footer_bottom_color_text').';
			    }
    			.top-footer div.left{
			    	color: '.groffer_redux('footer_top_color_text').';
			    }
    			.header-v3 .navbar-default, 
    			.header-v3 nav#modeltheme-main-head{
			    	background-color: '.groffer_redux('mt_style_top_header3_color', 'background-color').';
			    }
			    .header-v5 .navbar-default, 
    			.header-v5 nav#modeltheme-main-head{
			    	background-color: '.groffer_redux('mt_style_top_header5_color', 'background-color').';
			    }
			    .header-v2 .navbar-default{
			    	background-color: '.groffer_redux('mt_style_bottom_header2_color', 'background-color').';
			    }
		        .breadcrumb a::after {
		            content: "'.groffer_redux('breadcrumbs-delimitator').'";
		            content:"/";
		        }
		        .navbar-header .logo img {
		            max-width: '.esc_html(groffer_redux("logo_max_width")).'px;
		        }
			    ::selection{
			        color: '.groffer_redux('groffer_text_selection_color').';
			        background: '.groffer_redux('groffer_text_selection_background_color').';
			    }
			    ::-moz-selection { /* Code for Firefox */
			        color: '.groffer_redux('groffer_text_selection_color').';
			        background: '.groffer_redux('groffer_text_selection_background_color').';
			    }
			    a,
			    a:visited{
			        color: '.groffer_redux('groffer_global_link_styling', 'regular').';
			    }
			    a:focus,
			    a:hover{
			        color: '.groffer_redux('groffer_global_link_styling', 'hover').';
			    }
			    /*------------------------------------------------------------------
			        COLOR
			    ------------------------------------------------------------------*/
				span.amount
				table.compare-list .remove td a .remove,
				.woocommerce form .form-row .required,
				.woocommerce .woocommerce-info::before,
				.woocommerce .woocommerce-message::before,
				.woocommerce div.product p.price, 
				.woocommerce div.product span.price,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
				.widget_popular_recent_tabs .nav-tabs li.active a,
				.widget_product_categories .cat-item:hover,
				.widget_product_categories .cat-item a:hover,
				.widget_archive li:hover,
				.widget_archive li a:hover,
				.widget_categories li a:hover,
				.woocommerce .star-rating span::before,
				.pricing-table.recomended .button.solid-button, 
				.pricing-table .table-content:hover .button.solid-button,
				.pricing-table.Recommended .button.solid-button, 
				.pricing-table.recommended .button.solid-button, 
				.pricing-table.recomended .button.solid-button, 
				.pricing-table .table-content:hover .button.solid-button,
				.testimonial-author,
				.testimonials-container blockquote::before,
				.testimonials-container blockquote::after,
				h1 span,
				h2 span,
				label.error,
				.woocommerce input.button:hover,
				.author-name,
				.comment_body .author_name,
				.prev-next-post a:hover,
				.prev-text,
				.next-text,
				.social ul li a:hover i,
				.wpcf7-form span.wpcf7-not-valid-tip,
				.text-dark .statistics .stats-head *,
				.wpb_button.btn-filled,
				.widget_meta a:hover,
				.logo span,
				a.shop_cart::after,
				.woocommerce ul.products li.product .archive-product-title a:hover,
				.shop_cart:hover,
				.widget_pages a:hover,
				.categories_shortcode .category.active, .categories_shortcode .category:hover,
				.widget_recent_entries_with_thumbnail li:hover a,
				.widget_recent_entries li a:hover,
				.wpb_button.btn-filled:hover,
				li.seller-name::before,
				li.store-address::before,
				li.store-name::before,
				.full-width-part .post-category-comment-date a:hover, .article-details .post-author a:hover,
				.grid-view.col-md-12.list-view .more-link:hover,
				.woocommerce button.button:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce div.product form.buy-now.cart .button:hover span.amount,
				.woocommerce a.button:hover,
				.wc_vendors_active form input[type="submit"]:hover,
				.wcv-dashboard-navigation li a:hover,
				.woocommerce ul.cart_list li:hover a, .woocommerce ul.product_list_widget li:hover a,
				a.add-wsawl.sa-watchlist-action:hover, a.remove-wsawl.sa-watchlist-action:hover,
				.top-footer .menu-search .btn.btn-primary:hover i.fa,
				wpcf7-form .wpcf7-submit:hover,
				.woocommerce a.button.alt:hover,
				.form-submit input:hover,
				.post-name i,
				.modal-content p i,
				#yith-wcwl-form input[type="submit"]:hover,
				.form-row.form-group.user-role label.radio,
				.modeltheme-modal #loginform input[type="submit"]:hover,
				blockquote::before,
				.no-results input[type="submit"]:hover,
				.modal-content .woocommerce-LostPassword.lost_password a,
				.form-submit input:hover,
				div#cat-drop-stack a:hover,
				.sidebar-content .widget_nav_menu li a:hover,
				#signup-modal-content .woocommerce-form-register.register .button[type="submit"]:hover,
				.modeltheme-product-wrapper span.amount,
				.details-container > div.details-item .amount,
				.modeltheme-product-wrapper a.compare.button,
				footer .tagcloud > a:hover,
				.pricing-table small, .pricing-table .price,
				section.mt-tabs .fa, .fas,
				.pricing-table.recommended .table-content:hover small, .pricing-table.recommended .table-content:hover .price {
				    color: '.esc_html($groffer_style_main_texts_color).';
				}
				a#register-modal:hover,
				.woocommerce ul.products li.product .bottom-components-list .component.compare a.compare.button,
				.page-template-template-blog .article-detail-meta.post-date,
				.article-details .article-detail-meta i{
				    color: '.esc_html($groffer_style_main_texts_color).' !important;
				}
				.dokan-btn-theme a:hover, .dokan-btn-theme:hover, input[type="submit"].dokan-btn-danger:hover, input[type="submit"].dokan-btn-theme:hover,
				.woocommerce-MyAccount-navigation-link > a:hover,
				body .groffer_shortcode_blog .post-name a:hover,
				.masonry_banner .read-more:hover,
				.category-button a:hover,
				.dokan-single-store .profile-frame .profile-info-box .profile-info-summery-wrapper .profile-info-summery .profile-info i,
				.wpcf7-form .wpcf7-submit:hover,
				.product_meta > span a:hover,
				.dokan-dashboard .dokan-dashboard-wrap .delete a,
				.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active a,
				.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a:hover,
				#dropdown-user-profile ul li a:hover,
				.widget_groffer_social_icons a:hover,
				.header-v3 .menu-products .shop_cart,
				.simple-sitemap-container ul a:hover,
				.wishlist_table tr td.product-name a.button:hover,
				.dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover, .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce div.product .woocommerce-tabs ul.tabs li:hover a, .mega_menu .cf-mega-menu li a:hover, .mega_menu .cf-mega-menu.sub-menu p a:hover,
				.woocommerce a.remove,
				.groffer_shortcode_cause .button-content a:hover,
				.modeltheme_products_shadow .details-container > div.details-item .amount,
				.mt_products_slider .full .woocommerce-title-metas span.amount,
				.widget_groffer_recent_entries_with_thumbnail li a:hover,
				.page-links .post-page-numbers.current,
				.page-links .post-page-numbers:hover,
				.affiliate-reservation-wrapper td.go_price,
				.widget_groffer_address_social_icons  a:hover,
				.archive .article-detail-meta.post-date,
				header.header-v1 .menu-list .button:hover,
				footer .footer-top .menu .menu-item a:hover
				{
				    color: '.esc_html($groffer_style_main_texts_color).' !important;
				}
				.tagcloud > a:hover,
				 nav,
				.groffer-icon-search,
				.wpb_button::after,
				.rotate45,
				.latest-posts .post-date-day,
				.latest-posts h3, 
				.latest-tweets h3, 
				.latest-videos h3,
				.button.solid-button,
				.top-footer,
				.form-submit input,
				.page-template-template-blog .full-width-part .more-link, .full-width-part .more-link,
				button.vc_btn,
				.pricing-table.recomended .table-content, 
				.pricing-table .table-content:hover,
				.pricing-table.Recommended .table-content, 
				.pricing-table.recommended .table-content, 
				.pricing-table.recomended .table-content, 
				.pricing-table .table-content:hover,
				.block-triangle,
				.owl-theme .owl-controls .owl-page span,
				body .vc_btn.vc_btn-blue, 
				body a.vc_btn.vc_btn-blue, 
				body button.vc_btn.vc_btn-blue,
				.woocommerce #respond input#submit, 
				.woocommerce a.button, 
				.woocommerce button.button, 
				.woocommerce input.button,
				table.compare-list .add-to-cart td a,
				.woocommerce #respond input#submit.alt, 
				.woocommerce a.button.alt, 
				.woocommerce button.button.alt, 
				.woocommerce input.button.alt,
				.woocommerce a.remove:hover,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
				.woocommerce nav.woocommerce-pagination ul li a:focus, 
				.woocommerce nav.woocommerce-pagination ul li a:hover, 
				.woocommerce nav.woocommerce-pagination ul li span.current, 
				.widget_social_icons li a:hover, 
				#subscribe > button[type="submit"],
				.social-sharer > li:hover,
				.prev-next-post a:hover .rotate45,
				.masonry_banner.default-skin,
				.member-footer .social::before, 
				.member-footer .social::after,
				.subscribe > button[type="submit"],
				.woocommerce #respond input#submit.alt.disabled, 
				.woocommerce #respond input#submit.alt.disabled:hover, 
				.woocommerce #respond input#submit.alt:disabled, 
				.woocommerce #respond input#submit.alt:disabled:hover, 
				.woocommerce #respond input#submit.alt[disabled]:disabled, 
				.woocommerce #respond input#submit.alt[disabled]:disabled:hover, 
				.woocommerce a.button.alt.disabled, 
				.woocommerce a.button.alt.disabled:hover, 
				.woocommerce a.button.alt:disabled, 
				.woocommerce a.button.alt:disabled:hover, 
				.woocommerce a.button.alt[disabled]:disabled, 
				.woocommerce a.button.alt[disabled]:disabled:hover, 
				.woocommerce button.button.alt.disabled, 
				.woocommerce button.button.alt.disabled:hover, 
				.woocommerce button.button.alt:disabled, 
				.woocommerce button.button.alt:disabled:hover, 
				.woocommerce button.button.alt[disabled]:disabled, 
				.woocommerce button.button.alt[disabled]:disabled:hover, 
				.woocommerce input.button.alt.disabled, 
				.woocommerce input.button.alt.disabled:hover, 
				.woocommerce input.button.alt:disabled, 
				.woocommerce input.button.alt:disabled:hover, 
				.woocommerce input.button.alt[disabled]:disabled, 
				.woocommerce input.button.alt[disabled]:disabled:hover,
				.no-results input[type="submit"],
				table.compare-list .add-to-cart td a,
				.shop_cart,
				h3#reply-title::after,
				.newspaper-info,
				.categories_shortcode .owl-controls .owl-buttons i:hover,
				.widget-title:after,
				h2.heading-bottom:after,
				.wpb_content_element .wpb_accordion_wrapper .wpb_accordion_header.ui-state-active,
				#primary .main-content ul li:not(.rotate45)::before,
				.wpcf7-form .wpcf7-submit,
				.um-register .um-button.um-alt, .btn-register, .modeltheme-modal #loginform input[type="submit"], form#login .register_button, form#login .submit_button,
				.bottom-components .component a:hover, .bottom-components .component a:hover, .bottom-components .component a:hover, .woocommerce-page .overlay-components .component a:hover, .woocommerce-page .vc_col-md-3 .overlay-components .component a:hover,
				.woocommerce.single-product .wishlist-container .yith-wcwl-wishlistaddedbrowse.show a,
				.widget_address_social_icons .social-links a,
				.hover-components .component:hover,
				.navbar-default .navbar-toggle .icon-bar,
				#yith-wcwl-form input[type="submit"],
				.nav-previous a, .nav-next a,
				article.dokan-orders-area .dokan-panel-default > .dokan-panel-heading,
				#signup-modal-content .woocommerce-form-register.register .button[type="submit"],
				.dokan-dashboard .dokan-dashboard-content article.dashboard-content-area .dashboard-widget .widget-title,
				.woocommerce-MyAccount-navigation-link > a,
				a.add-wsawl.sa-watchlist-action, a.remove-wsawl.sa-watchlist-action,
				footer .footer-top .menu .menu-item a::before,
				.post-password-form input[type="submit"],
				.wcv-dashboard-navigation li a,
				.wc_vendors_active form input[type="submit"],
				.cd-gallery .button-bid a,
				.mt_products_slider .button-bid a,
				.groffer_shortcode_blog.boxed .post-button a.more-link,
				.sale_banner .sale_banner_holder.right span.read-more,
				.modeltheme-product-wrapper a.button,
				.pagination .page-numbers:hover  {
				    background: '.esc_html($groffer_style_main_backgrounds_color).';
				}
				.bottom-components .component a:hover, .bottom-components .component a:hover, .bottom-components .component a:hover, .woocommerce-page .vc_col-md-3 .overlay-components .component a:hover,.vc_col-md-4 .overlay-components .component a:hover, .no-sidebar .vc_col-md-3 .overlay-components .component a:hover,
				.bottom-components .component.add-to-cart a,
				.woocommerce_categories2 .products .component .yith-wcwl-wishlistexistsbrowse.show a,
				body .tp-bullets.preview1 .bullet,
				div#dokan-content .overlay-components .component a:hover,
				body #mega_main_menu li.default_dropdown .mega_dropdown > li > .item_link:hover, 
				body #mega_main_menu li.widgets_dropdown .mega_dropdown > li > .item_link:hover, 
				body #mega_main_menu li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover, 
				body .dokan-settings-content .dokan-settings-area a.dokan-btn-info,
				.btn-sticky-left,
				.dokan-btn-info,
				body #mega_main_menu li.grid_dropdown .mega_dropdown > li > .item_link:hover,
				.custom_groffer button,
				.woocommerce_categories.grid th,
				.groffer_shortcode_cause .button-content a,
				.domain.woocommerce_categories .button-bid a,
				.domain-but button,
				.woocommerce_simple_domain .button-bid a,
				.mt-product-search .menu-search button.form-control,
				.woocommerce ul.products li.product .bottom-components-list .component.compare a.compare.button:hover,
				.mt-mega-menu-shortcode h3.heading-title,
				.groffer_shortcode_blog .image_top .post-read-more i,
				.modeltheme-product-wrapper a.compare.button:hover,
				header.page-header-404 a.vc_button_404,
				.lvca-accordion.lvca-style1 .lvca-panel .lvca-panel-title,
				.lrm-form button, .lrm-form button[type=submit],
				.lrm-user-modal-container .lrm-switcher a,
				.lvca-pricing-table .lvca-purchase a,
				.groffer_shortcode_blog a.rippler.rippler-default,
				.product-badge,
				.affiliate-wrapper .affiliate_btn a,
				.affiliate-reservation-wrapper a.rippler.rippler-default,
				.full-width-part .more-link,
				.mt_simple_themes .mt-theme-wrapper a.button,
				.single-product .single-v2 .buy-button,
				.bitwallet-single-point > a,
				form#groffersearch button.btn.submit-search-domain,
				form#groffersearch button.btn.submit-search-ride-sharing,
				.pricing__item.pricing__item--premium .package__recommended,
				.pricing__item.pricing__item--premium .pricing__price,
				.pricing-section-v2 .pricing__item--premium .pricing__feature-list,
				.pricing__item a.pricing__action:hover,
				.woocommerce.single-product div.product form.cart .button,
				.gaming-btn .button-winona.btn.btn-medium,
				.modeltheme-modal input.submit,
				.mt-tabs .content-wrap a.tabs_button:hover,
				.crypto-btn .button-winona.btn.btn-medium
				{
				    background: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.flip-clock-wrapper ul li a div div.inn,
				.featured_product_shortcode span.amount,
				.featured_product_shortcode .featured_product_button:hover,
				.custom_groffer button:hover,
				.groffer-countdown strong,
				.woocommerce_categories.grid td.product-title a,
				.woocommerce_categories.grid td.add-cart a,
				.woocommerce_categories.list span.amount,
				.cd-tab-filter a:hover,
				.no-touch .cd-filter-block h4:hover,
				.cd-gallery .woocommerce-title-metas a:hover,
				.cd-tab-filter a.selected,
				.no-touch .cd-filter-trigger:hover,
				.woocommerce .woocommerce-widget-layered-nav-dropdown__submit:hover,
				.woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item a:hover,
				.mt_products_slider .woocommerce-title-metas h3 a:hover,
				.groffer_shortcode_cause h3 a:hover,
				.mt_products_slider .button-bid a:hover,
				.header-v3 .menu-products .shop_cart:hover,
				.domain.woocommerce_categories .archive-product-title a:hover,
				.custom-btn button:hover,
				.modeltheme_products_carousel .modeltheme-title-metas a:hover,
				.modeltheme_products_carousel.owl-theme .owl-controls .owl-buttons div,
				.modeltheme_products_simple h3.modeltheme-archive-product-title a:hover,
				.sale_banner .sale_banner_holder.right span.read-more:hover,
				.modeltheme-product-wrapper .modeltheme-archive-product-title a:hover,
				.single-product .product p.price span,
				.newsletter-footer input.submit:hover,
				.woocommerce button.button:disabled:hover, .woocommerce button.button:disabled[disabled]:hover,
				.full-width-part .more-link:hover,
				header.page-header-404 a.vc_button_404:hover,
				.form-submit input:hover,
				.lrm-form button[type=submit]:hover,
				.page-template-template-blog-2 .article-detail-meta.post-date,
				#commentform .form-submit button:hover,
				.products_category_vertical_shortcode_holder:hover .heading a,
				.single-product .single-v2 .product-sales,
				.single-product .single-v2 .buy-button:hover a,
				.mt_simple_themes .mt-theme-wrapper h3 a:hover,
				.mt_simple_themes .mt-theme-wrapper a.button:hover,
				.header-v4 .header-top-contact-method i,
				.woocommerce.single-product div.product form.cart .button:hover,
				.single-course-wrapper .mt-price,
				.mt-categories-content li.single-category i,
				.groffer_shortcode_blog .image_top .boxed-shadow p.text-center,
				.single-course-wrapper p.mt-title a:hover,
				.testimonial01-img-holder.style2 p.position-test,
				.pricing-table.style_2.recommended small, 
				.pricing-table.style_2.recommended .price,
				.list-inline-block > li a:hover{
					color: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.dokan-btn-success.grant_access, input#dokan-add-tracking-number,
				.dokan-dashboard .dokan-dash-sidebar, .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu,
				input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,
				#cd-zoom-in, #cd-zoom-out,
				.woocommerce .woocommerce-widget-layered-nav-dropdown__submit,
				.custom-btn button,
				.modeltheme_products_carousel .modeltheme-button-bid a,
				.modeltheme_products_simple .modeltheme-product-wrapper a.button,
				.lvca-pricing-table .lvca-top-header,
				.menu-products span.cart-number,
				#commentform .form-submit button,
				.navbar-default .navbar-toggle .icon-bar{
				    background-color: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.gridlist-toggle a:hover,
				.gridlist-toggle a.active,
				.dataTables_wrapper .pagination>.active>a, .dataTables_wrapper .pagination>.active>span, 
				.dataTables_wrapper .pagination>.active>a:hover, 
				.dataTables_wrapper .pagination>.active>span:hover, 
				.dataTables_wrapper .pagination>.active>a:focus, 
				.dataTables_wrapper .pagination>.active>span:focus {
					background-color: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.pagination > li > a.current, 
				.pagination > li > a:hover{
					background-color: '.esc_html($groffer_style_main_backgrounds_color_hover).';
					border: 1px solid '.esc_html($groffer_style_main_backgrounds_color_hover).';
				}
				.woocommerce ul.products li.product .onsale, 
				.back-to-top,
				body .woocommerce ul.products li.product .onsale, 
				body .woocommerce ul.products li.product .onsale,
				.pagination .page-numbers.current,
				.pagination .page-numbers.current:hover,
				.category-button.boxed a,
				.masonry_banner .read-more.boxed {
					background-color: '.esc_html($groffer_style_main_backgrounds_color).';
				}
				.comment-form input, 
				.author-bio,
				blockquote,
				.widget_popular_recent_tabs .nav-tabs > li.active,
				body .left-border, 
				body .right-border,
				body .member-header,
				body .member-footer .social,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce .woocommerce-info, 
				.woocommerce .woocommerce-message,
				body .button[type="submit"],
				.navbar ul li ul.sub-menu,
				.wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
				.header_mini_cart,
				.header_mini_cart.visible_cart,
				#contact-us .form-control:focus,
				.header_mini_cart .woocommerce .widget_shopping_cart .total, 
				.header_mini_cart .woocommerce.widget_shopping_cart .total,
				.sale_banner_holder:hover,
				.testimonial-img,
				.wpcf7-form input:focus, 
				.dokan-btn-success.grant_access, input#dokan-add-tracking-number,
				.navbar-default .navbar-toggle:hover, 
				.navbar-default .navbar-toggle,
				.full-width-part .more-link,
				header.page-header-404 a.vc_button_404,
				.form-submit input,
				.modeltheme-product-wrapper a.added_to_cart.wc-forward,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.pricing-table.style_2.recommended .table-content {
				    border-color: '.esc_html($groffer_style_main_backgrounds_color).';
				}
				.sidebar-content .widget-title::before, .dokan-widget-area .widget-title::before,
				.dokan-settings-content .dokan-settings-area a.dokan-btn-info, .dokan-btn-info,
				input[type="submit"].dokan-btn-theme, a.dokan-btn-theme, .dokan-btn-theme,
				.header-v3 .menu-products .shop_cart,
				.lvca-heading.lvca-alignleft h3.lvca-title::after,
				.dokan-category-menu,
				.header_mini_cart .button.wc-forward, .header_mini_cart .button.checkout,
				.woocommerce ul.products li.product .bottom-components-list .button,
				.woocommerce ul.products li.product .bottom-components-list .component.compare a.compare.button,
				.modeltheme-product-wrapper a.button,
				.lvca-pricing-table .lvca-top-header,
				.form-submit input,
				.woocommerce button.button.alt,
				.groffer_shortcode_blog .image_top .post-dates,
				.woocommerce #respond input#submit,
				.woocommerce a.button,
				#commentform .form-submit button,
				.no-results input[type="submit"],
				.affiliate-wrapper .affiliate_btn a,
				.affiliate-reservation-wrapper a.rippler.rippler-default,
				.single-product .single-v2 .buy-button,
				.mt_simple_themes .mt-theme-wrapper a.button,
				.header-v4 .navbar-default .navbar-toggle {
				    border-color: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.mt-tabs .tabs-style-iconbox nav ul li.tab-current a::after{
				    border-top-color: '.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				.services2 .block-triangle:hover i,
				.cd-filter::before,
				.cd-filter .cd-close {
					background-color:'.esc_html($groffer_style_main_backgrounds_color).';
				}
				#navbar .menu-item.black-friday-menu-link > a  {
					background-color:'.esc_html($groffer_style_main_backgrounds_color).' !important;
				}
				#navbar .menu-item.black-friday-menu-link > a:hover {
					background:'.esc_html(groffer_redux("header_top_bar_background","background-color")).' !important;
				}
				.woocommerce #respond input#submit:hover, 
				.woocommerce a.button:hover, 
				.wc_vendors_active form input[type="submit"]:hover,
				.wcv-dashboard-navigation li a:hover,
				.woocommerce button.button:hover, 
				.woocommerce input.button:hover,
				table.compare-list .add-to-cart td a:hover,
				.woocommerce #respond input#submit.alt:hover, 
				.woocommerce a.button.alt:hover, 
				.woocommerce button.button.alt:hover, 
				.woocommerce input.button.alt:hover,
				.groffer-search.groffer-search-open .groffer-icon-search, 
				.no-js .groffer-search .groffer-icon-search,
				.groffer-icon-search:hover,
				.latest-posts .post-date-month,
				.button.solid-button:hover,
				body .vc_btn.vc_btn-blue:hover, 
				body a.vc_btn.vc_btn-blue:hover, 
				body button.vc_btn.vc_btn-blue:hover,
				.subscribe > button[type="submit"]:hover,
				.no-results input[type="submit"]:hover,
				table.compare-list .add-to-cart td a:hover,
				.shop_cart:hover,
				.wpcf7-form .wpcf7-submit:hover,
				.widget_address_social_icons .social-links a:hover,
				.post-password-form input[type="submit"]:hover,
				.page-template-template-blog .full-width-part .more-link:hover,
				.form-submit input:hover,
				.full-width-part .more-link:hover,
				.modeltheme-modal #loginform input[type="submit"]:hover, 
				.modeltheme-modal p.btn-register-p a:hover,
				#yith-wcwl-form input[type="submit"]:hover,
				#signup-modal-content .woocommerce-form-register.register .button[type="submit"]:hover,
				.woocommerce_categories2 .bottom-components .component a:hover,.woocommerce_categories2 .bottom-components .component a:hover,
				woocommerce_categories2 .bottom-components .component a:hover
				 {
				    background: '.esc_html($groffer_style_main_backgrounds_color_hover).'; /*Color: Main Dark */
				}
				.woocommerce_categories.grid td.add-cart a:hover,
				.woocommerce_categories.grid td.product-title a:hover,
				.domain.woocommerce_categories .archive-product-title a,
				.menu-search .btn.btn-primary
				{
					color: '.esc_html($groffer_style_main_backgrounds_color_hover).' !important;
				}
				.no-touch #cd-zoom-in:hover, .no-touch #cd-zoom-out:hover,
				.woocommerce .woocommerce-widget-layered-nav-dropdown__submit:hover,
				.groffer_shortcode_cause .button-content a:hover,
				.cd-gallery .button-bid a:hover,
				.mt_products_slider .button-bid a:hover 
				{
				    background-color: '.esc_html($groffer_style_main_backgrounds_color_hover).' !important; /*Color: Main Dark */
				}
				
	    ';

	    wp_add_inline_style( 'groffer-custom-style', $html );
	}
}
?>
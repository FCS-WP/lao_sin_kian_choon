<?php
defined( 'ABSPATH' ) || exit;

// Logo Source
if (!function_exists('groffer_logo_source')) {
    function groffer_logo_source(){
        
        // REDUX VARIABLE
        global $groffer_redux;
        // html VARIABLE
        $html = '';
        // Metaboxes
        $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'groffer_custom_header_options_status', true );
        $mt_metabox_header_logo = get_post_meta( get_the_ID(), 'groffer_metabox_header_logo', true );
        if (is_page()) {
            if (isset($mt_custom_header_options_status) && isset($mt_metabox_header_logo) && $mt_custom_header_options_status == 'yes') {
                $html .='<img src="'.esc_url($mt_metabox_header_logo).'" alt="'.esc_attr(get_bloginfo()).'" />';
            }else{
                if(!empty($groffer_redux['groffer_logo']['url'])){
                    $html .='<img src="'.esc_url($groffer_redux['groffer_logo']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />';
                }else{ 
                    $html .= $groffer_redux['groffer_logo_text'];
                }
            }
        }else{
            if(!empty($groffer_redux['groffer_logo']['url'])){
                $html .='<img src="'.esc_url($groffer_redux['groffer_logo']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />';
            }elseif(isset($groffer_redux['groffer_logo_text'])){ 
                $html .= $groffer_redux['groffer_logo_text'];
            }else{
                $html .= esc_html(get_bloginfo());
            }
        }
        return $html; 
    }
}
// Logo Area
if (!function_exists('groffer_logo')) {
    function groffer_logo(){
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        global $groffer_redux;
        // html VARIABLE
        $html = '';
        $html .='<div class="logo logo-image">';
            $html .='<a href="'.esc_url(get_site_url()).'">';
                $html .= groffer_logo_source();
            $html .='</a>';
        $html .='</div>';
        return $html;
        // REDUX VARIABLE
     } else {
        global $groffer_redux;
        // html VARIABLE
        $html = '';
        $html .='<div class="logo logo-h">';
            $html .='<a href="'.esc_url(get_site_url()).'">';
                $html .= esc_html(get_bloginfo());
            $html .='</a>';
        $html .='</div>';
        return $html;
     } 
    }
}
// Add specific CSS class by filter
if (!function_exists('groffer_body_classes')) {
    function groffer_body_classes( $classes ) {
        global  $groffer_redux;
        $plugin_redux_status = '';
        if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
            $plugin_redux_status = 'missing-redux-framework';
        }
        $plugin_modeltheme_status = '';
        if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
            $plugin_modeltheme_status = 'missing-modeltheme-framework';
        }
        // CHECK IF FEATURED IMAGE IS FALSE(Disabled)
        $post_featured_image = '';
        if (is_singular('post')) {
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                if ($groffer_redux['post_featured_image'] == false) {
                    $post_featured_image = 'hide_post_featured_image';
                }else{
                    $post_featured_image = '';
                }
            }
        }
        // CHECK IF THE NAV IS STICKY
        $is_nav_sticky = '';
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                if ($groffer_redux['is_nav_sticky'] == true) {
                    // If is sticky
                    $is_nav_sticky = 'is_nav_sticky';
                }else{
                    // If is not sticky
                    $is_nav_sticky = '';
                }
            }
        }
        // DIFFERENT HEADER LAYOUT TEMPLATES
        if (is_page()) {
            $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'groffer_custom_header_options_status', true );
            $mt_header_custom_variant = get_post_meta( get_the_ID(), 'groffer_header_custom_variant', true );
            $header_version = 'first_header';
            if (isset($mt_custom_header_options_status) AND $mt_custom_header_options_status == 'yes') {
                if ($mt_header_custom_variant == '1') {
                    // Header Layout #1
                    $header_version = 'first_header';
                }else{
                    // if no header layout selected show header layout #1
                    $header_version = 'first_header';
                }
            }else{
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    if ($groffer_redux['header_layout'] == 'first_header') {
                        // Header Layout #1
                        $header_version = 'first_header';
                    }else{
                        // if no header layout selected show header layout #1
                        $header_version = 'first_header';
                    }
                }else{
                    $header_version = 'first_header';
                }
            }
        }else{
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                if ($groffer_redux['header_layout'] == 'first_header') {
                    // Header Layout #1
                    $header_version = 'first_header';
                }else{
                    // if no header layout selected show header layout #1
                    $header_version = 'first_header';
                }
            }else{
                $header_version = 'first_header';
            }
        }

        $wc_vendors_status = '';
        if (class_exists('WC_Vendors')) {
            $wc_vendors_status = 'wc_vendors_active';
        }


        $mt_footer_row1 = '';
        $mt_footer_row2 = '';
        $mt_footer_row3 = '';
        $mt_footer_row4 = '';
        $mt_footer_bottom = '';
        
        $mt_footer_row1_status = get_post_meta( get_the_ID(), 'mt_footer_row1_status', true );
        $mt_footer_row2_status = get_post_meta( get_the_ID(), 'mt_footer_row2_status', true );
        $mt_footer_row3_status = get_post_meta( get_the_ID(), 'mt_footer_row3_status', true );
        $mt_footer_bottom_bar = get_post_meta( get_the_ID(), 'mt_footer_bottom_bar', true );

        if (isset($mt_footer_row1_status) && !empty($mt_footer_row1_status)) {
            $mt_footer_row1 = 'hide-footer-row-1';
        }
        if (isset($mt_footer_row2_status) && !empty($mt_footer_row2_status)) {
            $mt_footer_row2 = 'hide-footer-row-2';
        }
        if (isset($mt_footer_row3_status) && !empty($mt_footer_row3_status)) {
            $mt_footer_row3 = 'hide-footer-row-3';
        }
        if (isset($mt_footer_bottom_bar) && !empty($mt_footer_bottom_bar)) {
            $mt_footer_bottom = 'hide-footer-bottom';
        }


        $classes[] = esc_attr($mt_footer_row1) . ' ' . esc_attr($mt_footer_row2) . ' ' . esc_attr($mt_footer_row3) . ' ' . esc_attr($mt_footer_bottom) . ' ' . esc_attr($wc_vendors_status) . ' ' . esc_attr($plugin_modeltheme_status) . ' ' . esc_attr($plugin_redux_status) . ' ' . esc_attr($is_nav_sticky) . ' ' . esc_attr($header_version) . ' ' . esc_attr($post_featured_image) . ' ';

        return $classes;
    }
    add_filter( 'body_class', 'groffer_body_classes' );
}


if (!function_exists('groffer_header_mobile_icons_group')) {
    function groffer_header_mobile_icons_group(){

        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (groffer_redux('groffer_header_mobile_switcher_top') == true) {

                $cart_url = "#";
                if ( class_exists( 'WooCommerce' ) ) {
                    $cart_url = wc_get_cart_url();
                }
                #YITH Wishlist rul
                if( function_exists( 'YITH_WCWL' ) ){
                    $wishlist_url = YITH_WCWL()->get_wishlist_url();
                }else{
                    $wishlist_url = '#';
                }

                if (groffer_redux('groffer_header_mobile_switcher_top_search') == true) {
                    echo '<div class="mobile_only_icon_group search">
                                <a href="#" class="mt-search-icon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </a>
                            </div>';
                }
                if (groffer_redux('groffer_header_mobile_switcher_top_cart') == true) {
                    echo '<div class="mobile_only_icon_group cart">
                                <a  href="' .esc_url($cart_url).'">
                                    <i class="fa fa-shopping-basket"></i>
                                </a>
                            </div>';
                }
                if (groffer_redux('groffer_header_mobile_switcher_top_wishlist') == true) {
                    echo '<div class="mobile_only_icon_group wishlist">
                                <a class="top-payment" href="'.esc_url($wishlist_url).'">
                                  <i class="fa fa-heart-o"></i>
                                </a>
                            </div>';
                }
            }
        }

    }
    add_action('groffer_before_mobile_navigation_burger', 'groffer_header_mobile_icons_group');
}

if (!function_exists('groffer_after_client_shop')) {
    function groffer_after_client_shop(){
       echo '   <div class="clearfix"></div>
                    <div class="related-clients owl-carousel owl-theme ">';
                        global  $post;  
                        $orig_post = $post;  
                        $tags = wp_get_post_tags($post->ID);  

                        $args=array(  
                            'post_type'             => 'client',  
                            'posts_per_page'        => -1, // Number of related posts to display.  
                            'ignore_sticky_posts'   => 1  
                        );  

                        $my_query = new wp_query( $args );  

                        while( $my_query->have_posts() ) {  
                            $my_query->the_post(); 
                                
                            echo '<div class="item">
                                    <div class="related_blog_custom">';
                                    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_portfolio_pic700x450' );
                                        if($thumbnail_src) { 
                                            echo '<img src="'.esc_url($thumbnail_src[0]).'" class="img-responsive" />';
                                        } 
                            echo '</div>
                        </div>';         
                    } 
        echo ' </div>';
                       
        wp_reset_postdata(); 
    } 
    add_action('groffer_before_after_client_shop', 'groffer_after_client_shop');                   
}

if (!function_exists('groffer_footer_mobile_icons_group')) {
    function groffer_footer_mobile_icons_group(){

        if ( class_exists( 'ReduxFrameworkPlugin' ) ) { 
            if (groffer_redux('groffer_header_mobile_switcher_footer') == true) {

                $cart_url = "#";
                if ( class_exists( 'WooCommerce' ) ) {
                    $cart_url = wc_get_cart_url();
                }

                #YITH Wishlist rul
                if( function_exists( 'YITH_WCWL' ) ){
                    $wishlist_url = YITH_WCWL()->get_wishlist_url();
                }else{
                    $wishlist_url = '#';
                }
                
                echo '<div class="mobile_footer_icon_wrapper">';
                    if (groffer_redux('groffer_header_mobile_switcher_footer_search') == true) {
                        echo '<div class="col-md-3 search">
                                    <a href="#" class="mt-search-icon">
                                        <i class="fa fa-search" aria-hidden="true"></i>'.esc_html__('Search','groffer').'
                                    </a>
                                </div>';
                    }
                    if (groffer_redux('groffer_header_mobile_switcher_footer_cart') == true) {
                        echo '<div class="col-md-3 cart">
                                    <a  href="' .esc_url($cart_url). '">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>'.esc_html__('Cart','groffer').'
                                    </a>
                                </div>';
                    }
                    if (groffer_redux('groffer_header_mobile_switcher_footer_wishlist') == true) {
                        echo '<div class="col-md-3 wishlist">
                                    <a class="top-payment" href="'  .esc_url($wishlist_url).'">
                                      <i class="fa fa-heart-o"></i>'.esc_html__('Wishlist','groffer').'
                                    </a>
                                </div>';
                    }
                    if (groffer_redux('groffer_header_mobile_switcher_footer_account') == true) {
                        if (is_user_logged_in()) {
                            $user_url = get_permalink( get_option('woocommerce_myaccount_page_id') );;
                            $data_attributes = '';
                        }else{
                            $user_url = '#';
                            $data_attributes = 'data-modal="modal-log-in" class="modeltheme-trigger"';
                        }
                        echo '<div class="col-md-3 account">
                                    <a href="' .esc_url($user_url). '" '.wp_kses_post($data_attributes).'>
                                      <i class="fa fa-user"></i>'.esc_html__('Account','groffer').'
                                    </a>
                                </div>';
                    }
                echo '</div>';
            }
        }
    }
    add_action('groffer_before_footer_mobile_navigation', 'groffer_footer_mobile_icons_group');
}

/* My Account Header with SVG icon */
if (!function_exists('groffer_my_account_header')) {
 function groffer_my_account_header() {
    if (is_user_logged_in()) {
        echo '<div id="dropdown-user-profile" class="ddmenu">
                        
                <li id="nav-menu-register" class="nav-menu-account">
                    <img src="'.esc_url( get_template_directory_uri().'/images/svg/header-account.svg' ).'" alt="'.esc_attr__('Header Account','groffer').'" />       
                    <span class="top-register">'.esc_html__('Hello,','groffer').'</span><br>
                    <span>'.esc_html__('My Account','groffer').'</span>
                </li>
                <ul>
                    <li><a href="'.esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )).'"><i class="icon-layers icons"></i>'.esc_html__('My Dashboard','groffer').'</a></li>'; 
                    if (class_exists('Dokan_Vendor') && dokan_is_user_seller( dokan_get_current_user_id() )) {           
                        echo '<li><a href="'.esc_url( home_url().'/dashboard' ).'"><i class="icon-trophy icons"></i>'.esc_html__('Vendor Dashboard','groffer').'</a></li>';
                    }      
                    if (class_exists('WCFM')) {
                        echo '<li><a href="'.apply_filters( 'wcfm_dashboard_home', get_wcfm_page() ).'"><i class="icon-trophy icons"></i> '.esc_html__('Vendor Dashboard','groffer').'</a></li>';
                    } 
                    if (class_exists('WCMp')) { 
                        $current_user = wp_get_current_user();
                        if (is_user_wcmp_vendor($current_user)) {
                            $dashboard_page_link = wcmp_vendor_dashboard_page_id() ? get_permalink(wcmp_vendor_dashboard_page_id()) : '#';
                            echo apply_filters('wcmp_vendor_goto_dashboard', '<li><a href="' . esc_url($dashboard_page_link) . '"><i class="icon-trophy icons"></i> ' . esc_html__('Vendor Dashboard','groffer') . '</a></li>');
                        }
                    }
                    if (class_exists('WC_Vendors')) {
                        if (get_option('wcvendors_vendor_dashboard_page_id') != '') {
                            echo '<li><a href="'.esc_url( get_permalink(get_option('wcvendors_vendor_dashboard_page_id')) ).'"><i class="icon-trophy icons"></i>'.esc_html__('Vendor Dashboard','groffer').'</a></li>';
                        }
                    }    
                    echo '<li><a href="'.esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')).'orders').'"><i class="icon-bag icons"></i>'.esc_html__('My Orders','groffer').'</a></li>
                          <li><a href="'.esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')).'edit-account').'"><i class="icon-user icons"></i>'.esc_html__('Account Details','groffer').'</a></li>
                          <div class="dropdown-divider"></div>
                          <li><a href="'.esc_url(wp_logout_url( home_url() )).'"><i class="icon-logout icons"></i>'.esc_html__('Log Out','groffer').'</a></li>
                        </ul>
                      </div>';
    } else {
        echo '<li id="nav-menu-login" class="groffer-logoin">
                <img src="'.esc_url( get_template_directory_uri().'/images/svg/header-account.svg' ).'" alt="'.esc_attr__('Header Account','groffer').'" />
                <span class="top-register">'.esc_html__('Hello, Sign in','groffer').'</span>
                <a href="'.esc_url('#').'" class="lrm-login lrm-hide-if-logged-in">'.esc_html__('Account & Lists','groffer').'';
                    do_shortcode('[nextend_social_login provider="google"]');
         echo '</a>
           </li>';
    } 
  }
}

/* My Cart Header with SVG icon */
if (!function_exists('groffer_my_cart_header')) {
 function groffer_my_cart_header() {
 	  $cart_url = "#";
	  if ( class_exists( 'WooCommerce' ) ) {
	    $cart_url = wc_get_cart_url();
	  }
 	  echo '<img src="'.esc_url( get_template_directory_uri().'/images/svg/header-cart.svg' ).'" alt="'.esc_attr__('Header Cart','groffer').'" />
            <span class="cart-number">'.sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'groffer' ), WC()->cart->get_cart_contents_count() ).'</span>
            <a  class="shop_cart" href="'.esc_url($cart_url).'">'.esc_html__('My Cart', 'groffer').'</a>

            <a class="cart-contents" href="'.esc_url(wc_get_cart_url()).'" title="'.esc_attr__( 'View your shopping cart', 'groffer').'">'.WC()->cart->get_cart_total().'</a>
                
            <div class="header_mini_cart">';
            	the_widget( 'WC_Widget_Cart' );
            echo '</div>';
 	}
}

/* My Cart Header with SVG icon */
if (!function_exists('groffer_my_banner_header')) {
 function groffer_my_banner_header() {
    echo '<div class="groffer-top-banner text-center">
                <span>'.groffer_redux('discout_header_text').'</span>';
                echo do_shortcode('[mt-countdown date="'.groffer_redux('discout_header_date').'"]');
          echo '<a class="button btn" href="'.groffer_redux('discout_header_btn_link').'">'.groffer_redux('discout_header_btn_text').'</a>
          </div>';
}}
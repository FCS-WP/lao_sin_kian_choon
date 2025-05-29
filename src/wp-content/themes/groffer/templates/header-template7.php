<?php
  #Redux global variable
  global $groffer_redux;
  #WooCommerce global variable
  global $woocommerce;
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
?>

<?php  
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
  if ( groffer_redux('groffer_top_header_info_switcher') == true) {
      echo groffer_my_banner_header();
  }
} ?>

<header class="header-v7">
  <?php if ( groffer_redux('mt_disable_top_bar_seven')  == false) { ?>
  <div class="top-navigation">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 contact-header">
            <?php if($groffer_redux['groffer_contact_phone']) { ?>
              <!-- Call Us -->
              <div class="header-top-contact-method">
                <span><i class="fa fa-headphones"></i></span>
                <a href="<?php echo esc_url('#'); ?>">
                  <?php echo esc_html($groffer_redux['groffer_contact_phone']); ?>
                </a>
              </div>
            <?php } ?>
            <?php if($groffer_redux['groffer_work_program']) { ?>
            <!-- Work Program -->
            <div class="header-top-contact-method">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
              <?php echo esc_html($groffer_redux['groffer_work_program']); ?>
            </div>
          <?php } ?>
          <?php if($groffer_redux['groffer_contact_address']) { ?>
            <!-- Contact Address -->
            <div class="header-top-contact-method">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <?php echo esc_html($groffer_redux['groffer_contact_address']); ?>
            </div>
          <?php } ?>
        </div>
        <div class="col-md-6 col-sm-12 account-urls">
            <!-- Social Icons -->
            <div class="header-top-social-actions">
              <?php /*Lists all active social media accounts from the theme panel*/ ?>
                  <?php echo groffer_social_media_accounts(); ?> 
            </div>

          <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
            <?php if ( groffer_redux('groffer_header_currency_switcher')  == true) { ?>
                  <!-- LEFT SIDE LINKS -->               
                    <ul class="currency-language list-inline-block menu-list">
                    <?php
                      if ( has_nav_menu( 'menu_header_2' ) ) {
                        $defaults = array(
                          'menu'            => '',
                          'container'       => false,
                          'container_class' => '',
                          'container_id'    => '',
                          'menu_class'      => 'menu',
                          'menu_id'         => '',
                          'echo'            => true,
                          'fallback_cb'     => false,
                          'before'          => '',
                          'after'           => '',
                          'link_before'     => '',
                          'link_after'      => '',
                          'items_wrap'      => '%3$s',
                          'depth'           => 0,
                          'walker'          => ''
                        );
                        $defaults['theme_location'] = 'menu_header_2';
                        wp_nav_menu( $defaults );
                      }else{
                        echo '<p class="no-menu text-right">';
                          echo esc_html__('Right Side menu is missing.', 'groffer');
                        echo '</p>';
                      }
                    ?>
                  
                     <?php if(groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1'){ ?>

                      <li class="language-wrap">
                        <div class="language-box dropdown-box">
                          <ul class="currency-language list-inline-block menu-list">
                            <?php if(groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1'){ ?>
                              <?php //WPML's hook for language switching; ?>
                              <?php do_action('wpml_add_language_selector'); ?>
                              <?php //Our theme's hook for language switching (for custom language switchers) - other than the WPML; ?>
                              <?php do_action('groffer_add_language_selector'); ?>
                            <?php } ?>
                          </ul>
                        </div>
                      </li>
                    <?php } ?>
                    <?php if(groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1'){ ?>

                      <li class="language-wrap">
                        <div class="language-box dropdown-box">
                          <ul class="currency-language list-inline-block menu-list">
                            <?php if(groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1'){ ?>
                              <?php echo do_shortcode('[woocs sd]'); ?>
                            <?php } ?>
                          </ul>
                        </div>
                      </li>
                    <?php } ?>
                    </ul>

            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
  <div class="navbar navbar-default" id="groffer-main-head">
      <div class="container">
        <div class="row">
          <div class="navbar-header col-md-2 col-sm-12">

           <?php if ( !class_exists( 'mega_main_init' ) ) { ?> 
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
            <?php } ?>

            <?php do_action('groffer_before_mobile_navigation_burger'); ?>

            <?php echo groffer_logo(); ?>
          </div>
              
             
          <div class="first-part col-md-10 col-sm-12">

            <?php if (class_exists('WooCommerce')) : ?>

            <?php endif; ?>
            <div class="col-md-9 menu-holder">
            <nav class="navbar navbar-default pull-right" id="modeltheme-main-head">
                <!-- NAV MENU -->
                <div id="navbar" class="navbar-collapse collapse">
                  <div class="bot_nav_wrap">
                    <ul class="menu nav navbar-nav nav-effect nav-menu">
                      <?php
                        if ( has_nav_menu( 'primary' ) ) {
                          $defaults = array(
                            'menu'            => '',
                            'container'       => false,
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => 'menu',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => false,
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'items_wrap'      => '%3$s',
                            'depth'           => 0,
                            'walker'          => ''
                          );
                          $defaults['theme_location'] = 'primary';
                          wp_nav_menu( $defaults );
                        }else{
                          echo '<p class="no-menu text-right">';
                            echo esc_html__('Primary navigation menu is missing.', 'groffer');
                          echo '</p>';
                        }
                      ?>
                    </ul>
                  </div>
                </div>
            </div>
        <div class="col-md-1 button-inquiry">
           <a class="button inquiry btn" href ="<?php echo esc_html($groffer_redux['groffer_seven_header_button']); ?>"><?php esc_html_e('JOIN FREE','groffer') ?></a>
        </div>
        <?php if (class_exists('WooCommerce')) { ?>
          <div class="col-md-2 menu-products">
            <?php } else { ?>
              <div class="col-md-12 menu-products">
              <?php } ?>
                <div class="my-account-navbar">
                  <ul>
                  <?php if ( class_exists('woocommerce')) { ?>
                    <?php if (is_user_logged_in()) { ?> 
                      <div id="dropdown-user-profile" class="ddmenu">
                        
                        <li id="nav-menu-register" class="nav-menu-account">
                          <span class="top-register"><?php echo esc_html__('My Account','groffer'); ?></span>
                        </li>
                        <ul>
                          <li><a href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') )); ?>"><i class="icon-layers icons"></i> <?php echo esc_html__('My Dashboard','groffer'); ?></a></li>
                          
                          <?php if (class_exists('Dokan_Vendor') && dokan_is_user_seller( dokan_get_current_user_id() )) {  ?>            
                            <li><a href="<?php echo esc_url( home_url().'/dashboard' ); ?>"><i class="icon-trophy icons"></i> <?php echo esc_html__('Vendor Dashboard','groffer'); ?></a></li>
                          <?php } ?>
                          
                          <?php if (class_exists('WCFM')) { ?>
                            <li><a href="<?php echo apply_filters( 'wcfm_dashboard_home', get_wcfm_page() ); ?>"><i class="icon-trophy icons"></i> <?php echo esc_html__('Vendor Dashboard','groffer'); ?></a></li>
                          <?php } ?>
                          
                          <?php if (class_exists('WCMp')) { 
                            $current_user = wp_get_current_user();
                            if (is_user_wcmp_vendor($current_user)) {
                                $dashboard_page_link = wcmp_vendor_dashboard_page_id() ? get_permalink(wcmp_vendor_dashboard_page_id()) : '#';
                                echo apply_filters('wcmp_vendor_goto_dashboard', '<li><a href="' . esc_url($dashboard_page_link) . '"><i class="icon-trophy icons"></i> ' . esc_html__('Vendor Dashboard','groffer') . '</a></li>');
                            }
                          } ?>
                          
                          <?php if (class_exists('WC_Vendors')) { ?>
                            <?php if (get_option('wcvendors_vendor_dashboard_page_id') != '') { ?>
                              <li><a href="<?php echo esc_url( get_permalink(get_option('wcvendors_vendor_dashboard_page_id')) ); ?>"><i class="icon-trophy icons"></i> <?php echo esc_html__('Vendor Dashboard','groffer'); ?></a></li>
                            <?php } ?>
                          <?php } ?>
                          
                          <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')).'orders'); ?>"><i class="icon-bag icons"></i> <?php echo esc_html__('My Orders','groffer'); ?></a></li>
                          <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id')).'edit-account'); ?>"><i class="icon-user icons"></i> <?php echo esc_html__('Account Details','groffer'); ?></a></li>
                          <div class="dropdown-divider"></div>
                          <li><a href="<?php echo esc_url(wp_logout_url( home_url() )); ?>"><i class="icon-logout icons"></i> <?php echo esc_html__('Log Out','groffer'); ?></a></li>
                        </ul>
                      </div>
                    <?php } else { ?> <!-- logged out -->
                      <li id="nav-menu-login" class="groffer-logoin">               
                        <a href="<?php echo esc_url('#'); ?>" class="lrm-login lrm-hide-if-logged-in">
                          <span class="top-register"><i class="fa fa-user-circle"></i><?php echo esc_html__('LOG IN','groffer'); ?></span>
                          <?php do_shortcode('[nextend_social_login provider="google"]'); ?>
                        </a>
                    </li>
                  <?php } ?>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <nav class="navbar bottom-menu-wrapper"></nav>
  </div>
</header>
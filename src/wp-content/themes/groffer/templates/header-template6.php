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

<header class="header-v6">
  <?php if ( groffer_redux('mt_disable_top_bar')  == false) { ?>
  <div class="top-navigation">
    <div class="container">
      <div class="row">
        <div class="col-md-7 col-sm-12 contact-header">
            <?php if($groffer_redux['groffer_contact_phone']) { ?>
              <!-- Call Us -->
              <div class="header-top-contact-method">
                <span><i class="fa fa-mobile"></i></span>
                <a href="<?php echo esc_url('#'); ?>">
                  <?php echo esc_html($groffer_redux['groffer_contact_phone']); ?>
                </a>
              </div>
            <?php } ?>
        </div>
        <div class="col-md-5 col-sm-12 account-urls">
          <?php if($groffer_redux['groffer_contact_email']) { ?>
            <!-- Mail Us -->
            <div class="header-top-contact-method">
              <span><i class="fa fa-envelope"></i></span>
              <a href="<?php echo esc_url('#'); ?>">
                <?php echo esc_html($groffer_redux['groffer_contact_email']); ?>
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
              
             
          <div class="first-part col-md-9 col-sm-12">

          <?php if (class_exists('WooCommerce')) : ?>
            <nav class="navbar navbar-default" id="modeltheme-main-head">
              <div class="row row-0">
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
                <?php endif; ?> 
            </div>
        </div>
        <div class="col-md-1 button-search">
          <a class="inquiry mt-search-icon" href ="<?php echo esc_url("#"); ?>"><i class="fa fa-search"></i></a>
        </div>
        <div class="col-md-1 button-inquiry">
          <a class="inquiry" href ="<?php echo esc_html($groffer_redux['groffer_sixth_header_button']); ?>"><?php esc_html_e('JOIN FREE','groffer') ?></a>
        </div>
      </div>
    
    <nav class="navbar bottom-menu-wrapper"></nav>
  </div>
</header>
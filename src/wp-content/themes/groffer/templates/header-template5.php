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
<header class="header-v5">
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
            <nav class="col-md-8 navbar bottom-navbar-default" id="modeltheme-main-head">
              <div class="row row-0">
                <!-- NAV MENU -->
                <div id="navbar" class="navbar-collapse collapse col-md-9">
                  <div class="bot_nav_wrap">
                    <ul class="menu nav navbar-nav pull-left nav-effect nav-menu">
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
        </nav>
        <nav class="navbar bottom-menu-wrapper"></nav>
               <?php if (class_exists('WooCommerce')) { ?>
                  <div class="col-md-4 menu-products">
                <?php } else { ?>
                  <div class="col-md-12 menu-products">
                  <?php } ?>
                    <div class="my-account-navbar">
                      <ul>
                      <?php if ( class_exists('woocommerce')) { ?>
                        <?php echo groffer_my_account_header() ?>
                      <?php } ?>
                      </ul>
                    </div>
                    <div class="menu-product-cart">
                    <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                        <?php echo groffer_my_cart_header() ?>
                    <?php } ?>
                    </div>
                </div>
            </div>
          </div>
      </div>
    
  </div>
</header>
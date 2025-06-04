<?php
#Redux global variable
global $groffer_redux;
#WooCommerce global variable
global $woocommerce;
$cart_url = "#";
if (class_exists('WooCommerce')) {
  $cart_url = wc_get_cart_url();
}
#YITH Wishlist rul
if (function_exists('YITH_WCWL')) {
  $wishlist_url = YITH_WCWL()->get_wishlist_url();
} else {
  $wishlist_url = '#';
}
?>
<?php
if (class_exists('ReduxFrameworkPlugin')) {
  if (groffer_redux('groffer_top_header_info_switcher') == true) {
    echo groffer_my_banner_header();
  }
} ?>

<header class="header-v1">
  <div class="navbar navbar-default" id="groffer-main-head">
    <div class="container">
      <div class="row">
        <div class="navbar-header col-md-2 col-sm-12">

          <?php if (!class_exists('mega_main_init')) { ?>
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

          <?php if (class_exists('WooCommerce') && class_exists('ReduxFrameworkPlugin')) : ?>
            <div class="col-md-8 search-form-product">
              <div class="groffer-header-searchform">
                <form name="header-search-form" method="GET" class="woocommerce-product-search menu-search" action="<?php echo esc_url(home_url('/')); ?>">
                  <?php
                  if (isset($_REQUEST['product_cat']) && !empty($_REQUEST['product_cat'])) {
                    $optsetlect = $_REQUEST['product_cat'];
                  } else {
                    $optsetlect = 0;
                  }
                  $args = array(
                    'show_option_none' => esc_html__('Category', 'groffer'),
                    'option_none_value'  => '',
                    'hierarchical' => 0,
                    'class' => 'cat',
                    'echo' => 1,
                    'value_field' => 'slug',
                    'hide_empty' => true,
                    'selected' => $optsetlect
                  );
                  $args['taxonomy'] = 'product_cat';
                  $args['name'] = 'product_cat';
                  $args['class'] = 'form-control1';
                  wp_dropdown_categories($args);
                  ?>
                  <input type="hidden" value="product" name="post_type">
                  <input type="text" name="s" class="search-field" id="keyword" onkeyup="ibid_fetch_products()" maxlength="128" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search products...', 'groffer'); ?>">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                  <input type="hidden" name="post_type" value="product" />
                </form>
                <div id="datafetch"></div>
              </div>
            </div>
          <?php endif; ?>
          <?php if (class_exists('WooCommerce') && class_exists('ReduxFrameworkPlugin')) { ?>
            <div class="col-md-4 menu-products">
            <?php } else { ?>
              <div class="col-md-12 menu-products">
              <?php } ?>
              <div class="my-account-navbar">
                <ul>
                  <?php if (class_exists('woocommerce') && class_exists('ReduxFrameworkPlugin')) { ?>
                    <?php echo groffer_my_account_header() ?>
                  <?php } ?>
                </ul>
              </div>
              <div class="menu-product-cart">
                <?php if (class_exists('WooCommerce') && class_exists('ReduxFrameworkPlugin')) { ?>
                  <?php echo groffer_my_cart_header() ?>
                <?php } ?>
              </div>
              </div>
            </div>
        </div>
      </div>

      <!-- BOTTOM BAR -->
      <nav class="navbar bottom-navbar-default" id="modeltheme-main-head">
        <div class="container">
          <div class="row row-0">
            <!-- NAV MENU -->
            <div id="navbar" class="navbar-collapse collapse col-md-8">

              <?php if (class_exists('ReduxFrameworkPlugin')) { ?>
                <?php if (groffer_redux('groffer_header_category_menu') != '') { ?>
                  <?php if (groffer_redux('groffer_header_category_menu') == true) { ?>
                    <div class="bot_nav_cat_inner">
                      <div class="bot_nav_cat">
                        <a href="#" class="bot_cat_button">
                          <span><i class="fa fa-bars"></i><?php esc_html_e('Shop by', 'groffer'); ?></span>
                          <span class="cat_ico_block"><?php esc_html_e('Categories', 'groffer'); ?></span></a>
                        <ul class="bot_nav_cat_wrap">
                          <?php
                          if (has_nav_menu('category')) {
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
                            $defaults['theme_location'] = 'category';
                            wp_nav_menu($defaults);
                          } else {
                            echo '<p class="no-menu text-right">';
                            echo esc_html__('Category navigation menu is missing.', 'groffer');
                            echo '</p>';
                          }
                          ?>
                        </ul>

                      </div>
                    </div>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
              <div class="bot_nav_wrap">
                <ul class="menu nav navbar-nav pull-left nav-effect nav-menu">
                  <?php
                  if (has_nav_menu('primary')) {
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
                    wp_nav_menu($defaults);
                  } else {
                    echo '<p class="no-menu text-right">';
                    echo esc_html__('Primary navigation menu is missing.', 'groffer');
                    echo '</p>';
                  }
                  ?>
                </ul>
              </div>
            </div>
            <?php if (class_exists('ReduxFrameworkPlugin')) { ?>
              <?php if (groffer_redux('groffer_header_currency_switcher')  == true) { ?>
                <!-- LEFT SIDE LINKS -->
                <ul class="currency-language list-inline-block menu-list col-md-4">
                  <?php
                  if (has_nav_menu('menu_header_2')) {
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
                    wp_nav_menu($defaults);
                  } else {
                    echo '<p class="no-menu text-right">';
                    echo esc_html__('Right Side menu is missing.', 'groffer');
                    echo '</p>';
                  }
                  ?>

                  <a class="inquiry btn" href="<?php echo esc_html($groffer_redux['groffer_first_header_button']); ?>"><?php esc_html_e('Shop Now', 'groffer') ?></a>
                  <?php if (groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1') { ?>

                    <li class="language-wrap">
                      <div class="language-box dropdown-box">
                        <ul class="currency-language list-inline-block menu-list">
                          <?php if (groffer_redux('groffer_header_language_switcher') != '' && groffer_redux('groffer_header_language_switcher') == '1') { ?>
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
      </nav>
      <nav class="navbar bottom-menu-wrapper"></nav>
    </div>
</header>
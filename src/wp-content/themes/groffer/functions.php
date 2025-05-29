<?php
/**
 * groffer functions and definitions
 *
 * @package groffer
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 640; /* pixels */
}

if ( ! function_exists( 'groffer_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function groffer_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on groffer, use a find and replace
     * to change 'groffer' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'groffer', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'title-tag' );
    remove_theme_support( 'widgets-block-editor' );
    add_theme_support( 'woocommerce', array(
        'gallery_thumbnail_image_width' => 200,
        'woocommerce_thumbnail' => 768,
    ));
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'groffer' ),
    ) );

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        register_nav_menus( array(
            'menu_header_2' => esc_html__( 'Right Side Menu', 'groffer' ),
        ) );
    }

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if (groffer_redux('groffer_header_category_menu') != '') {
            if (groffer_redux('groffer_header_category_menu') != '0') {
                register_nav_menus( array(
                    'category' => esc_html__( 'Category Menu', 'groffer' ),
                ) );
            }
        }
    }

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );

    /*
     * Enable support for Post Formats.
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link',
    ) );

    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'groffer_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    ) ) );
}
endif; // groffer_setup
add_action( 'after_setup_theme', 'groffer_setup' );

/**
 * Register widget area.
 *
 */
if (!function_exists('groffer_widgets_init')) {
    function groffer_widgets_init() {

        global $groffer_redux;

        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'groffer' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Sidebar 1', 'groffer' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ) );
        if ( class_exists( 'WooCommerce' ) ) {
            register_sidebar( array(
                'name'          => esc_html__( 'WooCommerce sidebar', 'groffer' ),
                'id'            => 'woocommerce',
                'description'   => esc_html__( 'Used on WooCommerce pages', 'groffer' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h5 class="widget-title">',
                'after_title'   => '</h5>',
            ) );
        }

        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            if (isset($groffer_redux['dynamic_sidebars']) && !empty($groffer_redux['dynamic_sidebars'])){
                foreach ($groffer_redux['dynamic_sidebars'] as &$value) {
                    $id           = str_replace(' ', '', $value);
                    $id_lowercase = strtolower($id);
                    if ($id_lowercase) {
                        register_sidebar( array(
                            'name'          => esc_html($value),
                            'id'            => esc_html($id_lowercase),
                            'description'   => esc_html($value),
                            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                            'after_widget'  => '</aside>',
                            'before_title'  => '<h5 class="widget-title">',
                            'after_title'   => '</h5>',
                        ) );
                    }
                }
            }

            // Footer Widgets Row 1
            if (isset($groffer_redux['groffer_number_of_footer_columns']) && $groffer_redux['groffer-enable-footer-widgets'] == true) {
                for ($i=1; $i <= intval( $groffer_redux['groffer_number_of_footer_columns'] ) ; $i++) { 
                    register_sidebar( array(
                        'name'          => esc_html__( 'Footer Row 1, Sidebar ', 'groffer' ).esc_html($i),
                        'id'            => 'footer_column_'.esc_html($i),
                        'description'   => esc_html__( 'Footer sidebar to show widgets by different column grid.', 'groffer' ),
                        'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                        'after_widget'  => '</aside>',
                        'before_title'  => '<h5 class="widget-title">',
                        'after_title'   => '</h5>',
                    ) );
                }
            }

            // Footer Widgets Row 2
            if ($groffer_redux['groffer-enable-footer-widgets-row2'] && $groffer_redux['groffer-enable-footer-widgets-row2'] == true) {
                if (isset($groffer_redux['groffer_number_of_footer_columns_row2'])) {
                    for ($i=1; $i <= intval( $groffer_redux['groffer_number_of_footer_columns_row2'] ) ; $i++) { 
                        register_sidebar( array(
                            'name'          => esc_html__( 'Footer Row 2, Sidebar ', 'groffer' ).esc_html($i),
                            'id'            => 'footer_column_row2'.esc_html($i),
                            'description'   => esc_html__( 'Footer sidebar to show widgets by different column grid.', 'groffer' ),
                            'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                            'after_widget'  => '</aside>',
                            'before_title'  => '<h5 class="widget-title">',
                            'after_title'   => '</h5>',
                        ) );
                    }
                }
            }

            // Footer Widgets Row 3
            if ($groffer_redux['groffer-enable-footer-widgets-row3'] && $groffer_redux['groffer-enable-footer-widgets-row3'] == true) {
                if (isset($groffer_redux['groffer_number_of_footer_columns_row3'])) {
                    for ($i=1; $i <= intval( $groffer_redux['groffer_number_of_footer_columns_row2'] ) ; $i++) { 
                        register_sidebar( array(
                            'name'          => esc_html__( 'Footer Row 3, Sidebar ', 'groffer' ).esc_html($i),
                            'id'            => 'footer_column_row3'.esc_html($i),
                            'description'   => esc_html__( 'Footer sidebar to show widgets by different column grid.', 'groffer' ),
                            'before_widget' => '<aside id="%1$s" class="widget vc_column_vc_container %2$s">',
                            'after_widget'  => '</aside>',
                            'before_title'  => '<h5 class="widget-title">',
                            'after_title'   => '</h5>',
                        ) );
                    }
                }
            }
        }
    }
    add_action( 'widgets_init', 'groffer_widgets_init' );
}


/**
 * Enqueue scripts and styles.
 */
if (!function_exists('groffer_scripts')) {
    function groffer_scripts() {

        //STYLESHEETS
        wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css' );
        wp_enqueue_style( 'groffer-responsive', get_template_directory_uri().'/css/responsive.css' );
        wp_enqueue_style( 'groffer-media-screens', get_template_directory_uri().'/css/media-screens.css' );
        wp_enqueue_style( 'owl-carousel', get_template_directory_uri().'/css/owl.carousel.css' );
        wp_enqueue_style( 'owl-theme', get_template_directory_uri().'/css/owl.theme.css' );
        wp_enqueue_style( 'animate', get_template_directory_uri().'/css/animate.css' );
        wp_enqueue_style( 'simple-line-icons', get_template_directory_uri().'/css/simple-line-icons.css' );
        wp_enqueue_style( 'groffer-styles', get_template_directory_uri().'/css/style.css' );
        wp_enqueue_style( 'groffer-skin-default', get_template_directory_uri().'/css/skin-colors/skin-default.css' );
        wp_enqueue_style( 'groffer-style', get_stylesheet_uri() );
        wp_enqueue_style( 'groffer-gutenberg-frontend', get_template_directory_uri().'/css/gutenberg-frontend.css' );
        wp_enqueue_style( 'groffer-dataTables.min', get_template_directory_uri().'/css/dataTables.min.css' );
        wp_enqueue_style( 'custom-popup-style', get_template_directory_uri().'/css/custom-popup-style.css' );

        //SCRIPTS
        wp_enqueue_script( 'modernizr-custom', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '2.6.2', true );
        wp_enqueue_script( 'js-mtlisitings-dataTables', get_template_directory_uri() . '/js/dataTables.min.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'classie', get_template_directory_uri() . '/js/classie.js', array('jquery'), '1.0', true );
        wp_enqueue_script( 'jquery-form', get_template_directory_uri() . '/js/jquery.form.js', array('jquery'), '3.51', true );
        wp_enqueue_script( 'jquery-ketchup', get_template_directory_uri() . '/js/jquery.ketchup.all.min.js', array('jquery'), '0.3.1', true );
        wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'), '1.13.1', true );
        wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'uisearch', get_template_directory_uri() . '/js/uisearch.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'jquery-appear', get_template_directory_uri() . '/js/count/jquery.appear.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'jquery-countTo', get_template_directory_uri() . '/js/count/jquery.countTo.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'modernizr-viewport', get_template_directory_uri() . '/js/modernizr.viewport.js', array('jquery'), '2.6.2', true );
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.1', true );
        wp_enqueue_script( 'animate', get_template_directory_uri() . '/js/animate.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'custom-popup', get_template_directory_uri() . '/js/custom-popup.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), '1.0.0', true );
        if ( class_exists( 'WooCommerce' ) ) {
            wp_enqueue_script( 'jquery-match-height', get_template_directory_uri() . '/js/jquery.matchHeight.js', array('jquery'), '1.0.0', true );
        }

        // GRID LIST TOGGLE
        if ( class_exists( 'WooCommerce' ) ) {
            if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
                wp_enqueue_script( 'custom-woocommerce', get_template_directory_uri() . '/js/custom-woocommerce.js', array('jquery'), '1.0.0', true );
                wp_enqueue_style( 'dashicons' );
            }
        }

        wp_enqueue_script( 'groffer-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true );
        wp_enqueue_script( 'groffer-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array('jquery'), '20130115', true );
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'groffer_scripts' );
}



/**
 * Load jQuery datepicker.
 *
 * By using the correct hook you don't need to check `is_admin()` first.
 * If jQuery hasn't already been loaded it will be when we request the
 * datepicker script.
 */
function groffer_enqueue_datepicker() {
    // Load the datepicker script (pre-registered in WordPress).
    wp_enqueue_script( 'jquery-ui-datepicker' );

    // You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
    wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );  
}
add_action( 'wp_enqueue_scripts', 'groffer_enqueue_datepicker' );

/**
 * Enqueue scripts and styles for admin dashboard.
 */
if (!function_exists('groffer_enqueue_admin_scripts')) {
    function groffer_enqueue_admin_scripts( $hook ) {
        wp_enqueue_style( 'groffer-admin-style', get_template_directory_uri().'/css/admin-style.css' );
        if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
            wp_enqueue_style( 'groffer-admin-style', get_template_directory_uri().'/css/admin-style.css' );
        }
    }
    add_action('admin_enqueue_scripts', 'groffer_enqueue_admin_scripts');
}


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Include the TGM_Plugin_Activation class.
 */
require get_template_directory().'/inc/tgm/include_plugins.php';

/**
 * Include the Helpers Plugin Version class.
 */
require_once get_template_directory() . '/inc/helpers.php';

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'groffer_vcSetAsTheme' );
function groffer_vcSetAsTheme() {
    vc_set_as_theme( true );
}


add_action( 'vc_base_register_front_css', 'groffer_enqueue_front_css_foreever' );

function groffer_enqueue_front_css_foreever() {
    wp_enqueue_style( 'js_composer_front' );
}

/* ========= LOAD - REDUX - FRAMEWORK ===================================== */
require_once(get_template_directory() . '/redux-framework/groffer-config.php');

// CUSTOM FUNCTIONS
require_once(get_template_directory() . '/inc/custom-functions.php');
require_once(get_template_directory() . '/inc/custom-functions.header.php');
require_once get_template_directory() . '/inc/custom-functions.gutenberg.php';
require_once get_template_directory() . '/inc/custom-functions.popup.php';
if (class_exists( 'WooCommerce' )) {
    require_once get_template_directory() . '/inc/custom-functions.woocommerce.php';
}

/* ========= CUSTOM COMMENTS ===================================== */
require get_template_directory() . '/inc/custom-comments.php';

/* ========= RESIZE IMAGES ===================================== */
add_image_size( 'groffer_member_pic350x350',        350, 350, true );
add_image_size( 'groffer_testimonials_pic110x110',  110, 110, true );
add_image_size( 'groffer_portfolio_pic400x400',     400, 400, true );
add_image_size( 'groffer_portfolio_230x350',     230, 350, true );
add_image_size( 'groffer_product_simple_285x380',     295, 390, true );
add_image_size( 'groffer_featured_post_pic500x230', 500, 230, true );
add_image_size( 'groffer_related_post_pic500x300',  500, 300, true );
add_image_size( 'groffer_post_pic700x450',          700, 450, true );
add_image_size( 'groffer_cat_pic500x500',          500, 500, true );
add_image_size( 'groffer_portfolio_pic500x350',     500, 350, true );
add_image_size( 'groffer_portfolio_pic700x450',     700, 450, true );
add_image_size( 'groffer_single_post_pic1200x500',   1200, 500, true );
add_image_size( 'groffer_single_prod_2',   1200, 200, true );
add_image_size( 'groffer_posts_1100x600',     1100, 600, true );
add_image_size( 'groffer_post_widget_pic70x70',     70, 70, true );
add_image_size( 'groffer_pic100x75',                100, 75, true );


/* ========= LIMIT POST CONTENT ===================================== */
function groffer_excerpt_limit($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if(count($words) > $word_limit) {
        array_pop($words);
    }
    return implode(' ', $words);
}

/* ========= BREADCRUMBS ===================================== */
if (!function_exists('groffer_breadcrumb')) {
    function groffer_breadcrumb() {
        global $groffer_redux;

         if (  class_exists( 'ReduxFrameworkPlugin' ) ) {
            if ( !$groffer_redux['groffer-enable-breadcrumbs'] ) {
               return false;
            }
        }

        $delimiter = '';
        //text for the 'Home' link
        $name = esc_html__("Home", "groffer");
            if (!is_home() && !is_front_page() || is_paged()) {
                global $post;
                global $product;
                $home = home_url();
                echo '<li><a href="' . esc_url($home) . '">' . esc_html($name) . '</a></li> ' . esc_html($delimiter) . '';
            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                    if ($thisCat->parent != 0)
                echo(get_category_parents($parentCat, true, '' . esc_html($delimiter) . ''));
                echo   '<li class="active">' . esc_html(single_cat_title('', false)) .  '</li>';
            } elseif (is_day()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a></li> ' . esc_html($delimiter) . '';
                echo '<li><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
                echo  '<li class="active">' . get_the_time('d') . '</li>';
            } elseif (is_month()) {
                echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . '';
                echo  '<li class="active">' . get_the_time('F') . '</li>';
            } elseif (is_year()) {
                echo  '<li class="active">' . get_the_time('Y') . '</li>';
            } elseif (is_attachment()) {
                echo  '<li class="active">';
                the_title();
                echo '</li>';
            } elseif (class_exists( 'WooCommerce' ) && is_shop()) {
                echo  '<li class="active">';
                echo esc_html__('Shop','groffer');
                echo '</li>';
            }elseif (class_exists('WooCommerce') && is_product()) {
                echo '<li><a href="' . esc_url(wc_get_page_permalink( 'shop' )) . '">' . esc_html__('Shop', 'groffer') . '</a></li> ' . esc_html($delimiter) . '';
                $product_categories = get_the_terms( get_the_ID(), 'product_cat' );
                if ($product_categories) {
                    foreach ($product_categories as $product_category) {
                        $product_category_id = $product_category->term_id;
                        $product_category_name = $product_category->name;
                        echo '<li><a href="' . esc_url(get_term_link( $product_category_id, 'product_cat' )) . '">' . esc_html($product_category_name) . '</a></li> ' . esc_html($delimiter) . '';
                        break;
                    }
                }
                
                echo  '<li class="active">';
                the_title();
                echo  '</li>';
            } elseif (is_single()) {
                if (get_the_category()) {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo '<li>' . get_category_parents($cat, true, ' ' . esc_html($delimiter) . '') . '</li>';
                }
                echo  '<li class="active">';
                the_title();
                echo  '</li>';
            } elseif (is_page() && !$post->post_parent) {
                echo  '<li class="active">';
                the_title();
                echo  '</li>';
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    echo  wp_kses($crumb, 'link') . ' ' . esc_html($delimiter) . ' ';
                echo  '<li class="active">';
                the_title();
                echo  '</li>';
            } elseif (is_search()) {
                echo  '<li class="active">' . get_search_query() . '</li>';
            } elseif (is_tag()) {
                echo  '<li class="active">' . single_tag_title( '', false ) . '</li>';
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo  '<li class="active">' . esc_html($userdata->display_name) . '</li>';
            } elseif (is_404()) {
                echo  '<li class="active">' . esc_html__('404 Not Found','groffer') . '</li>';
            }
            if (get_query_var('paged')) {
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo  '<li class="active">';
                echo esc_html__('Page','groffer') . ' ' . get_query_var('paged');
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    echo  '</li>';
            }
        }
    }
}


// Ensure cart contents update when products are added to the cart via AJAX
if (!function_exists('groffer_woocommerce_header_add_to_cart_fragment')) {
    function groffer_woocommerce_header_add_to_cart_fragment( $fragments ) {
        ob_start();
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e( 'View your shopping cart','groffer' ); ?>"><?php echo WC()->cart->get_cart_total(); ?></a>
        <?php
        $fragments['a.cart-contents'] = ob_get_clean();
        return $fragments;
    } 
    add_filter( 'woocommerce_add_to_cart_fragments', 'groffer_woocommerce_header_add_to_cart_fragment', 30, 1 );
}


// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
if (!function_exists('groffer_woocommerce_header_add_to_cart_fragment_qty_only')) {
    function groffer_woocommerce_header_add_to_cart_fragment_qty_only( $fragments ) {
        ob_start();
        ?>
        <span class="cart-number"><?php echo sprintf ( esc_html__('%d', 'groffer'), WC()->cart->get_cart_contents_count() ); ?></span>
        <?php
        $fragments['span.cart-number'] = ob_get_clean();
        return $fragments;
    } 
    add_filter( 'woocommerce_add_to_cart_fragments', 'groffer_woocommerce_header_add_to_cart_fragment_qty_only', 30, 1 );
}

/**
 * Rename product data tabs
 */
if (class_exists('Dokan_Template_Products')) {
    add_filter( 'woocommerce_product_tabs', 'groffer_rename_tabs', 98 );
    function groffer_rename_tabs( $tabs ) {
        $tabs['more_seller_product']['title'] = __('More from Vendor', 'groffer');
        return $tabs;
    }
}

add_filter( 'woocommerce_widget_cart_is_hidden', 'groffer_always_show_cart', 40, 0 );
function groffer_always_show_cart() {
    return false;
}




// SINGLE PRODUCT
// Unhook functions
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );


// Hook functions
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );


/* ========= PAGINATION ===================================== */
if ( ! function_exists( 'groffer_pagination' ) ) {
    function groffer_pagination($query = null) {

        if (!$query) {
            global $wp_query;
            $query = $wp_query;
        }
        
        $big = 999999999; // need an unlikely integer
        $current = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : '1');
        echo paginate_links( 
            array(
                'base'          => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'        => '?paged=%#%',
                'current'       => max( 1, $current ),
                'total'         => $query->max_num_pages,
                'prev_text'     => esc_html__('&#171;','groffer'),
                'next_text'     => esc_html__('&#187;','groffer'),
            ) 
        );
    }
}

/* ========= SEARCH FOR POSTS ONLY ===================================== */
function groffer_search_filter($query) {
    if ($query->is_search && !isset($_GET['post_type'])) {
        $query->set('post_type', 'post');
    }
    return $query;
}
if( !is_admin() ){
    add_filter('pre_get_posts','groffer_search_filter');
}

/* ========= CHECK FOR PINGBACKS ===================================== */
function groffer_post_has( $type, $post_id ) {
    $comments = get_comments('status=approve&type=' . esc_html($type) . '&post_id=' . esc_html($post_id) );
    $comments = separate_comments( $comments );
    return 0 < count( $comments[ $type ] );
}

/* ========= REGISTER FONT-AWESOME TO REDUX ===================================== */
if (!function_exists('groffer_register_fontawesome_to_redux')) {
    function groffer_register_fontawesome_to_redux() {
        wp_register_style( 'font-awesome', get_template_directory_uri().'/css/font-awesome.min.css', array(), time(), 'all' );  
        wp_enqueue_style( 'font-awesome' );
    }
    add_action( 'redux/page/redux_demo/enqueue', 'groffer_register_fontawesome_to_redux' );
}

add_filter( 'woocommerce_get_script_data', 'change_js_view_cart_button', 10, 2 ); 
function change_js_view_cart_button( $params, $handle )  {
    if( 'wc-add-to-cart' !== $handle ) return $params;

    // Changing "view_cart" button text and URL
    $params['i18n_view_cart'] = "<img src='https://groffer.modeltheme.com/wp-content/themes/groffer/images/svg/added-to-cart.svg'>";

    return $params;
}
/* Custom functions for woocommerce */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


if (!function_exists('groffer_woocommerce_show_top_custom_block')) {
    function groffer_woocommerce_show_top_custom_block() {
        $args = array();
        global $product;
        global $groffer_redux;
        echo '<div class="thumbnail-and-details">';    
                  
            wc_get_template( 'loop/sale-flash.php' );
            
            echo '<div class="overlay-container">';
                
                echo '<div class="thumbnail-overlay"></div>';
                echo '<div class="overlay-components">';
                    echo '<div class="component add-to-cart">';
                        woocommerce_template_loop_add_to_cart();
                    echo '</div>';
                    if ( class_exists( 'YITH_WCWL' ) ) {
    	                echo '<div class="component wishlist">';
    	                    echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
    	                echo '</div>';
    	            }

                    if (  class_exists( 'YITH_WCQV' ) ) {
                        echo '<div class="component quick-view">';
                            echo '<a href="'.esc_url('#').'" class="button yith-wcqv-button" data-tooltip="'.esc_attr__('Quickview', 'groffer').'" data-product_id="' . esc_attr(yit_get_prop( $product, 'id', true )) . '"><i class="fa fa-search"></i></a>';
                        echo '</div>';
                    }

                echo '</div>';
            echo '</div>';

            echo '<a class="woo_catalog_media_images" title="'.the_title_attribute('echo=0').'" href="'.esc_url(get_the_permalink(get_the_ID())).'">'.woocommerce_get_product_thumbnail();
               if (class_exists('ReduxFrameworkPlugin')) {
                    if (groffer_redux('groffer-archive-secondary-image-on-hover') != '0' && groffer_redux('groffer-archive-secondary-image-on-hover') != '') {
                        // SECONDARY IMAGE (FIRST IMAGE FROM WOOCOMMERCE PRODUCT GALLERY)
                        $product = wc_get_product( get_the_ID() );
                        $attachment_ids = $product->get_gallery_image_ids();

                        if ( is_array( $attachment_ids ) && !empty($attachment_ids) ) {
                            $first_image_url = wp_get_attachment_image_url( $attachment_ids[0], 'groffer_portfolio_pic400x400' );
                            echo '<img class="woo_secondary_media_image" src="'.esc_url($first_image_url).'" alt="'.the_title_attribute('echo=0').'" />';
                        }
                    }
                }
            echo '</a>';
        echo '</div>';
    }
    add_action( 'woocommerce_before_shop_loop_item_title', 'groffer_woocommerce_show_top_custom_block' );
}


if (!function_exists('groffer_woocommerce_show_price_and_review')) {
    function groffer_woocommerce_show_price_and_review() {
        $args = array();
        global $product;
        global $groffer_redux;

        echo '<div class="details-container">';
            echo '<div class="details-price-container details-item">';
                wc_get_template( 'loop/price.php' );
                
            echo '</div>';
        echo '</div>';
    }
    add_action( 'woocommerce_after_shop_loop_item_title', 'groffer_woocommerce_show_price_and_review' );
}



function groffer_woocommerce_get_sidebar() {
    global $groffer_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( is_shop() || is_product_category() || is_product_tag() || wc_get_attribute_taxonomies()) {

            if (is_active_sidebar($groffer_redux['groffer_shop_layout_sidebar'])) {
                dynamic_sidebar( $groffer_redux['groffer_shop_layout_sidebar'] );
            }else{
                if (is_active_sidebar('woocommerce')) {
                    dynamic_sidebar( 'woocommerce' );
                } 
            }
        }elseif ( is_product() ) {
            if (is_active_sidebar($groffer_redux['groffer_single_shop_sidebar'])) {
                dynamic_sidebar( $groffer_redux['groffer_single_shop_sidebar'] );
            }else{
                if (is_active_sidebar('woocommerce')) {
                    dynamic_sidebar( 'woocommerce' );
                }
            }
        }
    }else{
        if (is_active_sidebar('woocommerce')) {
            dynamic_sidebar( 'woocommerce' );
        }
    }
}
add_action ( 'woocommerce_sidebar', 'groffer_woocommerce_get_sidebar' );

add_filter( 'loop_shop_columns', 'groffer_wc_loop_shop_columns', 1, 13 );

/*
 * Return a new number of maximum columns for shop archives
 * @param int Original value
 * @return int New number of columns
 */
function groffer_wc_loop_shop_columns( $number_columns ) {
    global $groffer_redux;

    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        if ( $groffer_redux['groffer-shop-columns'] ) {
            return $groffer_redux['groffer-shop-columns'];
        }else{
            return 3;
        }
    }else{
        return 3;
    }
}

global $groffer_redux;
if ( isset($groffer_redux['groffer-enable-related-products']) && !$groffer_redux['groffer-enable-related-products'] ) {
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}


if ( !function_exists( 'groffer_related_products_args' ) ) {
    add_filter( 'woocommerce_output_related_products_args', 'groffer_related_products_args' );
    function groffer_related_products_args( $args ) {
        global $groffer_redux;
        if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
            $args['posts_per_page'] = $groffer_redux['groffer-related-products-number'];
        }else{
            $args['posts_per_page'] = 5;
        }
        $args['columns'] = 5;
        return $args;
    }
}
if ( !function_exists( 'groffer_show_whislist_button_on_single' ) ) {
    function groffer_show_whislist_button_on_single() {
        if ( class_exists( 'YITH_WCWL' ) ) {
            echo '<div class="wishlist-container">';
                echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
            echo '</div>';
        }
    }
    if ( class_exists( 'YITH_WCWL' ) ) {
        add_action( 'woocommerce_single_product_summary', 'groffer_show_whislist_button_on_single', 36 );
    }
}

//To change wp_register() text:
if ( !function_exists( 'groffer_register_text_change' ) ) {
    add_filter('register','groffer_register_text_change');
    function groffer_register_text_change($text) {
        $register_text_before   = esc_html__('Site Admin', 'groffer');
        $register_text_after    = esc_html__('Edit Your Profile', 'groffer');

        $text = str_replace($register_text_before, $register_text_after ,$text);

        return $text;
    }
}

//To change wp_loginout() text:
if ( !function_exists( 'groffer_loginout_text_change' ) ) {
    add_filter('loginout','groffer_loginout_text_change');
    function groffer_loginout_text_change($text) {
        $login_text_before  = esc_html__('Log in', 'groffer');
        $login_text_after   = esc_html__('Login', 'groffer');

        $logout_text_before = esc_html__('Log', 'groffer');
        $logout_text_after  = esc_html__('Log', 'groffer');

        $text = str_replace($login_text_before, $login_text_after ,$text);
        $text = str_replace($logout_text_before, $logout_text_after ,$text);
        return $text;
    }
}

function groffer_add_editor_styles() {
    add_editor_style( 'css/custom-editor-style.css' );
}
add_action( 'admin_init', 'groffer_add_editor_styles' );


if (!function_exists('groffer_new_loop_shop_per_page')) {
    add_filter( 'loop_shop_per_page', 'groffer_new_loop_shop_per_page', 20 );
    function groffer_new_loop_shop_per_page( $cols ) {
      // $cols contains the current number of products per page based on the value stored on Options -> Reading
      // Return the number of products you wanna show per page.
      $cols = 12;
      return $cols;
    }
}


if (!function_exists('groffer_redux')) {
    function groffer_redux($redux_meta_name1 = '',$redux_meta_name2 = ''){

        global  $groffer_redux;
        if (is_null($groffer_redux)) {
            return;
        }

        $html = '';
        if (isset($redux_meta_name1) && !empty($redux_meta_name2)) {
            $html = $groffer_redux[$redux_meta_name1][$redux_meta_name2];
        }elseif(isset($redux_meta_name1) && empty($redux_meta_name2)){
            $html = $groffer_redux[$redux_meta_name1];
        }
        
        return $html;
    }
}


/* search */
if (!function_exists('groffer_search_form_ajax_fetch')) {
    add_action( 'wp_footer', 'groffer_search_form_ajax_fetch' );
    function groffer_search_form_ajax_fetch() { ?>
        <script type="text/javascript">
         function ibid_fetch_products(){

             jQuery.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'post',
                data: { action: 'groffer_search_form_data_fetch', keyword: jQuery('#keyword').val() },
                success: function(data) {
                    jQuery('#datafetch').html( data );
                }
            });

        }
        </script>
    <?php
    }
}

/* Single Theme Functions */
if (!function_exists('groffer_we_postmeta')) {
    function groffer_we_postmeta( $post_id=0 )
        {
            return array(
                'rating'            => get_post_meta( $post_id, '_we_rating', true ),
                'site'              => get_post_meta( $post_id, '_we_site', true ),
                'audio_preview'     => get_post_meta( $post_id, '_we_audio_preview', true ),
                'item_id'           => get_post_meta( $post_id, '_we_item_id', true ),
                'trending'          => (boolean)get_post_meta( $post_id, '_we_trending', true ),
                'user_badges'       => get_post_meta( $post_id, '_user_badges', true ),
                'summary'           => get_post_meta( $post_id, '_we_summary', true ),
                'updated_at'        => get_post_meta( $post_id, '_we_updated_at', true ),
                'live_site'         => get_post_meta( $post_id, '_we_live_site', true ),
                'author'            => get_post_meta( $post_id, '_we_author', true ),
                'number_of_sales'   => get_post_meta( $post_id, '_we_number_of_sales', true ),
                'number_of_sales'   => get_post_meta( $post_id, '_we_number_of_sales', true )
            );
        }
}
if (!function_exists('groffer_print_product_ratings')) {
    function groffer_print_product_ratings( $meta=array() )
        {
            $html = array();
            if( isset($meta['rating']['rating']) ){
                $nb = (float) ceil($meta['rating']['rating']);
                $rating = (float) $meta['rating']['rating']; 
                $html[] = '<div class="theme-rating" data-rating="' . ( $rating ) . '">';
                
                    $html[] = '<div class="rating-background">';
                    for( $i=1; $i <=5 ; $i++ ){
                        $html[] = '<span><i class="fa fa-star"></i></span>';
                    }
                    $html[] = '</div>';
                    
                    $html[] = '<div class="rating-counter">';
                    for( $i=1; $i <=5 ; $i++ ){
                        $html[] = '<span class="rating-star-' . ( $i ) . '"><i class="fa fa-star"></i></span>';
                    }
                    $html[] = '</div>';
                    
                $html[] = '</div>';
            }
            
            
            return implode( "", $html ); 
        }
}
if (!function_exists('groffer_split_props')) {
    function groffer_split_props($str='') 
            {
                $ret = array();
                if (empty($str)) return $ret;
                
                $arr = explode(',', $str);
                $arr = array_map('trim', $arr);
                foreach ($arr as $key => $val) {
                    $arr2 = explode(':', $val);
                    $arr2 = array_map('trim', $arr2);
                    
                    $arr2_len = count($arr2);
                    if ( 2 == $arr2_len ) {
                        $_key = $arr2[0];
                        $ret["$_key"] = array();
                        $ret["$_key"][] = $arr2[1];

                    } else if ( 1 == $arr2_len ) {
                        $ret["$_key"][] = $arr2[0];
                    }
                }
                foreach ($ret as $key => $val) {
                    $ret["$key"] = implode(', ', $val);
                }
                return $ret;
            }
}
/* End Single Theme Functions */
 // the ajax function
if (!function_exists('groffer_search_form_data_fetch')) {
    add_action('wp_ajax_groffer_search_form_data_fetch' , 'groffer_search_form_data_fetch');
    add_action('wp_ajax_nopriv_groffer_search_form_data_fetch','groffer_search_form_data_fetch');
    function groffer_search_form_data_fetch(){
        if (  esc_attr( $_POST['keyword'] ) == null ) { die(); }
            $the_query = new WP_Query( array( 'post_type'=> 'product', 'post_per_page' =>  get_option('posts_per_page'), 's' => esc_attr( $_POST['keyword'] ) ) );
            $count_tax = 0;
            if( $the_query->have_posts() ) : ?>
                <ul class="search-result">           
                    <?php while( $the_query->have_posts() ): $the_query->the_post();  $post_type = get_post_type_object( get_post_type() ); ?>   
                        <?php $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'groffer_post_widget_pic70x70' ); ?>             
                        <li>
                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                <?php if($thumbnail_src) { ?>
                                    <?php the_post_thumbnail( 'groffer_post_widget_pic70x70' ); ?>
                                <?php } ?>
                                <?php the_title(); ?>
                            </a>
                        </li>             
                    <?php endwhile; ?>
                </ul>       
                <?php wp_reset_postdata();  
            
            endif;
        die();
    }
}


remove_action( 'woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10 );


add_filter( 'woocommerce_product_add_to_cart_text', 'groffer_change_select_options_button_text', 9999, 2 );
 
function groffer_change_select_options_button_text( $label, $product ) {
   if ( $product->is_type( 'variable' ) ) {
      return 'Add to cart';
   }
   return $label;
}

// KSES ALLOWED HTML
if (!function_exists('groffer_kses_allowed_html')) {
    function groffer_kses_allowed_html($tags, $context) {
      switch($context) {
        case 'link': 
            $tags = array( 
                'a' => array(
                    'href' => array(),
                    'class' => array(),
                    'title' => array(),
                    'target' => array(),
                    'rel' => array(),
                    'data-commentid' => array(),
                    'data-postid' => array(),
                    'data-belowelement' => array(),
                    'data-respondelement' => array(),
                    'data-replyto' => array(),
                    'aria-label' => array(),
                )
            );
            return $tags;
        break;

        case 'image':
            $tags = array(
                'img' => array(
                    'src' => array(),
                    'alt' => array(),
                    'class' => array(),
                    'style' => array(),
                    'height' => array(),
                    'width' => array(),
                    'loading' => array(),

                )
            );
            return $tags;
        break;

        case 'icon':
            $tags = array(
                'i' => array(
                    'class' => array(),
                ),
            );
            return $tags;
        break;
        
        default: 
            return $tags;
      }
    }
    add_filter( 'wp_kses_allowed_html', 'groffer_kses_allowed_html', 10, 2);
}

/**
 * Minifying the CSS
  */
function groffer_minify_css($css){
  $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
  return $css;
}
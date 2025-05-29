<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <link rel="shortcut icon" href="<?php echo esc_url(groffer_redux('groffer_favicon', 'url')); ?>">
    <?php } ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
    /**
    * Since WordPress 5.2
    */
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    }

    if (!in_array('login-register-page', get_body_class())) { ?>
        <div class="modeltheme-modal" id="modal-log-in">
            <div class="modeltheme-content" id="login-modal-content">
                <h3 class="relative">
                    <?php echo esc_html__('Login to Your Account', 'groffer'); ?>
                </h3>
                <div class="modal-content row">
                    <div class="col-md-12">
                        <form name="loginform" id="loginform" action="<?php echo wp_login_url(); ?>" method="post">
                            <p class="login-username">
                                <label for="user_login"><?php echo esc_html__('Username or Email Address','groffer'); ?></label>
                                <i class="fa fa-user-o" aria-hidden="true"></i>
                                <input type="text" name="log" id="user_login" class="input" value="" required size="20" placeholder="<?php echo esc_attr__('Username','groffer'); ?>">
                            </p>
                            <p class="login-password">
                                <label for="user_pass"><?php echo esc_html__('Password','groffer'); ?></label>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                <input type="password" name="pwd" id="user_pass" class="input" value="" required size="20" placeholder="<?php echo esc_attr__('Password','groffer'); ?>">
                            </p>
                            
                            <p class="login-remember">
                                <label>
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                                    <?php echo esc_html__('Remember Me','groffer'); ?>
                                </label>
                            </p>
                            <div class="row-buttons">
                                <p class="login-submit">
                                    <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="<?php echo esc_attr__('Log In','groffer'); ?>">
                                    <input type="hidden" name="redirect_to" value="<?php echo get_site_url(); ?>">
                                </p>
                                <?php if (  get_option('users_can_register')) { ?>
                                    <p class="btn-register-p">
                                        <a class="btn btn-register" id="register-modal"><?php echo esc_html__('Register','groffer'); ?></a>
                                    </p>
                                <?php } else { ?>
                                    <p class="um-notice err text-center"><?php echo esc_html__('Registration is currently disabled','groffer'); ?></p>
                                <?php } ?>

                                <div class="clearfix"></div>
                                <p class="woocommerce-LostPassword lost_password">
                                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php echo esc_html__('Lost your password?','groffer'); ?></a>
                                </p>
                            </div>
                            
                        </form>
                        <?php if (function_exists('YITH_WC_Social_Login')) { ?>
                            <?php if(get_option('ywsl_facebook_enable') == 'yes' || get_option('ywsl_google_enable') == 'yes' || get_option('ywsl_twitter_enable') == 'yes' ){ ?>
                                <div class="separator-modal"><?php echo esc_html__('OR ','groffer'); ?></div>
                                <?php echo do_shortcode("[yith_wc_social_login]"); ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modeltheme-content" id="signup-modal-content">
                <h3 class="relative">
                    <?php echo esc_html__('Personal Details','groffer'); ?>
                </h3>
                <div class="modal-content row">
                    <div class="col-md-12">
                        <?php if ( class_exists( 'WooCommerce' ) ) { ?>
                            <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) { ?>
                                <div class="u-column2 col-2">
                                    <?php do_action( 'woocommerce_before_customer_login_form' ); ?>
                                    <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>
                                        <?php do_action( 'woocommerce_register_form_start' ); ?>
                                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Username', 'groffer' ); ?>" />
                                            </p>
                                        <?php endif; ?>
                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Email address', 'groffer' ); ?>" />
                                        </p>
                                        <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_attr_e( 'Password', 'groffer' ); ?>" />
                                            </p>
                                        <?php else : ?>
                                            <p><?php esc_html_e( 'A password will be sent to your email address.', 'groffer' ); ?></p>
                                        <?php endif; ?>
                                        <?php do_action( 'woocommerce_register_form' ); ?>
                                        <p class="woocommerce-FormRow form-row">
                                            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                            <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'groffer' ); ?>"><?php esc_html_e( 'Register', 'groffer' ); ?></button>
                                            <!-- Back to login -->
                                            <a class="btn btn-login btn-login-p" id="login-modal"><?php echo esc_html__('Back to Login','groffer'); ?></a>
                                        </p>
                                        <?php do_action( 'woocommerce_register_form_end' ); ?>
                                    </form>
                                    <?php if (function_exists('YITH_WC_Social_Login')) { ?>
                                        <?php if(get_option('ywsl_facebook_enable') == 'yes' || get_option('ywsl_google_enable') == 'yes' || get_option('ywsl_twitter_enable') == 'yes' ){ ?>
                                            <div class="separator-modal"><?php echo esc_html__('OR ','groffer'); ?></div>
                                            <?php echo do_shortcode("[yith_wc_social_login]"); ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>            
            </div>
        </div>
    <?php } ?>
    <?php
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        global $groffer_redux;
        if ($groffer_redux['groffer-enable-popup'] == true) {
            echo groffer_popup_modal(); 
        }
    }?>
    <div class="modeltheme-overlay"></div>
    
    <!-- Fixed Search Form -->
    <div class="fixed-search-overlay">
        <!-- Close Sidebar Menu + Close Overlay -->
        <i class="icon-close icons"></i>
        <!-- INSIDE SEARCH OVERLAY -->
        <div class="fixed-search-inside">
            <div class="modeltheme-search">
                <?php do_action('groffer_products_search_form'); ?>
            </div>
        </div>
    </div>
        
    <div id="page" class="hfeed site">
    <?php
        #Redux global variable
        global $groffer_redux;
        
        if (is_page()) {
            $mt_custom_header_options_status = get_post_meta( get_the_ID(), 'groffer_custom_header_options_status', true );
            $mt_header_custom_variant = get_post_meta( get_the_ID(), 'groffer_header_custom_variant', true );
            if (isset($mt_custom_header_options_status) AND $mt_custom_header_options_status == 'yes') {
                get_template_part( 'templates/header-template'.esc_html($mt_header_custom_variant) );
            }else{
                // DIFFERENT HEADER LAYOUT TEMPLATES
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    if ($groffer_redux['header_layout'] == 'first_header') {
                        // Header Layout #1
                        get_template_part( 'templates/header-template1' );
                    }elseif ($groffer_redux['header_layout'] == 'second_header') {
                        // Header Layout #2
                        get_template_part( 'templates/header-template2' );
                    }elseif ($groffer_redux['header_layout'] == 'third_header') {
                        // Header Layout #3
                        get_template_part( 'templates/header-template3' );
                    }elseif ($groffer_redux['header_layout'] == 'fourth_header') {
                        // Header Layout #4
                        get_template_part( 'templates/header-template4' );
                    }elseif ($groffer_redux['header_layout'] == 'fifth_header') {
                        // Header Layout #5
                        get_template_part( 'templates/header-template5' );
                    }elseif ($groffer_redux['header_layout'] == 'sixth_header') {
                        // Header Layout #6
                        get_template_part( 'templates/header-template6' );
                    }elseif ($groffer_redux['header_layout'] == 'seven_header') {
                        // Header Layout #7
                        get_template_part( 'templates/header-template7' );
                    }else{
                        // if no header layout selected show header layout #1
                        get_template_part( 'templates/header-template1' );
                    } 
                }else{
                    get_template_part( 'templates/header-template1' );
                }
            }
        }else{
            // DIFFERENT HEADER LAYOUT TEMPLATES
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                if ($groffer_redux['header_layout'] == 'first_header') {
                    // Header Layout #1
                    get_template_part( 'templates/header-template1' );
                }elseif ($groffer_redux['header_layout'] == 'second_header') {
                    // Header Layout #5
                    get_template_part( 'templates/header-template2' );
                }elseif ($groffer_redux['header_layout'] == 'third_header') {
                    // Header Layout #5
                    get_template_part( 'templates/header-template3' );
                }elseif ($groffer_redux['header_layout'] == 'fourth_header') {
                        // Header Layout #4
                        get_template_part( 'templates/header-template4' );
                }elseif ($groffer_redux['header_layout'] == 'fifth_header') {
                    // Header Layout #5
                    get_template_part( 'templates/header-template5' );
                }elseif ($groffer_redux['header_layout'] == 'sixth_header') {
                    // Header Layout #6
                    get_template_part( 'templates/header-template6' );
                    }elseif ($groffer_redux['header_layout'] == 'seven_header') {
                    // Header Layout #7
                    get_template_part( 'templates/header-template7' );
                }else{
                    // if no header layout selected show header layout #1
                    get_template_part( 'templates/header-template1' );
                }
            }else{
                get_template_part( 'templates/header-template1' );
            }
        }
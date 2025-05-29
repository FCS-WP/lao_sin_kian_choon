<?php
/**
  ReduxFramework groffer Theme Config File
  For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
 * */



if (!class_exists("Redux_Framework_groffer_config")) {

    class Redux_Framework_groffer_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }
            
            // This is needed. Bah WordPress bugs.  ;)
            if ( get_template_directory() && strpos( Redux_Functions_Ex::wp_normalize_path( __FILE__ ), Redux_Functions_Ex::wp_normalize_path( get_template_directory() ) ) !== false) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);    
            }
        }

        public function initSettings() {

            if ( !class_exists("ReduxFramework" ) ) {
                return;
            }       
            
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

       

        

        public function setSections() {

            include_once(get_template_directory() . '/redux-framework/modeltheme-config.arrays.php');

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $groffer_patterns_path = ReduxFramework::$_dir . '../polygon/patterns/';
            $groffer_patterns_url = ReduxFramework::$_url . '../polygon/patterns/';
            $groffer_patterns = array();

            if (is_dir($groffer_patterns_path)) :

                if ($groffer_patterns_dir = opendir($groffer_patterns_path)) :
                    $groffer_patterns = array();

                    while (( $groffer_patterns_file = readdir($groffer_patterns_dir) ) !== false) {

                        if (stristr($groffer_patterns_file, '.png') !== false || stristr($groffer_patterns_file, '.jpg') !== false) {
                            $name = explode(".", $groffer_patterns_file);
                            $name = str_replace('.' . end($name), '', $groffer_patterns_file);
                            $groffer_patterns[] = array('alt' => $name, 'img' => $groffer_patterns_url . $groffer_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'groffer'), $this->theme->display('Name'));
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                    <a href="<?php echo esc_url(wp_customize_url()); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                        <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','groffer'); ?>" />
                    </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','groffer'); ?>" />
            <?php endif; ?>

                <h4>
            <?php echo esc_html($this->theme->display('Name')); ?>
                </h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'groffer'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'groffer'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'groffer') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_html($this->theme->display('Description')); ?></p>
                <?php
                if ($this->theme->parent()) {
                    printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'groffer') . '</p>', __('http://codex.WordPress.org/Child_Themes', 'groffer'), $this->theme->parent()->display('Name'));
                }
                ?>

                </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();


            /*
             *
             * ---> START SECTIONS
             *
             */
            include_once(get_template_directory(). '/redux-framework/modeltheme-config.responsive.php');


            # General Settings
            $this->sections[] = array(
                'icon' => 'el-icon-wrench',
                'title' => __('General Settings', 'groffer'),
            );
            # General
            $this->sections[] = array(
                'icon' => 'el el-chevron-right',
                'subsection' => true,
                'title' => __('Breadcrumbs', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_general_breadcrumbs',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Breadcrumbs</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer-enable-breadcrumbs',
                        'type'     => 'switch', 
                        'title'    => __('Breadcrumbs', 'groffer'),
                        'subtitle' => __('Enable or disable breadcrumbs', 'groffer'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'breadcrumbs-delimitator',
                        'type'     => 'text',
                        'title'    => __('Breadcrumbs delimitator', 'groffer'),
                        'subtitle' => __('This is a little space under the Field Title in the Options table, additional info is good in here.', 'groffer'),
                        'desc'     => __('This is the description field, again good for additional info.', 'groffer'),
                        'required' => array( 'groffer-enable-breadcrumbs', '=', true ),
                        'default'  => '/'
                    ),
                )
            );
            # General -> Sidebars
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Sidebars', 'groffer'),
                'subsection' => true,
                'fields' => array(
                    array(
                        'id'   => 'groffer_sidebars_generator',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Generate Unlimited Sidebars</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'dynamic_sidebars',
                        'type'     => 'multi_text',
                        'title'    => __( 'Sidebars', 'groffer' ),
                        'subtitle' => __( 'Use the "Add More" button to create unlimited sidebars.', 'groffer' ),
                        'add_text' => __( 'Add one more Sidebar', 'groffer' )
                    )
                )
            );



            # Section #2: Styling Settings
            $this->sections[] = array(
                'icon' => 'el-icon-magic',
                'title' => __('Styling Settings', 'groffer'),
            );
            // Colors
            $this->sections[] = array(
                'icon' => 'el-icon-magic',
                'subsection' => true,
                'title' => __('Colors', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_divider_links',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Links Colors(Regular, Hover, Active/Visited)</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_global_link_styling',
                        'type'     => 'link_color',
                        'title'    => esc_html__('Links Color Option', 'groffer'),
                        'subtitle' => esc_html__('Only color validation can be done on this field type(Default Regular:#136450; Default Hover: #136450; Default Active: #484848;)', 'groffer'),
                        'default'  => array(
                            'regular'  => '#136450', // blue
                            'hover'    => '#136450', // blue-x3
                            'active'   => '#484848',  // blue-x3
                            'visited'  => '#484848',  // blue-x3
                        )
                    ),
                    array(
                        'id'   => 'groffer_divider_main_colors',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Main Colors & Backgrounds</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_style_main_texts_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Main texts color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => '#136450',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'groffer_style_main_backgrounds_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Main background color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => '#136450',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'groffer_style_main_backgrounds_color_hover',
                        'type'     => 'color',
                        'title'    => esc_html__('Main background color (hover)', 'groffer'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'groffer'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'groffer_style_semi_opacity_backgrounds',
                        'type'     => 'color_rgba',
                        'title'    => esc_html__( 'Semitransparent blocks background', 'groffer' ),
                        'default'  => array(
                            'color' => '#f02222',
                            'alpha' => '.95'
                        ),
                        'output' => array(
                            'background-color' => '.fixed-sidebar-menu',
                        ),
                        'mode'     => 'background'
                    ),
                    array(
                        'id'   => 'groffer_divider_text_selection',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Text Selection Color & Background</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_text_selection_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text selection color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'groffer'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'groffer_text_selection_background_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Text selection background color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => '#136450',
                        'validate' => 'color',
                    ),


                    array(
                        'id'   => 'groffer_divider_nav_menu',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Menus Styling</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_nav_menu_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Menu Text Color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #0F0F0F', 'groffer'),
                        'default'  => '#0F0F0F',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar .menu-item > a,
                                        .navbar-nav .search_products a,
                                        .navbar-default .navbar-nav > li > a,
                                        .header-v3 span.top-register,
                                        .header-v4 .header-top-contact-method a,
                                        .header-v4 .header-top-contact-method,
                                        .header-v7 .header-top-contact-method a,
                                        .header-v7 span.top-register,
                                        .header-v7 .header-top-contact-method',
                        )
                    ),
                    array(
                        'id'       => 'groffer_nav_menu_color_hover',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Menu Text Color on hover', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => '#136450',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar .menu-item > a:hover, 
                                        .navbar-nav .search_products a:hover, 
                                        .navbar-nav .search_products a:focus,
                                        .navbar-default .navbar-nav > li > a:hover, 
                                        .navbar-default .navbar-nav > li > a:focus',
                        )
                    ),
                    array(
                        'id'   => 'groffer_divider_nav_submenu',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Submenus Styling</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_nav_submenu_background',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Submenu Background Color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #FFF', 'groffer'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'output' => array(
                            'background-color' => '#navbar .sub-menu, .navbar ul li ul.sub-menu',
                        )
                    ),
                    array(
                        'id'       => 'groffer_nav_submenu_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Submenu Text Color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #000000', 'groffer'),
                        'default'  => '#000000',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar ul.sub-menu li a,.bot_nav_cat_wrap li a:hover',
                        )
                    ),
                    array(
                        'id'       => 'groffer_nav_submenu_hover_background_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Submenu Hover Background Color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #FFF', 'groffer'),
                        'default'  => '#ffffff',
                        'validate' => 'color',
                        'output' => array(
                            'background-color' => '#navbar ul.sub-menu li a:hover',
                        )
                    ),
                    array(
                        'id'       => 'groffer_nav_submenu_hover_text_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Nav Submenu Hover Background Color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => '#136450',
                        'validate' => 'color',
                        'output' => array(
                            'color' => '#navbar ul.sub-menu li a:hover',
                        )
                    ),
                )
            );
            // Fonts
            $this->sections[] = array(
                'icon' => 'el-icon-fontsize',
                'subsection' => true,
                'title' => __('Typography', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_styling_gfonts',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Import Google Fonts</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_google_fonts_select',
                        'type'     => 'select',
                        'multi'    => true,
                        'title'    => esc_attr__('Import Google Font Globally', 'groffer'), 
                        'subtitle' => esc_attr__('Select one or multiple fonts', 'groffer'),
                        'desc'     => esc_attr__('Importing fonts made easy', 'groffer'),
                        'options'  => $google_fonts_list,
                        'default'  => array(
                            'Space+Grotesk:200,300,regular,500,600,700,900,latin-ext,latin'
                        ),
                    ),
                    array(
                        'id'   => 'groffer_styling_fonts',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Set the main site font</h3>', 'groffer' )
                    ),
                    array(
                        'id'          => 'groffer-body-typography',
                        'type'        => 'typography', 
                        'title'       => __('Body Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => false,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => false,
                        'font-weight'  => false,
                        'font-size'   => false,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('body'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'groffer_divider_5',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Headings</h3>', 'groffer' )
                    ),
                    array(
                        'id'          => 'groffer_heading_h1',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H1 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h1', 'h1 span'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '55px', 
                            'line-height'  => '61px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'groffer_heading_h2',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H2 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h2'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '50px', 
                            'line-height'  => '55px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'groffer_heading_h3',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H3 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h3', '.post-name'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '38px', 
                            'line-height'  => '48px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'groffer_heading_h4',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H4 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h4'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '28px', 
                            'line-height'  => '34px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'groffer_heading_h5',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H5 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h5'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '22px', 
                            'line-height'  => '31px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'          => 'groffer_heading_h6',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Heading H6 Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => true,
                        'line-height'  => true,
                        'font-weight'  => false,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('h6'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk',  
                            'font-size' => '20px', 
                            'line-height'  => '20px',
                            'color' => '#242424', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'   => 'groffer_divider_6',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Inputs & Textareas Font family</h3>', 'groffer' )
                    ),
                    array(
                        'id'                => 'groffer_inputs_typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Inputs Font family', 'groffer'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => false,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'output'            => array('input', 'textarea'),
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for inputs and textareas', 'groffer'),
                        'default'           => array(
                            'font-family' => 'Space Grotesk',  
                            'google'            => true
                        ),
                    ),
                    array(
                        'id'   => 'groffer_divider_7',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Buttons Font family</h3>', 'groffer' )
                    ),
                    array(
                        'id'                => 'groffer_buttons_typography',
                        'type'              => 'typography', 
                        'title'             => esc_html__('Buttons Font family', 'groffer'),
                        'google'            => true, 
                        'font-backup'       => true,
                        'color'             => false,
                        'text-align'        => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'font-weight'       => false,
                        'font-size'         => false,
                        'font-style'        => false,
                        'subsets'           => false,
                        'output'            => array(
                            'input[type="submit"]'
                        ),
                        'units'             =>'px',
                        'subtitle'          => esc_html__('Font family for buttons', 'groffer'),
                        'default'           => array(
                            'font-family' => 'Space Grotesk',  
                            'google'            => true
                        ),
                    ),
                )
            );
            // Fonts (mobile)
            $this->sections[] = $responsive_headings;
            // Custom CSS
            $this->sections[] = array(
                'icon' => 'el-icon-css',
                'subsection' => true,
                'title' => __('Custom CSS', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_styling_custom_css',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Custom CSS</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_css_editor',
                        'type'     => 'ace_editor',
                        'title'    => __('CSS Code', 'groffer'),
                        'subtitle' => __('Paste your CSS code here.', 'groffer'),
                        'mode'     => 'css',
                        'theme'    => 'monokai',
                        'desc'     => 'Add your own custom styling (CSS rules only)',
                        'default'     => '#header{margin: 0 auto;}',
                    )
                )
            );



            # Section #2: Header Settings

            $this->sections[] = array(
                'icon' => 'el-icon-arrow-up',
                'title' => __('Header Settings', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_header_variant',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Header Variant</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'header_layout',
                        'type'     => 'select',
                        'compiler' => true,
                        'title'    => esc_html__( 'Select Header layout', 'groffer' ),
                        'options'   => array(
                            'first_header'   => 'Header #1'
                        ),
                        'default'  => 'first_header'
                    ),
                    array(
                        'id'   => 'mt_divider_first_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 1 Custom Background (Menu bar)', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'first_header' ),
                    ),
                    array(         
                        'id'       => 'nav_main_background',
                        'type'     => 'background',
                        'title'    => __('Navigation background', 'groffer'),
                        'subtitle' => __('Override the Navigation background with color.', 'groffer'),
                        'required' => array( 'header_layout', '=', 'first_header' ),
                        'output'      => array('.header-v1 .navbar.bottom-navbar-default')
                    ),
                    array(
                        'id'   => 'mt_divider_second_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 2 Custom Top & Bottom Header Background', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'second_header' ),
                    ),
                    array(
                        'id'       => 'mt_style_bottom_header2_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Main Header - background color', 'groffer'), 
                        'subtitle' => esc_html__('This color is only available when using Header 2', 'groffer'),
                        'default'  => '#F27928',
                        'required' => array( 'header_layout', '=', 'second_header' ),
                        'default'  => array(
                            'background-color' => '#F27928',
                        ),
                    ),

                    array(
                        'id'   => 'mt_divider_third_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 3 Custom Top & Bottom Header Background', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'third_header' ),
                    ),
                    array(
                        'id'       => 'mt_style_top_header3_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Main Header - background color', 'groffer'), 
                        'subtitle' => esc_html__('This color is only available when using Header 3', 'groffer'),
                        'default'  => '#1C1F26',
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default'  => array(
                            'background-color' => '#1C1F26',
                        ),
                    ),
                    array(
                        'id'       => 'mt_style_bottom_header3_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Color Links (not navigation)', 'groffer'), 
                        'subtitle' => esc_html__('This color is only available when using Header 3', 'groffer'),
                        'required' => array( 'header_layout', '=', 'third_header' ),
                        'default'  =>  '#ffffff',
                        'validate' => 'color'
                    ),
                    array(
                        'id'   => 'mt_divider_fourth_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 4', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'fourth_header' ),
                    ),
                    array(
                        'id'       => 'mt_disable_top_bar',
                        'type'     => 'switch', 
                        'title'    => __('Disable Top Bar Header 4', 'groffer'),
                        'subtitle' => __('Enable or disable the Top Bar Header', 'groffer'),
                        'required' => array( 'header_layout', '=', 'fourth_header' ),
                        'default'  => false,
                    ),
                    array(
                        'id' => 'groffer_first_header_button',
                        'type' => 'text',
                        'title' => __('Button Link', 'groffer'),
                        'subtitle' => __('Enter button link', 'groffer'),
                        'default' => '#',
                        'required' => array( 'header_layout', '=', 'first_header' ),
                    ),
                    array(
                        'id'       => 'groffer_fourth_header_button_bg',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Background', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#fff',
                        'validate' => 'background',
                        'required' => array( 'header_layout', '=', 'fourth_header' ),
                        'output' => array(
                            'background-color' => '#groffer-main-head .button-inquiry a',
                        )
                    ),
                    array(
                        'id'       => 'groffer_fourth_header_button_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Color', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#222222',
                        'validate' => 'color',
                        'required' => array( 'header_layout', '=', 'fourth_header' ),
                        'output' => array(
                            'color' => '#groffer-main-head .button-inquiry a,.header-v4 #groffer-main-head .button-inquiry a:hover',
                        )
                    ),
                    array(
                        'id'   => 'mt_divider_fifth_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 5 Custom Navigation Header Background', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'fifth_header' ),
                    ),
                    array(
                        'id'       => 'mt_style_top_header5_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Main Header - background color', 'groffer'), 
                        'subtitle' => esc_html__('This color is only available when using Header 5', 'groffer'),
                        'default'  => '#1C1F26',
                        'required' => array( 'header_layout', '=', 'fifth_header' ),
                        'default'  => array(
                            'background-color' => '#0c0c0c',
                        ),
                    ),
                    array(
                        'id'   => 'mt_divider_sixth_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 6 General Options', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'sixth_header' ),
                    ),
                    array(
                        'id' => 'groffer_sixth_header_button',
                        'type' => 'text',
                        'title' => __('Button Link', 'groffer'),
                        'subtitle' => __('Enter button link', 'groffer'),
                        'default' => '#',
                        'required' => array( 'header_layout', '=', 'sixth_header' ),
                    ),
                    array(
                        'id'       => 'groffer_sixth_header_button_bg',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Background', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#fff',
                        'validate' => 'background',
                        'required' => array( 'header_layout', '=', 'sixth_header' ),
                        'output' => array(
                            'background-color' => '#groffer-main-head .button-inquiry',
                        )
                    ),
                    array(
                        'id'       => 'groffer_sixth_header_button_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Color', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#222222',
                        'validate' => 'color',
                        'required' => array( 'header_layout', '=', 'sixth_header' ),
                        'output' => array(
                            'color' => '#groffer-main-head .button-inquiry a,.header-v6 #groffer-main-head .button-inquiry a:hover',
                        )
                    ),
                    array(
                        'id'   => 'mt_divider_seven_header',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => '<h3>'.esc_html__( 'Header 7', 'groffer' ).'</h3>',
                        'required' => array( 'header_layout', '=', 'seven_header' ),
                    ),
                    array(
                        'id'       => 'mt_disable_top_bar_seven',
                        'type'     => 'switch', 
                        'title'    => __('Disable Top Bar Header 7', 'groffer'),
                        'subtitle' => __('Enable or disable the Top Bar Header', 'groffer'),
                        'required' => array( 'header_layout', '=', 'seven_header' ),
                        'default'  => false,
                    ),
                    array(
                        'id' => 'groffer_seven_header_button',
                        'type' => 'text',
                        'title' => __('Button Link', 'groffer'),
                        'subtitle' => __('Enter button link', 'groffer'),
                        'default' => '#',
                        'required' => array( 'header_layout', '=', 'seven_header' ),
                    ),
                    array(
                        'id'       => 'groffer_seven_header_button_bg',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Background', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#fff',
                        'validate' => 'background',
                        'required' => array( 'header_layout', '=', 'seven_header' ),
                        'output' => array(
                            'background-color' => '#groffer-main-head .button-inquiry a',
                        )
                    ),
                    array(
                        'id'       => 'groffer_seven_header_button_color',
                        'type'     => 'color',
                        'title'    => esc_html__('Button Color', 'groffer'),
                        'subtitle' => __('Enter button color', 'groffer'), 
                        'default'  => '#222222',
                        'validate' => 'color',
                        'required' => array( 'header_layout', '=', 'seven_header' ),
                        'output' => array(
                            'color' => '#groffer-main-head .button-inquiry a,.header-v7 #groffer-main-head .button-inquiry a:hover',
                        )
                    ),
                    array(
                        'id'       => 'is_nav_sticky',
                        'type'     => 'switch', 
                        'title'    => __('Fixed Navigation menu?', 'groffer'),
                        'subtitle' => __('Enable or disable "fixed positioned navigation menu".', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id' => 'groffer_top_header_order_tracking_link',
                        'type' => 'text',
                        'title' => __('Order Traking Url', 'groffer'),
                        'subtitle' => __('A link to a page where the shortcode "[woocommerce_order_tracking]" is added. It will show the order tracking form.', 'groffer'),
                        'default' => ''
                    ),
                    array(
                        'id'       => 'groffer_header_category_menu',
                        'type'     => 'switch', 
                        'title'    => __('Category menu enabled?', 'groffer'),
                        'subtitle' => __('Enable or disable "category navigation menu".', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_header_language_switcher',
                        'type'     => 'switch', 
                        'title'    => __('Language Switcher Dropdown', 'groffer'),
                        'subtitle' => __('Enable or disable "Language Switcher Dropdown".', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'        => 'groffer_header_language_switcher_info',
                        'type'      => 'info',
                        'desc'      => esc_html__( 'Note: The language switcher will be only listed if WPML plugin is installed and properly configured (more than one language enabled on the site). If you are using other translation plugin or language switcher plugin, the active header template needs to be manually modified in order to add the switcher. (Available Hook for header top bar: "groffer_add_language_selector")', 'groffer' ),
                        'required' => array( 'groffer_header_language_switcher', '=', true ),
                    ),
                    array(
                        'id'       => 'groffer_header_currency_switcher',
                        'type'     => 'switch', 
                        'title'    => __('Right menu enabled?', 'groffer'),
                        'subtitle' => __('Enable or disable "Right navigation menu".', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_top',
                        'type'     => 'switch', 
                        'title'    => __('Icon Groups on Top Header (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Icon Group on Top Header.', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_top_search',
                        'type'     => 'switch', 
                        'title'    => __('Search Icon Groups on Top Header (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Search Icon Group on Top Header.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_top', '=', true ),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_top_cart',
                        'type'     => 'switch', 
                        'title'    => __('Cart Icon Groups on Top Header (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Cart Icon Group on Top Header.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_top', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_top_wishlist',
                        'type'     => 'switch', 
                        'title'    => __('Wishlist Icon Groups on Top Header (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Wishlist Icon Group on Top Header.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_top', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_footer',
                        'type'     => 'switch', 
                        'title'    => __('Icon Groups on Sticky Footer (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Icon Group on Sticky Footer.', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_footer_search',
                        'type'     => 'switch', 
                        'title'    => __('Search Icon Groups on Sticky Footer (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Search Icon Group on Sticky Footer.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_footer', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_footer_cart',
                        'type'     => 'switch', 
                        'title'    => __('Cart Icon Groups on Sticky Footer (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Cart Icon Group on Sticky Footer.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_footer', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_footer_wishlist',
                        'type'     => 'switch', 
                        'title'    => __('Wishlist Icon Groups on Sticky Footer (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Wishlist Icon Group on Sticky Footer.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_footer', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_header_mobile_switcher_footer_account',
                        'type'     => 'switch', 
                        'title'    => __('Account Icon Groups on Sticky Footer (Mobile only)', 'groffer'),
                        'subtitle' => __('Enable or disable the Account Icon Group on Sticky Footer.', 'groffer'),
                        'required' => array( 'groffer_header_mobile_switcher_footer', '=', true ),
                        'default'  => true,
                    ),
                    array(
                        'id'   => 'groffer_header_search_settings',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Search Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id'        => 'search_for',
                        'type'      => 'select',
                        'title'     => __('Search form for:', 'groffer'),
                        'subtitle'  => __('Select the scope of the header search form(Search for PRODUCTS or POSTS).', 'groffer'),
                        'options'   => array(
                                'products'   => 'Products',
                                'posts'   => 'Posts'
                            ),
                        'default'   => 'products',
                    ),
                    array(
                        'id'   => 'groffer_header_logo_settings',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Logo & Favicon Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id' => 'groffer_logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Logo as image', 'groffer'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/svg/Groffer-Logo.svg'),
                    ),
                    array(
                        'id'        => 'logo_max_width',
                        'type'      => 'slider',
                        'title'     => __('Logo Max Width', 'groffer'),
                        'subtitle'  => __('Use the slider to increase/decrease max size of the logo.', 'groffer'),
                        'desc'      => __('Min: 1px, max: 500px, step: 1px, default value: 140px', 'groffer'),
                        "default"   => 186,
                        "min"       => 1,
                        "step"      => 1,
                        "max"       => 500,
                        'display_value' => 'label'
                    ),
                    array(
                        'id' => 'groffer_favicon',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Favicon url', 'groffer'),
                        'compiler' => 'true',
                        'subtitle' => __('Use the upload button to import media.', 'groffer'),
                        'default' => array('url' => get_template_directory_uri().'/images/Favicon.png'),
                    ),
                    array(
                        'id'   => 'groffer_header_styling_settings',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Header Styling Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_category_background',
                        'type'     => 'color',
                        'title'    => esc_html__('Category 2 Background color', 'groffer'), 
                        'subtitle' => esc_html__('Default: #ffffff', 'groffer'),
                        'default'  => '#ffffff',
                        'validate' => 'background',
                        'output' => array(
                            'background-color' => '.bot_nav_cat .bot_nav_cat_wrap',
                        )
                    ),
                    array(         
                        'id'       => 'header_top_bar_background',
                        'type'     => 'background',
                        'title'    => __('Header (top small bar) - background', 'groffer'),
                        'subtitle' => __('Header background with image or color.', 'groffer'),
                        'output'      => array('.top-header'),
                        'default'  => array(
                            'background-color' => '#ffffff',
                        )
                    ),
                    array(         
                        'id'       => 'header_main_background',
                        'type'     => 'background',
                        'title'    => __('Header (main-header) - background', 'groffer'),
                        'subtitle' => __('Header background with image or color.', 'groffer'),
                        'output'      => array('.navbar-default,.top-navigation'),
                        'default'  => array(
                            'background-color' => '#ffffff',
                        )
                    ),
                    array(
                        'id'   => 'groffer_header_styling_settings',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Top Header Information Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_top_header_info_switcher',
                        'type'     => 'switch', 
                        'title'    => __('Header Discount Block', 'groffer'),
                        'subtitle' => __('Enable or disable the Header Discount Block.', 'groffer'),
                        'default'  => false,
                    ),
                    array(         
                        'id'       => 'discout_header_background',
                        'type'     => 'background',
                        'title'    => __('Header Discount Background', 'groffer'),
                        'subtitle' => __('Header background with image or color.', 'groffer'),
                        'output'      => array('.groffer-top-banner'),
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'default'  => array(
                            'background-color' => '#f5f5f5',
                        )
                    ),
                    array(
                        'id' => 'discout_header_text',
                        'type' => 'text',
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'title' => __('Header Discount Text', 'groffer'),
                        'default' => 'New Student Deal..'
                    ),
                    array(
                        'id' => 'discout_header_date',
                        'type' => 'date',
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'title' => __('Header Discount Expiration Date', 'groffer'),
                        'default' => '22/02/2022'
                    ),
                    array(
                        'id' => 'discout_header_btn_text',
                        'type' => 'text',
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'title' => __('Button Text', 'groffer'),
                        'default' => 'Join Now'
                    ),
                    array(
                        'id' => 'discout_header_btn_link',
                        'type' => 'text',
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'title' => __('Button Link', 'groffer'),
                        'default' => '#'
                    ),
                    array(
                        'id'       => 'discout_header_btn_color',
                        'type'     => 'color',
                        'required' => array( 'groffer_top_header_info_switcher', '=', true ),
                        'title'    => esc_html__('Button Background', 'groffer'), 
                        'default'  => '#136450',
                        'validate' => 'background',
                        'output' => array(
                            'background-color' => '.groffer-top-banner .button',
                        )
                    ),
                )
            );


            # General Settings
            $this->sections[] = array(
                'icon' => 'el-icon-arrow-down',
                'title' => __('Footer Settings', 'groffer'),
            );
            $this->sections[] = array(
                'icon' => 'el-icon-circle-arrow-up',
                'subsection' => true,
                'title' => __('Footer Top', 'groffer'),
                'fields' => array(
                    array(         
                        'id'       => 'footer_top_background',
                        'type'     => 'background',
                        'title'    => __('Footer (top) - background', 'groffer'),
                        'subtitle' => __('Footer background with image or color.', 'groffer'),
                        'output'      => array('footer,.widget_groffer_social_icons a'),
                        'default'  => array(
                            'background-color' => 'transparent',
                            'background-image' => 'https://groffer.modeltheme.com/wp-content/uploads/2023/01/Footer-BG.png'
                        )
                    ),
                    array(         
                        'id'       => 'footer_top_color_text',
                        'type'     => 'color',
                        'title'    => __('Footer (top) - color text', 'groffer'),
                        'subtitle' => __('Footer text color.', 'groffer'),
                        'default'  =>  '#0F0F0F',
                        'validate' => 'color'
                    ),
                    array(
                        'id'   => 'groffer_footer_row1',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Footer Widgets (Row #1)</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer-enable-footer-widgets',
                        'type'     => 'switch', 
                        'title'    => __('Status', 'groffer'),
                        'default'  => true,
                    ),
                    array(
                        'id'       => 'groffer_number_of_footer_columns',
                        'type'     => 'select',
                        'title'    => __('Footer Widgets Row #1 - Number of columns', 'groffer'), 
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6'
                        ),
                        'default'  => '4',
                        'required' => array('groffer-enable-footer-widgets','equals',true),
                    ),
                    array(
                        'id'             => 'footer_row_1_spacing',
                        'type'           => 'spacing',
                        'output'         => array('.container.footer-top, .prefooter .container'),
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Widgets Row #1 - Padding', 'groffer'),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '20px', 
                            'units'          => 'px', 
                        ),
                        'required' => array('groffer-enable-footer-widgets','equals',true),
                    ),
                    array(
                        'id'   => 'groffer_footer_row2',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Footer Widgets (Row #2)</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer-enable-footer-widgets-row2',
                        'type'     => 'switch', 
                        'title'    => __('Status', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_number_of_footer_columns_row2',
                        'type'     => 'select',
                        'title'    => __('Footer Widgets Row #2 - Number of columns', 'groffer'), 
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6'
                        ),
                        'default'  => '5',
                        'required' => array('groffer-enable-footer-widgets-row2','equals',true),
                    ),
                    array(
                        'id'             => 'footer_row_2_spacing',
                        'type'           => 'spacing',
                        'output'         => array('.footer-top .footer-row-2'),
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Widgets Row #2 - Padding', 'groffer'),
                        'default'            => array(
                            'padding-top'     => '60px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        ),
                        'required' => array('groffer-enable-footer-widgets-row2','equals',true),
                    ),

                    array(
                        'id'   => 'groffer_footer_row3',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Footer Widgets (Row #3)</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer-enable-footer-widgets-row3',
                        'type'     => 'switch', 
                        'title'    => __('Status', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer_number_of_footer_columns_row3',
                        'type'     => 'select',
                        'title'    => __('Footer Widgets Row #3 - Number of columns', 'groffer'), 
                        'options'  => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                            '6' => '6'
                        ),
                        'default'  => '4',
                        'required' => array('groffer-enable-footer-widgets-row3','equals',true),
                    ),
                    array(
                        'id'             => 'footer_row_3_spacing',
                        'type'           => 'spacing',
                        'output'         => array('.footer-top .footer-row-3'),
                        'mode'           => 'padding',
                        'units'          => array('px'),
                        'units_extended' => 'false',
                        'title'          => esc_html__('Footer Widgets Row #3 - Padding', 'groffer'),
                        'default'            => array(
                            'padding-top'     => '0px', 
                            'padding-bottom'  => '0px', 
                            'units'          => 'px', 
                        ),
                        'required' => array('groffer-enable-footer-widgets-row3','equals',true),
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-circle-arrow-down',
                'subsection' => true,
                'title' => __('Footer Bottom (Copyright)', 'groffer'),
                'fields' => array(
                    array(
                        'id' => 'groffer_footer_text_left',
                        'type' => 'editor',
                        'title' => __('Footer Text Left', 'groffer'),
                        'default' => 'Copyright by ModelTheme. All Rights Reserved.',
                    ),
                    array(
                        'id' => 'groffer_card_icons1',
                        'type' => 'background',
                        'title' => __('Footer card icons', 'groffer'),
                        'compiler' => 'true',
                        'background-color' => 'false',
                        'background-repeat' => 'false',
                        'background-size' => 'false',
                        'background-attachment' => 'false',
                        'background-position' => 'false',
                        'output'      => array('.card-icons1'),
                        'default' => '',
                    ),
                    array(         
                        'id'       => 'footer_bottom_background',
                        'type'     => 'background',
                        'title'    => __('Footer (bottom) - background', 'groffer'),
                        'subtitle' => __('Footer background with image or color.', 'groffer'),
                        'output'      => array('footer .footer'),
                        'default'  => array(
                            'background-color' => 'transparent',
                        )
                    ),
                    array(         
                        'id'       => 'footer_bottom_color_text',
                        'type'     => 'color',
                        'title'    => __('Footer (bottom) - texts color', 'groffer'),
                        'subtitle' => __('Footer text color.', 'groffer'),
                        'default'  =>  '#0F0F0F',
                        'validate' => 'color'
                    ),
                    array(         
                        'id'       => 'footer_bottom_color_links',
                        'type'     => 'color',
                        'title'    => __('Footer (bottom) - links color', 'groffer'),
                        'subtitle' => __('Footer links color.', 'groffer'),
                        'default'  =>  '#484848',
                        'validate' => 'color'
                    ),
                    array(         
                        'id'       => 'footer_bottom_color_icons',
                        'type'     => 'color',
                        'title'    => __('Footer (bottom) - icons color', 'groffer'),
                        'subtitle' => __('Footer icons.', 'groffer'),
                        'default'  =>  '#136450',
                        'validate' => 'color'
                    ),

                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-caret-up',
                'subsection' => true,
                'title' => __('Back to Top', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_back_to_top',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Back to Top Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_backtotop_status',
                        'type'     => 'switch', 
                        'title'    => esc_html__('Back to Top Button Status', 'groffer'),
                        'subtitle' => esc_html__('Enable or disable "Back to Top Button"', 'groffer'),
                        'default'  => true,
                    ),
                    array(         
                        'id'       => 'groffer_backtotop_bg_color',
                        'type'     => 'background',
                        'title'    => esc_html__('Back to Top Button Status Backgrond', 'groffer'), 
                        'subtitle' => esc_html__('Default: #136450', 'groffer'),
                        'default'  => array(
                            'background-color' => '#136450',
                            'background-repeat' => 'no-repeat',
                            'background-position' => 'center center',
                            'background-image' => get_template_directory_uri().'/images/mt-to-top-arrow.svg',
                        )
                    ),

                )
            );


            # Section #4: Contact Settings

            $this->sections[] = array(
                'icon' => 'el-icon-map-marker-alt',
                'title' => __('Contact Settings', 'groffer'),
                'fields' => array(
                    array(
                        'id' => 'groffer_contact_phone',
                        'type' => 'text',
                        'title' => __('Phone Number', 'groffer'),
                        'subtitle' => __('Contact phone number displayed on the contact us page.', 'groffer'),
                        'validate_callback' => 'redux_validate_callback_function',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_contact_email',
                        'type' => 'text',
                        'title' => __('Email', 'groffer'),
                        'subtitle' => __('Contact email displayed on the contact us page., additional info is good in here.', 'groffer'),
                        'validate' => 'email',
                        'msg' => 'custom error message',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_work_program',
                        'type' => 'text',
                        'title' => __('Program', 'groffer'),
                        'subtitle' => __('Enter your work program', 'groffer'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_contact_address',
                        'type' => 'text',
                        'title' => __('Address', 'groffer'),
                        'subtitle' => __('Enter your contact address', 'groffer'),
                        'default' => ''
                    ),
                )
            );

            # Section: Popup Settings
            $this->sections[] = array(
                'icon' => 'fa fa-angle-double-up',
                'title' => __('Popup Settings', 'groffer'),
                'fields' => array(
                    array(
                        'id'       => 'groffer-enable-popup',
                        'type'     => 'switch', 
                        'title'    => __('Popup', 'groffer'),
                        'subtitle' => __('Enable or disable popup', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'   => 'groffer_popup_design',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Popup Design</h3>', 'groffer' )
                    ),
                    array(
                        'id' => 'groffer-enable-popup-img',
                        'type' => 'media',
                        'url' => true,
                        'title'    => __('Popup Image', 'groffer'),
                        'subtitle' => __('Set your popup image', 'groffer'),
                        'compiler' => 'true'
                    ),
                    array(
                        'id' => 'groffer-enable-popup-company',
                        'type' => 'media',
                        'url' => true,
                        'title'    => __('Your Company Logo', 'groffer'),
                        'subtitle' => __('Set your company logo', 'groffer'),
                        'compiler' => 'true',
                        'default' => array('url' => get_template_directory_uri().'/images/svg/Groffer-Logo.svg')
                    ),
                    array(
                        'id' => 'groffer-enable-popup-desc',
                        'type' => 'text',
                        'title' => __('Subtitle Description', 'groffer'),
                        'subtitle' => __('Write a few words as description', 'groffer'),
                        'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sit amet sagittis sem, at sollicitudin lectus.'
                    ),
                    array(
                        'id' => 'groffer-enable-popup-form',
                        'type' => 'editor',
                        'title' => __('Custom Form Shortcode', 'groffer'),
                        'subtitle' => __('Write a few words as description', 'groffer'),
                         'args'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 10
                        )
                    ),
                    array(
                        'id'       => 'groffer-enable-popup-additional',
                        'type'     => 'switch', 
                        'title'    => __('Disable Login message?', 'groffer'),
                        'subtitle' => __('Enable or disable Login message.', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'   => 'groffer_popup_settings',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Popup Settings</h3>', 'groffer' )
                    ),
                    array(
                        'id'        => 'groffer-enable-popup-expire-date',
                        'type'      => 'select',
                        'title'     => __('Expiring Cookie', 'groffer'),
                        'subtitle'  => __('Select the days for when the cookies to expire.', 'groffer'),
                        'options'   => array(
                                '1'    => 'One day',
                                '3'    => 'Three days',
                                '7'    => 'Seven days',
                                '30'   => 'One Month',
                                '3000' => 'Be Remembered'
                            ),
                        'default'   => '1',
                    ),
                    array(
                        'id'        => 'groffer-enable-popup-show-time',
                        'type'      => 'select',
                        'title'     => __('Show Popup', 'groffer'),
                        'subtitle'  => __('Select a specific time to show the popup.', 'groffer'),
                        'options'   => array(
                                '5000'     => '5 seconds',
                                '10000'    => '10 seconds',
                                '20000'    => '20 seconds'
                            ),
                        'default'   => '5000',
                    ),
                )
            );

            # Section #6: Blog Settings

            $icons = array(
            'fa fa-angellist'      => 'fa fa-angellist',
            'fa fa-area-chart'     => 'fa fa-area-chart',
            'fa fa-at'             => 'fa fa-at',
            'fa fa-bell-slash'     => 'fa fa-bell-slash',
            'fa fa-bell-slash-o'   => 'fa fa-bell-slash-o',
            'fa fa-bicycle'        => 'fa fa-bicycle',
            'fa fa-binoculars'     => 'fa fa-binoculars',
            'fa fa-birthday-cake'  => 'fa fa-birthday-cake',
            'fa fa-bus'            => 'fa fa-bus',
            'fa fa-calculator'     => 'fa fa-calculator',
            'fa fa-cc'             => 'fa fa-cc',
            'fa fa-cc-amex'        => 'fa fa-cc-amex',
            'fa fa-cc-discover'    => 'fa fa-cc-discover',
            'fa fa-cc-mastercard'  => 'fa fa-cc-mastercard',
            'fa fa-cc-paypal'      => 'fa fa-cc-paypal',
            'fa fa-cc-stripe'      => 'fa fa-cc-stripe',
            'fa fa-cc-visa'        => 'fa fa-cc-visa',
            'fa fa-copyright'      => 'fa fa-copyright',
            'fa fa-eyedropper'     => 'fa fa-eyedropper',
            'fa fa-futbol-o'       => 'fa fa-futbol-o',
            'fa fa-google-wallet'  => 'fa fa-google-wallet',
            'fa fa-ils'            => 'fa fa-ils',
            'fa fa-ioxhost'        => 'fa fa-ioxhost',
            'fa fa-lastfm'         => 'fa fa-lastfm',
            'fa fa-lastfm-square' => 'fa fa-lastfm-square',
            'fa fa-line-chart' => 'fa fa-line-chart',
            'fa fa-meanpath' => 'fa fa-meanpath',
            'fa fa-newspaper-o' => 'fa fa-newspaper-o',
            'fa fa-paint-brush' => 'fa fa-paint-brush',
            'fa fa-paypal' => 'fa fa-paypal',
            'fa fa-pie-chart' => 'fa fa-pie-chart',
            'fa fa-plug' => 'fa fa-plug',
            'fa fa-shekel' => 'fa fa-shekel',
            'fa fa-sheqel' => 'fa fa-sheqel',
            'fa fa-slideshare' => 'fa fa-slideshare',
            'fa fa-soccer-ball-o' => 'fa fa-soccer-ball-o',
            'fa fa-toggle-off' => 'fa fa-toggle-off',
            'fa fa-toggle-on' => 'fa fa-toggle-on',
            'fa fa-trash' => 'fa fa-trash',
            'fa fa-tty' => 'fa fa-tty',
            'fa fa-twitch' => 'fa fa-twitch',
            'fa fa-wifi' => 'fa fa-wifi',
            'fa fa-yelp' => 'fa fa-yelp',
            'fa fa-adjust' => 'fa fa-adjust',
            'fa fa-anchor' => 'fa fa-anchor',
            'fa fa-archive' => 'fa fa-archive',
            'fa fa-arrows' => 'fa fa-arrows',
            'fa fa-arrows-h' => 'fa fa-arrows-h',
            'fa fa-arrows-v' => 'fa fa-arrows-v',
            'fa fa-asterisk' => 'fa fa-asterisk',
            'fa fa-automobile' => 'fa fa-automobile',
            'fa fa-ban' => 'fa fa-ban',
            'fa fa-bank' => 'fa fa-bank',
            'fa fa-bar-chart' => 'fa fa-bar-chart',
            'fa fa-bar-chart-o' => 'fa fa-bar-chart-o',
            'fa fa-barcode' => 'fa fa-barcode',
            'fa fa-bars' => 'fa fa-bars',
            'fa fa-beer' => 'fa fa-beer',
            'fa fa-bell' => 'fa fa-bell',
            'fa fa-bell-o' => 'fa fa-bell-o',
            'fa fa-bolt' => 'fa fa-bolt',
            'fa fa-bomb' => 'fa fa-bomb',
            'fa fa-book' => 'fa fa-book',
            'fa fa-bookmark' => 'fa fa-bookmark',
            'fa fa-bookmark-o' => 'fa fa-bookmark-o',
            'fa fa-briefcase' => 'fa fa-briefcase',
            'fa fa-bug' => 'fa fa-bug',
            'fa fa-building' => 'fa fa-building',
            'fa fa-building-o' => 'fa fa-building-o',
            'fa fa-bullhorn' => 'fa fa-bullhorn',
            'fa fa-bullseye' => 'fa fa-bullseye',
            'fa fa-cab' => 'fa fa-cab',
            'fa fa-calendar' => 'fa fa-calendar',
            'fa fa-calendar-o' => 'fa fa-calendar-o',
            'fa fa-camera' => 'fa fa-camera',
            'fa fa-camera-retro' => 'fa fa-camera-retro',
            'fa fa-car' => 'fa fa-car',
            'fa fa-caret-square-o-down' => 'fa fa-caret-square-o-down',
            'fa fa-caret-square-o-left' => 'fa fa-caret-square-o-left',
            'fa fa-caret-square-o-right' => 'fa fa-caret-square-o-right',
            'fa fa-caret-square-o-up' => 'fa fa-caret-square-o-up',
            'fa fa-certificate' => 'fa fa-certificate',
            'fa fa-check' => 'fa fa-check',
            'fa fa-check-circle' => 'fa fa-check-circle',
            'fa fa-check-circle-o' => 'fa fa-check-circle-o',
            'fa fa-check-square' => 'fa fa-check-square',
            'fa fa-check-square-o' => 'fa fa-check-square-o',
            'fa fa-child' => 'fa fa-child',
            'fa fa-circle' => 'fa fa-circle',
            'fa fa-circle-o' => 'fa fa-circle-o',
            'fa fa-circle-o-notch' => 'fa fa-circle-o-notch',
            'fa fa-circle-thin' => 'fa fa-circle-thin',
            'fa fa-clock-o' => 'fa fa-clock-o',
            'fa fa-close' => 'fa fa-close',
            'fa fa-cloud' => 'fa fa-cloud',
            'fa fa-cloud-download' => 'fa fa-cloud-download',
            'fa fa-cloud-upload' => 'fa fa-cloud-upload',
            'fa fa-code' => 'fa fa-code',
            'fa fa-code-fork' => 'fa fa-code-fork',
            'fa fa-coffee' => 'fa fa-coffee',
            'fa fa-cog' => 'fa fa-cog',
            'fa fa-cogs' => 'fa fa-cogs',
            'fa fa-comment' => 'fa fa-comment',
            'fa fa-comment-o' => 'fa fa-comment-o',
            'fa fa-comments' => 'fa fa-comments',
            'fa fa-comments-o' => 'fa fa-comments-o',
            'fa fa-compass' => 'fa fa-compass',
            'fa fa-credit-card' => 'fa fa-credit-card',
            'fa fa-crop' => 'fa fa-crop',
            'fa fa-crosshairs' => 'fa fa-crosshairs',
            'fa fa-cube' => 'fa fa-cube',
            'fa fa-cubes' => 'fa fa-cubes',
            'fa fa-cutlery' => 'fa fa-cutlery',
            'fa fa-dashboard' => 'fa fa-dashboard',
            'fa fa-database' => 'fa fa-database',
            'fa fa-desktop' => 'fa fa-desktop',
            'fa fa-dot-circle-o' => 'fa fa-dot-circle-o',
            'fa fa-download' => 'fa fa-download',
            'fa fa-edit' => 'fa fa-edit',
            'fa fa-ellipsis-h' => 'fa fa-ellipsis-h',
            'fa fa-ellipsis-v' => 'fa fa-ellipsis-v',
            'fa fa-envelope' => 'fa fa-envelope',
            'fa fa-envelope-o' => 'fa fa-envelope-o',
            'fa fa-envelope-square' => 'fa fa-envelope-square',
            'fa fa-eraser' => 'fa fa-eraser',
            'fa fa-exchange' => 'fa fa-exchange',
            'fa fa-exclamation' => 'fa fa-exclamation',
            'fa fa-exclamation-circle' => 'fa fa-exclamation-circle',
            'fa fa-exclamation-triangle' => 'fa fa-exclamation-triangle',
            'fa fa-external-link' => 'fa fa-external-link',
            'fa fa-external-link-square' => 'fa fa-external-link-square',
            'fa fa-eye' => 'fa fa-eye',
            'fa fa-eye-slash' => 'fa fa-eye-slash',
            'fa fa-fax' => 'fa fa-fax',
            'fa fa-female' => 'fa fa-female',
            'fa fa-fighter-jet' => 'fa fa-fighter-jet',
            'fa fa-file-archive-o' => 'fa fa-file-archive-o',
            'fa fa-file-audio-o' => 'fa fa-file-audio-o',
            'fa fa-file-code-o' => 'fa fa-file-code-o',
            'fa fa-file-excel-o' => 'fa fa-file-excel-o',
            'fa fa-file-image-o' => 'fa fa-file-image-o',
            'fa fa-file-movie-o' => 'fa fa-file-movie-o',
            'fa fa-file-pdf-o' => 'fa fa-file-pdf-o',
            'fa fa-file-photo-o' => 'fa fa-file-photo-o',
            'fa fa-file-picture-o' => 'fa fa-file-picture-o',
            'fa fa-file-powerpoint-o' => 'fa fa-file-powerpoint-o',
            'fa fa-file-sound-o' => 'fa fa-file-sound-o',
            'fa fa-file-video-o' => 'fa fa-file-video-o',
            'fa fa-file-word-o' => 'fa fa-file-word-o',
            'fa fa-file-zip-o' => 'fa fa-file-zip-o',
            'fa fa-film' => 'fa fa-film',
            'fa fa-filter' => 'fa fa-filter',
            'fa fa-fire' => 'fa fa-fire',
            'fa fa-fire-extinguisher' => 'fa fa-fire-extinguisher',
            'fa fa-flag' => 'fa fa-flag',
            'fa fa-flag-checkered' => 'fa fa-flag-checkered',
            'fa fa-flag-o' => 'fa fa-flag-o',
            'fa fa-flash' => 'fa fa-flash',
            'fa fa-flask' => 'fa fa-flask',
            'fa fa-folder' => 'fa fa-folder',
            'fa fa-folder-o' => 'fa fa-folder-o',
            'fa fa-folder-open' => 'fa fa-folder-open',
            'fa fa-folder-open-o' => 'fa fa-folder-open-o',
            'fa fa-frown-o' => 'fa fa-frown-o',
            'fa fa-gamepad' => 'fa fa-gamepad',
            'fa fa-gavel' => 'fa fa-gavel',
            'fa fa-gear' => 'fa fa-gear',
            'fa fa-gears' => 'fa fa-gears',
            'fa fa-gift' => 'fa fa-gift',
            'fa fa-glass' => 'fa fa-glass',
            'fa fa-globe' => 'fa fa-globe',
            'fa fa-graduation-cap' => 'fa fa-graduation-cap',
            'fa fa-group' => 'fa fa-group',
            'fa fa-hdd-o' => 'fa fa-hdd-o',
            'fa fa-headphones' => 'fa fa-headphones',
            'fa fa-heart' => 'fa fa-heart',
            'fa fa-heart-o' => 'fa fa-heart-o',
            'fa fa-history' => 'fa fa-history',
            'fa fa-home' => 'fa fa-home',
            'fa fa-image' => 'fa fa-image',
            'fa fa-inbox' => 'fa fa-inbox',
            'fa fa-info' => 'fa fa-info',
            'fa fa-info-circle' => 'fa fa-info-circle',
            'fa fa-institution' => 'fa fa-institution',
            'fa fa-key' => 'fa fa-key',
            'fa fa-keyboard-o' => 'fa fa-keyboard-o',
            'fa fa-language' => 'fa fa-language',
            'fa fa-laptop' => 'fa fa-laptop',
            'fa fa-leaf' => 'fa fa-leaf',
            'fa fa-legal' => 'fa fa-legal',
            'fa fa-lemon-o' => 'fa fa-lemon-o',
            'fa fa-level-down' => 'fa fa-level-down',
            'fa fa-level-up' => 'fa fa-level-up',
            'fa fa-life-bouy' => 'fa fa-life-bouy',
            'fa fa-life-buoy' => 'fa fa-life-buoy',
            'fa fa-life-ring' => 'fa fa-life-ring',
            'fa fa-life-saver' => 'fa fa-life-saver',
            'fa fa-lightbulb-o' => 'fa fa-lightbulb-o',
            'fa fa-location-arrow' => 'fa fa-location-arrow',
            'fa fa-lock' => 'fa fa-lock',
            'fa fa-magic' => 'fa fa-magic',
            'fa fa-magnet' => 'fa fa-magnet',
            'fa fa-mail-forward' => 'fa fa-mail-forward',
            'fa fa-mail-reply' => 'fa fa-mail-reply',
            'fa fa-mail-reply-all' => 'fa fa-mail-reply-all',
            'fa fa-male' => 'fa fa-male',
            'fa fa-map-marker' => 'fa fa-map-marker',
            'fa fa-meh-o' => 'fa fa-meh-o',
            'fa fa-microphone' => 'fa fa-microphone',
            'fa fa-microphone-slash' => 'fa fa-microphone-slash',
            'fa fa-minus' => 'fa fa-minus',
            'fa fa-minus-circle' => 'fa fa-minus-circle',
            'fa fa-minus-square' => 'fa fa-minus-square',
            'fa fa-minus-square-o' => 'fa fa-minus-square-o',
            'fa fa-mobile' => 'fa fa-mobile',
            'fa fa-mobile-phone' => 'fa fa-mobile-phone',
            'fa fa-money' => 'fa fa-money',
            'fa fa-moon-o' => 'fa fa-moon-o',
            'fa fa-mortar-board' => 'fa fa-mortar-board',
            'fa fa-music' => 'fa fa-music',
            'fa fa-navicon' => 'fa fa-navicon',
            'fa fa-paper-plane' => 'fa fa-paper-plane',
            'fa fa-paper-plane-o' => 'fa fa-paper-plane-o',
            'fa fa-paw' => 'fa fa-paw',
            'fa fa-pencil' => 'fa fa-pencil',
            'fa fa-pencil-square' => 'fa fa-pencil-square',
            'fa fa-pencil-square-o' => 'fa fa-pencil-square-o',
            'fa fa-phone' => 'fa fa-phone',
            'fa fa-phone-square' => 'fa fa-phone-square',
            'fa fa-photo' => 'fa fa-photo',
            'fa fa-picture-o' => 'fa fa-picture-o',
            'fa fa-plane' => 'fa fa-plane',
            'fa fa-plus' => 'fa fa-plus',
            'fa fa-plus-circle' => 'fa fa-plus-circle',
            'fa fa-plus-square' => 'fa fa-plus-square',
            'fa fa-plus-square-o' => 'fa fa-plus-square-o',
            'fa fa-power-off' => 'fa fa-power-off',
            'fa fa-print' => 'fa fa-print',
            'fa fa-puzzle-piece' => 'fa fa-puzzle-piece',
            'fa fa-qrcode' => 'fa fa-qrcode',
            'fa fa-question' => 'fa fa-question',
            'fa fa-question-circle' => 'fa fa-question-circle',
            'fa fa-quote-left' => 'fa fa-quote-left',
            'fa fa-quote-right' => 'fa fa-quote-right',
            'fa fa-random' => 'fa fa-random',
            'fa fa-recycle' => 'fa fa-recycle',
            'fa fa-refresh' => 'fa fa-refresh',
            'fa fa-remove' => 'fa fa-remove',
            'fa fa-reorder' => 'fa fa-reorder',
            'fa fa-reply' => 'fa fa-reply',
            'fa fa-reply-all' => 'fa fa-reply-all',
            'fa fa-retweet' => 'fa fa-retweet',
            'fa fa-road' => 'fa fa-road',
            'fa fa-rocket' => 'fa fa-rocket',
            'fa fa-rss' => 'fa fa-rss',
            'fa fa-rss-square' => 'fa fa-rss-square',
            'fa fa-search' => 'fa fa-search',
            'fa fa-search-minus' => 'fa fa-search-minus',
            'fa fa-search-plus' => 'fa fa-search-plus',
            'fa fa-send' => 'fa fa-send',
            'fa fa-send-o' => 'fa fa-send-o',
            'fa fa-share' => 'fa fa-share',
            'fa fa-share-alt' => 'fa fa-share-alt',
            'fa fa-share-alt-square' => 'fa fa-share-alt-square',
            'fa fa-share-square' => 'fa fa-share-square',
            'fa fa-share-square-o' => 'fa fa-share-square-o',
            'fa fa-shield' => 'fa fa-shield',
            'fa fa-shopping-cart' => 'fa fa-shopping-cart',
            'fa fa-sign-in' => 'fa fa-sign-in',
            'fa fa-sign-out' => 'fa fa-sign-out',
            'fa fa-signal' => 'fa fa-signal',
            'fa fa-sitemap' => 'fa fa-sitemap',
            'fa fa-sliders' => 'fa fa-sliders',
            'fa fa-smile-o' => 'fa fa-smile-o',
            'fa fa-sort' => 'fa fa-sort',
            'fa fa-sort-alpha-asc' => 'fa fa-sort-alpha-asc',
            'fa fa-sort-alpha-desc' => 'fa fa-sort-alpha-desc',
            'fa fa-sort-amount-asc' => 'fa fa-sort-amount-asc',
            'fa fa-sort-amount-desc' => 'fa fa-sort-amount-desc',
            'fa fa-sort-asc' => 'fa fa-sort-asc',
            'fa fa-sort-desc' => 'fa fa-sort-desc',
            'fa fa-sort-down' => 'fa fa-sort-down',
            'fa fa-sort-numeric-asc' => 'fa fa-sort-numeric-asc',
            'fa fa-sort-numeric-desc' => 'fa fa-sort-numeric-desc',
            'fa fa-sort-up' => 'fa fa-sort-up',
            'fa fa-space-shuttle' => 'fa fa-space-shuttle',
            'fa fa-spinner' => 'fa fa-spinner',
            'fa fa-spoon' => 'fa fa-spoon',
            'fa fa-square' => 'fa fa-square',
            'fa fa-square-o' => 'fa fa-square-o',
            'fa fa-star' => 'fa fa-star',
            'fa fa-star-half' => 'fa fa-star-half',
            'fa fa-star-half-empty' => 'fa fa-star-half-empty',
            'fa fa-star-half-full' => 'fa fa-star-half-full',
            'fa fa-star-half-o' => 'fa fa-star-half-o',
            'fa fa-star-o' => 'fa fa-star-o',
            'fa fa-suitcase' => 'fa fa-suitcase',
            'fa fa-sun-o' => 'fa fa-sun-o',
            'fa fa-support' => 'fa fa-support',
            'fa fa-tablet' => 'fa fa-tablet',
            'fa fa-tachometer' => 'fa fa-tachometer',
            'fa fa-tag' => 'fa fa-tag',
            'fa fa-tags' => 'fa fa-tags',
            'fa fa-tasks' => 'fa fa-tasks',
            'fa fa-taxi' => 'fa fa-taxi',
            'fa fa-terminal' => 'fa fa-terminal',
            'fa fa-thumb-tack' => 'fa fa-thumb-tack',
            'fa fa-thumbs-down' => 'fa fa-thumbs-down',
            'fa fa-thumbs-o-down' => 'fa fa-thumbs-o-down',
            'fa fa-thumbs-o-up' => 'fa fa-thumbs-o-up',
            'fa fa-thumbs-up' => 'fa fa-thumbs-up',
            'fa fa-ticket' => 'fa fa-ticket',
            'fa fa-times' => 'fa fa-times',
            'fa fa-times-circle' => 'fa fa-times-circle',
            'fa fa-times-circle-o' => 'fa fa-times-circle-o',
            'fa fa-tint' => 'fa fa-tint',
            'fa fa-toggle-down' => 'fa fa-toggle-down',
            'fa fa-toggle-left' => 'fa fa-toggle-left',
            'fa fa-toggle-right' => 'fa fa-toggle-right',
            'fa fa-toggle-up' => 'fa fa-toggle-up',
            'fa fa-trash-o' => 'fa fa-trash-o',
            'fa fa-tree' => 'fa fa-tree',
            'fa fa-trophy' => 'fa fa-trophy',
            'fa fa-truck' => 'fa fa-truck',
            'fa fa-umbrella' => 'fa fa-umbrella',
            'fa fa-university' => 'fa fa-university',
            'fa fa-unlock' => 'fa fa-unlock',
            'fa fa-unlock-alt' => 'fa fa-unlock-alt',
            'fa fa-unsorted' => 'fa fa-unsorted',
            'fa fa-upload' => 'fa fa-upload',
            'fa fa-user' => 'fa fa-user',
            'fa fa-users' => 'fa fa-users',
            'fa fa-video-camera' => 'fa fa-video-camera',
            'fa fa-volume-down' => 'fa fa-volume-down',
            'fa fa-volume-off' => 'fa fa-volume-off',
            'fa fa-volume-up' => 'fa fa-volume-up',
            'fa fa-warning' => 'fa fa-warning',
            'fa fa-wheelchair' => 'fa fa-wheelchair',
            'fa fa-wrench' => 'fa fa-wrench',
            'fa fa-file' => 'fa fa-file',
            'fa fa-file-o' => 'fa fa-file-o',
            'fa fa-file-text' => 'fa fa-file-text',
            'fa fa-file-text-o' => 'fa fa-file-text-o',
            'fa fa-bitcoin' => 'fa fa-bitcoin',
            'fa fa-btc' => 'fa fa-btc',
            'fa fa-cny' => 'fa fa-cny',
            'fa fa-dollar' => 'fa fa-dollar',
            'fa fa-eur' => 'fa fa-eur',
            'fa fa-euro' => 'fa fa-euro',
            'fa fa-gbp' => 'fa fa-gbp',
            'fa fa-inr' => 'fa fa-inr',
            'fa fa-jpy' => 'fa fa-jpy',
            'fa fa-krw' => 'fa fa-krw',
            'fa fa-rmb' => 'fa fa-rmb',
            'fa fa-rouble' => 'fa fa-rouble',
            'fa fa-rub' => 'fa fa-rub',
            'fa fa-ruble' => 'fa fa-ruble',
            'fa fa-rupee' => 'fa fa-rupee',
            'fa fa-try' => 'fa fa-try',
            'fa fa-turkish-lira' => 'fa fa-turkish-lira',
            'fa fa-usd' => 'fa fa-usd',
            'fa fa-won' => 'fa fa-won',
            'fa fa-yen' => 'fa fa-yen',
            'fa fa-align-center' => ' fa fa-align-center',
            'fa fa-align-justify' => 'fa fa-align-justify',
            'fa fa-align-left' => 'fa fa-align-left',
            'fa fa-align-right' => 'fa fa-align-right',
            'fa fa-bold' => 'fa fa-bold',
            'fa fa-chain' => 'fa fa-chain',
            'fa fa-chain-broken' => 'fa fa-chain-broken',
            'fa fa-clipboard' => 'fa fa-clipboard',
            'fa fa-columns' => 'fa fa-columns',
            'fa fa-copy' => 'fa fa-copy',
            'fa fa-cut' => 'fa fa-cut',
            'fa fa-dedent' => 'fa fa-dedent',
            'fa fa-files-o' => 'fa fa-files-o',
            'fa fa-floppy-o' => 'fa fa-floppy-o',
            'fa fa-font' => 'fa fa-font',
            'fa fa-header' => 'fa fa-header',
            'fa fa-indent' => 'fa fa-indent',
            'fa fa-italic' => 'fa fa-italic',
            'fa fa-link' => 'fa fa-link',
            'fa fa-list' => 'fa fa-list',
            'fa fa-list-alt' => 'fa fa-list-alt',
            'fa fa-list-ol' => 'fa fa-list-ol',
            'fa fa-list-ul' => 'fa fa-list-ul',
            'fa fa-outdent' => 'fa fa-outdent',
            'fa fa-paperclip' => 'fa fa-paperclip',
            'fa fa-paragraph' => 'fa fa-paragraph',
            'fa fa-paste' => 'fa fa-paste',
            'fa fa-repeat' => 'fa fa-repeat',
            'fa fa-rotate-left' => 'fa fa-rotate-left',
            'fa fa-rotate-right' => 'fa fa-rotate-right',
            'fa fa-save' => 'fa fa-save',
            'fa fa-scissors' => 'fa fa-scissors',
            'fa fa-strikethrough' => 'fa fa-strikethrough',
            'fa fa-subscript' => 'fa fa-subscript',
            'fa fa-superscript' => 'fa fa-superscript',
            'fa fa-table' => 'fa fa-table',
            'fa fa-text-height' => 'fa fa-text-height',
            'fa fa-text-width' => 'fa fa-text-width',
            'fa fa-th' => 'fa fa-th',
            'fa fa-th-large' => 'fa fa-th-large',
            'fa fa-th-list' => 'fa fa-th-list',
            'fa fa-underline' => 'fa fa-underline',
            'fa fa-undo' => 'fa fa-undo',
            'fa fa-unlink' => 'fa fa-unlink',
            'fa fa-angle-double-down' => ' fa fa-angle-double-down',
            'fa fa-angle-double-left' => 'fa fa-angle-double-left',
            'fa fa-angle-double-right' => 'fa fa-angle-double-right',
            'fa fa-angle-double-up' => 'fa fa-angle-double-up',
            'fa fa-angle-down' => 'fa fa-angle-down',
            'fa fa-angle-left' => 'fa fa-angle-left',
            'fa fa-angle-right' => 'fa fa-angle-right',
            'fa fa-angle-up' => 'fa fa-angle-up',
            'fa fa-arrow-circle-down' => 'fa fa-arrow-circle-down',
            'fa fa-arrow-circle-left' => 'fa fa-arrow-circle-left',
            'fa fa-arrow-circle-o-down' => 'fa fa-arrow-circle-o-down',
            'fa fa-arrow-circle-o-left' => 'fa fa-arrow-circle-o-left',
            'fa fa-arrow-circle-o-right' => 'fa fa-arrow-circle-o-right',
            'fa fa-arrow-circle-o-up' => 'fa fa-arrow-circle-o-up',
            'fa fa-arrow-circle-right' => 'fa fa-arrow-circle-right',
            'fa fa-arrow-circle-up' => 'fa fa-arrow-circle-up',
            'fa fa-arrow-down' => 'fa fa-arrow-down',
            'fa fa-arrow-left' => 'fa fa-arrow-left',
            'fa fa-arrow-right' => 'fa fa-arrow-right',
            'fa fa-arrow-up' => 'fa fa-arrow-up',
            'fa fa-arrows-alt' => 'fa fa-arrows-alt',
            'fa fa-caret-down' => 'fa fa-caret-down',
            'fa fa-caret-left' => 'fa fa-caret-left',
            'fa fa-caret-right' => 'fa fa-caret-right',
            'fa fa-caret-up' => 'fa fa-caret-up',
            'fa fa-chevron-circle-down' => 'fa fa-chevron-circle-down',
            'fa fa-chevron-circle-left' => 'fa fa-chevron-circle-left',
            'fa fa-chevron-circle-right' => 'fa fa-chevron-circle-right',
            'fa fa-chevron-circle-up' => 'fa fa-chevron-circle-up',
            'fa fa-chevron-down' => 'fa fa-chevron-down',
            'fa fa-chevron-left' => 'fa fa-chevron-left',
            'fa fa-chevron-right' => 'fa fa-chevron-right',
            'fa fa-chevron-up' => 'fa fa-chevron-up',
            'fa fa-hand-o-down' => 'fa fa-hand-o-down',
            'fa fa-hand-o-left' => 'fa fa-hand-o-left',
            'fa fa-hand-o-right' => 'fa fa-hand-o-right',
            'fa fa-hand-o-up' => 'fa fa-hand-o-up',
            'fa fa-long-arrow-down' => 'fa fa-long-arrow-down',
            'fa fa-long-arrow-left' => 'fa fa-long-arrow-left',
            'fa fa-long-arrow-right' => 'fa fa-long-arrow-right',
            'fa fa-long-arrow-up' => 'fa fa-long-arrow-up',
            'fa fa-backward' => 'fa fa-backward',
            'fa fa-compress' => 'fa fa-compress',
            'fa fa-eject' => 'fa fa-eject',
            'fa fa-expand' => 'fa fa-expand',
            'fa fa-fast-backward' => 'fa fa-fast-backward',
            'fa fa-fast-forward' => 'fa fa-fast-forward',
            'fa fa-forward' => 'fa fa-forward',
            'fa fa-pause' => 'fa fa-pause',
            'fa fa-play' => 'fa fa-play',
            'fa fa-play-circle' => 'fa fa-play-circle',
            'fa fa-play-circle-o' => 'fa fa-play-circle-o',
            'fa fa-step-backward' => 'fa fa-step-backward',
            'fa fa-step-forward' => 'fa fa-step-forward',
            'fa fa-stop' => 'fa fa-stop',
            'fa fa-youtube-play' => 'fa fa-youtube-play'
            );

            $this->sections[] = array(
                'icon' => 'el-icon-comment',
                'title' => __('Blog Settings', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_divider_blog_archive_layout',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Blog Archive Layout</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Blog List Layout', 'groffer' ),
                        'subtitle' => __( 'Select Blog List layout.', 'groffer' ),
                        'options'  => array(
                            'groffer_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'groffer_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'groffer_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'groffer_blog_right_sidebar'
                    ),
                    array(
                        'id'       => 'groffer_blog_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Blog List Sidebar', 'groffer' ),
                        'subtitle' => __( 'Select Blog List Sidebar.', 'groffer' ),
                        'default'   => 'sidebar-1',
                        'required' => array('groffer_blog_layout', '!=', 'groffer_blog_fullwidth'),
                    ),
                    array(
                        'id'        => 'blog-grid-columns',
                        'type'      => 'select',
                        'title'     => esc_html__('Grid columns', 'groffer'),
                        'subtitle'  => esc_html__('Select how many columns you want.', 'groffer'),
                        'options'   => array(
                                '1'   => '1',
                                '2'   => '2',
                                '3'   => '3',
                                '4'   => '4'
                            ),
                        'default'   => '1',
                    ),
                    array(
                        'id'   => 'groffer_divider_blog_single_layout',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Blog Single Article Layout</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_single_blog_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Single Blog Layout', 'groffer' ),
                        'subtitle' => __( 'Select Single Blog Layout.', 'groffer' ),
                        'options'  => array(
                            'groffer_blog_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'groffer_blog_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'groffer_blog_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'groffer_blog_right_sidebar',
                        ),
                    array(
                        'id'       => 'groffer_single_blog_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Single Blog Sidebar', 'groffer' ),
                        'subtitle' => __( 'Select Single Blog Sidebar.', 'groffer' ),
                        'default'   => 'sidebar-1',
                        'required' => array('groffer_single_blog_layout', '!=', 'groffer_blog_fullwidth'),
                    ),

                    array(
                        'id'   => 'groffer_divider_blog_single_tyography',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Blog Single Article Typography</h3>', 'groffer' )
                    ),
                    array(
                        'id'          => 'groffer-blog-post-typography',
                        'type'        => 'typography', 
                        'title'       => esc_html__('Blog Post Font family', 'groffer'),
                        'google'      => true, 
                        'font-backup' => true,
                        'color'       => true,
                        'text-align'  => false,
                        'letter-spacing'  => false,
                        'line-height'  => true,
                        'font-weight'  => true,
                        'font-size'   => true,
                        'font-style'  => false,
                        'subsets'     => false,
                        'output'      => array('p'),
                        'units'       =>'px',
                        'default'     => array(
                            'font-family' => 'Space Grotesk', 
                            'font-size' => '16px', 
                            'line-height' => '25px', 
                            'color' => '#484848', 
                            'google'      => true
                        ),
                    ),
                    array(
                        'id'       => 'post_featured_image',
                        'type'     => 'switch', 
                        'title'    => __('Enable/disable featured image for single post.', 'groffer'),
                        'subtitle' => __('Show or Hide the featured image from blog post page.".', 'groffer'),
                        'default'  => true,
                    ),
                )
            );


            # Tab: Shop Settings
            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart-sign',
                'title' => __('Shop Settings', 'groffer'),
            );
            // Subtab: Shop Archives
            $this->sections[] = array(
                'subsection' => true,
                'icon' => 'el-icon-th',
                'title' => __('Shop Archives', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_shop_archive',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Shop Archives</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_shop_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Shop List Products Layout', 'groffer' ),
                        'subtitle' => __( 'Select Shop List Products layout.', 'groffer' ),
                        'options'  => array(
                            'groffer_shop_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'groffer_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'groffer_shop_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'groffer_shop_left_sidebar'
                    ),

                    array(
                        'id'       => 'groffer_shop_grid_list_switcher',
                        'type'     => 'select', 
                        'title'    => __('Grid / List default', 'groffer'),
                        'subtitle' => __('Choose which format products should display in by default.', 'groffer'),
                        'options'   => array(
                            'grid'   => __( 'Grid', 'groffer' ),
                            'list'   => __( 'List', 'groffer' ),
                        ),
                        'default'   => 'grid',
                    ),

                    array(
                        'id'       => 'groffer_shop_layout_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Shop List Sidebar', 'groffer' ),
                        'subtitle' => __( 'Select Shop List Sidebar.', 'groffer' ),
                        'default'   => 'woocommerce',
                        'required' => array('groffer_shop_layout', '!=', 'groffer_shop_fullwidth'),
                    ),
                    array(
                        'id'        => 'groffer-shop-columns',
                        'type'      => 'select',
                        'title'     => __('Number of shop columns', 'groffer'),
                        'subtitle'  => __('Number of products per column to show on shop list template.', 'groffer'),
                        'options'   => array(
                            '2'   => '2 columns',
                            '3'   => '3 columns',
                            '4'   => '4 columns'
                        ),
                        'default'   => '4',
                    ),
                    array(
                        'id'       => 'groffer-enable-padding-cont',
                        'type'     => 'switch', 
                        'title'    => __('Contain Products on Grid', 'groffer'),
                        'subtitle' => __('Enable or disable extra padding for grid', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id'       => 'groffer-archive-secondary-image-on-hover',
                        'type'     => 'switch', 
                        'title'    => __('Secondary Image on Hover', 'groffer'),
                        'subtitle' => __('Enable or disable the Secondary Image on Hover(The 2nd image is actually the first image from the media gallery of the product)', 'groffer'),
                        'default'  => true,
                    ),
                )
            );

            // Subtab: Product Single
            $this->sections[] = array(
                'subsection' => true,
                'icon' => 'el-icon-shopping-cart-sign',
                'title' => __('Product Single', 'groffer'),
                'fields' => array(
                    array(
                        'id'   => 'groffer_shop_single_product',
                        'type' => 'info',
                        'class' => 'groffer_divider',
                        'desc' => __( '<h3>Product Page</h3>', 'groffer' )
                    ),
                    array(
                        'id'       => 'groffer_single_product_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Single Product Layout', 'groffer' ),
                        'subtitle' => __( 'Select Single Product Layout.', 'groffer' ),
                        'options'  => array(
                            'groffer_shop_left_sidebar' => array(
                                'alt' => '2 Columns - Left sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-left.jpg'
                            ),
                            'groffer_shop_fullwidth' => array(
                                'alt' => '1 Column - Full width',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-no.jpg'
                            ),
                            'groffer_shop_right_sidebar' => array(
                                'alt' => '2 Columns - Right sidebar',
                                'img' => get_template_directory_uri().'/redux-framework/assets/sidebar-right.jpg'
                            )
                        ),
                        'default'  => 'groffer_shop_fullwidth'
                    ),
                    array(
                        'id'       => 'groffer_single_shop_sidebar',
                        'type'     => 'select',
                        'data'     => 'sidebars',
                        'title'    => __( 'Shop Single Product Sidebar', 'groffer' ),
                        'subtitle' => __( 'Select Shop List Sidebar.', 'groffer' ),
                        'default'   => 'sidebar-1',
                        'required' => array('groffer_single_product_layout', '!=', 'groffer_shop_fullwidth'),
                    ),
                    array(
                        'id'       => 'groffer-enable-related-products',
                        'type'     => 'switch', 
                        'title'    => __('Related Products', 'groffer'),
                        'subtitle' => __('Enable or disable related products on single product', 'groffer'),
                        'default'  => true,
                    ),
                    array(
                        'id'        => 'groffer-related-products-number',
                        'type'      => 'select',
                        'title'     => __('Number of related products', 'groffer'),
                        'subtitle'  => __('Number of related products to show on single product template.', 'groffer'),
                        'options'   => array(
                            '5'   => '5',
                            '10'   => '10',

                        ),
                        'default'   => '5',
                        'required' => array('groffer-enable-related-products', '=', true),
                    ),
                    array(
                        'id'       => 'groffer-enable-general-info',
                        'type'     => 'switch', 
                        'title'    => __('General Information', 'groffer'),
                        'subtitle' => __('Enable or disable General Information on single product', 'groffer'),
                        'default'  => false,
                    ),
                    array(
                        'id' => 'groffer-enable-general-img1',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('First Icon', 'groffer') ,
                        'compiler' => 'true',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-desc1',
                        'type' => 'editor',
                        'title' => esc_html__('First Block', 'groffer') ,
                        'default' => '<span>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipisc elit. Duis sollicitudin diam in diamui varius, sed anim.', 'groffer').'</span>',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-img2',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Second Icon', 'groffer') ,
                        'compiler' => 'true',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-desc2',
                        'type' => 'editor',
                        'title' => esc_html__('Second Block', 'groffer') ,
                        'default' => '<span>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipisc elit. Duis sollicitudin diam in diamui varius, sed anim.', 'groffer').'</span>',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-img3',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Third Icon', 'groffer') ,
                        'compiler' => 'true',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-desc3',
                        'type' => 'editor',
                        'title' => esc_html__('Third Block', 'groffer') ,
                        'default' => '<span>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipisc elit. Duis sollicitudin diam in diamui varius, sed anim.', 'groffer').'</span>',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-img4',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Fourth Icon', 'groffer') ,
                        'compiler' => 'true',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-general-desc4',
                        'type' => 'editor',
                        'title' => esc_html__('Fourth Block', 'groffer') ,
                        'default' => '<span>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipisc elit. Duis sollicitudin diam in diamui varius, sed anim.', 'groffer').'</span>',
                        'required' => array('groffer-enable-general-info', '=', true),
                    ),
                    array(
                        'id'       => 'groffer-enable-contact-info',
                        'type'     => 'switch', 
                        'title'    => __('Contact Information', 'groffer'),
                        'subtitle' => __('Enable or disable Contact Information on single product', 'groffer'),
                        'default'  => true,
                    ),
                    array(
                        'id' => 'groffer-enable-contact-img',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Contact Icon', 'groffer') ,
                        'compiler' => 'true',
                        'required' => array('groffer-enable-contact-info', '=', true),
                    ),
                    array(
                        'id' => 'groffer-enable-contact-desc',
                        'type' => 'editor',
                        'title' => esc_html__('Contact Block', 'groffer') ,
                        'default' => '<span>'.esc_html__('Lorem ipsum dolor sit amet, consectetur adipisc elit. Duis sollicitudin diam in diamui varius, sed anim.', 'groffer').'</span>',
                        'required' => array('groffer-enable-contact-info', '=', true),
                    ),
                )
            );


            # Section: Social Media Settings
            $this->sections[] = array(
                'icon' => 'el-icon-myspace',
                'title' => __('Social Media Settings', 'groffer'),
                'fields' => array(
                    array(
                        'id' => 'groffer_social_fb',
                        'type' => 'text',
                        'title' => __('Facebook URL', 'groffer'),
                        'subtitle' => __('Type your Facebook url.', 'groffer'),
                        'validate' => 'url',
                        'default' => 'http://facebook.com'
                    ),
                    array(
                        'id' => 'groffer_social_tw',
                        'type' => 'text',
                        'title' => __('Twitter username', 'groffer'),
                        'subtitle' => __('Type your Twitter username.', 'groffer'),
                        'default' => 'google'
                    ),
                    array(
                        'id' => 'groffer_social_pinterest',
                        'type' => 'text',
                        'title' => __('Pinterest URL', 'groffer'),
                        'subtitle' => __('Type your Pinterest url.', 'groffer'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_social_skype',
                        'type' => 'text',
                        'title' => __('Skype Name', 'groffer'),
                        'subtitle' => __('Type your Skype username.', 'groffer'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_social_instagram',
                        'type' => 'text',
                        'title' => __('Instagram URL', 'groffer'),
                        'subtitle' => __('Type your Instagram url.', 'groffer'),
                        'validate' => 'url',
                        'default' => 'http://instagram.com'
                    ),
                    array(
                        'id' => 'groffer_social_youtube',
                        'type' => 'text',
                        'title' => __('YouTube URL', 'groffer'),
                        'subtitle' => __('Type your YouTube url.', 'groffer'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_social_dribbble',
                        'type' => 'text',
                        'title' => __('Dribbble URL', 'groffer'),
                        'subtitle' => __('Type your Dribbble url.', 'groffer'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_social_gplus',
                        'type' => 'text',
                        'title' => __('Google+ URL', 'groffer'),
                        'subtitle' => __('Type your Google+ url.', 'groffer'),
                        'validate' => 'url',
                        'default' => ''
                    ),
                    array(
                        'id' => 'groffer_social_linkedin',
                        'type' => 'text',
                        'title' => __('LinkedIn URL', 'groffer'),
                        'subtitle' => __('Type your LinkedIn url.', 'groffer'),
                        'validate' => 'url',
                        'default' => 'http://linkedin.com'
                    ),
                    array(
                        'id' => 'groffer_social_deviantart',
                        'type' => 'text',
                        'title' => __('Deviant Art URL', 'groffer'),
                        'subtitle' => __('Type your Deviant Art url.', 'groffer'),
                        'validate' => 'url',
                        'default' => 'http://deviantart.com'
                    ),
                    array(
                        'id' => 'groffer_social_digg',
                        'type' => 'text',
                        'title' => __('Digg URL', 'groffer'),
                        'subtitle' => __('Type your Digg url.', 'groffer'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'groffer_social_flickr',
                        'type' => 'text',
                        'title' => __('Flickr URL', 'groffer'),
                        'subtitle' => __('Type your Flickr url.', 'groffer'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'groffer_social_stumbleupon',
                        'type' => 'text',
                        'title' => __('Stumbleupon URL', 'groffer'),
                        'subtitle' => __('Type your Stumbleupon url.', 'groffer'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'groffer_social_tumblr',
                        'type' => 'text',
                        'title' => __('Tumblr URL', 'groffer'),
                        'subtitle' => __('Type your Tumblr url.', 'groffer'),
                        'validate' => 'url'
                    ),
                    array(
                        'id' => 'groffer_social_vimeo',
                        'type' => 'text',
                        'title' => __('Vimeo URL', 'groffer'),
                        'subtitle' => __('Type your Vimeo url.', 'groffer'),
                        'validate' => 'url'
                    ),
                )
            );


            $theme_info = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'groffer') . '<a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' . esc_html($this->theme->get('ThemeURI')) . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'groffer') . esc_html($this->theme->get('Author')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'groffer') . esc_html($this->theme->get('Version')) . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . esc_html($this->theme->get('Description')) . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'groffer') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-1',
                'title' => __('', 'groffer'),
                'content' => __('', 'groffer')
            );

            $this->args['help_tabs'][] = array(
                'id' => 'redux-opts-2',
                'title' => __('', 'groffer'),
                'content' => __('', 'groffer')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('', 'groffer');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name' => 'redux_demo', // This is where your data is stored in the database and also becomes your global variable name.
                'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
                'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
                'menu_type' => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu' => true, // Show the sections below the admin menu item or not
                'menu_title' => __('Theme Panel', 'groffer'),
                'page' => __('Theme Panel', 'groffer'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'menu_icon' => get_template_directory_uri().'/images/svg/theme-panel-menu-icon.svg', // Specify a custom URL to an icon
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                'admin_bar' => false, // Show the panel pages on the admin bar
                'global_variable' => 'groffer_redux', // Set a different name for your global variable other than the opt_name
                'dev_mode' => false, // Show the time the page took to load, etc
                'customizer' => true, // Enable basic customizer support
                // OPTIONAL -> Give you extra features
                'page_priority' => 2, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent' => 'themes.php', // For a full list of options
                'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
                'last_tab' => '', // Force your panel to always open to a specific tab (by id)
                'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
                'page_slug' => '_options', // Page slug used to denote the panel
                'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
                'default_show' => false, // If true, shows the default value next to each field that is not the default value.
                'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
                // CAREFUL -> These options are for advanced use only
                'transient_time' => 60 * MINUTE_IN_SECONDS,
                'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag' => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'domain'              => 'groffer', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'show_import_export' => true, // REMOVE
                'system_info' => false, // REMOVE
                'help_tabs' => array(),
                'help_sidebar' => '',      
                'show_options_object' => false,   
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace("-", "_", $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('', 'groffer'), $v);
            } else {
                $this->args['intro_text'] = __('', 'groffer');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('', 'groffer');
        }

    }

    new Redux_Framework_groffer_config();
}
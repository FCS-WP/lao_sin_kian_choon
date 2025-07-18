<?php
/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.3
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {
    class ReduxFramework_extension_wbc_importer {
        public static $instance;
        static $version = "1.0.3";
        protected $parent;
        private $filesystem = array();
        public $extension_url;
        public $extension_dir;
        public $demo_data_dir;
        public $wbc_import_files = array();
        public $active_import_id;
        public $active_import;
        private $field_name;
        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {
            $this->parent = $parent;
            if ( !is_admin() ) return;
            //Hides importer section if anything but true returned. Way to abort :)
            if ( true !== apply_filters( 'wbc_importer_abort', true ) ) {
                return;
            }
            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                $this->demo_data_dir = apply_filters( "wbc_importer_dir_path", $this->extension_dir . 'demo-data/' );
            }
            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');
            $this->getImports();
            $this->field_name = 'wbc_importer';
            self::$instance = $this;
            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );
            add_action( 'wp_ajax_redux_wbc_importer', array(
                    $this,
                    'ajax_importer'
                ) );
            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/wbc_importer_files', array(
                    $this,
                    'addImportFiles'
                ) );
            //Adds Importer section to panel
            $this->add_importer_section();
            include $this->extension_dir.'inc/class-wbc-importer-progress.php';
            $wbc_progress = new Wbc_Importer_Progress( $this->parent );
        }
        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function demoFiles() {
            $this->filesystem = $this->parent->filesystem->execute( 'object' );
            $dir_array = $this->filesystem->dirlist( $this->demo_data_dir, false, true );

            // $wpbakery_demos = array('Antiques Collectibles', 'Art Auction');
            // $elementor_demos = array('Elementor Demo');

            // if (function_exists('vc_map')) {
                
            // }else{
            //     if (class_exists('elementor')) {
                    
            //     }
            // }

            if ( !empty( $dir_array ) && is_array( $dir_array ) ) {
               
                uksort( $dir_array, 'strcasecmp' );
                return $dir_array;
                // echo '<pre>' . var_export($imports, true) . '</pre>';
            }else{
                $dir_array = array();
                $demo_directory = array_diff( scandir( $this->demo_data_dir ), array( '..', '.' ) );
                if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {
                    foreach ( $demo_directory as $key => $value ) {
                        if ( is_dir( $this->demo_data_dir.$value ) ) {
                            $dir_array[$value] = array( 'name' => $value, 'type' => 'd', 'files'=> array() );
                            $demo_content = array_diff( scandir( $this->demo_data_dir.$value ), array( '..', '.' ) );
                            foreach ( $demo_content as $d_key => $d_value ) {
                                if ( is_file( $this->demo_data_dir.$value.'/'.$d_value ) ) {
                                    $dir_array[$value]['files'][$d_value] = array( 'name'=> $d_value, 'type' => 'f' );
                                }
                            }
                        }
                    }
                    uksort( $dir_array, 'strcasecmp' );
                }
            }
            return $dir_array;
        }
        public function getImports() {
            if ( !empty( $this->wbc_import_files ) ) {
                return $this->wbc_import_files;
            }
            $imports = $this->demoFiles();
            $imported = get_option( 'wbc_imported_demos' );
            if ( !empty( $imports ) && is_array( $imports ) ) {
                $x = 1;
                foreach ( $imports as $import ) {
                    if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
                        continue;
                    }
                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->wbc_import_files['wbc-import-'.$x] = isset( $this->wbc_import_files['wbc-import-'.$x] ) ? $this->wbc_import_files['wbc-import-'.$x] : array();
                        $this->wbc_import_files['wbc-import-'.$x]['directory'] = $import['name'];
                        if ( !empty( $imported ) && is_array( $imported ) ) {
                            if ( array_key_exists( 'wbc-import-'.$x, $imported ) ) {
                                $this->wbc_import_files['wbc-import-'.$x]['imported'] = 'imported';
                            }
                        }
                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                            case 'content.xml':
                                $this->wbc_import_files['wbc-import-'.$x]['content_file'] = $file['name'];
                                break;
                            case 'theme-options.txt':
                            case 'theme-options.json':
                                $this->wbc_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                break;
                            case 'widgets.json':
                            case 'widgets.txt':
                                $this->wbc_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                break;
                            case 'screen-image.png':
                            case 'screen-image.jpg':
                            case 'screen-image.gif':
                                $this->wbc_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                break;
                            }
                        }
                    }
                    $x++;
                }
            }
        }
        public function addImportFiles( $wbc_import_files ) {
            if ( !is_array( $wbc_import_files ) || empty( $wbc_import_files ) ) {
                $wbc_import_files = array();
            }
            $wbc_import_files = wp_parse_args( $wbc_import_files, $this->wbc_import_files );
            return $wbc_import_files;
        }
        public function ajax_importer() {
            if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_wbc_importer" ) ) {
                die( 0 );
            }
            if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->wbc_import_files ) ) {
                $reimporting = false;
                if ( isset( $_REQUEST['wbc_import'] ) && $_REQUEST['wbc_import'] == 're-importing' ) {
                    $reimporting = true;
                }
                $this->active_import_id = $_REQUEST['demo_import_id'];
                
                $this->active_import = array( $this->active_import_id => $this->wbc_import_files[$this->active_import_id] );
                if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
                    include $this->extension_dir.'inc/init-installer.php';
                    $installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
                }else {
                    echo esc_html__( "Demo Already Imported", 'framework' );
                }
                die();
            }
            die();
        }
        public static function get_instance() {
            return self::$instance;
        }
        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }
        function add_importer_section() {
            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'wbc_importer_section' ) {
                    return;
                }
            }

            $server_requirements = '';
            
            $wbc_importer_label = trim( esc_html( apply_filters( 'wbc_importer_label', __( 'Demo Importer', 'framework' ) ) ) );
            $wbc_importer_label = ( !empty( $wbc_importer_label ) ) ? $wbc_importer_label : __( 'Demo Importer', 'framework' );
            $this->parent->sections[] = array(
                'id'     => 'wbc_importer_section',
                'title'  => $wbc_importer_label,
                'desc'   => '<p class="description">'. apply_filters( 'wbc_importer_description', $server_requirements ).'</p>',
                'icon'   => 'el-icon-website',
                'fields' => array(
                    array(
                        'id'   => 'wbc_demo_importer',
                        'type' => 'wbc_importer'
                    )
                )
            );
        }
    } // class
} // if
/************************************************************************
* Extended Example:
* Way to set menu, import revolution slider, and set home page.
*************************************************************************/
if ( !function_exists( 'wbc_extended_example' ) ) {
    function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
        reset( $demo_active_import );
        $current_key = key( $demo_active_import );
        /**
        ||-> Import slider(s) for the current demo being imported
        
        */
        if ( class_exists( 'RevSlider' ) ) {

            $wbc_sliders_array = array(
                'Main Home' => array('organic-slider.zip'),
            );

            if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
                $wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
                if( is_array( $wbc_slider_import ) ){
                    foreach ($wbc_slider_import as $slider_zip) {
                        if ( !empty($slider_zip) && file_exists( $demo_directory_path.$slider_zip ) ) {
                            $slider = new RevSlider();
                            $slider->importSliderFromPost( true, true, $demo_directory_path.$slider_zip );
                        }
                    }
                }else{
                    if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
                        $slider = new RevSlider();
                        $slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
                    }
                }
            }
        }
        /************************************************************************
        * Setting Menus
        *************************************************************************/
        // If it's demo1 - demo3
        $wbc_menu_array = array( 
            'Main Home',

        );
        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
            $top_menu = get_term_by( 'name', 'Main Left Menu', 'nav_menu' );
            if ( isset( $top_menu->term_id ) ) {
                // set_theme_mod( 'nav_menu_locations', array(
                //         'primary' => 'Main Menu',
                //     )
                // );
                set_theme_mod( 'nav_menu_locations', array(
                        'primary' => $top_menu->term_id,
                    )
                );
                // update_option('blogdescription', 'X1-NEW');
            }
            // update_option('blogdescription', 'X2-NEW');
        }

        /**
        ||-> Set HomePage
        */
        // array of demos/homepages to check/select from
        $wbc_home_pages = array(
            'Main Home'                  => 'Home',

        );

        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
            $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
            if ( isset( $page->ID ) ) {
                update_option( 'page_on_front', $page->ID );
                update_option( 'show_on_front', 'page' );

                // WooCommerce Pages
                if ( class_exists( 'WooCommerce' ) ) {
                    // Shop page
                    if (!get_option( 'woocommerce_shop_page_id' ) ) {
                        $shop = get_page_by_title( 'Shop' );
                        if ( $shop ) {
                            update_option( 'woocommerce_shop_page_id', $shop->ID );
                        }
                    }

                    // Cart page
                    if (!get_option( 'woocommerce_cart_page_id' )) {
                        $cart = get_page_by_title( 'Cart' );
                        if ( $cart ) {
                            update_option( 'woocommerce_cart_page_id', $cart->ID );
                        }
                    }

                    // Checkout page
                    if (!get_option( 'woocommerce_checkout_page_id' )) {
                        $cart = get_page_by_title( 'Checkout' );
                        if ( $checkout ) {
                            update_option( 'woocommerce_checkout_page_id', $checkout->ID );
                        }
                    }

                    // Myaccount page
                    if (!get_option( 'woocommerce_myaccount_page_id' )) {
                        $cart = get_page_by_title( 'My account' );
                        if ( $account ) {
                            update_option( 'woocommerce_myaccount_page_id', $account->ID );
                        }
                    }
                }

            }
        }
    }
    // Uncomment the below
    add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
}

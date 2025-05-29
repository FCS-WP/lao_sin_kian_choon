<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_wbc_importer' ) ) {

    /**
     * Main ReduxFramework_wbc_importer class
     *
     * @since       1.0.0
     */
    class ReduxFramework_wbc_importer {
        private $parent;
        private $field;
        private $value;
        private $demo_data_dir;
        private $demo_data_url;
        private $extension_dir;
        private $extension_url;

        /**
         * Field Constructor.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent = '' ) {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            $class = ReduxFramework_extension_wbc_importer::get_instance();

            if ( !empty( $class->demo_data_dir ) ) {
                $this->demo_data_dir = $class->demo_data_dir;
                $this->demo_data_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->demo_data_dir ) );
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }
        }

        /**
         * Field Render Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {

            echo '</fieldset></td></tr><tr><td colspan="2"><fieldset class="redux-field wbc_importer">';

            $nonce = wp_create_nonce( "redux_{$this->parent->args['opt_name']}_wbc_importer" );

            // No errors please
            $defaults = array(
                'id'        => '',
                'url'       => '',
                'width'     => '',
                'height'    => '',
                'thumbnail' => '',
            );

            $this->value = wp_parse_args( $this->value, $defaults );

            $imported = false;

            $this->field['wbc_demo_imports'] = apply_filters( "redux/{$this->parent->args['opt_name']}/field/wbc_importer_files", array() );

                echo '<div class="theme-browser">';

                    if (class_exists('Vc_Manager') && class_exists('Elementor\Core\Admin\Admin')) {
                        echo '<div class="mt-notice mt-notice-wpbakery-elementor-active">
                                <p><span class="dashicons dashicons-warning"></span> Both <strong>WPBakery</strong> and <strong>Elementor Page Builder</strong> detected as active. This Demo Importer will only list demos after disabling one of the two page builders. Choose one page builder and disable the other one. Instructions:</p>
                                <ol>
                                    <li>Go to Plugins.</li>
                                    <li>Choose a page builder (WPBakery or Elementor).</li>
                                    <li>Disable the second page builder (Example: If you choose to run your site using WPBakery, simply disable Elementor).</li>
                                    <li>Reload this page to see demos for the selected page builder only.</li>
                                </ol>
                            </div>';
                    }elseif (class_exists('Vc_Manager') && !class_exists('Elementor\Core\Admin\Admin')) {
                        echo '<div class="mt-notice mt-notice-wpbakery-active">
                                <p><span class="dashicons dashicons-info-outline"></span> <strong>WPBakery Page Builder</strong> is active. Only demos for WPBakery are listed below. Note: In case you need to use the theme with Elementor Page Builder, please follow the instructions:</p>
                                <ol>
                                    <li>Disable the "WPBakery page builder" plugin.</li>
                                    <li>Disable the "Livemesh Addons for WPBakery Page Builder" plugin.</li>
                                    <li>Install & Activate "Elementor", from Appearance - <a target="_blank" href="'.admin_url('themes.php?page=tgmpa-install-plugins').'">Install Plugins</a>.</li>
                                    <li>Reload this page to see demos for Elementor only.</li>
                                </ol>
                            </div>';
                    }elseif (class_exists('Elementor\Core\Admin\Admin') && !class_exists('Vc_Manager')) {
                        echo '<div class="mt-notice mt-notice-elementor-active">
                                <p><span class="dashicons dashicons-info-outline"></span> <strong>Elementor Page Builder</strong> is active. Only demos for Elementor are listed below. Note: In case you need to use the theme with WPBakery Page Builder, please follow the instructions:</p>
                                <ol>
                                    <li>Disable the "Elementor" plugin (Both Free and/or PRO).</li>
                                    <li>Disable the "Livemesh Addons for Elementor Page Builder" plugin.</li>
                                    <li>Install & Activate "WPBakery Page Builder", from Appearance - <a target="_blank" href="'.admin_url('themes.php?page=tgmpa-install-plugins').'">Install Plugins</a>.</li>
                                    <li>Reload this page to see demos for WPBakery only.</li>
                                </ol>
                                <p><i><strong>Important:</strong> Not all of the demos are compatible with Elementor. Can be imported and used with Elementor only the demos listed below. (New Updates Coming Soon).</i></p>
                            </div>';
                    } elseif (!class_exists('Vc_Manager') && !class_exists('Elementor\Core\Admin\Admin')) {
                        echo '<div class="mt-notice mt-notice-wpbakery-elementor-active">
                               <p><span class="dashicons dashicons-warning"></span> None of the Page Builders (<strong>WPBakery Page Builder</strong> or <strong>Elementor Page Builder</strong>) were found active. Please activate a Page Builder Plugin. Instructions:</p>
                                <ol>
                                    <li>Go to Plugins.</li>
                                    <li>Choose a page builder (WPBakery or Elementor).</li>
                                    <li>Reload this page to see demos for the selected page builder only.</li>
                                </ol>
                            </div>';
                    }

                    echo '<div class="themes">';

                        if ( !empty( $this->field['wbc_demo_imports'] ) ) {

                            if (modelthemeav3_is_license_activated()) {
                                foreach ( $this->field['wbc_demo_imports'] as $section => $imports ) {

                                    if ( empty( $imports ) ) {
                                        continue;
                                    }

                                    if (class_exists('Vc_Manager') && !class_exists('Elementor\Core\Admin\Admin')) {
                                        if (strpos($imports['directory'], 'Elementor') === false) {

                                            if ( !array_key_exists( 'imported', $imports ) ) {
                                                $extra_class = 'not-imported';
                                                $imported = false;
                                                $import_message = esc_html__( 'Import Demo', 'framework' );
                                            }else {
                                                $imported = true;
                                                $extra_class = 'active imported';
                                                $import_message = esc_html__( 'Demo Imported', 'framework' );
                                            }
                                            echo '<div class="wrap-importer theme '.$extra_class.'" data-demo-id="'.esc_attr( $section ).'"  data-nonce="' . $nonce . '" id="' . $this->field['id'] . '-custom_imports">';

                                            echo '<div class="theme-screenshot">';

                                            if ( isset( $imports['image'] ) ) {
                                                echo '<img class="wbc_image" src="'.esc_attr( esc_url( $this->demo_data_url.$imports['directory'].'/'.$imports['image'] ) ).'"/>';

                                            }
                                            echo '</div>';

                                            echo '<span class="more-details">'.$import_message.'</span>';
                                            echo '<div class="mt-badge mt-badge-wpbakery">for <strong>WPBakery</strong></div>';
                                            echo '<h3 class="theme-name">'. esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) .'</h3>';

                                            echo '<div class="theme-actions">';
                                            if ( false == $imported ) {
                                                echo '<div class="wbc-importer-buttons"><span class="spinner">'.esc_html__( 'Please Wait...', 'framework' ).'</span><span class="button-primary importer-button import-demo-data">' . __( 'Import Demo', 'framework' ) . '</span></div>';
                                            }else {
                                                echo '<div class="wbc-importer-buttons button-secondary importer-button">'.esc_html__( 'Imported', 'framework' ).'</div>';
                                                echo '<span class="spinner">'.esc_html__( 'Please Wait...', 'framework' ).'</span>';
                                                echo '<div id="wbc-importer-reimport" class="wbc-importer-buttons button-primary import-demo-data importer-button">'.esc_html__( 'Re-Import', 'framework' ).'</div>';
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }elseif (class_exists('Elementor\Core\Admin\Admin') && !class_exists('Vc_Manager')) {
                                        if (strpos($imports['directory'], 'Elementor') !== false) {

                                            if ( !array_key_exists( 'imported', $imports ) ) {
                                                $extra_class = 'not-imported';
                                                $imported = false;
                                                $import_message = esc_html__( 'Import Demo', 'framework' );
                                            }else {
                                                $imported = true;
                                                $extra_class = 'active imported';
                                                $import_message = esc_html__( 'Demo Imported', 'framework' );
                                            }
                                            echo '<div class="wrap-importer theme '.$extra_class.'" data-demo-id="'.esc_attr( $section ).'"  data-nonce="' . $nonce . '" id="' . $this->field['id'] . '-custom_imports">';

                                            echo '<div class="theme-screenshot">';

                                            if ( isset( $imports['image'] ) ) {
                                                echo '<img class="wbc_image" src="'.esc_attr( esc_url( $this->demo_data_url.$imports['directory'].'/'.$imports['image'] ) ).'"/>';

                                            }
                                            echo '</div>';

                                            echo '<span class="more-details">'.$import_message.'</span>';
                                            echo '<div class="mt-badge mt-badge-elementor">for <strong>Elementor</strong></div>';
                                            echo '<h3 class="theme-name">'. esc_html( apply_filters( 'wbc_importer_directory_title', $imports['directory'] ) ) .'</h3>';

                                            echo '<div class="theme-actions">';
                                            if ( false == $imported ) {
                                                echo '<div class="wbc-importer-buttons"><span class="spinner">'.esc_html__( 'Please Wait...', 'framework' ).'</span><span class="button-primary importer-button import-demo-data">' . __( 'Import Demo', 'framework' ) . '</span></div>';
                                            }else {
                                                echo '<div class="wbc-importer-buttons button-secondary importer-button">'.esc_html__( 'Imported', 'framework' ).'</div>';
                                                echo '<span class="spinner">'.esc_html__( 'Please Wait...', 'framework' ).'</span>';
                                                echo '<div id="wbc-importer-reimport" class="wbc-importer-buttons button-primary import-demo-data importer-button">'.esc_html__( 'Re-Import', 'framework' ).'</div>';
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    }elseif (class_exists('Vc_Manager') && class_exists('Elementor\Core\Admin\Admin')) {
                                        // echo "<h5>".esc_html__( 'No Demo Data Provided', 'framework' )."</h5>";
                                    }

                                }
                            } else{
                                echo "<h3>Your license has not been activated yet. Please navigate to the <a href=".admin_url('admin.php?page=modeltheme-license').">Theme License Manager</a> tab to activate your license key.</h3>";
                            }

                        } else {
                            echo "<h5>".esc_html__( 'No Demo Data Provided', 'framework' )."</h5>";
                        }

                    echo '</div>';

                echo '</div>';
            echo '</fieldset></td></tr>';

        }

        /**
         * Enqueue Function.
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {

            $min = Redux_Functions::isMin();

            wp_enqueue_script(
                'redux-field-wbc-importer-js',
                $this->extension_url . '/field_wbc_importer' . $min . '.js',
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'redux-field-wbc-importer-css',
                $this->extension_url . 'field_wbc_importer.css',
                time(),
                true
            );

        }
    }
}

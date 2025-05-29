<?php
/*
 Project author:     ModelTheme
 File name:          Custom Popup
*/

defined( 'ABSPATH' ) || exit;

if ( !function_exists( 'groffer_popup_modal' ) ) {
    function groffer_popup_modal() { 
        // REDUX VARIABLE
        global $groffer_redux;
        $user_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
        echo'<div class="popup modeltheme-modal" id="modal-log-in" data-expire="'.esc_attr($groffer_redux['groffer-enable-popup-expire-date']).'" show="'.esc_attr($groffer_redux['groffer-enable-popup-show-time']).'">
            
            <div class="mt-popup-wrapper col-md-12" id="popup-modal-wrapper">
                <div class="dismiss">
                <a id="exit-popup"></a>
            </div>
                <div class="mt-popup-image col-md-4">
                    <img src="'.esc_url($groffer_redux['groffer-enable-popup-img']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />
                </div>
                <div class="mt-popup-content col-md-8 text-center">
                    <img src="'.esc_url($groffer_redux['groffer-enable-popup-company']['url']).'" alt="'.esc_attr(get_bloginfo()).'" />';
                    if($groffer_redux['groffer-enable-popup-desc']) {
                        echo '<p class="mt-popup-desc">'.esc_attr($groffer_redux['groffer-enable-popup-desc']).'</p>';
                    }
                    echo '<p class="mt-popup-desc">'.do_shortcode(''.$groffer_redux["groffer-enable-popup-form"].'').'</p>';
                    if($groffer_redux['groffer-enable-popup-additional'] == false) {

                        echo '<p class="mt-additional">'.esc_html__('Already a member?','groffer').' <a href="'.$user_url.'">'.esc_html__('Log In.','groffer').'</a></p>';
                    }
                echo '</div>          
            </div>
        </div>';
    }
}
?>
<?php 

/**
||-> Shortcode: Mega Menu Accordion
*/
function mt_shortcode_menu_accordion($params,  $content = NULL) {
    extract( shortcode_atts( 
        array(
            'heading_title'       =>'',
            'animation'           =>'',
        ), $params ) );

  $html = '';       

  $html .= '<div class="mt-mega-menu-shortcode wow '.$animation.'">';
    $html .= '<h3 class="heading-title">'.$heading_title.'</h3>';
    $html .= '<div class="mega-menu-accordion">';
      $html .= '<ul id="accordion" class="accordion"></ul>';

          $html .= do_shortcode($content);
        
    $html .= '</div>';
  $html .= '</div>';

  return $html;
}
add_shortcode('mt_menu_accordion_short', 'mt_shortcode_menu_accordion');
/**
||-> Shortcode: Mega Menu item
*/
function mt_shortcode_menu_accordion_items($params, $content = NULL) {

    extract( shortcode_atts( 
        array(
            'menu_id'             =>''
        ), $params ) );

      if ($menu_id) {
          $menu_id_value = $menu_id;
      }else{
          $menu_id_value = __('385', 'modeltheme');
      }

      $open_accordion = '';

      $html = '';
        $html .= '<div class="bot_nav_cat_wrap">'.do_shortcode('[vc_wp_custommenu nav_menu="'.$menu_id_value.'"]').'</div>';

      return $html;
}
add_shortcode('mt_menu_accordion_short_item', 'mt_shortcode_menu_accordion_items');
?>
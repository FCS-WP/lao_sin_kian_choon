<?php

require_once(__DIR__.'/../vc-shortcodes.inc.arrays.php');


/**

||-> Shortcode: Absolute Element

*/

function modeltheme_absolute_element_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'elements'                       => '',
        ), $params ) );
    
    $elements = vc_param_group_parse_atts($params['elements']);

    $shortcode_content = '';
    if ($elements) {
        foreach($elements as $element){
            $image_attributes = wp_get_attachment_image_src( $element['image'], 'full' );
            if ($image_attributes) {
                $shortcode_content .= '<img class="absolute" style="left: '.$element['left_percent'].'%; top: '.$element['top_percent'].'%;" src="'.$image_attributes[0].'" alt="absolute element" />';
            }
        }
    }

    return $shortcode_content;
}
add_shortcode('mt-absolute-element', 'modeltheme_absolute_element_shortcode');





/**
||-> Map Shortcode in Visual Composer with: vc_map();
*/
if ( function_exists('vc_map') ) {
    vc_map( 
      array(
       "name" => esc_attr__("groffer - Absolute Element", 'modeltheme'),
       "base" => "mt-absolute-element",
       "category" => esc_attr__('groffer', 'modeltheme'),
        "icon" => plugins_url( '../images/panel.svg', __FILE__ ),
       "params" => array(
            array(
                "group"        => esc_attr__( "Settings", 'modeltheme' ),
                'type' => 'param_group',
                'value' => '',
                'param_name' => 'elements',
                // Note params is mapped inside param-group:
                'params' => array(
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_attr__("Element Image", 'modeltheme'),
                        "param_name" => "image",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_attr__("Left (%) - Do not write the '%'", 'modeltheme'),
                        "param_name" => "left_percent",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => esc_attr__("Top (%) - Do not write the '%'", 'modeltheme'),
                        "param_name" => "top_percent",
                    ),
                )
            ),
       )
    ));  
}

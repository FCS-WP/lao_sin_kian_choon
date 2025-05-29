<?php

/**

||-> Shortcode: Members Slider

*/

function mt_shortcode_members02($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'category' => '',
            'number' => '',
            'order' => 'desc',

        ), $params ) );


    $html = '';



    // CLASSES
    $class_slider2 = 'mt_slider_members_v2_'.uniqid();

        $html .= '<div class="row mt_members2 '.$class_slider2.' row wow '.$animation.'">';
        $args_members = array(
          'orderby'          => 'post_date',
          'order'            => 'DESC',
          'posts_per_page'   => $number,
          'post_type'        => 'member',
          'tax_query' => array(
              array(
                  'taxonomy' => 'mt-member-category',
                  'field' => 'slug',
                  'terms' => $category
              )
          ),
          'post_status'      => 'publish' 
        ); 
        $members = get_posts($args_members);
            foreach ($members as $membercat) {
                #metaboxes
                $metabox_member_position = get_post_meta( $membercat->ID, 'av-job-position', true );
                $metabox_address_position = get_post_meta( $membercat->ID, 'av-address-position', true );
                $metabox_facebook_profile = get_post_meta( $membercat->ID, 'av-facebook-link', true );
                $metabox_twitter_profile  = get_post_meta( $membercat->ID, 'av-twitter-link', true );
                $metabox_linkedin_profile = get_post_meta( $membercat->ID, 'av-gplus-link', true );
                $metabox_vimeo_url = get_post_meta( $membercat->ID, 'av-instagram-link', true );
                $av_member_website = get_post_meta( $membercat->ID, 'av_member_website', true );

                $member_title = get_the_title( $membercat->ID );

                $testimonial_id = $membercat->ID;
                $content_post   = get_post($membercat);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $membercat->ID ),'groffer_member_pic350x350' );
                if ($thumbnail_src) {
                  $member_img = '<img class="memeber02-img-holder" src="'. esc_url($thumbnail_src[0]) . '" alt="'.$membercat->post_title.'" />';
                  
                } else {
                    $member_img = '';
                }

                if($metabox_facebook_profile) {
                    $profil_fb = '<a target="_new" href="'. $metabox_facebook_profile .'" class="member01_profile-facebook"> <i class="fa fa-facebook" aria-hidden="true"></i></a> ';
                }

                if($metabox_twitter_profile) {
                    $profil_tw = '<a target="_new" href="https://twitter.com/'. $metabox_twitter_profile .'" class="member01_profile-twitter"> <i class="fa fa-twitter" aria-hidden="true"></i></a> ';
                }

                if($metabox_linkedin_profile) {
                    $profil_in = '<a target="_new" href="'. $metabox_linkedin_profile .'" class="member01_profile-linkedin"> <i class="fa fa-linkedin" aria-hidden="true"></i> </a> ';
                }

                if($metabox_vimeo_url) {
                    $profil_vi = '<a target="_new" href="'. $metabox_vimeo_url .'" class="member01_vimeo_url"> <i class="fa fa-vimeo" aria-hidden="true"></i> </a> ';
                }
                $html.='
                    <div class="col-md-12 relative">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="member_hover" class="members_img_holder">
                                    
                                    <div class="memeber02-img-holder">';

                                        if(empty($av_member_website)) {
                                            $html .= '<a class="memeber02-img-holder" href="'.get_permalink($membercat->ID).'">'.$member_img.'</a>';
                                        }else{ 
                                            $html.='<h4><a class="memeber02-img-holder" href="'.esc_url($av_member_website).'"></i>'.$member_img.'</h4></a>';
                                        }

                                    $html.='</div>
                                    
                                   </div>
                                   <div class="member02-content">
                                        <div class="member02-content-inside">';
                                        if(empty($av_member_website)) {
                                            $html.='<h4><a class="member02_name " href="'.get_permalink($membercat->ID).'"></i>'.$membercat->post_title.'</h4></a>';
                                        } else {
                                            $html.='<h4><a class="member02_name " href="'.esc_url($av_member_website).'"></i>'.$membercat->post_title.'</h4></a>';
                                        }
                                        $html.= '<div class="clearfix"></div>                                
                                            <div class="content-div"><p class="member02_content-desc"><a href="'.get_permalink($membercat->ID).'">'.$metabox_address_position.'</a></p></div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>';


            }
    $html .= '</div>';
    return $html;
}
add_shortcode('mt_members_slider_v2', 'mt_shortcode_members02');




if ( function_exists('vc_map') ) {

    global $wpdb;

    $myrows=$wpdb->get_results("SELECT name,slug FROM {$wpdb->prefix}terms WHERE term_id IN (SELECT term_id FROM {$wpdb->prefix}term_taxonomy where taxonomy = 'mt-member-category');" );

    $category = array();

    foreach($myrows as $row) {
        $category[$row->name] = $row->slug; 
    }

    vc_map( array(
        "name" => esc_attr__("MT - Members Slider v2", 'modeltheme'),
        "base" => "mt_members_slider_v2",
        "category" => esc_attr__('groffer', 'modeltheme'),
        "icon" => plugins_url( '../images/members-slider.svg', __FILE__ ),
        "params" => array(
            array(
                "group" => "Slider Options",
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Number of members", 'modeltheme' ),
                "param_name" => "number",
                "value" => "",
                "description" => esc_attr__( "Enter number of members to show.", 'modeltheme' )
            ),
            array(
                 "type" => "dropdown",
                 "group" => "Slider Options",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Select Members Category", 'modeltheme'),
                 "param_name" => "category",
                 "description" => esc_attr__("Please select Members category", 'modeltheme'),
                 "std" => 'Default value',
                 "value" => $category
            ),
            array(
                "group" => "Animation",
                "type" => "dropdown",
                "heading" => esc_attr__("Animation", 'modeltheme'),
                "param_name" => "animation",
                "std" => '',
                "holder" => "div",
                "class" => "",
                "description" => "",
                "value" => $animations_list
            ),
        )
    ));
}
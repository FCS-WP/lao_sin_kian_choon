<?php
/*------------------------------------------------------------------
[groffer - SHORTCODES]
Project:    groffer – Multi-Purpose WordPress Template
Author:     ModelTheme
[Table of contents]
1. Recent Tweets
2. Contact Form
4. Recent Posts
5. Featured Post with thumbnail
6. Testimonials
7. Subscribe form
8. Services style 1
9. Services style 2
10. Recent Portfolios
11. Recent testimonials
12. Skill
13. Google map
14. Pricing tables
15. Jumbotron
16. Alert
17. Progress bars
18. Custom content
19. Responsive video (YouTube)
20. Heading With Border
21. Testimonials
22. List group
23. Thumbnails custom content
24. Section heading with title and subtitle
25. Heading with bottom border
26. Portfolio square
27. Call to action
28. Blog posts
29. Social Media
30. Countdown Version 2
31. Category Tabs Version 2
-------------------------------------------------------------------*/
global $groffer_redux;

include_once( 'mt-typed-text/mt-typed-text.php' ); # Typed text
include_once( 'mt-products-filter/mt-products-filters.php' ); # Typed text
include_once( 'mt-map-pins/mt-map-pins.php' );
include_once( 'mt-video/mt-video.php' );
include_once( 'mt-category-tabs/mt-category-tab.php' );
include_once( 'mt-products-banner/mt-products-banner.php' );
include_once( 'mt-mega-menu/mt-mega-menu.php' );
include_once( 'mt-member-slider-v2/mt-member-slider-v2.php' );
include_once( 'mt-absolute-element/mt-absolute-element.php' );



/*---------------------------------------------*/
/*--- 5. Featured Post with thumbnail ---*/
/*---------------------------------------------*/
function groffer_featured_post_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'      => '',
            'icon'      => '',
            'postid'    => '',
            'title'     => ''
        ), $params ) );
    $featured_post = '';
    #Content
    $content_post = get_post($postid);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    #Author
    $post_author_id = get_post_field( 'post_author', $postid );
    $user_info = get_userdata($post_author_id);
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ),'groffer_featured_post_pic500x230' );
    $featured_post .= '<div class="latest-videos animateIn" data-animate="'.$animation.'">';
        $featured_post .= '<h3 class=""><i class="'.$icon.'"></i>'.$title.'</h3>';
        $featured_post .= '<a href="'.get_permalink( $postid ).'">';
            if($thumbnail_src) { $featured_post .= '<img class="img-responsive" src="'. $thumbnail_src[0] . '" alt="" />';
            }else{ $featured_post .= '<img class="img-responsive" src="http://placehold.it/500x230" alt="" />'; }
        $featured_post .= '</a>';
        $featured_post .= '<div class="video-title">';
            $featured_post .= '<a href="'.get_permalink( $postid ).'">'.get_the_title( $postid ).'</a>';
            $featured_post .= '<span class="post-date"><i class="fa fa-calendar"></i>'.get_the_date('', $postid ).'</span>';
            $featured_post .= '</div>';
        $featured_post .= '<div class="video-excerpt">'.groffer_excerpt_limit($content,20).'</div>';
    $featured_post .= '</div>';
    return $featured_post;
}
add_shortcode('featured_post', 'groffer_featured_post_shortcode');
/*---------------------------------------------*/
/*--- 6. Testimonials ---*/
/*---------------------------------------------*/
function groffer_testimonials_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                 =>'',
            'number'                    =>'',
            'testimonial_border_color'  =>'',
            'visible_items'             =>'',
            'testimonial_style'         =>'',
            'block_bg'                  =>'',
            'title_color'               =>'',
            'content_color'             =>''
        ), $params ) );

    $mtf  ='';
    $mtf .='<style type="text/css" scoped>
                .testimonial-img-holder .testimonial-img {
                    border-color: '.$testimonial_border_color.' !important;
                }
                .testimonial01-img-holder.style2 {
                    background: '.$block_bg.' !important;
                }
                .testimonial01-img-holder.style2 p.name-test {
                    color: '.$title_color.' !important;
                }
                .testimonial01-img-holder.style2 .content p {
                    color: '.$content_color.' !important;
                }
            </style>';

    $mtf .='<div class="vc_row">';
        $mtf .='<div data-animate="'.$animation.'" class="testimonials-container-'.$visible_items.' owl-carousel owl-theme animateIn">';
        $args_testimonials = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'testimonial',
                'post_status'      => 'publish' 
                ); 
        $testimonials = get_posts($args_testimonials);
            foreach ($testimonials as $testimonial) {
                #metaboxes
                $metabox_job_position = get_post_meta( $testimonial->ID, 'job-position', true );
                $metabox_company = get_post_meta( $testimonial->ID, 'company', true );
                $testimonial_id = $testimonial->ID;
                $content_post   = get_post($testimonial_id);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ),'groffer_member_pic350x350' );
                
                $mtf.='
                <div class="wow '.$animation.' item vc_col-md-12 relative">
                    <div class="testimonial01_item">';
                    if($testimonial_style == 'style_1' or $testimonial_style == ''){            
                        $mtf.= '<div class="testimonial01-img-holder pull-left">
                                    <div class="testimonail01-content">
                                        <div class="testimonial-info-content">';
                                        $cls = '';
                                        if(!empty($thumbnail_src)) {
                                            $mtf.='<div class="testimonail01-profile-img">';                        
                                                $mtf.='<img alt="testimonial-image" src="'.home_url().'/wp-content/plugins/modeltheme-framework/inc/shortcodes/images/groffer--testimonial.svg">';
                                            $mtf.='</div>';
                                        } else {
                                            $cls .= 'text-center';                           
                                        }
                                     
                                        $mtf.= '<div class="testimonail01-name-position '.$cls.'">
                                                    <h2 class="name-test"><strong>'. $testimonial->post_title .'</strong></h2>
                                                    <p class="position-test">'. $metabox_job_position .'</p>
                                                </div>
                                        </div>
                                        <p>'.$content.'</p> 
                                    </div> 
                                </div>';
                    }else if($testimonial_style == 'style_2') {
                        $mtf.='<div class="testimonial01-img-holder style2">';    
                                $cls = '';
                                if($thumbnail_src) {
                                    $mtf.='<div class="testimonail01-profile-img">';                       
                                        $mtf.='<img src="'.$thumbnail_src[0].'" alt="'.$testimonial->post_title .'" />';
                                    $mtf.='</div>';
                                }
                                    $mtf.=' <div class="testimonial-info-content">
                                                <div class="content">'.$content.'</div>
                                                <p class="name-test"><strong>'. $testimonial->post_title .'</strong></p>
                                                <p class="position-test">'. $metabox_job_position .'</p>
                                            </div>  
                                </div>';
                    }
                    $mtf.='</div> 
                </div>';
            }
        $mtf .= '</div>';
    $mtf .= '</div>';
    return $mtf;
}
add_shortcode('testimonials', 'groffer_testimonials_shortcode');


/*---------------------------------------------*/
/*--- 8. Services style 1 ---*/
/*---------------------------------------------*/
function groffer_service_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon'          => '', 
            'title'         => '', 
            'description'   => '',
            'animation'     => ''
        ), $params ) );
    $service = '';
    $service .= '<div class="block-container">';
        $service .= '<div class="block-icon">';
            $service .= '<div class="block-triangle">';
                $service .= '<div>';
                    $service .= '<i class="'.$icon.'"></i>';
                $service .= '</div>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="block-title">';
            $service .= '<p>'.$title.'</p>';
        $service .= '</div>';
        $service .= '<div class="block-content">';
            $service .= '<p>'.$description.'</p>';
        $service .= '</div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('service', 'groffer_service_shortcode');
/*---------------------------------------------*/
/*--- 9. Services style 2 ---*/
/*---------------------------------------------*/
function groffer_service_style2_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon'          => '', 
            'title'         => '', 
            'description'   => '',
            'animation'     => ''
        ), $params ) );
    $service = '';
    $service .= '<div class="left-block-container services2 animateIn" data-animate="'.$animation.'">';
        $service .= '<div class="block-icon vc_col-md-2">';
            $service .= '<div class="block-triangle">';
                $service .= '<div>';
                    $service .= '<i class="'.$icon.'"></i>';
                $service .= '</div>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="vc_col-md-9 vc_col-md-offset-1">';
            $service .= '<div class="block-title">';
                $service .= '<p>'.$title.'</p>';
            $service .= '</div>';
            $service .= '<div class="block-content">';
                $service .= '<p>'.$description.'</p>';
            $service .= '</div>';
        $service .= '</div>';
        $service .= '<div class="clearfix"></div>';
    $service .= '</div>';
    return $service;
}
add_shortcode('service_style2', 'groffer_service_style2_shortcode');

/*---------------------------------------------*/
/*--- 11. Recent testimonials ---*/
/*---------------------------------------------*/
function groffer_testimonials2_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'number'=>'',
            'animation'=>''
        ), $params ) );
        $args_recenposts = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => 'DESC',
                'post_type'        => 'testimonial',
                'post_status'      => 'publish' 
                );
        $recentposts = get_posts($args_recenposts);
        $content  = "";
        $content .= '<div class="testimonials_slider owl-carousel owl-theme animateIn" data-animate="'.$animation.'">';
        foreach ($recentposts as $post) {
            $job_position = get_post_meta( $post->ID, 'job-position', true );
            $content .= '<div class="item">';
                $content .= '<div class="testimonial-content relative">';
                    $content .= '<span>'.get_post_field('post_content', $post->ID).'</span>';
                    $content .= '<div class="testimonial-client-details">';
                        $content .= '<div class="testimonial-name">'.$post->post_title.'</div>';
                        $content .= '<div class="testimonial-job">'.$job_position.'</div>';
                    $content .= '</div>';
                $content .= '</div>';
            $content .= '</div>';
        }
        $content .= '</div>';
        return $content;
}
add_shortcode('testimonials-style2', 'groffer_testimonials2_shortcode');
/*---------------------------------------------*/
/*--- 12. Skill ---*/
/*---------------------------------------------*/
function groffer_skills_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'icon_or_image'            => '', 
            'animation'                => '', 
            'icon'                     => '', 
            'text_transform'                     => '', 
            'title'                    => '',
            'skillvalue'               => '',
            'border_color'             => '',
            'bg_color'                 => '',
            'title_color'              => '',
            'skill_color_value'        => '',
            'image_skill'              => ''
        ), $params ) );

    $image_skill      = wp_get_attachment_image_src($image_skill, "linify_skill_counter_65x65");
    $image_skillsrc  = $image_skill[0];

    $subtitle_text_transform = 'uppercase';
    if (isset($text_transform) && !empty($text_transform)) {
        $subtitle_text_transform = $text_transform;
    }
    $subtitle_style = 'text-transform:'.$subtitle_text_transform.';';


    $skill = '';
    $skill .= '<div class="stats-block statistics wow '.esc_attr($animation).'">';
         $skill .= '<div class="stats-img">';

                if($icon_or_image == 'choosed_icon'){
                  $skill .= '<i class="'.esc_attr($icon).'"></i>';
                } elseif($icon_or_image == 'choosed_image') {
                  $skill .= '<img src="'.esc_attr($image_skillsrc).'" data-src="'.esc_attr($image_skillsrc).'" alt="">';
                }
         $skill .= '</div>';

        $skill .= '<div class="stats-content percentage " data-perc="'.esc_attr($skillvalue).'" style="background:'.$bg_color.'">';
          $skill .= '<span class="skill-count text-center" style="color: '.esc_attr($skill_color_value).'">'.esc_attr($skillvalue).'</span>';
            
              $skill .= '<p style="'.$subtitle_style.' color: '.esc_attr($title_color).'">'.esc_attr($title).'</p>';
              
            $skill .= '</div>';

        

    $skill .= '</div>';
    return $skill;
}
add_shortcode('mt_skill', 'groffer_skills_shortcode');


/*---------------------------------------------*/
/*--- 14. Pricing tables ---*/
/*---------------------------------------------*/
function groffer_pricing_table_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'package_currency'  => '',
            'package_price'     => '',
            'package_name'      => '',
            'package_basis'     => '',
            'package_desc'      => '',
            'package_feature1'  => '',
            'package_feature2'  => '',
            'package_feature3'  => '',
            'package_feature4'  => '',
            'package_feature5'  => '',
            'package_feature6'  => '',
            'animation'         => '',
            'button_url'        => '',
            'recommended'       => '',
            'style_price'       => '',
            'button_text'       => ''
        ), $params ) );
    $pricing_table = '';
    $pricing_table .= '<div class="pricing-table '.$recommended.' '.$style_price.'" data-animate="'.$animation.'">';
        $pricing_table .= '<div class="table-content">';
            $pricing_table .= '<h2>'.$package_name.'</h2>';
            $pricing_table .= '<small>'.$package_currency.'</small><span class="price">'.$package_price.'</span><span class="basis">'.$package_basis.'</span>';
            if($package_desc) {
                $pricing_table .= '<p class="package_desc">'.$package_desc.'</p>';
            }
            $pricing_table .= '<ul class="text-center">';
                $pricing_table .= '<li>'.$package_feature1.'</li>';
                $pricing_table .= '<li>'.$package_feature2.'</li>';
                $pricing_table .= '<li>'.$package_feature3.'</li>';
                $pricing_table .= '<li>'.$package_feature4.'</li>';
                $pricing_table .= '<li>'.$package_feature5.'</li>';
                $pricing_table .= '<li>'.$package_feature6.'</li>';
            $pricing_table .= '</ul>';
            $pricing_table .= '<div class="button-holder text-center">';
                $pricing_table .= '<a href="'.$button_url.'" class="solid-button button">'.$button_text.'</a>';
            $pricing_table .= '</div>';
        $pricing_table .= '</div>';
    $pricing_table .= '</div>';
    return $pricing_table;
}
add_shortcode('pricing-table', 'groffer_pricing_table_shortcode');

/*---------------------------------------------*/
/*--- 16. Alert ---*/
/*---------------------------------------------*/
function groffer_alert_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'alert_style'           => '', 
            'alert_dismissible'     => '', // yes/no
            'alert_text'            => '',
            'animation'            => ''
        ), $params ) );
    $content = '';
    $content .= '<div role="alert" class="alert alert-'.$alert_style.' animateIn" data-animate="'.$animation.'">';
        if ($alert_dismissible == 'yes') {
            $content .= '<button aria-label="'.esc_attr__('Close', 'modeltheme').'" data-dismiss="alert" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>';
        }
        $content .= $alert_text;
    $content .= '</div>';
    return $content;
}
add_shortcode('alert', 'groffer_alert_shortcode');
/*---------------------------------------------*/
/*--- 17. Progress bars ---*/
/*---------------------------------------------*/
function groffer_progress_bar_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'bar_scope'  => '', // success/info/warning/danger
            'bar_style'  => '', // normal/progress-bar-striped
            'bar_label'  => '', // optional
            'bar_value'  => '',
            'animation'  => ''
        ), $params ) );
    $content = '';
    $content .= '<div class="animateIn progress" data-animate="'.$animation.'" >';
        $content .= '<div class="progress-bar progress-bar-'.$bar_scope . ' ' . $bar_style.'" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar_value.'%">';
            if(!isset($bar_label)){
                $content .= '<span class="sr-only">'.$bar_label.'</span>.';
            }else{ 
                $content .= $bar_label;
            }
        $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('progress_bar', 'groffer_progress_bar_shortcode');
/*---------------------------------------------*/
/*--- 18. Custom content ---*/
/*---------------------------------------------*/
function groffer_panel_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'panel_style'    => '', // success/info/warning/danger
            'panel_title'    => '', 
            'panel_content'  => '',
            'animation'  => ''
        ), $params ) ); ?>
    <div class="panel animateIn panel-<?php echo esc_attr($panel_style); ?>" data-animate="<?php echo esc_attr($animation); ?>">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo esc_attr($panel_title); ?></h3>
        </div>
        <div class="panel-body">
            <?php echo $panel_content; ?>
        </div>
    </div>
    
<?php }
add_shortcode('panel', 'groffer_panel_shortcode');
/*---------------------------------------------*/
/*--- 20. Heading With Border ---*/
/*---------------------------------------------*/
function groffer_heading_with_border( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'align'       => 'left',
            'animation'   => ''
        ), $params ) );
    $content = do_shortcode($content);
    echo '<h2 data-animate="'.$animation.'" class="'.$align.'-border animateIn">'.$content.'</h2>';
}
add_shortcode('heading-border', 'groffer_heading_with_border');


/*---------------------------------------------*/
/*--- 21. Testimonials ---*/
/*---------------------------------------------*/
function groffer_clients_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'=>'',
            'number'=>''
        ), $params ) );
    $myContent = '';
    $myContent .= '<div class="clients-container owl-carousel owl-theme ">';
    $args_clients = array(
            'posts_per_page'   => $number,
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'post_type'        => 'client',
            'post_status'      => 'publish' 
            ); 
    $clients = get_posts($args_clients);
        foreach ($clients as $client) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $client->ID ),'full' );
            
            $myContent .= '<div class="item">';
                if($thumbnail_src) { $myContent .= '<img src="'. $thumbnail_src[0] . '" alt="'. $client->post_title .'" />';
                }else{ $myContent .= '<img src="http://placehold.it/110x110" alt="'. $client->post_title .'" />'; }
            $myContent .= '</div>';
        }
    $myContent .= '</div>';
    return $myContent;
}
add_shortcode('clients', 'groffer_clients_shortcode');
/*---------------------------------------------*/
/*--- 22. List group ---*/
/*---------------------------------------------*/
function groffer_list_group_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'description'   => '',
            'active'        => '',
            'animation'     => ''
        ), $params ) ); 
    $content = '';
    $content .= '<a href="#" class="list-group-item '.$active.' animateIn" data-animate="'.$animation.'">';
        $content .= '<h4 class="list-group-item-heading">'.$heading.'</h4>';
        $content .= '<p class="list-group-item-text">'.$description.'</p>';
    $content .= '</a>';
    return $content;
}
add_shortcode('list_group', 'groffer_list_group_shortcode');

function groffer_btn_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'btn_text'                 => '',
            'btn_url'                  => '',
            'btn_size'                 => '',
            'align'                    => '',
            'gradient_color_1'         => '',
            'gradient_color_2'         => '',
            'text_color'               => '',
            'btn_border_color'         => '',
            'hover_btn_border_color'         => '',
            'hover_text_color'               => '',
            'btn_format'             => '',
            'btn_format_rounded_radius'             => ''
        ), $params ) ); 

    $id_selector = 'btn_custom_'.uniqid();

    $content .= '<style type="text/css">
                .modeltheme_button .'.$id_selector.' {
                  background: '.esc_attr($gradient_color_1).' !important; /* Old browsers */
                  border: 2px solid '.esc_attr($btn_border_color).' !important; /* Old browsers */
                  color: '.esc_attr($text_color).' !important; 
                  transform: scale(1.0);
                  transition: all 300ms ease-in-out 0s;
                  -ms-transformtransition: all 300ms ease-in-out 0s;
                  -webkit-transformtransition: all 300ms ease-in-out 0s;
                }
                .modeltheme_button .button-winona:hover,
                .modeltheme_button .button-winona::before, 
                .modeltheme_button .button-winona::after {
                  background: '.$gradient_color_2.' !important;
                  border: 2px solid '.esc_attr($hover_btn_border_color).' !important; /* Old browsers */
                  color: '.$hover_text_color.' !important;
                  transition: all 300ms ease-in-out 0s;
                  -ms-transformtransition: all 300ms ease-in-out 0s;
                  -webkit-transformtransition: all 300ms ease-in-out 0s;
                }
              </style>';

    $style = '';
   
    
    $style_radius = '';
    if (!empty($btn_format_rounded_radius)) {
      $style_radius = 'border-radius:' . $btn_format_rounded_radius . ';';
    }
    
    $content .= '<div class="'.$align.' modeltheme_button wow ">';
        $content .= '<a href="'.$btn_url.'" class="button-winona '.$btn_size.' '.$id_selector.'" style="'.$style.' ' .$style_radius.'">'.$btn_text.'</a>';
    $content .= '</div>';
    return $content;
}
add_shortcode('groffer_btn', 'groffer_btn_shortcode');
/*---------------------------------------------*/
/*--- 23. Thumbnails custom content ---*/
/*---------------------------------------------*/
function groffer_thumbnails_custom_content_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'image'         => '',
            'heading'       => '',
            'description'   => '',
            'active'        => '',
            'button_url'    => '',
            'button_text'   => '',
            'animation'     => ''
        ), $params ) ); 
    $thumb      = wp_get_attachment_image_src($image, "large");
    $thumb_src  = $thumb[0]; 
    $content = '';
    $content .= '<div class="thumbnail animateIn" data-animate="'.$animation.'">';
        $content .= '<img data-holder-rendered="true" src="'.$thumb_src.'" data-src="'.$thumb_src.'" alt="'.$heading.'">';
        $content .= '<div class="caption">';
            if (!empty($heading)) {
                $content .= '<h3>'.$heading.'</h3>';  
            }
            if (!empty($description)) {
                $content .= '<p>'.$description.'</p>';
            }
            if (!empty($button_text)) {
                $content .= '<p><a href="'.$button_url.'" class="btn btn-primary" role="button">'.$button_text.'</a></p>';
            }
        $content .= '</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('thumbnails_custom_content', 'groffer_thumbnails_custom_content_shortcode');
/*---------------------------------------------*/
/*--- 24. Section heading with title and subtitle ---*/
/*---------------------------------------------*/
function groffer_heading_title_subtitle_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'title'         => '',
            'separator'     => '',
            'subtitle'      => '',
            'disable_sep'   => '',
            'title_style'   => '',
            'title_color'   => '',
            'delimitator_color' => ''
        ), $params ) ); 

    $separator = wp_get_attachment_image_src($separator, "full");

    if ($delimitator_color) {
        $delimitator_color_value = $delimitator_color;
    }else{
        $delimitator_color_value = '#2695FF';
    }

    $content = '<div class="title-subtile-holder">';
    $content .= '<h2 class="section-title '.$title_style.' '.$title_color.'">'.$title.'</h2>';
    if (isset($separator) && !empty($separator)) {
        $content .= '<div class="section-border" style="background: url('.$separator[0].') no-repeat center center;"></div>';
    }else{
        $content .= '<div class="svg-border '.$disable_sep.'"><svg width="515" height="25" viewBox="0 0 515 25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M228.333 11.6667H28.3333V13.3333H228.333V11.6667Z" fill="#CCCCCC"/><path d="M486.667 11.6667H286.667V13.3333H486.667V11.6667Z" fill="#CCCCCC"/><path d="M275.258 24.0703H239.525C239.386 24.0703 239.252 24.0149 239.154 23.9164C239.055 23.8178 239 23.6842 239 23.5448V2.52548C239 2.38612 239.055 2.25246 239.154 2.15391C239.252 2.05536 239.386 2 239.525 2H275.258C275.398 2 275.531 2.05536 275.63 2.15391C275.728 2.25246 275.784 2.38612 275.784 2.52548V23.5448C275.784 23.6842 275.728 23.8178 275.63 23.9164C275.531 24.0149 275.398 24.0703 275.258 24.0703ZM240.051 23.0193H274.733V3.05097H240.051V23.0193Z" fill="'.$delimitator_color_value.'"/><path d="M270.003 20.9174H244.78C244.641 20.9174 244.507 20.862 244.409 20.7635C244.31 20.6649 244.255 20.5313 244.255 20.3919C244.255 19.9738 244.089 19.5728 243.793 19.2772C243.497 18.9815 243.096 18.8154 242.678 18.8154C242.539 18.8154 242.405 18.7601 242.307 18.6615C242.208 18.563 242.153 18.4293 242.153 18.29V7.78031C242.153 7.64094 242.208 7.50728 242.307 7.40873C242.405 7.31019 242.539 7.25482 242.678 7.25482C243.096 7.25482 243.497 7.08873 243.793 6.79309C244.089 6.49745 244.255 6.09648 244.255 5.67838C244.255 5.53901 244.31 5.40535 244.409 5.3068C244.507 5.20826 244.641 5.15289 244.78 5.15289H270.003C270.143 5.15289 270.276 5.20826 270.375 5.3068C270.474 5.40535 270.529 5.53901 270.529 5.67838C270.529 6.09648 270.695 6.49745 270.991 6.79309C271.286 7.08873 271.687 7.25482 272.105 7.25482C272.245 7.25482 272.378 7.31019 272.477 7.40873C272.576 7.50728 272.631 7.64094 272.631 7.78031V18.29C272.631 18.4293 272.576 18.563 272.477 18.6615C272.378 18.7601 272.245 18.8154 272.105 18.8154C271.687 18.8154 271.286 18.9815 270.991 19.2772C270.695 19.5728 270.529 19.9738 270.529 20.3919C270.529 20.5313 270.474 20.6649 270.375 20.7635C270.276 20.862 270.143 20.9174 270.003 20.9174ZM245.253 19.8664H269.531C269.634 19.3619 269.884 18.8989 270.248 18.5347C270.612 18.1705 271.075 17.921 271.58 17.817V8.25324C271.075 8.14931 270.612 7.89981 270.248 7.53558C269.884 7.17135 269.634 6.70836 269.531 6.20386H245.253C245.149 6.70836 244.9 7.17135 244.536 7.53558C244.171 7.89981 243.708 8.14931 243.204 8.25324V17.817C243.708 17.921 244.171 18.1705 244.536 18.5347C244.9 18.8989 245.149 19.3619 245.253 19.8664V19.8664Z" fill="'.$delimitator_color_value.'"/><path d="M267.902 15.1371C267.486 15.1371 267.079 15.0138 266.734 14.7828C266.388 14.5519 266.119 14.2236 265.96 13.8395C265.801 13.4554 265.759 13.0328 265.84 12.6251C265.921 12.2173 266.121 11.8428 266.415 11.5488C266.709 11.2549 267.084 11.0547 267.491 10.9736C267.899 10.8925 268.322 10.9341 268.706 11.0932C269.09 11.2523 269.418 11.5217 269.649 11.8674C269.88 12.213 270.003 12.6194 270.003 13.0351C270.003 13.5926 269.782 14.1272 269.388 14.5214C268.994 14.9156 268.459 15.1371 267.902 15.1371ZM267.902 11.9842C267.694 11.9842 267.49 12.0458 267.318 12.1613C267.145 12.2768 267.01 12.4409 266.931 12.6329C266.851 12.825 266.83 13.0363 266.871 13.2402C266.911 13.444 267.011 13.6313 267.158 13.7783C267.305 13.9253 267.493 14.0253 267.697 14.0659C267.9 14.1064 268.112 14.0856 268.304 14.0061C268.496 13.9265 268.66 13.7918 268.775 13.619C268.891 13.4462 268.953 13.243 268.953 13.0351C268.953 12.7564 268.842 12.4891 268.645 12.292C268.448 12.0949 268.18 11.9842 267.902 11.9842Z" fill="'.$delimitator_color_value.'"/><path d="M246.882 15.1371C246.467 15.1371 246.06 15.0138 245.714 14.7828C245.369 14.5519 245.099 14.2236 244.94 13.8395C244.781 13.4554 244.74 13.0328 244.821 12.6251C244.902 12.2173 245.102 11.8428 245.396 11.5488C245.69 11.2549 246.064 11.0547 246.472 10.9736C246.88 10.8925 247.303 10.9341 247.687 11.0932C248.071 11.2523 248.399 11.5217 248.63 11.8674C248.861 12.213 248.984 12.6194 248.984 13.0351C248.984 13.5926 248.763 14.1272 248.369 14.5214C247.974 14.9156 247.44 15.1371 246.882 15.1371ZM246.882 11.9842C246.674 11.9842 246.471 12.0458 246.298 12.1613C246.126 12.2768 245.991 12.4409 245.911 12.6329C245.832 12.825 245.811 13.0363 245.851 13.2402C245.892 13.444 245.992 13.6313 246.139 13.7783C246.286 13.9253 246.473 14.0253 246.677 14.0659C246.881 14.1064 247.092 14.0856 247.284 14.0061C247.476 13.9265 247.641 13.7918 247.756 13.619C247.872 13.4462 247.933 13.243 247.933 13.0351C247.933 12.7564 247.822 12.4891 247.625 12.292C247.428 12.0949 247.161 11.9842 246.882 11.9842Z" fill="'.$delimitator_color_value.'"/><path d="M257.392 17.7645C256.695 17.7636 256.028 17.4866 255.535 16.994C255.042 16.5014 254.765 15.8336 254.764 15.1371H255.815C255.815 15.5552 255.982 15.9561 256.277 16.2518C256.573 16.5474 256.974 16.7135 257.392 16.7135C257.81 16.7135 258.211 16.5474 258.507 16.2518C258.802 15.9561 258.968 15.5552 258.968 15.1371C258.968 14.6352 258.772 13.9999 257.24 13.5385C255.194 12.9216 254.764 11.7813 254.764 10.9332C254.764 10.2364 255.041 9.56807 255.534 9.07534C256.027 8.5826 256.695 8.30579 257.392 8.30579C258.089 8.30579 258.757 8.5826 259.25 9.07534C259.742 9.56807 260.019 10.2364 260.019 10.9332H258.968C258.968 10.5151 258.802 10.1141 258.507 9.81848C258.211 9.52284 257.81 9.35675 257.392 9.35675C256.974 9.35675 256.573 9.52284 256.277 9.81848C255.982 10.1141 255.815 10.5151 255.815 10.9332C255.815 11.1996 255.815 12.011 257.544 12.5317C259.186 13.0272 260.019 13.9038 260.019 15.1371C260.018 15.8336 259.741 16.5014 259.249 16.994C258.756 17.4866 258.088 17.7636 257.392 17.7645Z" fill="'.$delimitator_color_value.'"/><path d="M256.866 7.25482H257.917V8.83127H256.866V7.25482Z" fill="'.$delimitator_color_value.'"/><path d="M256.866 17.239H257.917V18.8154H256.866V17.239Z" fill="'.$delimitator_color_value.'"/></svg></div>';
    }
    $content .= '<div class="section-subtitle '.$title_color.'">'.$subtitle.'</div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('heading_title_subtitle', 'groffer_heading_title_subtitle_shortcode');


/*---------------------------------------------*/
/*--- 24. Section heading with title and subtitle ---*/
/*---------------------------------------------*/
function groffer_heading_title_subtitle_shortcode_v2($params, $content) {
    extract( shortcode_atts( 
        array(
            'title'         => '',
            'separator'     => '',
            'button_link'   => '',
            'button_text'   => '',
            'subtitle'      => ''
        ), $params ) ); 

    $separator = wp_get_attachment_image_src($separator, "full");

    $content = '<div class="title-subtile-holder v2">';
        $content .= '<div class="title-content" >';
            $content .= '<h1 class="section-title text-left">'.$title.'</h1>';
            $content .= '<div class="section-subtitle text-left">'.$subtitle.'</div>';
        $content .= '</div>';
         $content .= '<a class="button title-btn " href="'.$button_link.'">'.$button_text.'</a>';
    $content .= '</div>';
    return $content;
}
add_shortcode('heading_title_subtitle_v2', 'groffer_heading_title_subtitle_shortcode_v2');

/*---------------------------------------------*/
/*--- 25. Heading with bottom border ---*/
/*---------------------------------------------*/
function groffer_heanding_bottom_border_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'    => '',
            'text_align' => ''
        ), $params ) );
    $content = '<h2 class="heading-bottom '.$text_align.'">'.$heading.'</h2>';
    return $content;
}
add_shortcode('heading_border_bottom', 'groffer_heanding_bottom_border_shortcode');
/*---------------------------------------------*/
/*--- 26. Portfolio square ---*/
/*---------------------------------------------*/
function groffer_portfolio_sqare_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'       => ''
           ), $params ) 
        );

    $args = array(
        'posts_per_page'   => $number,
        'post_type'        => 'portfolio',
        'post_status'      => 'publish',
    );
    $posts = new WP_Query( $args );
    $content = '<div class="portfolio-overlay"></div>';
    $content = '<div class="blog-posts portfolio-posts portfolio-shortcode quick-view-items">';
    foreach ( $posts->posts as $portfolio ) {
        
        $project_url = get_post_meta( $portfolio->ID, 'av-project-url', true );
        $project_skills = get_post_meta( $portfolio->ID, 'av-project-category', true );
        $excerpt = get_post_field( 'post_content', $portfolio->ID );
        $thumbnail_src      = wp_get_attachment_image_src( get_post_thumbnail_id( $portfolio->ID ), 'groffer_portfolio_pic700x450' );
        $content .= '<article id="post-'.$portfolio->ID.'" class="vc_col-md-4 single-portfolio-item groffer-item relative portfolio">';
        
        if($thumbnail_src) { 
            $content .= '<img src="'. $thumbnail_src[0] . '" alt="'.$portfolio->post_title.'" />';
        }else{ 
            $content .= '<img src="http://placehold.it/700x450" alt="'.$portfolio->post_title.'" />'; 
        }
            $content .= '<div class="item-description absolute">';
                $content .= '<div class="holder-top">';
                    $content .= '<a class="groffer-trigger" href="#"><i class="fa fa-expand"></i></a>';
                    $content .= '<a href="'.get_the_permalink($portfolio->ID).'"><i class="fa fa-plus"></i></a>';
                $content .= '</div>';
                $content .= '<div class="holder-bottom">';
                    $content .= '<h3>'.$portfolio->post_title.'</h3>';
                    $content .= '<h5>'.$project_skills.'</h5>';
                $content .= '</div>';
            $content .= '</div>';



            $content .= '<div class="groffer-quick-view portfolio-shortcode high-padding post-'.$portfolio->ID.'">';
                $content .= '<div class="groffer-slider-wrapper">';
                    $content .= '<ul class="groffer-slider">';
                        if($thumbnail_src) { 
                            $content .= '<li class="selected single-slide"><img class="portfolio-item-img" src="'. $thumbnail_src[0] . '" alt="'.$portfolio->post_title.'" /></li>';
                        }
                        if( class_exists('Dynamic_Featured_Image') ) {
                            global $dynamic_featured_image;
                            $featured_images = $dynamic_featured_image->get_featured_images($portfolio->ID);

                            $i = 0;
                            foreach ($featured_images as $row=>$innerArray) {
                                $id = $featured_images[$i]['attachment_id'];
                                $mediumSizedImage = $dynamic_featured_image->get_image_url($id,'groffer_portfolio_pic700x450'); 
                                $caption = $dynamic_featured_image->get_image_caption( $mediumSizedImage );
                                $content .= '<li class="single-slide"><img src="'.$mediumSizedImage.'" alt="'.$caption.'"></li>';
                                $i++;
                            }
                        }            
                    $content .= '</ul>';
                    $content .= '<ul class="groffer-slider-navigation">';
                        $content .= '<li><a class="groffer-next" href="#0"><i class="fa fa-angle-left"></i></a></li>';
                        $content .= '<li><a class="groffer-prev" href="#0"><i class="fa fa-angle-right"></i></a></li>';
                    $content .= '</ul>';
                $content .= '</div>';

                $content .= '<div class="groffer-item-info col-md-5">';
                    $content .= '<h2 class="heading-bottom top">'.$portfolio->post_title.'</h2>';
                    $content .= '<div class="desc">'.get_post_field('post_content', $portfolio->ID).'</div>';

                    $content .= '<div class="portfolio-details">';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Customer:', 'modeltheme').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.get_the_author().'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Live demo:', 'modeltheme').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.$project_url.'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Skills:', 'modeltheme').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.$project_skills.'</div>';
                        $content .= '</div>';
                        $content .= '<div class="vc_row">';
                            $content .= '<div class="vc_col-md-4 portfolio_label">'.esc_attr__('Date post:', 'modeltheme').'</div>';
                            $content .= '<div class="vc_col-md-8 portfolio_label_value">'.get_the_date().'</div>';
                        $content .= '</div>';
                    $content .= '</div>';
                    $content .= '<a href="'.get_the_permalink($portfolio->ID).'" class="vc_btn vc_btn-blue">More details</a>';
                $content .= '</div>';
                $content .= '<a href="#0" class="groffer-close"><i class="fa fa-times"></i></a>';
            $content .= '</div>';
        $content .= '</article>';
    }
    $content .= '<div class="clearfix"></div>';
    $content .= '<div class="portfolio-overlay"></div>';
    $content .= '</div>';
    return $content;
}
add_shortcode('portfolio-square', 'groffer_portfolio_sqare_shortcode');
/*---------------------------------------------*/
/*--- 27. Call to action ---*/
/*---------------------------------------------*/
function groffer_call_to_action_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'heading_type'  => '',
            'subheading'    => '',
            'align'         => '',
            'button_text'   => '',
            'url'           => ''
        ), $params ) );
    $shortcode_content = '<div class="groffer_call-to-action">';
    $shortcode_content .= '<div class="vc_col-md-12">';
    $shortcode_content .= '<'.$heading_type.' class="'.$align.'">'.$heading.'</'.$heading_type.'>';
    $shortcode_content .= '<p class="'.$align.'">'.$subheading.'</p>';
    $shortcode_content .= '</div>';
    $shortcode_content .= '<div class="clearfix"></div>';
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('groffer-call-to-action', 'groffer_call_to_action_shortcode');


/*---------------------------------------------*/
/*--- 27. Call to action ---*/
/*---------------------------------------------*/
function groffer_shop_feature_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'heading'       => '',
            'subheading'    => '',
            'icon'          => ''
        ), $params ) );

    $shortcode_content = '<div class="shop_feature">';
        $shortcode_content .= '<div class="pull-left shop_feature_icon">';
            $shortcode_content .= '<i class="'.$icon.'"></i>';
        $shortcode_content .= '</div>';
        $shortcode_content .= '<div class="pull-left shop_feature_description">';
            $shortcode_content .= '<h4>'.$heading.'</h4>';
            $shortcode_content .= '<p>'.$subheading.'</p>';
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('shop-feature', 'groffer_shop_feature_shortcode');

/*---------------------------------------------*/
/*--- Woocommerce Categories List ---*/
/*---------------------------------------------*/

function groffer_shop_categories_with_thumbnails_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'hide_empty'                           => ''
        ), $params ) );

    $prod_categories = get_terms( 'product_cat', array(
        'number'        => $number,
        'hide_empty'    => $hide_empty,
        'parent' => 0
    ));

    $shortcode_content = '';
    $shortcode_content .= '<div class="woocommerce_categories list">';
        $shortcode_content .= '<div class="categories-list categories_shortcode categories_shortcode_'.$number_of_columns.' owl-carousel owl-theme">';
        foreach( $prod_categories as $prod_cat ) {
            if ( class_exists( 'WooCommerce' ) ) {
                $cat_thumb_id   = get_term_meta( $prod_cat->term_id, 'thumbnail_id', true );
            } else {
                $cat_thumb_id = '';
            }
            $cat_thumb_url  = wp_get_attachment_image_src( $cat_thumb_id, 'pic100x75' );
            $term_link      = get_term_link( $prod_cat, 'product_cat' );

            $shortcode_content .= '<div class="category item ">';
                    $shortcode_content .= '<a class="#categoryid_'.$prod_cat->term_id.'">';
                        $shortcode_content .= '<span class="cat-name">'.$prod_cat->name.'</span>';                    
                    $shortcode_content .= '</a>';    
            $shortcode_content .= '</div>';
        }
        $shortcode_content .= '</div>';

            $shortcode_content .= '<div class="products_category">';
                foreach( $prod_categories as $prod_cat ) {
                        $shortcode_content .= '<div id="categoryid_'.$prod_cat->term_id.'" class="products_by_category '.$prod_cat->name.'">'.do_shortcode('[product_category columns="1" per_page="'.$number_of_products_by_category.'" category="'.$prod_cat->slug.'"]').'</div>';
                }
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';

    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('shop-categories-with-thumbnails', 'groffer_shop_categories_with_thumbnails_shortcode');

/*---------------------------------------------*/
/*--- Woocommerce Products Slider ---*/
/*---------------------------------------------*/

function mt_shortcode_products($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'number' => '',
            'navigation' => 'false',
            'order' => 'desc',
            'pagination' => 'false',
            'autoPlay' => 'false',
            'layout'  => '',
            'button_text' => '',
            'button_link' => '',
            'button_background' => '',
            'paginationSpeed' => '700',
            'slideSpeed' => '700',
            'number_desktop' => '4',
            'number_tablets' => '2',
            'number_mobile' => '1'
        ), $params ) );


    $html = '';



    // CLASSES
    $class_slider = 'mt_slider_products_'.uniqid();



    $html .= '<script>
                jQuery(document).ready( function() {
                    jQuery(".'.$class_slider.'").owlCarousel({
                        navigation      : '.$navigation.', // Show next and prev buttons
                        pagination      : '.$pagination.',
                        autoPlay        : '.$autoPlay.',
                        slideSpeed      : '.$paginationSpeed.',
                        paginationSpeed : '.$slideSpeed.',
                        autoWidth: true,
                        itemsCustom : [
                            [0,     '.$number_mobile.'],
                            [450,   '.$number_mobile.'],
                            [600,   '.$number_desktop.'],
                            [700,   '.$number_tablets.'],
                            [1000,  '.$number_tablets.'],
                            [1200,  '.$number_desktop.'],
                            [1400,  '.$number_desktop.'],
                            [1600,  '.$number_desktop.']
                        ]
                    });
                    
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item:nth-child(2)").addClass("hover_class");
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item").hover(
                  function () {
                    jQuery(".'.$class_slider.' .owl-wrapper .owl-item").removeClass("hover_class");
                    if(jQuery(this).hasClass("open")) {
                        jQuery(this).removeClass("open");
                    } else {
                    jQuery(this).addClass("open");
                    }
                  }
                );


                });
              </script>';


        $html .= '<div class="mt_products_slider '.$class_slider.' row  ">';
        $args_blogposts = array(
              'posts_per_page'   => $number,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish' 
         ); 
        $blogposts = get_posts($args_blogposts);
        
        foreach ($blogposts as $blogpost) {
                global $product;
                $product = wc_get_product( $blogpost->ID );

                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'groffer_portfolio_pic400x400' );
                if ($thumbnail_src) {
                    $post_img = '<img class="portfolio_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.$blogpost->post_title.'" />';
                    $post_col = 'col-md-12';
                }else{
                    $post_col = 'col-md-12 no-featured-image';
                    $post_img = '';
                }
                $thumbnail_src2 = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'groffer_related_post_pic500x300' );
                if ($thumbnail_src2) {
                    $post_img2 = '<img class="portfolio_post_image" src="'. esc_url($thumbnail_src2[0]) . '" alt="'.$blogpost->post_title.'" />';
                    $post_col2 = 'col-md-12';
                }else{
                    $post_col2 = 'col-md-12 no-featured-image';
                    $post_img2 = '';
                }
            $html .= '<div id="product-id-'.esc_attr($blogpost->ID).'">
                        <div class="slider-wrapper">';
                        if($layout == "vertical" || $layout == "") {

                            $html .= '<div class="col-md-12 post ">
                              <div class="thumbnail-and-details">
                                <a class="woo_catalog_media_images" title="'.esc_attr($blogpost->post_title).'" href="'.esc_url(get_permalink($blogpost->ID)).'"> '.$post_img.'</a>
                              </div>
                              <div class="woocommerce-title-metas text-center">
                                <h3 class="archive-product-title">
                                  <a href="'.esc_url(get_permalink($blogpost->ID)).'" title="'. $blogpost->post_title .'">'. $blogpost->post_title .'</a>
                                </h3>';
                                 if($product->get_price_html()) {
                                  $html .= '<p>'.esc_html__('Price: ','modeltheme').''.$product->get_price_html().'</p>';
                                }
                    $html .= '</div>
                            </div>';
                        }else {
                            $html .= '<div class="col-md-12 post full ">
                              <div class="thumbnail-and-details">
                                <a class="woo_catalog_media_images" title="'.esc_attr($blogpost->post_title).'" href="'.esc_url(get_permalink($blogpost->ID)).'"> '.$post_img2.'</a>
                              </div>
                              <div class="woocommerce-title-metas text-center">
                                <h3 class="archive-product-title">
                                  <a href="'.esc_url(get_permalink($blogpost->ID)).'" title="'. $blogpost->post_title .'">'. $blogpost->post_title .'</a>
                                </h3>';

                    $html .= '</div>
                            </div>';
                        }


                            $html .= '</div>                     
                          </div>';

            }
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}
add_shortcode('mt_products_slider', 'mt_shortcode_products');


/*---------------------------------------------*/
/*--- Woocommerce Products Styled ---*/
/*---------------------------------------------*/

function groffer_products_styled_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'category'                             => '',
            'layout'                               => '',
            'block_bg'                             => '',
            'title_color'                          => '',
            'hide_empty'                           => ''
        ), $params ) );

    $cat = get_term_by('slug', $category, 'product_cat');

    if (isset($number_of_columns)) {
        if ($number_of_columns == '' || $number_of_columns == '5') {
            $column_type = 'col-md-2';
        }elseif($number_of_columns == '4'){
            $column_type = 'col-md-3';
        }
    }else{
        $column_type = 'col-md-3';
    }
    
    $shortcode_content = '';
    $shortcode_content .='<style type="text/css">
                            .woocommerce_styled .woocommerce-title-metas {
                                background: '.$block_bg.' !important;
                            }
                            .woocommerce_styled ul.products li.product .archive-product-title a{
                                color: '.$title_color.' !important;
                            }
                        </style>';
    $shortcode_content .= '<div class="woocommerce_styled">';
        $shortcode_content .= '<div class="products_category">';
            $shortcode_content .= '<div id="categoryid_'.$cat->term_id.'" class=" col-md-12 products_by_categories '.$cat->name.'">'.do_shortcode('[product_category columns="'.$number_of_columns.'" per_page="'.$number_of_products_by_category.'" category="'.$category.'"]').'</div>';
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';

    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('mt-products-styled', 'groffer_products_styled_shortcode');


/*---------------------------------------------*/
/*--- Woocommerce Categories Grid ---*/
/*---------------------------------------------*/

function groffer_shop_categories_with_grids( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'hide_empty'                           => ''
        ), $params ) );


    $args = array(
        'post_type'   =>  'product',
        'posts_per_page'  => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
            ),
        ),
        // 'posts_per_page'  => $number,
        'orderby'     =>  'date',
        'order'       =>  'DESC'
    );

    $prods = new WP_Query( $args );


    

    $shortcode_content = '';
    $shortcode_content .= '<div class="woocommerce_categories grid">';

        $shortcode_content .= '<table id="DataTable-icondrops-active" class="table" cellspacing="0" width="100%">';
            $shortcode_content .= '<thead>';
                $shortcode_content .= '<tr>';
                    $shortcode_content .= '<th>'.esc_html__('Image','modeltheme').'</th>';
                    $shortcode_content .= '<th>'.esc_html__('Title','modeltheme').'</th>';
                    $shortcode_content .= '<th>'.esc_html__('SKU','modeltheme').'</th>';
                    $shortcode_content .= '<th>'.esc_html__('Current Bid','modeltheme').'</th>';
                    $shortcode_content .= '<th>'.esc_html__('In stock','modeltheme').'</th>';
                    $shortcode_content .= '<th>'.esc_html__('Place Bid','modeltheme').'</th>';
                $shortcode_content .= '</tr>';
            $shortcode_content .= '<thead>';
            
            $shortcode_content .= '<tbody>';
            while ($prods->have_posts()) {
                $prods->the_post();
                global $product;

                    $shortcode_content .= '<tr>';
                        $shortcode_content .= '<td class="featured-image">'.get_the_post_thumbnail( $prods->post->ID, 'groffer_pic180x75' ).'</td>';
                        $shortcode_content .= '<td class="product-title"><a href="'.get_permalink().'"</a>'.$product->get_title().'</td>';
                        $shortcode_content .= '<td>'.$product->get_sku().'</td>';
                        $shortcode_content .= '<td>'.$product->get_price_html().'</td>';
                        $shortcode_content .= '<td>'.$product->get_stock_quantity().'</td>';
                        $shortcode_content .= '<td class="add-cart"><a href="'.get_permalink().'"</a>'.esc_html__('Bid Now','modeltheme').'</td>';   
                    $shortcode_content .= '</tr>';
            }
                            
        $shortcode_content .= '<tbody>';
        $shortcode_content .= '</table>';
                       
    $shortcode_content .= '</div>';

    wp_reset_postdata();


    return $shortcode_content;
}
add_shortcode('shop-categories-with-grids', 'groffer_shop_categories_with_grids');


/*---------------------------------------------*/
/*--- Woocommerce Categories with thumbnails version 2 ---*/
/*---------------------------------------------*/
function groffer_shop_categories_with_xsthumbnails_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'button_text'                          => '',
            'products_label_text'                  => '',
            'category'                             => '',
            'overlay_color1'                       => '',
            'overlay_color2'                       => '',
            'bg_image'                             => '',
            'hide_empty'                           => '',
            'products_layout'                      => '',
            'styles'                               => '',
            'button_style'                         => '',
            'banner_pos'                           => ''
        ), $params ) );

    if (isset($bg_image) && !empty($bg_image)) {
        $bg_image = wp_get_attachment_image_src($bg_image, "full");
    }

    $category_style_bg = '';
    if (isset($bg_image) && !empty($bg_image)) {
        $category_style_bg .= 'background: url('.$bg_image[0].') no-repeat center center;';
    }else{
        $category_style_bg .= 'background: radial-gradient('.$overlay_color1.','.$overlay_color2.');';
    }

    if ($button_text) {
        $button_text_value = $button_text;
    }else{
        $button_text_value = __('View All Items', 'modeltheme');
    }

    if ($products_label_text) {
        $products_label_text_value = $products_label_text;
    }else{
        $products_label_text_value = __('Products', 'modeltheme');
    }


    $cat = get_term_by('slug', $category, 'product_cat');

    $shortcode_content = ''; 

    if (isset($products_layout)) {
        if ($products_layout == '' || $products_layout == 'image_left') {
            if( $styles == '' || $styles == "style_1") {
                $block_type = 'woocommerce_categories2';
            }elseif($styles == "style_2") {
                $block_type = 'woocommerce_simple_styled';
            }
        }elseif($products_layout == 'image_top'){
            $block_type = 'woocommerce_categories2_top';
        }
    }else{
        $block_type = 'woocommerce_categories2';
    }

    if (!isset($number_of_columns) || (isset($number_of_columns) && $number_of_columns == '')) {
        $number_of_columns = '2';
    }

    if ($cat) {
        $shortcode_content .= '<div class="'.$block_type.'">';
            $shortcode_content .= '<div class="products_category">';
                $shortcode_content .= '<div class="category item col-md-3 '.$banner_pos.'" >';
                    $shortcode_content .= '<div style="'.$category_style_bg.'" class="category-wrapper">';
                        $shortcode_content .= '<a class="#categoryid_'.$cat->term_id.'">';
                            $shortcode_content .= '<span class="cat-name">'.$category.'</span>';                    
                        $shortcode_content .= '</a>';
                        $shortcode_content .= '<br>'; 

                        $shortcode_content .= '<span class="cat-count"><strong>'.$cat->count.'</strong> '.esc_html($products_label_text_value).'</span>';
                        $shortcode_content .= '<br>';
                        $shortcode_content .= '<div class="category-button '.$button_style.'">';
                           $shortcode_content .= '<a href="'.get_term_link($cat->slug, 'product_cat').'" class="button" title="'.__('View more', 'modeltheme').'" ><span>'.$button_text_value.'</span></a>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';    
                $shortcode_content .= '</div>';
                            $shortcode_content .= '<div id="categoryid_'.$cat->term_id.'" class=" col-md-9 products_by_categories '.$cat->name.'">'.do_shortcode('[product_category columns="'.$number_of_columns.'" per_page="'.$number_of_products_by_category.'" category="'.$category.'"]').'</div>';
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';
        $shortcode_content .= '<div class="clearfix"></div>';
    }

    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('shop-categories-with-xsthumbnails', 'groffer_shop_categories_with_xsthumbnails_shortcode');


/*---------------------------------------------*/
/*--- Woocommerce Only Product Categories  ---*/
/*---------------------------------------------*/

function groffer_shortcode_categories_image($params, $content) {
    extract( shortcode_atts( 
        array(
            'category'            => '',
            'category_title'      => '',
            'layout'              => '',
            'title_color'         => '',
            'animation'           => ''
        ), $params ) );
    
    $html  = '';
    $html .='<style type="text/css">
                .products_category_vertical_shortcode_holder .heading a {
                    color: '.$title_color.' !important;
                }
            </style>';

    $term = get_term_by('slug', $category, 'product_cat');
    if ($term) {
        $img_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); 
        $img_id_2 = get_term_meta( $term->term_id, 'thumbnail_id', true );
        // get the image URL
        $thumbnail_src = wp_get_attachment_image_src( $img_id, 'groffer_testimonials_pic110x110' ); 
        $thumbnail_src_2 = wp_get_attachment_image_src( $img_id_2, 'groffer_cat_pic500x500' ); 

        $query_count = new WP_Query( array( 'product_cat' => $term->name ) );
        $count_tax = $query_count->found_posts;
        if($count_tax == 1) {
            $count_string = __(' Product in this Category', 'modeltheme');
        } else {
            $count_string = __(' Products in this Category', 'modeltheme');
        }

        if (isset($layout)) {
            if ($layout == '' || $layout == 'horizontal') {
                $block_type = 'products_category_image_shortcode_holder';
                $thumbnail_type = $thumbnail_src;
            }elseif($layout == 'vertical'){
                $block_type = 'products_category_vertical_shortcode_holder text-center';
                $thumbnail_type = $thumbnail_src_2;
            }
        }else{
            $block_type = 'products_category_image_shortcode_holder';
        }

        $html .= '<div class="products_category_image_shortcode">';
          $html .= '<div class="'.$block_type.'">';
            $html .= '<a href="'.get_term_link($term->term_id, 'product_cat').'"><img class="cat-image" alt="cat-image" src="'.$thumbnail_type[0].'"></a>';
            $html .= '<div class="listings_category_footer">';
              $html .= '<h4 class="heading"><a href="'.get_term_link($term->term_id, 'product_cat').'">'. $category .'</a></h4>';
              $html .= '<div class="description"><p>'. $count_tax . esc_attr($count_string) .'</p></div>';
            $html .= '</div>';
          $html .= '</div>';
        $html .= '</div>';
    }
    return $html;
}
add_shortcode('mt_groffer_category_image', 'groffer_shortcode_categories_image');


/*---------------------------------------------*/
/*--- Woocommerce Products Carousel ---*/
/*---------------------------------------------*/

function mt_carousel_products($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'number' => '',
            'navigation' => 'true',
            'navigationText' => '',
            'order' => 'desc',
            'pagination' => 'true',
            'autoPlay' => 'true',
            'button_text' => '',
            'button_link' => '',
            'button_background' => '',
            'paginationSpeed' => '700',
            'slideSpeed' => '700',
            'number_desktop' => '4',
            'number_tablets' => '2',
            'number_mobile' => '1'
        ), $params ) );


    $html = '';

    // CLASSES
    $class_slider = 'mt_carousel_products_'.uniqid();

    $html .= '<script>
                jQuery(document).ready( function() {
                    jQuery(".'.$class_slider.'").owlCarousel({
                        navigation      : '.$navigation.', // Show next and prev buttons
                        pagination      : '.$pagination.',
                        navigationText  : '.$navigationText.',
                        autoPlay        : '.$autoPlay.',
                        slideSpeed      : '.$paginationSpeed.',
                        paginationSpeed : '.$slideSpeed.',
                        autoWidth: true,
                        itemsCustom : [
                            [0,     '.$number_mobile.'],
                            [450,   '.$number_mobile.'],
                            [600,   '.$number_desktop.'],
                            [700,   '.$number_tablets.'],
                            [1000,  '.$number_tablets.'],
                            [1200,  '.$number_desktop.'],
                            [1400,  '.$number_desktop.'],
                            [1600,  '.$number_desktop.']
                        ]
                    });
                    
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item:nth-child(2)").addClass("hover_class");
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item").hover(
                  function () {
                    jQuery(".'.$class_slider.' .owl-wrapper .owl-item").removeClass("hover_class");
                    if(jQuery(this).hasClass("open")) {
                        jQuery(this).removeClass("open");
                    } else {
                    jQuery(this).addClass("open");
                    }
                  }
                );


                });
              </script>';

        $html .= '<div class="modeltheme_products_carousel '.$class_slider.' row  owl-carousel owl-theme">';
        $args_blogposts = array(
              'posts_per_page'   => $number,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish' 
         ); 
        $blogposts = get_posts($args_blogposts);
        
        foreach ($blogposts as $blogpost) {
                #metaboxes

                #thumbnail
                 $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $blogpost->ID ), 'groffer_portfolio_pic400x400' );
                 $product_cause = get_post_meta( $blogpost->ID, 'product_cause', true );
                if ($thumbnail_src) {
                    $post_img = '<img class="portfolio_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.$blogpost->post_title.'" />';
                    $post_col = 'col-md-12';
                  }else{
                    $post_col = 'col-md-12 no-featured-image';
                    $post_img = '';
                  }
            $html .= '<div id="product-id-'.esc_attr($blogpost->ID).'">
                        <div class="col-md-12 modeltheme-slider ">
                            <div class="modeltheme-slider-wrapper"> 
                              <div class="modeltheme-thumbnail-and-details">
                                <a class="modeltheme_media_image" title="'.esc_attr($blogpost->post_title).'" href="'.esc_url(get_permalink($blogpost->ID)).'"> '.$post_img.'</a>
                              </div>
                              <div class="modeltheme-title-metas text-center">
                                <h3 class="modeltheme-archive-product-title">
                                  <a href="'.esc_url(get_permalink($blogpost->ID)).'" title="'. $blogpost->post_title .'">'. $blogpost->post_title .'</a>
                                </h3>';
                    $html .= '</div>
                            </div>
                        </div>                     
                    </div>';
                }
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}
add_shortcode('mt-products-carousel', 'mt_carousel_products');


/*---------------------------------------------*/
/*--- Masonry Banners ---*/
/*---------------------------------------------*/
function groffer_shop_masonry_banners_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'default_skin_background_color'      => '',
            'dark_skin_background_color'         => '',
            'banner_1_img'                       => '',
            'banner_1_title'                     => '',
            'banner_1_count'                     => '',
            'banner_1_url'                       => '',
            'banner_2_img'                       => '',
            'banner_2_title'                     => '',
            'banner_2_count'                     => '',
            'banner_2_url'                       => '',
            'banner_3_img'                       => '',
            'banner_3_title'                     => '',
            'banner_3_count'                     => '',
            'banner_3_url'                       => '',
            'banner_4_img'                       => '',
            'banner_4_title'                     => '',
            'banner_4_count'                     => '',
            'banner_4_url'                       => '',
            'button_style'                       => ''
        ), $params ) );

    
    
    $shortcode_content = '';


    $shortcode_content .= '<div class="masonry_banners banners_column">';

        $img1 = wp_get_attachment_image_src($banner_1_img, "large");
        $img2 = wp_get_attachment_image_src($banner_2_img, "large");
        $img3 = wp_get_attachment_image_src($banner_3_img, "large");
        $img4 = wp_get_attachment_image_src($banner_4_img, "large");

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #1
            if (isset($img1) && !empty($img1)) {
                $shortcode_content .= '<div class="masonry_banner default-skin" style=" background-color: '.$default_skin_background_color.'!important;">';
                    $shortcode_content .= '<a href="'.$banner_1_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img1[0].'" alt="'.$banner_1_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_1_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_1_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
            #IMG #2
            if (isset($img2) && !empty($img2)) {
                $shortcode_content .= '<div class="masonry_banner dark-skin" style="background-color: '.$dark_skin_background_color.'!important;">';
                    $shortcode_content .= '<a href="'.$banner_2_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img2[0].'" alt="'.$banner_2_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_2_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_2_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
        $shortcode_content .= '</div>';

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #3
            if (isset($img3) && !empty($img3)) {
                $shortcode_content .= '<div class="masonry_banner dark-skin">';
                    $shortcode_content .= '<a href="'.$banner_3_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img3[0].'" alt="'.$banner_3_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_3_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_3_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
            #IMG #4
            if (isset($img4) && !empty($img4)) {
                $shortcode_content .= '<div class="masonry_banner default-skin">';
                    $shortcode_content .= '<a href="'.$banner_4_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img4[0].'" alt="'.$banner_4_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_4_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_4_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';

    return $shortcode_content;
}
add_shortcode('shop-masonry-banners', 'groffer_shop_masonry_banners_shortcode');


function groffer_domain_banners_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'default_skin_background_color'      => '',
            'dark_skin_background_color'         => '',
            'banner_1_img'                       => '',
            'banner_1_title'                     => '',
            'banner_1_count'                     => '',
            'banner_1_url'                       => '',
            'banner_2_img'                       => '',
            'banner_2_title'                     => '',
            'banner_2_count'                     => '',
            'banner_2_url'                       => '',
            'banner_3_img'                       => '',
            'banner_3_title'                     => '',
            'banner_3_count'                     => '',
            'banner_3_url'                       => '',
            'banner_1_prefix'                       => '',
            'banner_2_prefix'                       => '',
            'banner_3_prefix'                       => '',
            'button_style'                       => ''
        ), $params ) );

    
    
    $shortcode_content = '';


    $shortcode_content .= '<div class="masonry_banners banners_column domains">';

        $img1 = wp_get_attachment_image_src($banner_1_img, "large");
        $img2 = wp_get_attachment_image_src($banner_2_img, "large");
        $img3 = wp_get_attachment_image_src($banner_3_img, "large");

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #1
            if (isset($img1) && !empty($img1)) {
                $shortcode_content .= '<div class="masonry_banner default-skin" style=" background-color: '.$default_skin_background_color.'!important;">';
                    $shortcode_content .= '<a href="'.$banner_1_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img1[0].'" alt="'.$banner_1_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h2 class="category_prefix">'.$banner_1_prefix.'</h2>';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_1_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_1_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
        $shortcode_content .= '</div>';

        $shortcode_content .= '<div class="vc_col-md-6">';
            #IMG #3
            if (isset($img2) && !empty($img2)) {
                $shortcode_content .= '<div class="masonry_banner dark-skin">';
                    $shortcode_content .= '<a href="'.$banner_2_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img2[0].'" alt="'.$banner_2_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h2 class="category_prefix">'.$banner_2_prefix.'</h2>';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_2_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_2_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
            #IMG #4
            if (isset($img3) && !empty($img3)) {
                $shortcode_content .= '<div class="masonry_banner dark-skin">';
                    $shortcode_content .= '<a href="'.$banner_3_url.'" class="relative">';
                        $shortcode_content .= '<img src="'.$img3[0].'" alt="'.$banner_3_title.'" />';
                        $shortcode_content .= '<div class="masonry_holder">';
                            $shortcode_content .= '<h2 class="category_prefix">'.$banner_3_prefix.'</h2>';
                            $shortcode_content .= '<h3 class="category_name">'.$banner_3_title.'</h3>';
                             $shortcode_content .= '<p class="category_count">'.$banner_3_count.'</p>';
                            $shortcode_content .= '<span class="read-more '.$button_style.'">'.esc_html__('VIEW MORE', 'modeltheme').'</span>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';
            }
        $shortcode_content .= '</div>';
    $shortcode_content .= '</div>';

    return $shortcode_content;
}
add_shortcode('domain-masonry-banners', 'groffer_domain_banners_shortcode');

/*---------------------------------------------*/
/*--- Masonry Banners ---*/
/*---------------------------------------------*/
function groffer_shop_sale_banner_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'banner_img'            => '',
            'banner_button_text'    => '',
            'banner_button_count'   => '',
            'banner_button_url'     => '',
            'color_style'           => '',
            'layout'                => ''
        ), $params ) );

    $banner = wp_get_attachment_image_src($banner_img, "large");
    if (isset($layout)) {
        if ($layout == '' || $layout == 'right-center') {
            $layout_type = 'sale_banner_holder right';
        }elseif($layout == 'center'){
            $layout_type = 'sale_banner_center';
        }elseif($layout == 'bottom'){
            $layout_type = 'sale_banner_holder';
        }
    }else{
        $layout_type = 'sale_banner_holder';
    }

    $shortcode_content = '';
    #SALE BANNER
    $shortcode_content .= '<div class="sale_banner relative">';
            $shortcode_content .= '<img src="'.$banner[0].'" alt="'.$banner_button_text.'" />';
            $shortcode_content .= '<a href="'.$banner_button_url.'">
                                    <div class="'.$layout_type.'">';
                $shortcode_content .= '<div class="masonry_holder '.$color_style.'">';
                    $shortcode_content .= '<p class="category_count">'.$banner_button_count.'</p>';
                    $shortcode_content .= '<h3 class="category_name">'.$banner_button_text.'</h3>';
                    $shortcode_content .= '<span class="read-more">'.esc_html__('Shop Now', 'modeltheme').'</span>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</div></a>';
    $shortcode_content .= '</div>';
       
    return $shortcode_content;
}
add_shortcode('sale-banner', 'groffer_shop_sale_banner_shortcode');






/*---------------------------------------------*/
/*--- 28. BLOG POSTS ---*/
/*---------------------------------------------*/
function groffer_show_blog_post_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'            => '',
            'category'          => '',
            'overlay_color'     => '',
            'text_color'        => '',
            'columns'           => '',
            'version'           => '',
            'layout'            => '',
            'styles'            => '',
            'block_color'       => '',
            'date_color'        => ''
           ), $params ) );
    $args_posts = array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'post_status'           => 'publish' 
        );
    $posts = get_posts($args_posts);
    $shortcode_content = '';
    $shortcode_content .='<style type="text/css">
                            .head-content.style3 {
                                background: '.$block_color.' !important;
                            }
                            .head-content.style3 p{
                                color: '.$date_color.' !important;
                            }
                        </style>';
    $shortcode_content .= '<div class="groffer_shortcode_blog vc_row sticky-posts">';
    foreach ($posts as $post) { 
        $excerpt = get_post_field('post_content', $post->ID);
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_portfolio_pic400x400' );
        $thumbnail_src2 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_portfolio_pic700x450' );
        $author_id = $post->post_author;
        $url = get_permalink($post->ID);

        if ( $columns == 'col-md-6') {
            $column_type = 'col-md-6';
        }else{
            $column_type = 'col-md-4';
        } 

        $shortcode_content .= '<div class="'.$column_type.' post '.$layout.'">';
            if($layout == "image_left" || $layout == "") {
                
                    $shortcode_content .= '<div class="col-md-4 blog-thumbnail">';
                        $shortcode_content .= '<a href="'.$url.'" class="relative">';
                            if($thumbnail_src) { 
                                $shortcode_content .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                            }else{ 
                                $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                            }
                            $shortcode_content .= '<div class="thumbnail-overlay absolute" style="background: '.$overlay_color.'!important;">';
                                $shortcode_content .= '<i class="fa fa-plus absolute"></i>';
                            $shortcode_content .= '</div>';
                        $shortcode_content .= '</a>';
                    $shortcode_content .= '</div>';

                    $shortcode_content .= '<div class="col-md-8 blog-content">';
                     $shortcode_content .= '<p class="author">';
                                    $shortcode_content .= '<span class="post-tags">
                                      '.get_the_term_list( $post->ID, 'category', '', ', ' ).'
                                    </span>';
                                $shortcode_content .= '</p>';
                        $shortcode_content .= '<div class="head-content">';
                            $shortcode_content .= '<h3 class="post-name"><a href="'.$url.'" style="color: '.$text_color.'">'.$post->post_title.'</a></h3>';
                        $shortcode_content .= '</div>';
                        $shortcode_content .= '<div class="post-excerpt">'.wp_trim_words($excerpt,25).'</div>';
                        $shortcode_content .= '<div class="post-more-download">';
                            $shortcode_content .= '<div class="post-read-more">';
                                $shortcode_content .= '<a class="rippler rippler-default" href="'.$url.'">'. esc_html__( 'Read more', 'modeltheme' ).'</a>';
                            $shortcode_content .= '</div>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>'; 
            }else{

                if($styles == "style_1" || $styles == "") {
                    $shortcode_content .= '<div class="col-md-12 blog-thumbnail ">';
                        $shortcode_content .= '<a href="'.$url.'" class="relative">';
                            if($thumbnail_src) { 
                                $shortcode_content .= '<img src="'. $thumbnail_src2[0] . '" alt="'. $post->post_title .'" />';
                            }else{ 
                                $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                            }
                        $shortcode_content .= '</a>';
                        $shortcode_content .= '<div class="post-dates">
                                    <a href="'.get_the_permalink().'">
                                      <span class="blog_date blog_day">'.get_the_date( 'j', $post->ID).'</span>
                                      <span class="blog_date blog_month">'.get_the_date( 'M Y', $post->ID).'</span>
                                    </a>
                                </div>';
                $shortcode_content .= '</div>';

                $shortcode_content .= '<div class="col-md-12 blog-content">';
                $shortcode_content .= '<div class="content-element">';
                            $shortcode_content .= '<p class="author">';
                                $shortcode_content .= '<span class="post-tags">
                                  '.get_the_term_list( $post->ID, 'category', '', ', ' ).'
                                </span>';
                            $shortcode_content .= '</p>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '<div class="head-content">';
                        $shortcode_content .= '<h3 class="post-name"><a href="'.$url.'" style="color: '.$text_color.'">'.$post->post_title.'</a></h3>';
                $shortcode_content .= '</div>';
                    
                    $shortcode_content .= '<div class="post-excerpt">'.wp_trim_words($excerpt,16).'</div>';
                    $shortcode_content .= '<div class="post-more-download">';
                        $shortcode_content .= '<div class="post-read-more">';
                            $shortcode_content .= '<a class="rippler rippler-default" href="'.$url.'">'. esc_html__( 'Read more', 'modeltheme' ).'</a>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</div>';

            } else {

                if($styles == "style_3") {
                    $style   = 'text-left';
                    $version = 'style3';
                } else {
                    $style = 'text-center';
                }

                $shortcode_content .= '<div class="col-md-12 blog-thumbnail ">';
                    $shortcode_content .= '<a href="'.$url.'" class="relative">';
                        if($thumbnail_src) { 
                            $shortcode_content .= '<img src="'. $thumbnail_src2[0] . '" alt="'. $post->post_title .'" />';
                        }else{ 
                            $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                        }
                    $shortcode_content .= '</a>';
                $shortcode_content .= '</div>';

                $shortcode_content .= '<div class="boxed-shadow  col-md-12 blog-content">';
                
                    $shortcode_content .= '<div class="head-content '.$version.'">';
                        $shortcode_content .= '<p class="'.$style.'">' .get_the_date(get_option('date_format'), $post->ID).'</p>';
                        $shortcode_content .= '<h3 class="post-name '.$style.'"><a href="'.$url.'" style="color: '.$text_color.'">'.$post->post_title.'</a></h3>';
                         $shortcode_content .= '<div class="content-element '.$style.'">';
                            $shortcode_content .= '<p class="author ">';
                                $shortcode_content .= '<span class="post-tags">
                                  '.get_the_term_list( $post->ID, 'category', '', ', ' ).'
                                </span>';
                            $shortcode_content .= '</p>';
                        $shortcode_content .= '</div>';
                    $shortcode_content .= '</div>';
                   
                $shortcode_content .= '</div>';
                $shortcode_content .= '</div>';
            }
        }
    } 
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('groffer-blog-posts', 'groffer_show_blog_post_shortcode');


/*---------------------------------------------*/
/*--- 29. Social Media ---*/
/*---------------------------------------------*/
function groffer_social_icons_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'facebook'      => '',
            'twitter'       => '',
            'pinterest'     => '',
            'skype'         => '',
            'instagram'     => '',
            'youtube'       => '',
            'dribbble'      => '',
            'googleplus'    => '',
            'linkedin'      => '',
            'deviantart'    => '',
            'digg'          => '',
            'flickr'        => '',
            'stumbleupon'   => '',
            'tumblr'        => '',
            'vimeo'         => '',
            'animation'     => ''
        ), $params ) ); 
        $content = '';
        $content .= '<div class="sidebar-social-networks vc_social-networks widget_social_icons animateIn vc_row" data-animate="'.$animation.'">';
            $content .= '<ul class="vc_col-md-12">';
            if ( isset($facebook) && $facebook != '' ) {
                $content .= '<li><a href="'.esc_attr( $facebook ).'"><i class="fa fa-facebook"></i></a></li>';
            }
            if ( isset($twitter) && $twitter != '' ) {
                $content .= '<li><a href="'.esc_attr( $twitter ).'"><i class="fa fa-twitter"></i></a></li>';
            }
            if ( isset($pinterest) && $pinterest != '' ) {
                $content .= '<li><a href="'.esc_attr( $pinterest ).'"><i class="fa fa-pinterest"></i></a></li>';
            }
            if ( isset($youtube) && $youtube != '' ) {
                $content .= '<li><a href="'.esc_attr( $youtube ).'"><i class="fa fa-youtube"></i></a></li>';
            }
            if ( isset($instagram) && $instagram != '' ) {
                $content .= '<li><a href="'.esc_attr( $instagram ).'"><i class="fa fa-instagram"></i></a></li>';
            }
            if ( isset($linkedin) && $linkedin != '' ) {
                $content .= '<li><a href="'.esc_attr( $linkedin ).'"><i class="fa fa-linkedin"></i></a></li>';
            }
            if ( isset($skype) && $skype != '' ) {
                $content .= '<li><a href="skype:'.esc_attr( $skype ).'?call"><i class="fa fa-skype"></i></a></li>';
            }
            if ( isset($googleplus) && $googleplus != '' ) {
                $content .= '<li><a href="'.esc_attr( $googleplus ).'"><i class="fa fa-google-plus"></i></a></li>';
            }
            if ( isset($dribbble) && $dribbble != '' ) {
                $content .= '<li><a href="'.esc_attr( $dribbble ).'"><i class="fa fa-dribbble"></i></a></li>';
            }
            if ( isset($deviantart) && $deviantart != '' ) {
                $content .= '<li><a href="'.esc_attr( $deviantart ).'"><i class="fa fa-deviantart"></i></a></li>';
            }
            if ( isset($digg) && $digg != '' ) {
                $content .= '<li><a href="'.esc_attr( $digg ).'"><i class="fa fa-digg"></i></a></li>';
            }
            if ( isset($flickr) && $flickr != '' ) {
                $content .= '<li><a href="'.esc_attr( $flickr ).'"><i class="fa fa-flickr"></i></a></li>';
            }
            if ( isset($stumbleupon) && $stumbleupon != '' ) {
                $content .= '<li><a href="'.esc_attr( $stumbleupon ).'"><i class="fa fa-stumbleupon"></i></a></li>';
            }
            if ( isset($tumblr) && $tumblr != '' ) {
                $content .= '<li><a href="'.esc_attr( $tumblr ).'"><i class="fa fa-tumblr"></i></a></li>';
            }
            if ( isset($vimeo) && $vimeo != '' ) {
                $content .= '<li><a href="'.esc_attr( $vimeo ).'"><i class="fa fa-vimeo-square"></i></a></li>';
            }
            $content .= '</ul>';
        $content .= '</div>';
        return $content;
}
add_shortcode('social_icons', 'groffer_social_icons_shortcode');


include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// check for plugin using plugin name
if ( function_exists('vc_map') ) {
  require_once('vc-shortcodes.inc.php');
} 

/**

||-> Shortcode: Members Slider

*/

function mt_shortcode_members01($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation' => '',
            'number' => '',
            'navigation' => 'false',
            'order' => 'desc',
            'pagination' => 'false',
            'autoPlay' => 'false',
            'button_text' => '',
            'button_link' => '',
            'button_background' => '',
            'paginationSpeed' => '700',
            'slideSpeed' => '700',
            'number_desktop' => '4',
            'number_tablets' => '2',
            'number_mobile' => '1'
        ), $params ) );


    $html = '';



    // CLASSES
    $class_slider = 'mt_slider_members_'.uniqid();



    $html .= '<script>
                jQuery(document).ready( function() {
                    jQuery(".'.$class_slider.'").owlCarousel({
                        navigation      : '.$navigation.', // Show next and prev buttons
                        pagination      : '.$pagination.',
                        autoPlay        : '.$autoPlay.',
                        slideSpeed      : '.$paginationSpeed.',
                        paginationSpeed : '.$slideSpeed.',
                        autoWidth: true,
                        itemsCustom : [
                            [0,     '.$number_mobile.'],
                            [450,   '.$number_mobile.'],
                            [600,   '.$number_desktop.'],
                            [700,   '.$number_tablets.'],
                            [1000,  '.$number_tablets.'],
                            [1200,  '.$number_desktop.'],
                            [1400,  '.$number_desktop.'],
                            [1600,  '.$number_desktop.']
                        ]
                    });
                    
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item:nth-child(2)").addClass("hover_class");
                jQuery(".'.$class_slider.' .owl-wrapper .owl-item").hover(
                  function () {
                    jQuery(".'.$class_slider.' .owl-wrapper .owl-item").removeClass("hover_class");
                    if(jQuery(this).hasClass("open")) {
                        jQuery(this).removeClass("open");
                    } else {
                    jQuery(this).addClass("open");
                    }
                  }
                );


                });
              </script>';


        $html .= '<div class="mt_members1 '.$class_slider.' row animateIn wow '.$animation.'">';
        $args_members = array(
                'posts_per_page'   => $number,
                'orderby'          => 'post_date',
                'order'            => $order,
                'post_type'        => 'member',
                'post_status'      => 'publish' 
                ); 
        $members = get_posts($args_members);
            foreach ($members as $member) {
                #metaboxes
                $metabox_member_position = get_post_meta( $member->ID, 'av-job-position', true );

                $metabox_facebook_profile = get_post_meta( $member->ID, 'av-facebook-link', true );
                $metabox_twitter_profile  = get_post_meta( $member->ID, 'av-twitter-link', true );
                $metabox_linkedin_profile = get_post_meta( $member->ID, 'av-gplus-link', true );
                $metabox_vimeo_url = get_post_meta( $member->ID, 'av-instagram-link', true );

                $member_title = get_the_title( $member->ID );

                $testimonial_id = $member->ID;
                $content_post   = get_post($member);
                $content        = $content_post->post_content;
                $content        = apply_filters('the_content', $content);
                $content        = str_replace(']]>', ']]&gt;', $content);
                #thumbnail
                $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $member->ID ),'full' );

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
                                    
                                    <div class="memeber01-img-holder">';
                                        if($thumbnail_src) { 
                                            $html .= '<div class="grid">
                                                        <div class="effect-duke">
                                                            <img src="'. $thumbnail_src[0] . '" alt="'. $member->post_title .'" />
                                                        </div>
                                                      </div>';
                                        }else{ 
                                            $html .= '<img src="http://placehold.it/450x1000" alt="'. $member->post_title .'" />'; 
                                        }
                                    $html.='</div>
                                    
                                   </div>
                                   <div class="member01-content">
                                        <div class="member01-content-inside">
                                            <h3 class="member01_name">'.$member_title.'</h3>
                                            <div class="content-div"><p class="member01_content-desc">'.  $metabox_member_position. '</p></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>';

            }
    $html .= '</div>';
    wp_reset_postdata();
    return $html;
}
add_shortcode('mt_members_slider', 'mt_shortcode_members01');


function modeltheme_icon_listgroup_shortcode($params, $content) {
  extract( shortcode_atts( 
      array(
          'list_icon'               => '',
          'list_image'              => '',
          'list_image_max_width'    => '',
          'list_image_margin'       => '',
          'list_icon_size'          => '',
          'list_icon_margin'        => '',
          'list_icon_color'         => '',
          'list_icon__hover_color'  => '',
          'list_icon_title'         => '',
          'list_icon_url'           => '',
          'list_icon_title_size'    => '',
          'list_icon_title_color'   => '',
          'list_icon_subtitle'                => '',
          'list_icon_subtitle_size'      => '',
          'list_icon_subtitle_color'          => '',
          'animation'               => '',
      ), $params ) );
  $thumb      = wp_get_attachment_image_src($list_image, "full");
  $thumb_src  = $thumb[0];
  $html = '';
  if(!empty($list_icon__hover_color)) {
    $html .= '<style type="text/css">
                  .mt-icon-listgroup-holder:hover i {
                      color: '.$list_icon__hover_color.' !important;
                  }
              </style>';
  }
  $html .= '<div class="mt-icon-listgroup-item wow '.$animation.'">';
              if (!empty($list_icon_url)) {
                $html .= '<a href="'.$list_icon_url.'">';
              }
      $html .= '<div class="mt-icon-listgroup-holder">
                  <div class="mt-icon-listgroup-icon-holder-inner">';
                    if(empty($list_image)) {
                    $html .= '<i style="margin-right:'.esc_attr($list_icon_margin).'px; color:'.esc_attr($list_icon_color).';font-size:'.esc_attr($list_icon_size).'px" class="'.esc_attr($list_icon).'"></i>';
                    } else {
                      $html .='<img alt="list-image" style="margin-right:'.esc_attr($list_image_margin).'px;" class="mt-image-list" src="'.esc_attr($thumb_src).'">';
                    }
                  $html .= '</div>
                <div class="mt-icon-listgroup-content-holder-inner">
                  <p class="mt-icon-listgroup-title" style="font-size: '.esc_attr($list_icon_title_size).'px; color: '.esc_attr($list_icon_title_color).'">'.esc_attr($list_icon_title).'</p>
                  <p class="mt-icon-listgroup-text" style="font-size: '.esc_attr($list_icon_subtitle_size).'px; color: '.esc_attr($list_icon_subtitle_color).'">'.esc_attr($list_icon_subtitle).'</p>                  
                </div>
              </div>';
              if (!empty($list_icon_url)) {
                $html .= '</a>';
              }
            $html .= '</div>';
  return $html;
}
add_shortcode('mt_list_group', 'modeltheme_icon_listgroup_shortcode');
/**
||-> Map Shortcode in Visual Composer with: vc_map();
*/
if ( function_exists('vc_map') ) {
  vc_map( array(
     "name" => esc_attr__("groffer - Icon List Group Item", 'modeltheme'),
     "base" => "mt_list_group",
     "category" => esc_attr__('groffer', 'modeltheme'),
     "icon" => plugins_url( 'images/list-group.svg', __FILE__ ),
     "params" => array(
        array(
          "group" => "Image Setup",
          "type" => "attach_images",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__( "Choose image", 'modeltheme' ),
          "param_name" => "list_image",
          "value" => "",
          "description" => esc_attr__( "If you set this, will overwrite the icon setup.", 'modeltheme' )
        ),
        array(
          "group" => "Image Setup",
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Image max width", 'modeltheme'),
          "param_name" => "list_image_max_width",
          "value" => "50",
          "description" => "Default: 50(px)"
        ),
        array(
          "group" => "Image Setup",
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Image Margin right (px)", 'modeltheme'),
          "param_name" => "list_image_margin",
          "value" => "",
          "description" => ""
        ),
        array(
          "group" => "Icon Setup",
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Icon Size (px)", 'modeltheme'),
          "param_name" => "list_icon_size",
          "value" => "",
          "description" => "Default: 18(px)"
        ),
        array(
          "group" => "Icon Setup",
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Icon Margin right (px)", 'modeltheme'),
          "param_name" => "list_icon_margin",
          "value" => "",
          "description" => ""
        ),
        array(
          "group" => "Icon Setup",
          "type" => "colorpicker",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Icon Color", 'modeltheme'),
          "param_name" => "list_icon_color",
          "value" => "",
          "description" => ""
        ),
        array(
          "group" => "Icon Setup",
          "type" => "colorpicker",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Icon Hover Color", 'modeltheme'),
          "param_name" => "list_icon__hover_color",
          "value" => "",
          "description" => ""
        ),
        array(
          "group" => "Label Setup",
          "type" => "textfield",
          "heading" => esc_attr__("Label/Title", 'modeltheme'),
          "param_name" => "list_icon_title",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => "Eg: This is a label"
        ),
        array(
          "group" => "Label Setup",
          "type" => "textfield",
          "heading" => esc_attr__("Label/SubTitle", 'modeltheme'),
          "param_name" => "list_icon_subtitle",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => "Eg: This is a label"
        ),
        array(
          "group" => "Label Setup",
          "type" => "textfield",
          "heading" => esc_attr__("Label/Icon URL", 'modeltheme'),
          "param_name" => "list_icon_url",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => "Eg: http://modeltheme.com"
        ),
        array(
          "group" => "Label Setup",
          "type" => "textfield",
          "heading" => esc_attr__("Title Font Size", 'modeltheme'),
          "param_name" => "list_icon_title_size",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => ""
        ),
        array(
          "group" => "Label Setup",
          "type" => "colorpicker",
          "heading" => esc_attr__("Title Color", 'modeltheme'),
          "param_name" => "list_icon_title_color",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => ""
        ),
        array(
          "group" => "Label Setup",
          "type" => "textfield",
          "heading" => esc_attr__("SubTitle Font Size", 'modeltheme'),
          "param_name" => "list_icon_subtitle_size",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => ""
        ),
        array(
          "group" => "Label Setup",
          "type" => "colorpicker",
          "heading" => esc_attr__("SubTitle Color", 'modeltheme'),
          "param_name" => "list_icon_subtitle_color",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => ""
        ), 
     )
  ));
}

/*--------------------------------------------- */
/*--- 30. Countdown ---*/
/*---------------------------------------------*/
function groffer_countdown_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'date'                       => '',
            'digits_font_size'           => '',
            'digits_line_height'           => '',
            'texts_font_size'            => '',
            'texts_line_height'            => '',
            'digit_color'                => '',
            'text_color'                 => '',
            'dots_color'                 => '',
            'dots_font_size'                 => '',
            'dots_line_height'                 => ''
        ), $params ) );
    // DIGITS STYLE
    $digit_style = '';
    if (isset($digit_color)) {
      $digit_style .= 'color:'.esc_attr($digit_color).';';
    }
    if (isset($digits_font_size)) {
      $digit_style .= 'font-size: '.esc_attr($digits_font_size).' !important;';
    }
    if (isset($digits_line_height)) {
      $digit_style .= 'line-height: '.esc_attr($digits_line_height).' !important;';
    }
    // LABELS STYLE
    $text_style = '';
    if (isset($text_color)) {
      $text_style .= 'color:'.esc_attr($text_color).';';
    }
    if (isset($texts_font_size)) {
      $text_style .= 'font-size: '.esc_attr($texts_font_size).' !important;';
    }
    if (isset($digits_line_height)) {
      $text_style .= 'line-height: '.esc_attr($digits_line_height).' !important;';
    }
    // DOTS STYLE
    $dots_style = '';
    if (isset($dots_color)) {
      $dots_style = 'color:'.esc_attr($dots_color).';';
    }
    if (isset($dots_font_size)) {
      $dots_style .= 'font-size: '.esc_attr($dots_font_size).' !important;';
    }
    if (isset($dots_line_height)) {
      $dots_style .= 'line-height: '.esc_attr($dots_line_height).' !important;';
    }
    // YYYY/MM/DD hh:mm:ss
    // 
    $uniqueID = 'countdown_'.uniqid();
    $content = '';
    $content .= '<div class="text-center row"><div id="'.esc_attr($uniqueID).'" class="modeltheme-countdown"></div></div>';
    $content .= '<script type="text/javascript">
                  jQuery( document ).ready(function() {
                    //get each width
                    var width_days'.esc_attr($uniqueID).' = jQuery(\'.rev_slider #'.esc_attr($uniqueID).' .days-digit\').width();
                    var width_hours'.esc_attr($uniqueID).' = jQuery(\'.rev_slider #'.esc_attr($uniqueID).' .hours-digit\').width();
                    var width_minutes'.esc_attr($uniqueID).' = jQuery(\'.rev_slider #'.esc_attr($uniqueID).' .minutes-digit\').width();
                    var width_seconds'.esc_attr($uniqueID).' = jQuery(\'.rev_slider #'.esc_attr($uniqueID).' .seconds-digit\').width();
                    var width_dots'.esc_attr($uniqueID).' = jQuery(\'.rev_slider #'.esc_attr($uniqueID).' .c_dot\').width();
                    var width_dots_x3'.esc_attr($uniqueID).' = width_dots'.esc_attr($uniqueID).'*7;
                    //total width
                    var width_sum'.esc_attr($uniqueID).' = width_days'.esc_attr($uniqueID).'+width_hours'.esc_attr($uniqueID).'+width_minutes'.esc_attr($uniqueID).'+width_seconds'.esc_attr($uniqueID).'+width_dots_x3'.esc_attr($uniqueID).';
                    //test
                    //console.log(width_sum'.esc_attr($uniqueID).');
                    //apply width
                    jQuery(".rev_slider #'.esc_attr($uniqueID).'").width(width_sum'.esc_attr($uniqueID).');
                    jQuery("#'.esc_attr($uniqueID).'").countdown("'.esc_attr($date).'", function(event) {
                      jQuery(this).html(
                        event.strftime("<div class=\'days\'>"
                                          +"<div class=\'days-digit\' style=\''.esc_attr($digit_style).'\'>%D</div>"
                                          +"<div class=\'clearfix\'></div>"
                                          +"<div class=\'days-name\' style=\''.esc_attr($text_style).'\'>Days</div>"
                                        +"</div>"
                                        +"<span class=\'c_dot\' style=\''.esc_attr($dots_style).'\'>&middot;</span>"
                                        +"<div class=\'hours\'>"
                                          +"<div class=\'hours-digit\'  style=\''.esc_attr($digit_style).'\'>%H</div>"
                                          +"<div class=\'clearfix\'></div>"
                                          +"<div class=\'hours-name\' style=\''.esc_attr($text_style).'\'>Hours</div>"
                                        +"</div>"
                                        +"<span class=\'c_dot\' style=\''.esc_attr($dots_style).'\'>&middot;</span>"
                                        +"<div class=\'minutes\'>"
                                          +"<div class=\'minutes-digit\' style=\''.esc_attr($digit_style).'\'>%M</div>"
                                          +"<div class=\'clearfix\'></div>"
                                          +"<div class=\'minutes-name\' style=\''.esc_attr($text_style).'\'>Minutes</div>"
                                        +"</div>"
                                        +"<span class=\'c_dot\' style=\''.esc_attr($dots_style).'\'>&middot;</span>"
                                        +"<div class=\'seconds\'>"
                                          +"<div class=\'seconds-digit\' style=\''.esc_attr($digit_style).'\'>%S</div>"
                                          +"<div class=\'clearfix\'></div>"
                                          +"<div class=\'seconds-name\' style=\''.esc_attr($text_style).'\'>Seconds</div>"
                                        +"</div>")
                      );
                    });
                  });
                </script>';
    return $content;
}
add_shortcode('mt-countdown', 'groffer_countdown_shortcode');

/*--------------------------------------------- */
/*--- 30. Countdown version 2 ---*/
/*---------------------------------------------*/
function modeltheme_shortcode_countdown_version_2($params, $content) {

    extract( shortcode_atts( 
        array(
            'animation'                 => '',
            'insert_date'               => '',
            'el_class'              => ''
        ), $params ) );

    $html = '';
    
    $uniqueID = 'countdown_'.uniqid();

    // custom javascript
    $html .= '<script type="text/javascript">
      var clock;

      jQuery(document).ready(function() {

        // Grab the current date
        var currentDate = new Date();

        // Grab the date inserted by user
        var inserted_date = new Date("'.$insert_date.'");

        // Calculate the difference in seconds between the future and current date
        var diff = inserted_date.getTime() / 1000 - currentDate.getTime() / 1000;

        // Instantiate a coutdown FlipClock
        clock = jQuery("#'.$uniqueID.'").FlipClock(diff, {
          clockFace: "DailyCounter",
          countdown: true
        });
      });
    </script>';

              
    $html .= '<div class="countdownv2_holder '.$el_class.'">';
        $html .= '<div class="countdownv2 clock " id="'.$uniqueID.'"></div>';
    $html .= '</div>';
    

      

    return $html;
}

add_shortcode('shortcode_countdown_v2', 'modeltheme_shortcode_countdown_version_2');


/**

||-> Shortcode: Featured Product

*/
function modeltheme_shortcode_featured_product($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                       =>'',
            'category_text_color'             =>'',
            'product_name_text_color'         =>'',
            'background_color'                =>'',
            'price_text_color'                =>'',
            'button_background_color1'        =>'',
            'button_background_color2'        =>'',
            'button_text_color'               =>'',
            'button_text'                     =>'',
            'subtitle_product'                =>'',
            'select_product'                  =>''
        ), $params ) );
    

    $html = '';

    


    $html .= '<div class="featured_product_shortcode col-md-12 wow '.$animation.' " style=" background-color: '.$background_color.';">';
      $args_blogposts = array(
              'posts_per_page'   => 1,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish' 
              ); 

              
      $blogposts = get_posts($args_blogposts);
      

      foreach ($blogposts as $blogpost) {
      global $woocommerce, $product, $post;
      $product = new WC_Product($select_product);
      $content_post = get_post($select_product);
      $content = $content_post->post_content;
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);

        $html .= '<div class="featured_product_image_holder col-md-6">';
          if ( has_post_thumbnail( $select_product ) ) {
              $attachment_ids[0] = get_post_thumbnail_id( $select_product );
              $attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' );   
              $html.='<img class="featured_product_image" src="'.$attachment[0].'" alt="'.get_the_title($select_product).'" />';
             }
        $html .= '</div>';

        $html .= '<div class="featured_product_details_holder  col-md-6">';
          $html.='<h2 class="featured_product_categories" style="color: '.$category_text_color.';">'.$subtitle_product.'</h2>';
          $html.='<h1 class="featured_product_name" style="color: '.$product_name_text_color.';">
                    <a href="'.get_permalink($select_product).'">'.get_the_title($select_product).'</a>

                  </h1>';
          
          $html.='<h3 class="featured_product_price" style="color: '.$price_text_color.';">' .esc_html__("Current bid :","modeltheme").' '.$product->get_price_html().'</h2>';
          $html.='<div class="featured_product_description">'.$content.'</div>';
          $html.='<div class="featured_product_countdown">
                    
                 '.do_shortcode('[shortcode_countdown_v2 insert_date="'.esc_attr(date_format($date, 'Y-m-d')).'"]').'</div>';
       
          $html.='<a class="featured_product_button" href="'.get_permalink($select_product).'?add-to-cart='.$select_product.'" target="_blank" style="color: '.$button_text_color.';background: '.esc_attr($button_background_color1).';">'.$button_text.'</a>';

        $html .= '</div>';

      }
    $html .= '</div>';
    return $html;
}
add_shortcode('featured_product', 'modeltheme_shortcode_featured_product');

/**

||-> Shortcode: Featured Product

*/
function modeltheme_shortcode_featured_simple_product($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                       =>'',
            'category_text_color'             =>'',
            'product_name_text_color'         =>'',
            'price_text_color'                =>'',
            'subtitle_product'                =>'',
            'bar_value'                       =>'',
            'progress_bg'                     =>'',
            'countdown_opt'                   =>'',
            'subtitle_countdown'              =>'',
            'countdown_bg'                    =>'',
            'countdown_color'                 =>'',
            'featured_img'                    =>'',
            'product_img'                     =>'',
            'select_product'                  =>''
        ), $params ) );
    

    $html = '';
    $html .='<style type="text/css">
                .featured_product_shortcode .featured_product_name a {
                    color: '.$product_name_text_color.' !important;
                }
                .featured_product_shortcode.simple span.amount{
                    color: '.$price_text_color.' !important;
                }
                .featured_product_shortcode.simple .featured_product_description p{
                    color: '.$category_text_color.' !important;
                }
                .featured_product_shortcode.simple .progress-bar-success{
                    background: '.$progress_bg.' !important;
                }
                .featured_product_shortcode.simple .featured_countdown .row div{
                    color: '.$countdown_color.' !important;
                }
                .featured_product_shortcode.simple .featured_countdown .row .days-digit, 
                .featured_product_shortcode.simple .featured_countdown .row .hours-digit, 
                .featured_product_shortcode.simple .featured_countdown .row .minutes-digit, 
                .featured_product_shortcode.simple .featured_countdown .row .seconds-digit {
                    background: '.$countdown_bg.' !important;
                }
            </style>';
    $html .= '<div class="featured_product_shortcode simple col-md-12 wow '.$animation.' ">';
        $args_blogposts = array(
              'posts_per_page'   => 1,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish' 
        ); 
         
    $blogposts = get_posts($args_blogposts);
      
    foreach ($blogposts as $blogpost) {
        global $woocommerce, $product, $post;
        $product = new WC_Product($select_product);
        $content_post = get_post($select_product);
        $content = $content_post->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]&gt;', $content);

        $product_img      = wp_get_attachment_image_src($product_img, "linify_skill_counter_65x65");
        $product_imgsrc  = $product_img[0];
        if($featured_img == 'choosed_nothing' or $featured_img == ''){
            $html .= '<div class="featured_product_image_holder col-md-6">';
                if ( has_post_thumbnail( $select_product ) ) {
                    $attachment_ids[0] = get_post_thumbnail_id( $select_product );
                    $attachment = wp_get_attachment_image_src($attachment_ids[0], 'full' );   
                    $html.='<img class="featured_product_image" src="'.$attachment[0].'" alt="'.get_the_title($select_product).'" />';
                }
            $html .= '</div>';
        } elseif($featured_img == 'custom_image') {
            $html .= '<div class="featured_product_image_holder col-md-6">';
                $html .= '<img src="'.esc_attr($product_imgsrc).'" data-src="'.esc_attr($product_imgsrc).'" alt="">';
            $html .= '</div>';
        }
        $html .= '<div class="featured_product_details_holder  col-md-6">';  
            $html.='<h2 class="featured_product_name">
                        <a href="'.get_permalink($select_product).'">'.get_the_title($select_product).'</a>
                    </h2>';
           
            $html.='<h3 class="featured_product_price">'.$product->get_price_html().'</h3>';

            $html.='<div class="featured_product_description">'.groffer_excerpt_limit($content,15).'</div>';

            if($subtitle_product) {
                $html.='<p class="featured_product_categories" style="color: '.$category_text_color.';">'.$subtitle_product.'</p>';
            }
            $html.='<div class="progress">';
                $html.='<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar_value.'%"></div>';   
            $html.='</div>';
            
            if($countdown_opt) {
                $html.='<p class="featured_product_categories" style="color: '.$category_text_color.';">'.$subtitle_countdown.'</p>';
                $html.='<div class="featured_countdown">'.do_shortcode('[mt-countdown date="'.$countdown_opt.'"]').'</div>';
            }
        $html.='</div>';
      }
    $html .= '</div>';
    return $html;
}
add_shortcode('featured_simple_product', 'modeltheme_shortcode_featured_simple_product');

/**

||-> Shortcode: Featured Product no image

*/
function modeltheme_shortcode_featured_no_image($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                       =>'',
            'category_text_color'             =>'',
            'product_name_text_color'         =>'',
            'background_color'                =>'',
            'price_text_color'                =>'',
            'button_background_color1'        =>'',
            'button_background_color2'        =>'',
            'button_text_color'               =>'',
            'button_text'                     =>'',
            'subtitle_product'                =>'',
            'select_product'                  =>''
        ), $params ) );
    

    $html = '';

    


    $html .= '<div class="featured_product_shortcode v2 col-md-12 wow '.$animation.' " style=" background-color: '.$background_color.';">';
      $args_blogposts = array(
              'posts_per_page'   => 1,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'post_status'      => 'publish' 
              ); 

              
      $blogposts = get_posts($args_blogposts);


      foreach ($blogposts as $blogpost) {
      global $woocommerce, $product, $post;
      $product = new WC_Product($select_product);
      $content_post = get_post($select_product);
      $content = $content_post->post_content;

      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);


        $html .= '<div class="featured_product_details_holder col-md-12">';
          $html.='<h2 class="featured_product_categories" style="color: '.$category_text_color.';">'.$subtitle_product.'</h2>';
          $html.='<h1 class="featured_product_name" style="color: '.$product_name_text_color.';">
                    <a href="'.get_permalink($select_product).'">'.get_the_title($select_product).'</a>

                  </h1>';
          
          
          $html.='<div class="featured_product_description">'.$content.'</div>';
          $html.='<div class="featured_product_countdown">
                    
                 '.do_shortcode('[shortcode_countdown_v2 insert_date="'.esc_attr(date_format($date, 'Y-m-d')).'"]').'</div>';

          $html.='<a class="featured_product_button" href="'.get_permalink($select_product).'?add-to-cart='.$select_product.'" target="_blank" style="color: '.$button_text_color.';background: '.esc_attr($button_background_color1).';">'.$button_text.'</a>';
          $html.='<p class="featured_product_price" style="color: '.$price_text_color.';">' .esc_html__("Current bid :","modeltheme").' '.$product->get_price_html().'</p>';

        $html .= '</div>';


      }
    $html .= '</div>';
    return $html;
}
add_shortcode('featured_product_no_image', 'modeltheme_shortcode_featured_no_image');

/**

||-> Shortcode: Crypto Featured

*/
function modeltheme_shortcode_crypto_featured_product($params, $content) {
    extract( shortcode_atts( 
        array(
            'animation'                       =>'',
            'category_text_color'             =>'',
            'product_name_text_color'         =>'',
            'price_text_color'                =>'',
            'title_crypto'                    =>'',
            'subtitle_product'                =>'',
            'bar_value'                       =>'',
            'progress_bg'                     =>'',
            'countdown_opt'                   =>'',
            'subtitle_countdown'              =>'',
            'countdown_bg'                    =>'',
            'countdown_color'                 =>'',
            'featured_img'                    =>'',
            'product_img'                     =>'',
            'block_bg'                        =>'',
            'select_product'                  =>''
        ), $params ) );
    

    $html = '';
    $html .='<style type="text/css">
                .featured_crypto_shortcode .featured_crypto_name {
                    color: '.$product_name_text_color.' !important;
                }
                .featured_crypto_shortcode span.amount{
                    color: '.$price_text_color.' !important;
                }
                .featured_crypto_shortcode .featured_crypto_description p{
                    color: '.$category_text_color.' !important;
                }
                .featured_crypto_details_holder{
                    background: '.$block_bg.' !important;
                }
                .featured_crypto_shortcode .progress-bar-success{
                    background: '.$progress_bg.' !important;
                }
                .featured_crypto_shortcode .featured_countdown .row div{
                    color: '.$countdown_color.' !important;
                }
                .featured_crypto_shortcode .featured_countdown .row .days-digit, 
                .featured_crypto_shortcode .featured_countdown .row .hours-digit, 
                .featured_crypto_shortcode .featured_countdown .row .minutes-digit, 
                .featured_crypto_shortcode .featured_countdown .row .seconds-digit {
                    background: '.$countdown_bg.' !important;
                }
            </style>';
    $html .= '<div class="featured_crypto_shortcode col-md-12 wow '.$animation.' ">';
  
        $html .= '<div class="featured_crypto_details_holder">';  
            $html.='<h2 class="featured_crypto_name text-center">'.$title_crypto.'</h2>';

            if($countdown_opt) {
                $html.='<p class="featured_crypto_categories text-center" style="color: '.$category_text_color.';">'.$subtitle_countdown.'</p>';
                $html.='<div class="featured_countdown">'.do_shortcode('[mt-countdown date="'.$countdown_opt.'"]').'</div>';
            }
            $html.='<div class="featured_crypto_btn"><a class="button btn" href="#">Get Token</a></div>';
            if($subtitle_product) {
                $html.='<p class="featured_crypto_categories" style="color: '.$category_text_color.';">'.$subtitle_product.'</p>';
            }
            $html.='<div class="progress">';
                $html.='<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$bar_value.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$bar_value.'%"></div>';   
            $html.='</div>';
            
            
        $html.='</div>';
    $html .= '</div>';
    return $html;
}
add_shortcode('featured_crypto', 'modeltheme_shortcode_crypto_featured_product');

/*---------------------------------------------*/
/*--- Custom Images with Links ---*/
/*---------------------------------------------*/
function groffer_custom_images_links_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'banner_img'            => '',
            'banner_button_text'    => '',
            'banner_button_count'   => '',
            'banner_button_url'     => ''
        ), $params ) );

    $banner = wp_get_attachment_image_src($banner_img, "groffer_cat_pic500x500");

    $shortcode_content = '';
    #SALE BANNER
    $shortcode_content .= '<div class="custom_pages_links relative">';
            $shortcode_content .= '<img src="'.$banner[0].'" alt="'.$banner_button_text.'" />';
            $shortcode_content .= '<a href="'.$banner_button_url.'">
                                    <div class="custom_pages_links_holder">';
                $shortcode_content .= '<div class="masonry_holder">';
                    $shortcode_content .= '<h3 class="category_name">'.$banner_button_text.'</h3>';
                    $shortcode_content .= '<p class="category_count">'.$banner_button_count.'</p>';
                $shortcode_content .= '</div>';
            $shortcode_content .= '</div></a>';
    $shortcode_content .= '</div>';
       
    return $shortcode_content;
}
add_shortcode('custom-images-links', 'groffer_custom_images_links_shortcode');


/*---------------------------------------------*/
/*--- BLOG POSTS version 2 ---*/
/*---------------------------------------------*/
function groffer_blog_post_2_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'            => '',
            'category'          => '',
            'overlay_color'     => '',
            'text_color'        => '',
            'columns'           => '',
            'layout'            => ''
           ), $params ) );
    $args_posts = array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'post_status'           => 'publish' 
        );
    $posts = get_posts($args_posts);
    $shortcode_content = '';
    $shortcode_content .= '<div class="groffer_shortcode_blog_v2 vc_row sticky-posts">';
    foreach ($posts as $post) { 
        $excerpt = get_post_field('post_content', $post->ID);
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_post_pic700x450' );
        $thumbnail_src2 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_blog_500x800' );
        $author_id = $post->post_author;
        $url = get_permalink($post->ID); 
        $shortcode_content .= '<div class="'.$columns.' post '.$layout.'">';

        if($layout == "horizontal" || $layout == "") {
            $shortcode_content .= '<div class="col-md-12 blog-thumbnail">';
                $shortcode_content .= '<a href="'.$url.'" class="relative">';
                    if($thumbnail_src) { 
                        $shortcode_content .= '<img src="'. $thumbnail_src[0] . '" alt="'. $post->post_title .'" />';
                    }else{ 
                        $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                    }
                    $shortcode_content .= '<div class="thumbnail-overlay absolute" style="background: '.$overlay_color.'!important;">';
                        $shortcode_content .= '<i class="fa fa-plus absolute"></i>';
                    $shortcode_content .= '</div>';
                $shortcode_content .= '</a>';
                $shortcode_content .= '<p class="author">';
                            $shortcode_content .= '<span class="post-tags">
                              '.get_the_term_list( $post->ID, 'category', '', ', ' ).'
                            </span>';
                        $shortcode_content .= '</p>';
                
                $shortcode_content .= '<div class="col-md-12 blog-content">';
                 
                $shortcode_content .= '<div class="head-content">';
                    $shortcode_content .= '<h3 class="post-name"><a href="'.$url.'" style="color: '.$text_color.'">'.$post->post_title.'</a></h3>';
                $shortcode_content .= '</div>';
                $shortcode_content .= '<div class="post-dates">
                              <a href="'.get_the_permalink().'">
                                  <span class="blog_date blog_day">'.get_the_date( 'j', $post->ID).'</span>
                                  <span class="blog_date blog_month">'.get_the_date( 'M Y', $post->ID).'</span>
                              </a>
                          </div>';
              $shortcode_content .= '</div>';
            $shortcode_content .= '</div>';
        $shortcode_content .= '</div>';
        }else{
            $shortcode_content .= '<div class="col-md-12 blog-thumbnail ">';
                $shortcode_content .= '<a href="'.$url.'" class="relative">';
                    if($thumbnail_src) { 
                        $shortcode_content .= '<img src="'. $thumbnail_src2[0] . '" alt="'. $post->post_title .'" />';
                    }else{ 
                        $shortcode_content .= '<img src="http://placehold.it/700x450" alt="'. $post->post_title .'" />'; 
                    }
              
                $shortcode_content .= '</a>';
                $shortcode_content .= '<p class="author">';
                            $shortcode_content .= '<span class="post-tags">
                              '.get_the_term_list( $post->ID, 'category', '', ', ' ).'
                            </span>';
                        $shortcode_content .= '</p>';
            $shortcode_content .= '</div>';

            $shortcode_content .= '<div class="col-md-12 blog-content">';

            $shortcode_content .= '<div class="head-content">';
                    $shortcode_content .= '<h3 class="post-name"><a href="'.$url.'" style="color: '.$text_color.'">'.$post->post_title.'</a></h3>';
                $shortcode_content .= '</div>';
                $shortcode_content .= '<div class="post-dates">
                              <a href="'.get_the_permalink().'">
                                  <span class="blog_date blog_day">'.get_the_date( 'j', $post->ID).'</span>
                                  <span class="blog_date blog_month">'.get_the_date( 'M Y', $post->ID).'</span>
                              </a>
                          </div>';
            $shortcode_content .= '</div>';
            $shortcode_content .= '</div>';
        }
    } 
    $shortcode_content .= '</div>';
    return $shortcode_content;
}
add_shortcode('groffer-blog-posts-2', 'groffer_blog_post_2_shortcode');


/*---------------------------------------------*/
/*--- Category Tabs Version 2 ---*/
/*---------------------------------------------*/


function modeltheme_tabs_categories2_shortcode($params, $content) {
    extract( shortcode_atts( 
        array(
            'tabs_item_title_tab1'             => '',
            'tabs_item_subtitle_tab1'          => '',
            'tabs_item_button_text1'            => '',
            'tabs_item_button_link1'            => '',
            'tabs_item_number_tab1'            => '',
            'tabs_item_img1'                  => '',
            'tabs_item_img2'                  => '',
            'tabs_item_img3'                  => '',
            'tabs_item_img4'                  => '',
            'tabs_item_img5'                  => '',
            'tabs_item_icon1'   => '',
            'tabs_item_icon2'   => '',
            'tabs_item_icon3'   => '',
            'tabs_item_icon4'   => '',
            'tabs_item_icon5'   => '',
            'tabs_item_title_tab2'             => '',
            'tabs_item_subtitle_tab2'          => '',
            'tabs_item_button_text2'            => '',
            'tabs_item_button_link2'            => '',
            'tabs_item_number_tab2'            => '',
            'tabs_item_title_tab3'             => '',
            'tabs_item_subtitle_tab3'          => '',
            'tabs_item_button_text3'            => '',
            'tabs_item_button_link3'            => '',
            'tabs_item_number_tab3'            => '',
            'tabs_item_title_tab4'             => '',
            'tabs_item_subtitle_tab4'          => '',
            'tabs_item_button_text4'            => '',
            'tabs_item_button_link4'            => '',
            'tabs_item_number_tab4'            => '',
            'tabs_item_title_tab5'             => '',
            'tabs_item_subtitle_tab5'          => '',
            'tabs_item_button_text5'            => '',
            'tabs_item_button_link5'            => '',
            'tabs_item_number_tab5'            => '',

        ), $params ) );

    //$vc_css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'mt_tabs_categories', $params );
    $tabs_item_img1 = wp_get_attachment_image_src($tabs_item_img1, "smartowl_500x500");
    $tabs_item_img2 = wp_get_attachment_image_src($tabs_item_img2, "smartowl_500x500");
    $tabs_item_img3 = wp_get_attachment_image_src($tabs_item_img3, "smartowl_500x500");
    $tabs_item_img4 = wp_get_attachment_image_src($tabs_item_img4, "smartowl_500x500");
    $tabs_item_img5 = wp_get_attachment_image_src($tabs_item_img5, "smartowl_500x500");
    $tabs_item_icon1 = wp_get_attachment_image_src($tabs_item_icon1, "smartowl_500x500");
    $tabs_item_icon2 = wp_get_attachment_image_src($tabs_item_icon2, "smartowl_500x500");
    $tabs_item_icon3 = wp_get_attachment_image_src($tabs_item_icon3, "smartowl_500x500");
    $tabs_item_icon4 = wp_get_attachment_image_src($tabs_item_icon4, "smartowl_500x500");
    $tabs_item_icon5 = wp_get_attachment_image_src($tabs_item_icon5, "smartowl_500x500");

    // param groups
    $description_content_tab1 = vc_param_group_parse_atts($params['icon_description_content_tab1']);
    $description_content_tab2 = vc_param_group_parse_atts($params['icon_description_content_tab2']);
    $description_content_tab3 = vc_param_group_parse_atts($params['icon_description_content_tab3']);
    $description_content_tab4 = vc_param_group_parse_atts($params['icon_description_content_tab4']);
    $description_content_tab5 = vc_param_group_parse_atts($params['icon_description_content_tab5']);

    // Adding the font families into the $icon_font_families var
    $icon_font_families = array();
    $groups = array(
        $description_content_tab1,
        $description_content_tab2,
        $description_content_tab3,
        $description_content_tab4,
        $description_content_tab5,
    );

    if ($groups) {
        foreach($groups as $group){
            if ($group) {
                foreach($group as $inner_group){
                    if (isset($inner_group['tabs_item_service_icon_dropdown']) && !empty($inner_group['tabs_item_service_icon_dropdown'])) {
                        array_push($icon_font_families, $inner_group['tabs_item_service_icon_dropdown']);
                    }
                }
            }
        }
    }

    // Unique font families array
    $icon_font_families = array_unique($icon_font_families);
    if ($icon_font_families) {
        foreach($icon_font_families as $font){
            vc_icon_element_fonts_enqueue( $font );
        }
    }

    // echo '<pre>' . var_export($icon_font_families, true) . '</pre>';
    $content = '';
    $content .= '<section class="mt-tabs">
            <div class="tabs tabs-style-iconbox">
                <nav>
                    <ul>';

                    if (!empty($tabs_item_img1) || !empty($tabs_item_icon1) || !empty($tabs_item_title_tab1) ) {
                        $content .= '<li><a href="#section-iconbox-1" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon1[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab1.'</h5>
                        </a></li>';
                    }

                    if (!empty($tabs_item_img2) || !empty($tabs_item_icon2) || !empty($tabs_item_title_tab2)) {
                        $content .= '<li><a href="#section-iconbox-2" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon2[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab2.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img3) || !empty($tabs_item_icon3) || !empty($tabs_item_title_tab3)) {
                        $content .= '<li><a href="#section-iconbox-3" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon3[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab3.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img4) || !empty($tabs_item_icon4) || !empty($tabs_item_title_tab4)) {
                        $content .= '<li><a href="#section-iconbox-4" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon4[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab4.'</h5>
                        </a></li>';
                    }
                        
                    if (!empty($tabs_item_img5) || !empty($tabs_item_icon5) || !empty($tabs_item_title_tab5)) {
                        $content .= '<li><a href="#section-iconbox-5" class="list-icon-title">
                            <img class="tabs_icon" src="'.esc_attr($tabs_item_icon5[0]).'" alt="tabs-image">
                            <h5 class="tab-title">'.$tabs_item_title_tab5.'</h5>
                        </a></li>';
                    }
                    $content .= '</ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img1[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_subtitle_tab1.'</h3>';
                                $content .= '<ul>';
                                    $content .= groffer_get_tabs_param_group_li($description_content_tab1);
                                $content .= '</ul>';
                                $content .= '<a href="'.$tabs_item_button_link1.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text1.'</a>
                                <h4 class="tabs_number"> <i class="fa fa-volume-control-phone" aria-hidden="true"> </i> '.$tabs_item_number_tab1.'</h4>
                            </div>
                        </div>                     
                    </section>
                   
                    <section id="section-iconbox-2">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img2[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_subtitle_tab2.'</h3>';
                                $content .= '<ul>';
                                    $content .= groffer_get_tabs_param_group_li($description_content_tab2);
                                $content .= '</ul>';
                                $content .= '<a href="'.$tabs_item_button_link2.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text2.'</a>
                                <h4 class="tabs_number"> <i class="fa fa-volume-control-phone" aria-hidden="true"> </i> '.$tabs_item_number_tab2.'</h4>

                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-3">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img3[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_subtitle_tab3.'</h3>';
                                $content .= '<ul>';
                                    $content .= groffer_get_tabs_param_group_li($description_content_tab3);
                                $content .= '</ul>';
                                $content .= '<a href="'.$tabs_item_button_link3.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text3.'</a>
                                <h4 class="tabs_number"> <i class="fa fa-volume-control-phone" aria-hidden="true"> </i> '.$tabs_item_number_tab3.'</h4>

                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-4">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img4[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_subtitle_tab4.'</h3>';
                                $content .= '<ul>';
                                    $content .= groffer_get_tabs_param_group_li($description_content_tab4);
                                $content .= '</ul>';
                                $content .= '<a href="'.$tabs_item_button_link4.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text4.'</a>
                                <h4 class="tabs_number"> <i class="fa fa-volume-control-phone" aria-hidden="true"> </i> '.$tabs_item_number_tab4.'</h4>

                            </div>
                        </div>
                    </section>
                    
                    <section id="section-iconbox-5">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img class="tabs_image" src="'.esc_attr($tabs_item_img5[0]).'" alt="tabs-image">
                            </div>
                            <div class="col-md-6">
                                <h3 class="tabs_title">'.$tabs_item_subtitle_tab5.'</h3>';
                                $content .= '<ul>';
                                    $content .= groffer_get_tabs_param_group_li($description_content_tab4);
                                $content .= '</ul>';
                                $content .= '<a href="'.$tabs_item_button_link5.'" class="rippler rippler-default button-winona btn btn-lg tabs_button">'.$tabs_item_button_text5.'</a>
                                <h4 class="tabs_number"> <i class="fa fa-volume-control-phone" aria-hidden="true"> </i> '.$tabs_item_number_tab5.'</h4>

                            </div>
                        </div>
                    </section>
                </div><!-- /content -->
            </div><!-- /tabs -->
        </section>';

    return $content;
}
add_shortcode('mt_categories_tabs2', 'modeltheme_tabs_categories2_shortcode');



function groffer_get_tabs_param_group_li($param_group){

    $html = '';

    if ($param_group) {
        foreach($param_group as $param){
            // var_dump($param);
            $icon = $title = $value = '';
            if($param['tabs_item_service_icon_dropdown'] == 'fontawesome'){
                $icon = $param['tabs_item_service_icon_fa'];
            }elseif($param['tabs_item_service_icon_dropdown'] == 'linecons'){
                $icon = $param['tabs_item_service_icon__lineicons'];
            }

            #title
            if (isset($param['tabs_item_service_title']) && !empty($param['tabs_item_service_title'])) {
                $title = $param['tabs_item_service_title'];
            } 

            #value
            if (isset($param['tabs_item_service_value']) && !empty($param['tabs_item_service_value'])) {
                $value = $param['tabs_item_service_value'];
            } 

            $html .= '<li><i class="'.$icon.'"></i> '.$title.' <strong>'.$value.'</strong></li>';
        }
    }

    return $html;
}
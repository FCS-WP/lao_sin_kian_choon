<?php
function groffer_shop_categories_with_banners_shortcode( $params, $content ) {
    extract( shortcode_atts( 
        array(
            'number'                               => '',
            'number_of_products_by_category'       => '',
            'number_of_columns'                    => '',
            'title'                                => '',
            'category'                             => '',
            'banner_image'                         => '',
            'banner_url'                           => '',
            'banner_pos'                           => '',
            'banner_text'                          => '',
            'hide_empty'                           => ''
        ), $params ) );

    $cat = get_term_by( 'slug', $category, 'product_cat' );

    if ($cat) {
        $prod_categories = get_terms( 'product_cat', array(
            'number'        => $number,
            'child_of'      => $cat->term_id,
            'hide_empty'    => $hide_empty,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
            )
        ));
    }else{
        $prod_categories = get_terms( 'product_cat', array(
            'number'        => $number,
            'hide_empty'    => $hide_empty,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $category
                )
            )
        )); 
    }
    $banner_image = wp_get_attachment_image_src($banner_image, '');
    $class = 'banners_'.uniqid();
    $shortcode_content = '';
 
    //Begin: Main div holder
    $shortcode_content .= '<div id="'.$class.'" class="woocommerce_categories banners '.$class.'">';

      // Section Header
      $shortcode_content .= '<div class="header_banners col-md-12">';
        $shortcode_content .= '<h2 class="col-md-7">'.$title.'</h2>';
        $shortcode_content .= '<div class="col-md-5 categories-list categories_shortcode categories_shortcode_'.$number_of_columns.' ">';
        if ($prod_categories) {
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
        }
        $shortcode_content .= '</div>';
      $shortcode_content .= '</div>';

      // Section Body
      $shortcode_content .= '<div class="products_category">';
        if ($prod_categories) {
          foreach( $prod_categories as $prod_cat ) {

            wp_reset_postdata();
            $args_prods = array(
              'posts_per_page'   => $number_of_products_by_category,
              'order'            => 'DESC',
              'post_type'        => 'product',
              'tax_query' => array(
                array(
                  'taxonomy' => 'product_cat',
                  'field' => 'slug',
                  'terms' => $prod_cat
                )
              ),
              'post_status'      => 'publish' 
            ); 
            // $prods = get_posts($args_prods);
            $prods = new WP_Query( $args_prods );
            $count = 0;

            $shortcode_content .= '<div id="categoryid_'.$prod_cat->term_id.'" class=" products_by_category '.$prod_cat->name.'">';
              if ( $prods->have_posts() ) {
                while ( $prods->have_posts() ) {
                  $prods->the_post(); 
                  // foreach ($prods as $prod) {
                  #thumbnail
                  $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'groffer_product_simple_285x38' );                        

                  if ($thumbnail_src) {
                    $post_img = '<img class="portfolio_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.get_the_title().'" />';
                    $post_col = 'col-md-12';
                  }else{
                    $post_col = 'col-md-12 no-featured-image';
                    $post_img = '';
                  }
                   // SECONDARY IMAGE (FIRST IMAGE FROM WOOCOMMERCE PRODUCT GALLERY)
                      $product = wc_get_product( get_the_ID() );
                      $attachment_ids = $product->get_gallery_image_ids();
                      $secondary_post_img = '';
                        if ( is_array( $attachment_ids ) && !empty($attachment_ids) ) {
                            $first_image_url = wp_get_attachment_image_url( $attachment_ids[0], 'iffiliate_product_simple_285x38' );
                            $secondary_post_img= '<img class="woo_secondary_media_image" src="'.esc_url($first_image_url).'" alt="'.the_title_attribute('echo=0').'" />';
                        }

                  if($count == 2 && $banner_pos == 2) {
                    $shortcode_content.='<div class="product-banner">';
                    $shortcode_content .= '<a class="col-md-2" href="'.$banner_url.'" target="_blank">
                                            <img src="'.esc_attr($banner_image[0]).'" alt="banner">
                                            <p>'.$banner_text.'</p>
                                          </a>';
                    $shortcode_content .= '</div>';
                  }elseif($count == 3 && $banner_pos == 3) {
                    $shortcode_content.='<div class="product-banner">';
                    $shortcode_content .= '<a class="col-md-2" href="'.$banner_url.'" target="_blank">
                                            <img src="'.esc_url($banner_image[0]).'" alt="banner">
                                            <p>'.$banner_text.'</p>
                                          </a>';
                    $shortcode_content .= '</div>';
                  }elseif($count == 4 && $banner_pos == 4) {
                    $shortcode_content.='<div class="product-banner">';
                    $shortcode_content .= '<a class="col-md-2" href="'.$banner_url.'" target="_blank">
                                            <img src="'.esc_url($banner_image[0]).'" alt="banner">
                                            <p>'.$banner_text.'</p>
                                          </a>
                                          ';
                    $shortcode_content .= '</div>';
                  }elseif($count == 1 && $banner_pos == 1) {
                    $shortcode_content.='<div class="product-banner">';
                    $shortcode_content .= '<a class="col-md-2" href="'.$banner_url.'" target="_blank">
                                            <img src="'.esc_url($banner_image[0]).'" alt="banner">
                                            <p>'.$banner_text.'</p>
                                          </a>';
                    $shortcode_content .= '</div>';
                  }

                  $shortcode_content .= '<div class="prods product-id-'.esc_attr(get_the_ID()).'">
                                          <div class="prods_'.$number_of_products_by_category.' modeltheme-product ">
                                              <div class="modeltheme-product-wrapper">
                                                  
                                                  <div class="modeltheme-thumbnail-and-details">
                                                    <div class="overlay-container">
                                                      <div class="overlay-components">
                                                        <div class="component add-to-cart">
                                                          <a href="' . esc_url( $product->add_to_cart_url() ) . '" data-quantity="1" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="'.esc_attr(get_the_ID()).'" aria-label="Add <'.esc_attr(get_the_title()).'> to your cart" rel="nofollow"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"><path d="M2425 5114 c-312 -48 -544 -166 -745 -381 -144 -154 -238 -326 -287 -528 l-26 -103 -331 -4 c-311 -4 -335 -6 -396 -27 -161 -55 -289 -186 -334 -341 -15 -51 -306 -3129 -306 -3235 0 -163 117 -349 269 -429 135 -70 -31 -66 2291 -66 2290 0 2153 -3 2278 58 67 33 159 115 201 181 41 64 70 150 77 230 7 89 -279 3183 -302 3261 -47 160 -180 293 -344 346 -46 14 -107 18 -386 22 l-331 4 -26 103 c-108 440 -461 784 -907 886 -83 19 -327 33 -395 23z m369 -369 c243 -71 431 -224 540 -440 27 -55 76 -184 76 -202 0 -1 -383 -3 -851 -3 -736 0 -850 2 -846 14 3 8 11 34 17 58 21 77 89 202 154 283 132 165 334 281 546 315 96 16 265 4 364 -25z m-1444 -1262 c0 -239 2 -272 19 -308 22 -48 44 -69 96 -91 73 -30 162 2 203 74 21 38 22 49 22 316 l0 276 870 0 870 0 0 -276 c0 -267 1 -278 22 -316 41 -72 130 -104 203 -74 52 22 74 43 96 91 17 36 19 69 19 308 l0 267 304 0 c299 0 304 0 337 -23 45 -30 77 -80 84 -130 3 -23 68 -730 145 -1571 113 -1228 138 -1535 130 -1562 -16 -48 -48 -84 -94 -105 -39 -18 -117 -19 -2116 -19 -1999 0 -2077 1 -2116 19 -46 21 -78 57 -94 105 -8 27 17 334 130 1562 77 841 142 1548 145 1571 7 50 39 100 84 130 33 23 38 23 337 23 l304 0 0 -267z"/> </g></svg></a>                                                       
                                                        </div>
                                                      </div>
                                                    </div>
                                                      <a class="modeltheme_media_image" title="'.esc_attr(get_the_title()).'" href="'.esc_url(get_permalink(get_the_ID())).'"> '.$post_img.' '.$secondary_post_img.'</a>
                                                  </div>

                                                  <div class="modeltheme-title-metas">

                                                    <h3 class="modeltheme-archive-product-title">
                                                        <a href="'.esc_url(get_permalink(get_the_ID())).'" title="'. esc_attr(get_the_title()) .'">'. get_the_title() .'</a>
                                                    </h3>';
                                                      
                                                    global $product;
                                                    $product = wc_get_product( get_the_ID() );

                                                    $shortcode_content .= '<p>'.$product->get_price_html().'</p>';
                                                   
                            $shortcode_content .= '</div>
                                              </div>
                                          </div>                     
                                      </div>';
                  $count++;
                }
              }else{
                $shortcode_content .= '<div class="clearfix"></div>';
                $shortcode_content .= '<div class="alert alert-info">'.__('<strong>This category doesn\'t exist or it has no products!</strong> Edit the page and set an existing category from the builder.', 'modeltheme').'</div>';
              }
            $shortcode_content .= '</div>';
          }
        }
      $shortcode_content .= '</div>';

    //End: Main div holder
    $shortcode_content .= '</div>';

    wp_reset_postdata();

    return $shortcode_content;
}
add_shortcode('shop-categories-with-banners', 'groffer_shop_categories_with_banners_shortcode');

<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' ); ?>
<?php
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'groffer_single_post_pic1200x500' );
$side = "";
$class = "col-md-12";
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    if ( $groffer_redux['groffer_single_product_layout'] == 'groffer_shop_fullwidth' ) {
        $class = "col-md-12";
    }elseif ( $groffer_redux['groffer_single_product_layout'] == 'groffer_shop_right_sidebar' or $groffer_redux['groffer_single_product_layout'] == 'groffer_shop_left_sidebar') {
        $class = "col-md-9";
        if ( $groffer_redux['groffer_single_product_layout'] == 'groffer_shop_right_sidebar' ) {
        	$side = "right";
        }else{
        	$side = "left";
        }
    }
}
?>
    <!-- Breadcrumbs -->
    <div class="groffer-single-product-v1">
        <div class="groffer-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                            if(!function_exists('bcn_display')){
                                echo '<ol class="breadcrumb pull-left">';
                                    echo groffer_breadcrumb(); 
                                echo '</ol>';
                            }else{
                                echo '<div class="breadcrumbs breadcrumbs-navxt pull-left" typeof="BreadcrumbList" vocab="https://schema.org/">';
                                    echo bcn_display();
                                echo '</div>';
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>

    	<?php
    		/**
    		 * woocommerce_before_main_content hook
    		 *
    		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
    		 * @hooked woocommerce_breadcrumb - 20
    		 */
    		do_action( 'woocommerce_before_main_content' );
    	?>
    		<!-- Page content -->
    	<div class="high-padding">
    	    <!-- Blog content -->
            <div class="container blog-posts">
                <div class="row">
        	        <?php if ( $side == 'left' ) { ?>
            	        <div class="col-md-3 sidebar-content">
            	            <?php
            					/**
            					 * woocommerce_sidebar hook
            					 *
            					 * @hooked woocommerce_get_sidebar - 10
            					 */
            					do_action( 'woocommerce_sidebar' );
            				?>
            	        </div>
        	        <?php } ?>
                    <div class="<?php echo esc_attr($class); ?> main-content">
            			<?php while ( have_posts() ) : the_post(); ?>
                            <?php wc_get_template_part( 'content', 'single-product' ); ?>

            			<?php endwhile; // end of the loop. ?>
        			</div>
        	        <?php if ( $side == 'right' ) { ?>
        	        <div class="col-md-3 sidebar-content">
        	            <?php //dynamic_sidebar( $sidebar ); ?>
        	            <?php
        					/**
        					 * woocommerce_sidebar hook
        					 *
        					 * @hooked woocommerce_get_sidebar - 10
        					 */
        					do_action( 'woocommerce_sidebar' );
        				?>
        	        </div>
        	        <?php } ?>
        	    </div>
            </div>
    	</div>
    	<?php
    		/**
    		 * woocommerce_after_main_content hook
    		 *
    		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    		 */
    		do_action( 'woocommerce_after_main_content' );
    	?>
    <?php get_footer( 'shop' ); ?>

    </div>

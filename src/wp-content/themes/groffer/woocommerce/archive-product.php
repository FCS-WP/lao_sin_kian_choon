<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
global $groffer_redux;
$class = "col-md-12";
$side = "";
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	if ( $groffer_redux['groffer_shop_layout'] == 'groffer_shop_fullwidth' ) {
	    $class = "col-md-12";
	}elseif ( $groffer_redux['groffer_shop_layout'] == 'groffer_shop_right_sidebar' or $groffer_redux['groffer_shop_layout'] == 'groffer_shop_left_sidebar') {
	    $class = "col-md-9";
	    if ( $groffer_redux['groffer_shop_layout'] == 'groffer_shop_right_sidebar' ) {
	    	$side = "right";
	    }else{
	    	$side = "left";
	    }
	}
}
?>
	<!-- Breadcrumbs -->
    <div class="groffer-breadcrumbs">
        <div class="container">
            <div class="row">
            	<div class="col-md-12">
                    <ol class="breadcrumb">
                        <?php groffer_breadcrumb(); ?>
                    </ol>
                </div>
                <div class="col-md-12">
                    <h1><?php woocommerce_page_title(); ?></h1>
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
	    	
	        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
		        <?php if (is_active_sidebar($groffer_redux['groffer_shop_layout_sidebar'])) { ?>
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
		        <?php }else{ ?>
		            <?php if (is_active_sidebar('woocommerce')) { ?>
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
		            <?php }else{ ?>
		            	<?php $class = 'col-md-12'; ?>
		            <?php } ?>
		        <?php } ?>
	        <?php }else{ ?>
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

				<?php do_action( 'woocommerce_archive_description' ); ?>

				<?php if ( have_posts() ) : ?>
					
					<div class="groffer-shop-sort-group">
						<?php
							/**
							 * woocommerce_before_shop_loop hook
							 *
							 * @hooked woocommerce_result_count - 20
							 * @hooked woocommerce_catalog_ordering - 30
							 */
							do_action( 'woocommerce_before_shop_loop' );
						?>
						<div class="clearfix"></div>
					</div>

					<div class="clearfix"></div>

					<?php woocommerce_product_loop_start(); ?>

						<?php woocommerce_product_subcategories(); ?>

						<?php $i = 1; ?>

						<?php while ( have_posts() ) : the_post(); ?>

							<?php wc_get_template_part( 'content', 'product' ); ?>



								<?php
									global $woocommerce_loop;

									// Store column count for displaying the grid

									if ( empty( $woocommerce_loop['columns'] ) ){

										$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

									}
								?>

								<?php

								if ( $woocommerce_loop['columns'] == 2 ) {

									if ($i % 2 == 0){

										echo '<li class="clearfix hide-on-mobile"></li>';

									}

								}elseif ( $woocommerce_loop['columns'] == 3 ) {

									if ($i % 3 == 0){

										echo '<li class="clearfix hide-on-mobile"></li>';

									}

								}elseif ( $woocommerce_loop['columns'] == 4 ) {

									if ($i % 4 == 0){

										echo '<li class="clearfix hide-on-mobile"></li>';

									}

								} ?>



								<?php $i++; ?>



							<?php endwhile; // end of the loop. ?>

					<?php woocommerce_product_loop_end(); ?>

					<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>

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

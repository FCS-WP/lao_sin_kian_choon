<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class('row'); ?>>
	<div class="col-md-12 thumbnails-summary">
		<div class="row">

			<?php if (groffer_redux('groffer-enable-general-info') == true) { 
        		   $class ='col-md-5'; ?>
        		   <div class="col-md-3 product-general-info">
        		   	<?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) { ?>
        		   			
                            <div class="single-general-info col-md-12">
                            	<div class="col-md-4 ">
	                            	<?php if(groffer_redux('groffer-enable-general-img1','url')){ ?>
	                                	<img src="<?php echo esc_url(groffer_redux('groffer-enable-general-img1','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
	                          		<?php } ?>
	                          	</div>
	                          	<div class="col-md-8 ">
                            		<p><?php echo groffer_redux('groffer-enable-general-desc1'); ?></p>
                            	</div>
                            </div>
                            <?php if(groffer_redux('groffer-enable-general-desc2')){ ?>
                            <div class="single-general-info col-md-12">
                            	<div class="col-md-4 ">
	                            	<?php if(groffer_redux('groffer-enable-general-img2','url')){ ?>
	                                	<img src="<?php echo esc_url(groffer_redux('groffer-enable-general-img2','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
	                          		<?php } ?>
	                          	</div>
	                          	<div class="col-md-8">
                            		<p><?php echo groffer_redux('groffer-enable-general-desc2'); ?></p>
                            	</div>
                            </div>
                        	<?php } ?>
                        	<?php if(groffer_redux('groffer-enable-general-desc3')){ ?>
                            <div class="single-general-info col-md-12">
                            	<div class="col-md-4">
	                            	<?php if(groffer_redux('groffer-enable-general-img3','url')){ ?>
	                                	<img src="<?php echo esc_url(groffer_redux('groffer-enable-general-img3','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
	                          		<?php } ?>
	                          	</div>
	                          	<div class="col-md-8">
                            		<p><?php echo groffer_redux('groffer-enable-general-desc3'); ?></p>
                            	</div>
                            </div>
                        	<?php } ?>
                        	<?php if(groffer_redux('groffer-enable-general-desc4')){ ?>
                            <div class="single-general-info col-md-12">
                            	<div class="col-md-4">
	                            	<?php if(groffer_redux('groffer-enable-general-img4','url')){ ?>
	                                	<img src="<?php echo esc_url(groffer_redux('groffer-enable-general-img4','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
	                          		<?php } ?>
	                          	</div>
	                          	<div class="col-md-8">
                            		<p><?php echo groffer_redux('groffer-enable-general-desc4'); ?></p>
                            	</div>
                            </div>
                        	<?php } ?>
                        	<?php if(groffer_redux('groffer-enable-contact-desc') && groffer_redux('groffer-enable-contact-info') == true){ ?>
                            <div class="single-general-info contact col-md-12">
                            	<div class="col-md-4">
	                            	<?php if(groffer_redux('groffer-enable-contact-img','url')){ ?>
	                                	<img src="<?php echo esc_url(groffer_redux('groffer-enable-contact-img','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" />
	                          		<?php } ?>
	                          	</div>
	                          	<div class="col-md-8">
                            		<p><?php echo groffer_redux('groffer-enable-contact-desc'); ?></p>
                            	</div>
                            </div>
                        	<?php } ?>
                    <?php } ?>
        		   </div>
			<?php }else{
			        $class ='col-md-6';
			} ?>
				

			<div class="<?php echo esc_attr($class) ?> product-thumbnails">
				<?php
					/**
					 * woocommerce_before_single_product_summary hook.
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */
					do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<?php if (groffer_redux('groffer-enable-general-info') == true) { 
        		$class_desc ='col-md-4'; 
        	}else{
        		$class_desc ='col-md-6'; 
        	} ?>
			<div class="summary entry-summary <?php echo esc_attr($class_desc) ?>">

				<?php
					/**
					 * woocommerce_single_product_summary hook.
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 * @hooked WC_Structured_Data::generate_product_data() - 60
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>

			</div><!-- .summary -->
		</div>
	</div><!-- .summary -->

	
	<div class="col-md-12 tabs-related">
	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	</div>
                    
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php 
defined( 'ABSPATH' ) || exit;

/**
 * Check if WooCommerce is active
 **/
if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


		/**
		 * groffer_WC_List_Grid class
		 **/
		if ( ! class_exists( 'groffer_WC_List_Grid' ) ) {

			class groffer_WC_List_Grid {

				public function __construct() {
					// Hooks
	  				add_action( 'wp' , array( $this, 'groffer_setup_gridlist' ) , 20);
				}

				/*-----------------------------------------------------------------------------------*/
				/* Class Functions */
				/*-----------------------------------------------------------------------------------*/

				// Setup
				function groffer_setup_gridlist() {
					if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
						add_action( 'wp_enqueue_scripts', array( $this, 'groffer_setup_scripts_script' ), 20);
						add_action( 'woocommerce_before_shop_loop', array( $this, 'groffer_gridlist_toggle_button' ), 30);
						add_action( 'woocommerce_after_shop_loop_item', array( $this, 'groffer_gridlist_buttonwrap_open' ), 9);
						add_action( 'woocommerce_after_shop_loop_item', array( $this, 'groffer_gridlist_buttonwrap_close' ), 11);
						add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 5);
						add_action( 'woocommerce_after_subcategory', array( $this, 'groffer_gridlist_cat_desc' ) );
					}
				}

				function groffer_setup_scripts_script() {
					add_action( 'wp_footer', array( $this, 'groffer_gridlist_set_default_view' ) );
				}

				// Toggle button
				function groffer_gridlist_toggle_button() {

					$grid_view = __( 'Grid view', 'groffer' );
					$list_view = __( 'List view', 'groffer' );

					$output = sprintf( '<nav class="gridlist-toggle"><a href="#" id="grid" title="%1$s"><span class="dashicons dashicons-grid-view"></span> <em>%1$s</em></a><a href="#" id="list" title="%2$s"><span class="dashicons dashicons-exerpt-view"></span> <em>%2$s</em></a></nav>', $grid_view, $list_view );

					echo apply_filters( 'groffer_gridlist_toggle_button_output', $output, $grid_view, $list_view );
				}

				// Button wrap
				function groffer_gridlist_buttonwrap_open() {
					echo apply_filters( 'gridlist_button_wrap_start', '<div class="gridlist-buttonwrap">' );
				}
				function groffer_gridlist_buttonwrap_close() {
					echo apply_filters( 'gridlist_button_wrap_end', '</div>' );
				}

				function groffer_gridlist_set_default_view() {
					global $groffer_redux;
					$default = 'grid';
					if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
						if ($groffer_redux['groffer_shop_grid_list_switcher'] && !empty($groffer_redux['groffer_shop_grid_list_switcher'])) {
							$default = $groffer_redux['groffer_shop_grid_list_switcher'];
						}
					}
					?>
						<script>
						if ( 'function' == typeof(jQuery) ) {
							jQuery(document).ready(function($) {
								if ($.cookie( 'gridcookie' ) == null) {
									$( 'ul.products' ).addClass( '<?php echo esc_html($default); ?>' );
									$( '.gridlist-toggle #<?php echo esc_html($default); ?>' ).addClass( 'active' );
								}
							});
						}
						</script>
					<?php
				}

				function groffer_gridlist_cat_desc( $category ) {
					global $woocommerce;
					echo apply_filters( 'groffer_gridlist_cat_desc_wrap_start', '<div itemprop="description">' );
						echo esc_html($category->description);
					echo apply_filters( 'groffer_gridlist_cat_desc_wrap_end', '</div>' );

				}
			}

			$groffer_WC_List_Grid = new groffer_WC_List_Grid();
		}
	}

	// always display rating stars
	if (!function_exists('groffer_woocommerce_product_get_rating_html')) {
	    function groffer_woocommerce_product_get_rating_html( $rating_html, $rating, $count ) { 
	        $rating_html  = '<div class="star-rating">';
	        $rating_html .= wc_get_star_rating_html( $rating, $count );
	        $rating_html .= '</div>';

	        return $rating_html; 
	    };  
	}
	add_filter( 'woocommerce_product_get_rating_html', 'groffer_woocommerce_product_get_rating_html', 10, 3 );

	if (!function_exists('groffer_custom_search_form')) {
		add_action('groffer_products_search_form','groffer_custom_search_form');
		function groffer_custom_search_form(){ ?>
			<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

			        <input type="hidden" name="post_type" value="product" />
					<input type="search" class="search-field" placeholder="<?php echo esc_attr__( 'Search...', 'groffer' ); ?>" value="" name="s">
					<input type="submit" class="search-submit" value="&#xf002;">

			</form>
		<?php }
	}
}

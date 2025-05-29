<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     9.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$add_to_cart_attr = esc_attr__('Add to cart', 'groffer');
$add_to_cart_icon = 'fa-shopping-basket';
if( $product->is_type( 'simple' ) ) {
	$add_to_cart_attr = esc_attr__('Add to cart', 'groffer');
	$add_to_cart_icon = 'fa-shopping-basket';
} elseif( $product->is_type( 'auction' ) ) {
	$add_to_cart_attr = esc_attr__('Bid Now', 'groffer');
	$add_to_cart_icon = 'fa-gavel';
}else{
	$add_to_cart_attr = $product->add_to_cart_text();
	$add_to_cart_icon = 'fa-shopping-basket';
}

$classes = get_post_class();
if (in_array('product-type-auction',$classes)) {
	$meta_auction_closed = get_post_meta( $product->get_id(), '_auction_closed', true );
	if ($meta_auction_closed == '') {
		$add_to_cart_attr = esc_attr__('Bid Now', 'groffer');
		$add_to_cart_icon = 'fa-gavel';
	}else{
		$add_to_cart_attr = esc_attr__('View Auction', 'groffer');
		$add_to_cart_icon = 'fa-eye';
	}
}
echo apply_filters( 'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf( '<a href="%s" data-quantity="%s" data-tooltip="'.esc_attr($add_to_cart_attr).'" class="%s" %s><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet"><g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none"> <path d="M2425 5114 c-312 -48 -544 -166 -745 -381 -144 -154 -238 -326 -287 -528 l-26 -103 -331 -4 c-311 -4 -335 -6 -396 -27 -161 -55 -289 -186 -334 -341 -15 -51 -306 -3129 -306 -3235 0 -163 117 -349 269 -429 135 -70 -31 -66 2291 -66 2290 0 2153 -3 2278 58 67 33 159 115 201 181 41 64 70 150 77 230 7 89 -279 3183 -302 3261 -47 160 -180 293 -344 346 -46 14 -107 18 -386 22 l-331 4 -26 103 c-108 440 -461 784 -907 886 -83 19 -327 33 -395 23z m369 -369 c243 -71 431 -224 540 -440 27 -55 76 -184 76 -202 0 -1 -383 -3 -851 -3 -736 0 -850 2 -846 14 3 8 11 34 17 58 21 77 89 202 154 283 132 165 334 281 546 315 96 16 265 4 364 -25z m-1444 -1262 c0 -239 2 -272 19 -308 22 -48 44 -69 96 -91 73 -30 162 2 203 74 21 38 22 49 22 316 l0 276 870 0 870 0 0 -276 c0 -267 1 -278 22 -316 41 -72 130 -104 203 -74 52 22 74 43 96 91 17 36 19 69 19 308 l0 267 304 0 c299 0 304 0 337 -23 45 -30 77 -80 84 -130 3 -23 68 -730 145 -1571 113 -1228 138 -1535 130 -1562 -16 -48 -48 -84 -94 -105 -39 -18 -117 -19 -2116 -19 -1999 0 -2077 1 -2116 19 -46 21 -78 57 -94 105 -8 27 17 334 130 1562 77 841 142 1548 145 1571 7 50 39 100 84 130 33 23 38 23 337 23 l304 0 0 -267z"/></g></svg></a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		''
	),
$product, $args );
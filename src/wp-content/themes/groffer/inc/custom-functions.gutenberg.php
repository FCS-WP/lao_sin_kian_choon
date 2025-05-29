<?php
defined( 'ABSPATH' ) || exit;

// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'groffer_add_gutenberg_assets' );
/**
 * Load Gutenberg stylesheet.
 */
function groffer_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'groffer-gutenberg-style', get_theme_file_uri( '/css/gutenberg-editor-style.css' ), false );
    wp_enqueue_style( 
        'groffer-gutenberg-fonts', 
        '//fonts.googleapis.com/css?family=Montserrat:regular,500,600,700,800,900,latin' 
    ); 
}
?>
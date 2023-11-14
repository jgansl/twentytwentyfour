<?php
/**
 * Enqueue all styles and scripts
 */

function theme_scripts() {
	$theme = wp_get_theme();
  //TODO i18n, multi-theme
	$theme_uri = get_template_directory_uri(); 

	wp_dequeue_script( 'jquery' );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', 'https://cdn.jsdelivr.net/npm/cash-dom@8.1.5/dist/cash.min.js', array(), null, true );
	
  wp_enqueue_style('base-css', $theme_uri . "/build/design.css",  false, $theme->version);
	
}
add_action( 'wp_enqueue_scripts', 'theme_scripts', 10 );

// add_action( 'get_footer', 'prefix_add_footer_styles' );
add_action( 'wp_footer', function() {
  $theme = wp_get_theme();
	$theme_uri = get_template_directory_uri();

  wp_enqueue_style('font-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap', false, $theme->version);
}, 10 );


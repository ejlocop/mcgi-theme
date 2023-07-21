<?php 

include 'inc/mcgi-helpers.php';
include 'inc/mcgi-menus.php';
include 'inc/mcgi-widgets.php';
include 'inc/mcgi-cpt.php';

// Enqueue the new styles and scripts
function mcgi_enqueue_styles() {
	// Get cache bust value
	$cache_bust = get_field('cache_bust', 'options') ? get_field('cache_bust', 'options') : 1;

	// Enque child styles and css
	// wp_enqueue_style('child_theme_styles_web', get_stylesheet_directory_uri() . '/assets/app.min.css?' . $cache_bust, array(), null);
	wp_register_script('theme_script_web', get_bloginfo('url') . '/wp-content/themes/base-theme/assets/app.min.js?' . $cache_bust, array('jquery'), null, true);
	wp_register_script('child_theme_script_web', get_stylesheet_directory_uri() . '/assets/app.min.js?' . $cache_bust, array('jquery'), null, true);
	wp_enqueue_script('child_theme_script_web');
	
	if(wp_style_is('theme_styles_web')) {
		wp_dequeue_style( 'theme_styles_web' );
		wp_deregister_style( 'theme_styles_web' );
	}
	
	if(wp_style_is('wp-block-library')) {
		wp_dequeue_style( 'wp-block-library' );
		wp_deregister_style( 'wp-block-library' );
	}
	
	// google maps
	wp_register_script('child_google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . get_field('google_map_api_key', 'options'), '', '', true);
	wp_enqueue_script('child_google_maps');
}
add_action( 'wp_enqueue_scripts', 'mcgi_enqueue_styles', 12 );

function prefix_add_footer_styles() {
	$cache_bust = get_field('cache_bust', 'options') ? get_field('cache_bust', 'options') : 1;
	wp_enqueue_style('theme_styles_web',  get_bloginfo('url') . '/wp-content/themes/base-theme/assets/app.min.css?' . $cache_bust, array(), null);
	wp_enqueue_style('child_theme_styles_web', get_stylesheet_directory_uri() . '/assets/app.min.css?' . $cache_bust, array(), null);
	
};
add_action( 'get_footer', 'prefix_add_footer_styles');

// set the contact form to scroll to confirmation message after submission
add_filter( 'gform_confirmation_anchor_1', '__return_true' );

// Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open', 1 );

function wrap_gform_cdata_open( $content = '' ) {
    if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
        return $content;
    }
    $content = 'document.addEventListener( "DOMContentLoaded", function() { ';
    return $content;
}

add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close', 99 );
function wrap_gform_cdata_close( $content = '' ) {
    if ( ( defined('DOING_AJAX') && DOING_AJAX ) || isset( $_POST['gform_ajax'] ) ) {
        return $content;
    }
    $content = ' }, false );';
    return $content;
}
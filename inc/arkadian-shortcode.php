<?php
// Social links
function arkadian_social_shortcode($atts) {
	ob_start();
	include( locate_template("templates/shortcodes/social" . ".php", false, false) );
	return ob_get_clean();
}
add_shortcode( 'social_links', 'arkadian_social_shortcode' );


// Sort Home Filter
function arkadian_sort_home_filter($atts) {
	$a = shortcode_atts( array(
		'lot_width_min' => null,
		'lot_width_max'	=> null,
		'lot_width_gap'	=> null,
		'lot_width_unit'=> null,
		'size_min' => null,
		'size_max' => null,
		'size_gap' => null,
		'size_unit' => null,
		'bedroom_min' => 1,
		'bedroom_max' => 4,
	), $atts);
	ob_start();
	include( locate_template("templates/shortcodes/sort-home-filter" . ".php", false, false) );
	return ob_get_clean();
}
add_shortcode( 'sort_home_filter', 'arkadian_sort_home_filter' );


// Show google map
function arkadian_show_map($atts) {
	$a = shortcode_atts( array(
		'latitude' 		=> null,
		'longitude'		=> null,
		'zoom'			=> 16,
		'icon'			=> null,
		'greyscale'		=> null,
		'text'			=> null,
		'disable-ui'   => false
	), $atts, 'shortcodeWPSE');

	ob_start();
	include( locate_template("templates/shortcodes/map" . ".php", false, false) );
	return ob_get_clean();
}
add_shortcode( 'show_map', 'arkadian_show_map' );
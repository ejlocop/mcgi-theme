<?php
// Custom Post Types
add_action('init', 'mcgi_custom_posts');
function mcgi_custom_posts()
{

	// sliders
	register_post_type('people', [
		'labels' => [
			'name'          =>  __('People'),
			'singular_name' =>  __('People')
		],
		'menu_icon'           => 'dashicons-admin-users',
		'public'              => false,  // it's not public, it shouldn't have it's own permalink, and so on
		'publicly_queryable'  => true,   // you should be able to query it
		'queryable'           => true,   // you should be able to query it
		'show_ui'             => true,   // you should be able to edit it in wp-admin
		'exclude_from_search' => true,   // you should exclude it from search results
		'show_in_nav_menus'   => false,  // you shouldn't be able to add it to menus
		'has_archive'         => false,  // it shouldn't have archive page
		'rewrite'             => false,  // it shouldn't have rewrite rules
	]);
	
	register_post_type('service', [
		'labels' => [
			'name'          =>  __('Services'),
			'singular_name' =>  __('Service')
		],
		'menu_icon'           => 'dashicons-clipboard',
		'public'              => false,  // it's not public, it shouldn't have it's own permalink, and so on
		'publicly_queryable'  => true,   // you should be able to query it
		'queryable'           => true,   // you should be able to query it
		'show_ui'             => true,   // you should be able to edit it in wp-admin
		'exclude_from_search' => true,   // you should exclude it from search results
		'show_in_nav_menus'   => false,  // you shouldn't be able to add it to menus
		'has_archive'         => false,  // it shouldn't have archive page
		'rewrite'             => false,  // it shouldn't have rewrite rules
	]);
}

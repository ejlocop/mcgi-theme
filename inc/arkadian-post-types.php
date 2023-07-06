<?php

function arkadian_post_types() {
	return [
		// Projects
		[
			'name'                => 'home_designs',
			'label'               => __( 'Home Designs'),
			// Features this CPT supports in Post Editor
			'supports'            => [ 'title', 'editor', 'thumbnail',],
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'rewrite' =>array(
				'with_front' => false,
				'slug'       => 'home-designs'
			),
			'labels' => [
				'name'                => __( 'Home Designs'),
				'singular_name'       => __( 'Home Designs'),
				'menu_name'           => __( 'Home Designs'),
				'parent_item_colon'   => __( 'Parent Home Design'),
				'all_items'           => __( 'All Home Designs'),
				'view_item'           => __( 'View Home Design'),
				'add_new_item'        => __( 'Add New Home Design'),
				'add_new'             => __( 'Add New'),
				'edit_item'           => __( 'Edit Home Design'),
				'update_item'         => __( 'Update Home Design'),
				'search_items'        => __( 'Search Home Design'),
				'not_found'           => __( 'Not Found'),
				'not_found_in_trash'  => __( 'Not found in Trash'),
			],
			'tax' => [
				'home_design_dwelling_type' => [
					'hierarchical' => true,
					'labels' => [
						'name' => _x( 'Dwelling Types', 'taxonomy general name' ),
						'singular_name' => _x( 'Dwelling Type', 'taxonomy singular name' ),
						'search_items' =>  __( 'Search Dwelling Types' ),
						'all_items' => __( 'All Dwelling Types' ),
						'parent_item' => __( 'Parent Dwelling Type' ),
						'parent_item_colon' => __( 'Parent Dwelling Type:' ),
						'edit_item' => __( 'Edit Dwelling Types' ), 
						'update_item' => __( 'Update Dwelling Type' ),
						'add_new_item' => __( 'Add New Dwelling Type' ),
						'new_item_name' => __( 'New Dwelling Type' ),
						'menu_name' => __( 'Dwelling Types' ),
					],
					'show_ui' => true,
					'show_in_rest' => true,
					'show_admin_column' => true,
					'query_var' => true,
				]
			]
		],
		// FAQs
		[
			'name'                => 'faq',
			'label'               => __( 'FAQs'),
			// Features this CPT supports in Post Editor
			'supports'            => [ 'title', 'editor', 'thumbnail',],
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 7,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'labels' => [
				'name'                => __( 'FAQs'),
				'singular_name'       => __( 'FAQ'),
				'menu_name'           => __( 'FAQs'),
				'parent_item_colon'   => __( 'Parent FAQ'),
				'all_items'           => __( 'All FAQs'),
				'view_item'           => __( 'View FAQ'),
				'add_new_item'        => __( 'Add New FAQ'),
				'add_new'             => __( 'Add New'),
				'edit_item'           => __( 'Edit FAQ'),
				'update_item'         => __( 'Update FAQ'),
				'search_items'        => __( 'Search FAQ'),
				'not_found'           => __( 'Not Found'),
				'not_found_in_trash'  => __( 'Not found in Trash'),
			],
			'rewrite' =>array(
				'with_front' => false,
				'slug'       => 'faq'
			),
			'tax' => [
				'faq_category' => [
					'hierarchical' => true,
					'labels' => [
						'name' => _x( 'Category', 'taxonomy general name' ),
						'singular_name' => _x( 'Category', 'taxonomy singular name' ),
						
						'search_items' =>  __( 'Search Categories' ),
						'all_items' => __( 'All Categories' ),
						'parent_item' => __( 'Parent Category' ),
						'parent_item_colon' => __( 'Parent Category:' ),
						'edit_item' => __( 'Edit Category' ), 
						'update_item' => __( 'Update Category' ),
						'add_new_item' => __( 'Add New Category' ),
						'new_item_name' => __( 'New Category Name' ),
						'menu_name' => __( 'Categories' ),
					],
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'show_in_rest' => true,
					'show_admin_column' => true,
					'query_var' => true,
					'rewrite' => ['slug' => 'faqs' , 'with_front' => false],
				]
			]
		],
		// Gallery
		[
			'name'                => 'gallery',
			'label'               => __( 'Gallery'),
			// Features this CPT supports in Post Editor
			'supports'            => [ 'title', 'thumbnail' ],
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 7,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'labels' => [
				'name'                => __( 'Gallery'),
				'singular_name'       => __( 'Gallery'),
				'menu_name'           => __( 'Gallery'),
				'parent_item_colon'   => __( 'Parent Gallery'),
				'all_items'           => __( 'All Gallery'),
				'view_item'           => __( 'View Gallery'),
				'add_new_item'        => __( 'Add New Gallery'),
				'add_new'             => __( 'Add New'),
				'edit_item'           => __( 'Edit Gallery'),
				'update_item'         => __( 'Update Gallery'),
				'search_items'        => __( 'Search Gallery'),
				'not_found'           => __( 'Not Found'),
				'not_found_in_trash'  => __( 'Not found in Trash'),
			],
			'rewrite' => [
				'with_front' => false,
				'slug'       => 'gallery'
			],
			'tax' => [
				'faq_category' => [
					'hierarchical' => true,
					'labels' => [
						'name' => _x( 'Category', 'taxonomy general name' ),
						'singular_name' => _x( 'Category', 'taxonomy singular name' ),
						
						'search_items' =>  __( 'Search Categories' ),
						'all_items' => __( 'All Categories' ),
						'parent_item' => __( 'Parent Category' ),
						'parent_item_colon' => __( 'Parent Category:' ),
						'edit_item' => __( 'Edit Category' ), 
						'update_item' => __( 'Update Category' ),
						'add_new_item' => __( 'Add New Category' ),
						'new_item_name' => __( 'New Category Name' ),
						'menu_name' => __( 'Categories' ),
					],
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'show_in_rest' => true,
					'show_admin_column' => true,
					'query_var' => true,
					'rewrite' => ['slug' => 'faqs' , 'with_front' => false],
				]
			]
		],
	];
} 

// Register Custom Post Types
function arkadian_theme_register_post_types() {
	foreach(arkadian_post_types() as $post_type) {
		// Registering your Custom Post Type
		register_post_type( $post_type['name'], $post_type );

		if(isset($post_type['tax']) && $post_type['tax']) {
			foreach( $post_type['tax'] as $key => $taxonomy) {

				// var_dump($taxonomy);
				register_taxonomy($key, $post_type['name'], $taxonomy);
			}
		}
	}
	
}
add_action('init', 'arkadian_theme_register_post_types');



<?php

function mcgi_footer_columns()
{
	register_sidebar(array(
		'name' => __('Footer Column 1'),
		'id' => 'footer_column_1',
		'description' => '',
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Footer Column 2'),
		'id' => 'footer_column_2',
		'description' => '',
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => __('Footer Column 3'),
		'id' => 'footer_column_3',
		'description' => '',
		'class' => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
	));

}

add_action('widgets_init', 'mcgi_footer_columns');
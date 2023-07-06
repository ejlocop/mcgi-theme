<?php

// Post type template mappings
$post_type_templates = [
	'post'        =>    'post',
	'faq'       =>  'faq'
];


// Get the current post type
$post_type = get_post_type();
$post_template = 'default';

// Check if the current post type has assigned template
if (isset($post_type_templates[$post_type])) {
	$post_template = $post_type_templates[$post_type];
}
?>


<?php get_header(); ?>

<div class="page-content post page-single page-single-<?php echo $post_type ?>">
	<?php include(locate_template("template-parts/post-types/" . $post_template . ".php", false, false)); ?>
</div>

<?php get_footer(); ?>
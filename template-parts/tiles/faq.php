<?php


if($section['tiles_source'] == 'dynamic') {
	$tile_data = [
		'title' 	 => $tile->post_title,
		'content'	 => $tile->post_content,
		'permalink'	 => get_permalink($tile->ID),
		'media_type' => isset($tile->media_type) ? $tile->media_type : 'image'
	];
	$post_thumbnail = get_the_post_thumbnail_url($tile->ID);

	$tile_data['content'] = $tile->post_content;

}
else {
	$tile_data = [
		'title'      => $tile['heading'],
		'content'    => $tile['content'],
		'permalink'  => isset($tile['call_to_action']['url']) ? $tile['call_to_action']['url'] : '' ,
		'excerpt'    => $tile['content'],
		'media_type' => isset($tile['media_type']) ? $tile['media_type'] : 'image',
		'thumbnail'  => $tile['thumbnail'] ? $tile['thumbnail']['url'] : get_field('default_thumbnail', 'options')['url'],
		'embed'      => isset($tile['video_embed']) ? $tile['video_embed'] : null
	];
}
?>

<div class="tiles__item --card --revealed <?php echo (isset($tile->media_type) && $tile->media_type == 'embed') ? '--tile-embed' : '' ?>">
	<div class="tiles__item__content">
		<?php if($tile_data['permalink']): ?>
			<a href="<?php echo $tile_data['permalink'] ?>" class="tiles__item__permalink">
		<?php endif ?>
		<?php echo flexi_generate_heading(
			'tile',
			object_val($tile_data, 'title'),
			object_val($section, 'html_tile_headings'),
			['class' => 'tiles__item__heading']
		) ?>
		<?php if($tile_data['permalink']): ?>
			</a>
		<?php endif ?>
		<?php if($tile_data['content']): ?>
			<div class="tiles__item__description"><div class="tiles__item__description--inner"><?php echo $tile_data['content'] ?></div></div>
		<?php endif ?>
	</div>
</div>

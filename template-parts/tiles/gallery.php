<?php


if($section['tiles_source'] == 'dynamic') {
	$tile_data = [
		'title' 	 => $tile->post_title,
		'content'	 => $tile->post_content,
		'permalink'	 => get_permalink($tile->ID),
		'media_type' => isset($tile->media_type) ? $tile->media_type : 'image'
	];
	$tile_data['thumbnail'] = get_the_post_thumbnail_url($tile->ID, 'full');
	$tile_data['content'] = $tile->post_content;
	$tile_data['id'] = $tile->ID;
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

// echo '<pre>';
// print_r($tile);
// die;
// echo '</pre>'
?>

<div class="tiles__item --card --revealed">
	<div class="tiles__item__content">
		<div class="tiles__item__thumbnail">
			<img data-id="gallery-<?php echo $tile_data['id']; ?>" class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>" data-lazy="<?php echo $tile_data['thumbnail'] ?>">
		</div>
	</div>
</div>

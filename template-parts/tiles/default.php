<?php


if($section['tiles_source'] == 'dynamic') {
	$tile_data = [
		'title' 	 => $tile->post_title,
		'content'	 => $tile->post_content,
		'permalink'	 => get_permalink($tile->ID),
		'media_type' => isset($tile->media_type) ? $tile->media_type : 'image'
	];
	$post_thumbnail = get_the_post_thumbnail_url($tile->ID);

	$tile_data['excerpt'] = strlen($tile->post_excerpt) == 0 ? wp_trim_words($tile->post_content, 40, '...') : $tile->post_excerpt;

	if(!$post_thumbnail) {
		$post_thumbnail = get_field('default_thumbnail', 'options')['url'];
		
	}

	$tile_data['thumbnail'] = $post_thumbnail;
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

// $date = new DateTime($tile->post_date);

?>

<div class="tiles__item --card --revealed <?php echo (isset($tile->media_type) && $tile->media_type == 'embed') ? '--tile-embed' : '' ?>">
	<?php if($tile_data['permalink']): ?>
		<a href="<?php echo $tile_data['permalink'] ?>" class="tiles__item__permalink">
	<?php endif ?>
		<?php if($tile_data['thumbnail'] && isset($tile_data['media_type']) && $tile_data['media_type'] == 'image'): ?>
			<div class="tiles__item__thumbnail">
				<img class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>">
			</div>
		<?php endif ?>
		<?php if(isset($tile_data['media_type']) && $tile_data['media_type'] == 'embed'): ?>
			<div class="tiles__item__oembed">
				<?php
					// Load value.
					$tile_iframe = $tile_data['embed'];

					// Use preg_match to find iframe src.
					preg_match('/src="(.+?)"/', $tile_iframe, $matches);
					$src = $matches[1];

					// Add extra parameters to src and replcae HTML.
					$params = array(
					'controls'  => 0,
					'hd'        => 1,
					'autohide'  => 1
					);
					$new_src = add_query_arg($params, $src);
					$tile_iframe = str_replace($src, $new_src, $tile_iframe);

					// Add extra attributes to iframe HTML.
					$attributes = 'frameborder="0"';
					$tile_iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $tile_iframe);

					// // Display customized HTML.
					echo $tile_iframe;
				?>
			</div>
		<?php endif ?>

		<div class="tiles__item__content">
			<?php echo flexi_generate_heading(
				'tile',
				object_val($tile_data, 'title'),
				object_val($section, 'html_tile_headings'),
				['class' => 'tiles__item__heading']
			) ?>
			<?php if($tile_data['excerpt']): ?>
				<div class="tiles__item__description"><?php echo $tile_data['excerpt'] ?></div>
			<?php endif ?>
		</div>
	<?php if($tile_data['permalink']): ?>
		</a>
	<?php endif ?>
</div>

<?php

$tile_data = [
	'title'      => $tile['heading'],
	'subheading'   => $tile['subheading'],
	'content'    => $tile['content'],
	'permalink'  => isset($tile['call_to_action']['url']) ? $tile['call_to_action']['url'] : '',
	'excerpt'    => $tile['content'],
	'media_type' => isset($tile['media_type']) ? $tile['media_type'] : 'image',
	'thumbnail'  => $tile['thumbnail'] ? $tile['thumbnail']['url'] : null,
	'embed'      => isset($tile['video_embed']) ? $tile['video_embed'] : null
];
// $date = new DateTime($tile->post_date);

?>

<div class="tiles__item --card --revealed <?php echo (isset($tile->media_type) && $tile->media_type == 'embed') ? '--tile-embed' : '' ?>">
	<?php if ($tile_data['permalink']) : ?>
		<a href="<?php echo $tile_data['permalink'] ?>" class="tiles__item__permalink">
		<?php endif ?>
		<?php if (!is_null($tile_data['thumbnail']) && isset($tile_data['media_type']) && $tile_data['media_type'] == 'image') : ?>
			<div class="tiles__item__thumbnail">
				<img class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>">
			</div>
		<?php endif ?>
		<?php if (isset($tile_data['media_type']) && $tile_data['media_type'] == 'embed' && !is_null($tile_data['embed'])) : ?>
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
				'h4',
				['class' => 'tiles__item__heading']
			) ?>
			<?php echo flexi_generate_heading(
				'sub',
				object_val($tile_data, 'subheading'),
				'h6',
				['class' => 'tiles__item__subheading']
			) ?>
			<?php if ($tile_data['excerpt']) : ?>
				<div class="tiles__item__description"><?php echo $tile_data['excerpt'] ?></div>
			<?php endif ?>
		</div>
		<?php if ($tile_data['permalink']) : ?>
		</a>
	<?php endif ?>
</div>
<?php


if($section['tiles_source'] == 'dynamic') {
	$tile_data = [
		'title' 	 => $tile->post_title,
		'content'	 => $tile->post_content,
		'permalink'	 => get_permalink($tile->ID),
		'media_type' => isset($tile->media_type) ? $tile->media_type : 'image'
	];
	$post_thumbnail = get_the_post_thumbnail_url($tile->ID, 'full');

	$tile_data['excerpt'] = strlen($tile->post_excerpt) == 0 ? wp_trim_words($tile->post_content, 40, '...') : $tile->post_excerpt;

	if(!$post_thumbnail) {
		$post_thumbnail = get_field('default_thumbnail', 'options')['url'];
	}

	$tile_data['thumbnail'] = $post_thumbnail;

	$tile_acf = get_fields($tile->ID);
	$tile_data['home_design_description'] = $tile_acf['home_design_description'];
	$tile_data['bedrooms'] =  ($tile_acf['no_of_bedrooms'] == 1)? $tile_acf['no_of_bedrooms'] .' Bedroom' : $tile_acf['no_of_bedrooms'] . ' Bedrooms';
	$tile_data['bathrooms'] = ($tile_acf['no_of_bathrooms'] == 1)? $tile_acf['no_of_bathrooms'] .' Bathroom' : $tile_acf['no_of_bathrooms'] . ' Bathrooms';
	// $tile_data['carparks'] = ($tile_acf['no_of_carparks'] == 1)? $tile_acf['no_of_carparks'] .' Carpark' : $tile_acf['no_of_carparks'] . ' Carparks';
	$tile_data['carparks'] = $tile_acf['no_of_carparks'];
	$tile_data['living'] = ($tile_acf['no_of_living_rooms'] == 1)? $tile_acf['no_of_living_rooms'] .' Living' : $tile_acf['no_of_living_rooms'] . ' Living';
	$tile_data['alfresco'] = ($tile_acf['no_of_alfresco'] == 1)? $tile_acf['no_of_alfresco'] .' Alfresco' : $tile_acf['no_of_alfresco'] . ' Alfrescos';
	$tile_data['block_width'] = $tile_acf['block_width'];
	$tile_data['flyer'] = $tile_acf['upload_flyer'];

	$tile_data['no_of_study_rooms'] = ($tile_acf['no_of_study_rooms'])? ($tile_acf['no_of_study_rooms'] == 1)?  '+ Study' : '+ ' . $tile_acf['no_of_study_rooms'] . ' Study' : '';

	$inclusions_brochure_file = get_field('homes_inclusions_brochure_file', 'options');
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
	<?php endif ?>
		<?php if($tile_data['thumbnail'] && isset($tile_data['media_type']) && $tile_data['media_type'] == 'image'): ?>
			<div class="tiles__item__thumbnail">
				<img class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>" alt="<?php echo $tile_data['title'] ?>">
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
				['class' => 'tiles__item__heading --project-name']
			) ?>
			<?php if($tile_data['home_design_description']): ?>
				<div class="tiles__item__description"><?php echo $tile_data['home_design_description'] ?></div>
			<?php endif ?>
			<div class="tiles__item__details">
				<?php if($tile_data['bedrooms']): ?>
					<div class="tiles__item__details-item --bedrooms">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bedrooms.png" alt="Bedrooms"></div>
						<span>
							<?php echo $tile_data['bedrooms'] ?>
							<?php if($tile_data['no_of_study_rooms']): ?>
								<br> <?php echo $tile_data['no_of_study_rooms']; ?>
							<?php endif ?>
						</span>
					</div>
				<?php endif ?>
				<?php if($tile_data['bathrooms']): ?>
					<div class="tiles__item__details-item --bathrooms">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bathrooms.png" alt="Bathrooms"></div>
						<span><?php echo $tile_data['bathrooms'] ?></span>
					</div>
				<?php endif ?>
				<?php if($tile_data['carparks']): ?>
					<div class="tiles__item__details-item --carparks">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/carparks.png" alt="Carparks"></div>
						<span><?php echo $tile_data['carparks'] ?></span>
					</div>
				<?php endif ?>
				<?php if($tile_data['living']): ?>
					<div class="tiles__item__details-item --living">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/livingroom.png" alt="Living"></div>
						<span><?php echo $tile_data['living'] ?></span>
					</div>
				<?php endif ?>
				<?php if($tile_data['alfresco']): ?>
					<div class="tiles__item__details-item --alfresco">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/alfresco.png" alt="Alfresco"></div>
						<span><?php echo $tile_data['alfresco'] ?></span>
					</div>
				<?php endif ?>
				<?php if($tile_data['block_width']): ?>
					<div class="tiles__item__details-item --block_width">
						<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/block.png" alt="Block width"></div>
						<span>Block width: <br><?php echo $tile_data['block_width'] ?> metres</span>
					</div>
				<?php endif ?>
			</div>
			<div class="tiles__item__btn">
				<?php if($tile_data['flyer']): ?>
					<a class="btn --primary" href="<?php echo $tile_data['flyer'] ?>" download>Download flyer</a>
				<?php endif ?>
				<?php if($inclusions_brochure_file && $inclusions_brochure_file['url']): ?>
					<a class="btn --primary --inclusions" href="<?php echo $inclusions_brochure_file['url'] ?>" download>Download inclusions brochure</a>
				<?php endif ?>
			</div>

		</div>
	<?php if($tile_data['permalink']): ?>
	<?php endif ?>
</div>

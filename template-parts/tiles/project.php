<?php


if ($section['tiles_source'] == 'dynamic') {
	$tile_data = [
		'title' 	 => $tile->post_title,
		'content'	 => $tile->post_content,
		'permalink'	 => get_permalink($tile->ID),
		'media_type' => isset($tile->media_type) ? $tile->media_type : 'image'
	];
	$post_thumbnail = get_the_post_thumbnail_url($tile->ID, 'full');

	$tile_data['excerpt'] = strlen($tile->post_excerpt) == 0 ? wp_trim_words($tile->post_content, 40, '...') : $tile->post_excerpt;

	if (!$post_thumbnail) {
		$post_thumbnail = get_field('default_thumbnail', 'options')['url'];
	}

	$tile_data['thumbnail'] = $post_thumbnail;


	$tile_acf = get_fields($tile->ID);

	$tile_data['facades'] = array();
	foreach ($tile_acf['facades'] as $key => $facade) {

		$facade['bedrooms'] =  ($facade['no_of_bedrooms'] == 1) ? $facade['no_of_bedrooms'] . ' Bedroom' : $facade['no_of_bedrooms'] . ' Bedrooms';
		$facade['bathrooms'] = ($facade['no_of_bathrooms'] == 1) ? $facade['no_of_bathrooms'] . ' Bathroom' : $facade['no_of_bathrooms'] . ' Bathrooms';
		// $tile_data['carparks'] = ($tile_acf['no_of_carparks'] == 1)? $tile_acf['no_of_carparks'] .' Carpark' : $tile_acf['no_of_carparks'] . ' Carparks';
		$facade['carparks'] = $facade['no_of_carparks'];
		$facade['living'] = ($facade['no_of_living_rooms'] == 1) ? $facade['no_of_living_rooms'] . ' Living' : $facade['no_of_living_rooms'] . ' Living';
		$facade['alfresco'] = ($facade['no_of_alfresco'] == 1) ? $facade['no_of_alfresco'] . ' Alfresco' : $facade['no_of_alfresco'] . ' Alfrescos';
		$facade['study'] = ($facade['no_of_study_rooms']) ? ($facade['no_of_study_rooms'] == 1) ?  '+ Study' : '+ ' . $facade['no_of_study_rooms'] . ' Study' : '';

		$facade['bedrooms'] =  ($facade['no_of_study_rooms'] > 0) ? $facade['bedrooms'] . '<br>' . $facade['study'] : $facade['bedrooms'];
		$facade['block_width'] = 'Block width: <br>' . $facade['block_width'] .' metres';
		$tile_data['facades'][] = $facade;

	}

	$inclusions_brochure_file = get_field('homes_inclusions_brochure_file', 'options');
} 
else {
	$tile_data = [
		'title'      => $tile['heading'],
		'content'    => $tile['content'],
		'permalink'  => isset($tile['call_to_action']['url']) ? $tile['call_to_action']['url'] : '',
		'excerpt'    => $tile['content'],
		'media_type' => isset($tile['media_type']) ? $tile['media_type'] : 'image',
		'thumbnail'  => $tile['thumbnail'] ? $tile['thumbnail']['url'] : get_field('default_thumbnail', 'options')['url'],
		'embed'      => isset($tile['video_embed']) ? $tile['video_embed'] : null
	];
}

?>

<div class="tiles__item --card --revealed <?php echo (isset($tile->media_type) && $tile->media_type == 'embed') ? '--tile-embed' : '' ?>">
	<?php if ($tile_data['permalink']) : ?>
	<?php endif ?>

	<div class="tiles__item__heading">
		<p class="tiles__item__heading__item --title"><?php echo object_val($tile_data, 'title') ?></p>

		<?php if (count($tile_data['facades']) > 0) : ?>
			<ul class="tiles__item__heading__item --floor-layouts flipper" data-toggle="flip" data-target="#floorLayout<?php echo $tile->ID ?>" data-content-id="#itemDetails_<?php echo $tile->ID ?>">
				<?php foreach ($tile_data['facades'] as $index => $facade) : ?>
					<li>
						<a class="<?php if($index === 0) echo 'active'; ?>" href="#layout_<?php echo str_replace(' ', '_', $facade['floor_layout_name']); ?>" nofollow><?php echo $facade['floor_layout_name']; ?></a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
		<p class="tiles__item__heading__item --facade">Facade</p>
	</div>
	<div class="tiles__item__content">
		<div class="tiles__item__details" id="itemDetails_<?php echo $tile->ID; ?>">
			<?php if ($tile_data['facades']) : ?>
				<div class="tiles__item__details-item --bedrooms" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'bedrooms', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bedrooms.png" alt="Bedrooms"></div>
					<span><?php echo $tile_data['facades'][0]['bedrooms'] ?>
					</span>
				</div>
				<div class="tiles__item__details-item --bathrooms" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'bathrooms', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bathrooms.png" alt="Bathrooms"></div>
					<span><?php echo $tile_data['facades'][0]['bathrooms'] ?></span>
				</div>
				<div class="tiles__item__details-item --carparks" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'carparks', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/carparks.png" alt="Carparks"></div>
					<span><?php echo $tile_data['facades'][0]['carparks'] ?></span>
				</div>
				<div class="tiles__item__details-item --living" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'living', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/livingroom.png" alt="Living"></div>
					<span><?php echo $tile_data['facades'][0]['living'] ?></span>
				</div>
				<div class="tiles__item__details-item --alfresco" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'alfresco', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/alfresco.png" alt="Alfresco"></div>
					<span><?php echo $tile_data['facades'][0]['alfresco'] ?></span>
				</div>
				<div class="tiles__item__details-item --block_width" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'block_width', 'floor_layout_name'))); ?>">
					<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/block.png" alt="Block width"></div>
					<span><?php echo $tile_data['facades'][0]['block_width'] ?></span>
				</div>
			<?php endif ?>

			<div class="tiles__item__btn">
				<a class="btn --primary --inclusions" href="<?php echo $tile_data['permalink'] ?>">Explore</a>
			</div>
		</div>

		<?php if (count($tile_data['facades']) > 0) : ?>
			<div class="tiles__item__floor-layout" id="floorLayout<?php echo $tile->ID ?>">
				<?php foreach ($tile_data['facades'] as $index => $facade) : ?>
					<div class="tiles__item__floor-layout__wrapper" id="<?php echo "layout_" . str_replace(' ', '_', $facade['floor_layout_name']); ?>" <?php if ($index >= 1) : ?> style="display: none;" <?php endif ?>>
						<img class="tiles__item__floor-layout__img" src="<?php echo $facade['floor_layout_image'] ?>" alt="<?php echo $facade['floor_layout_name']; ?> floor layout">
					</div>
				<?php endforeach ?>
			</div>
			
			<ul class="tiles__item__floor-layout__flipper flipper" data-toggle="flip" data-target="#floorLayout<?php echo $tile->ID ?>" data-content-id="#itemDetails_<?php echo $tile->ID ?>">
				<?php foreach ($tile_data['facades'] as $index => $facade) : ?>
					<li>
						<a class="<?php if($index === 0) echo 'active'; ?>" href="#layout_<?php echo str_replace(' ', '_', $facade['floor_layout_name']); ?>" nofollow><?php echo $facade['floor_layout_name']; ?></a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>

		<?php if ($tile_data['thumbnail'] && isset($tile_data['media_type']) && $tile_data['media_type'] == 'image') : ?>
			<div class="tiles__item__thumbnail">
				<p class="tiles__item__thumbnail__facade-name" data-facade-name="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'facade_name', 'floor_layout_name'))); ?>"><?php echo $tile_data['facades'][0]['facade_name']; ?></p>
				
				<?php foreach($tile_data['facades'] as $index => $facade): ?>
					<img class="tiles__item__thumbnail__img" data-id="layout_<?php echo str_replace(' ', '_', $facade['floor_layout_name']); ?>" src="<?php echo $facade['facade_image'] ?>" alt="<?php echo $tile_data['title'] ?>" <?php if ($index >= 1) : ?> style="display: none;" <?php endif ?>>	
				<?php endforeach ?>
			<?php endif ?>
			</div>

			<?php if ($tile_data['permalink']) : ?>
			<?php endif ?>
	</div>
</div>
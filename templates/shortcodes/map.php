<?php
	$map = null;
	
	// check shortcode params
	if($a['latitude'] && $a['longitude']) {
		$map = [
			'address' => '',
			'lat' => $a['latitude'],
			'lng' => $a['longitude'],
		];
	}

	$icon = $a['icon'] ? $a['icon'] : (get_stylesheet_directory_uri() . '/img/icons/map-marker.png'); 
	$classes = [];

	if(filter_var( $a['disable-ui'], FILTER_VALIDATE_BOOLEAN )) {
		$classes[] = '--disable-ui';
	}
	if(filter_var( $a['greyscale'], FILTER_VALIDATE_BOOLEAN )) {
		$classes[] = 'greyscale';
	}
?>

	<div class="block-map">
		<div class="block-map__map <?php echo join(' ', $classes) ?>" data-zoom="<?php echo $a['zoom'] ?>">

		<?php if(is_array($map) && !empty($map)): ?>
			<?php
				$lat = $map['lat'];
				$lng = $map['lng'];
			?>
				<div class="marker" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>" data-icon="<?php echo $icon ?>">
					<?php if(!empty($a['text'])): ?>
						<div class="info-window-custom">
							<?php echo $a['text'] ?>
						</div>
					<?php endif ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

<?php
	$column_selector = "#$id " . "#$slide_id " . ".$column_class";

	// var_dump($column_selector);

	$column_background_styles = [
		'mobile' => [],
		'tablet' => [],
		'desktop' => [],
	];

	$column_background_overlay_styles = [];

	$column_background_video_sources = [];

	$breakpoints = [
		'mobile' => '0px',
		'tablet' => '767px',
		'desktop' => '992px'
	];

	foreach($slideColumn['media'] as $screen => $background) {
		// background image
		if($background['type'] == 'image') {
			$column_background_styles[$screen][] = isset($background['image']['file']['url']) ? ('background-image:url(' . $background['image']['file']['url'] .')' ): null;
	
			// image positioning and repeat
			if(isset($background['image']['repeat_image']) && isset($background['image']['positioning'])) {
				if($background['image']['repeat_image']) {
					$column_background_styles[$screen][] = 'background-repeat:repeat';
					// $column_background_styles[$screen][] = 'background-size:auto;';
				}
				if($background['image']['positioning'] == 'top') {
					$column_background_styles[$screen][] = 'background-position:center ' . ($background['image']['top_position_offset'] > 0 ? $background['image']['top_position_offset'] . '%' : 'top');
				}
				elseif($background['image']['positioning'] == 'bottom') {
					$column_background_styles[$screen][] = 'background-position:center bottom';
				}
			}
	
			// image overlay
			$column_background_overlay_styles[$screen][] = 'background-color:'. $background['image']['colour_overlay'];
			$column_background_overlay_styles[$screen][] = 'opacity:'. ($background['image']['colour_opacity'] / 100);
		}
		// background colour
		elseif($background['type'] == 'colour') {
			$column_background_styles[$screen][] = 'background-color:' . $background['background_colour'];
		}
		// background video
		elseif($background['type'] == 'video') {
			if(isset($background['video']['url']) && $background['video']['url']) {
				$column_background_video_sources[$screen] = [
					'is_local' => true,
					'breakpoint' => $breakpoints[$screen],
					'url'  => $background['video']['url'],
					'mime' => $background['video']['mime_type']
				];
			}
		}
		// inherit
		elseif($background['type'] == 'inherit') {
			$background_mobile_type = $slideColumn['media']['mobile']['type'];
			$background_tablet_type = $slideColumn['media']['tablet']['type'];

			// just copy styles of screen before this if not video type
			if($screen == 'tablet' && ($background_mobile_type != 'video' && $background_mobile_type != 'youtube')) {
				$column_background_styles['tablet'] = $column_background_styles['mobile'];
			}
			elseif($screen == 'desktop' && ($background_tablet_type != 'video' && $background_tablet_type != 'youtube')) {
				$column_background_styles['desktop'] = $column_background_styles['tablet'];
			}

			// if video or youtube
			if($screen == 'tablet' && ($background_mobile_type == 'video' || $background_mobile_type == 'youtube')) {
				if(isset($column_background_video_sources['mobile'])) {
					$column_background_video_sources['tablet'] = $column_background_video_sources['mobile'];
				}
			}
			elseif($screen == 'desktop' && (($background_tablet_type == 'video' || $background_mobile_type == 'video') || ($background_tablet_type == 'youtube' || $background_mobile_type == 'youtube') )) {
				if(isset($column_background_video_sources['tablet'])) {
					$column_background_video_sources['desktop'] = $column_background_video_sources['tablet'];
				}
			}
		}
		// no background
		else {
			$column_background_styles[$screen][] = 'background:none';
			$column_background_overlay_styles[$screen][] = 'background:none';
		}
	}

	// echo '<pre>';
	// var_dump($column_background_overlay_styles['mobile']);
	// echo '</pre>';

?>


<div class="slider__item__column__item__background">
	<?php if(!empty($column_background_video_sources)): ?>
		<video autoplay muted loop class="slider__item__column__item__background__video" data-object-fit="cover"

			<?php foreach($column_background_video_sources as $screen => $source): ?>
				<?php if($source['is_local']): ?>
					data-source-<?php echo $screen ?>="<?php echo htmlspecialchars(json_encode($source), ENT_QUOTES, 'UTF-8') ?>"
				<?php endif ?>
			<?php endforeach ?>
		>
		</video>

		<div class="slider__item__column__item__background__video --embed"
			<?php foreach($column_background_video_sources as $screen => $source): ?>
				<?php if(!$source['is_local']): ?>
					data-source-<?php echo $screen ?>="<?php echo htmlspecialchars(json_encode($source), ENT_QUOTES, 'UTF-8') ?>"
				<?php endif ?>
			<?php endforeach ?>
		>
			<div class="slider__item__column__item__background__video__player"></div>
		</div>
	<?php endif ?>
	<div class="slider__item__column__item__background__overlay-color"></div>
</div>

<style>
	<?php if(isset($column_background_styles['mobile']) || isset($column_background_video_sources['mobile'])): ?>
		<?php echo $column_selector ?> .slider__item__column__item__background {
			<?php echo implode($column_background_styles['mobile'], ';') ?>

			<?php if(isset($column_background_video_sources['mobile'])): ?>
				background:none
			<?php endif ?>
		}
	<?php endif ?>

	<?php if(isset($background_overlay_styles['mobile']) || isset($column_background_video_sources['mobile'])): ?>
		<?php echo $column_selector ?> .slider__item__column__item__background__overlay-color {
			<?php if(isset($background_overlay_styles['mobile'])): ?>
				<?php echo implode($column_background_overlay_styles['mobile'], ';') ?>
			<?php endif ?>

			<?php if(isset($column_background_video_sources['mobile'])): ?>
				display:none
			<?php endif ?>
		}
	<?php endif ?>

	<?php echo $column_selector ?> .slider__item__column__item__background__video{
		<?php echo !isset($column_background_video_sources['mobile']) ? 'display:none' : 'display:block' ?>
	}

	@media(min-width:<?php echo $breakpoints['tablet'] ?>){
		<?php if(isset($column_background_styles['tablet']) || isset($column_background_video_sources['tablet'])): ?>
			<?php echo $column_selector ?> .slider__item__column__item__background{
				<?php echo implode($column_background_styles['tablet'], ';') ?>
			}
		<?php endif ?>

		<?php if(isset($background_overlay_styles['tablet']) || isset($column_background_video_sources['tablet'])): ?>
			<?php echo $column_selector ?> .slider__item__column__item__background__overlay-color{
				<?php if(isset($background_overlay_styles['tablet'])): ?>
					<?php echo implode($background_overlay_styles['tablet'], ';') ?>
				<?php endif ?>
			}
		<?php endif ?>

		<?php echo $column_selector ?> .slider__item__column__item__background__video{
			<?php echo !isset($column_background_video_sources['tablet']) ? 'display:none' : 'display:block' ?>
		}
	}

	@media(min-width:<?php echo $breakpoints['desktop'] ?>){
		<?php if(isset($column_background_styles['desktop']) || isset($column_background_video_sources['desktop'])): ?>
			<?php echo $column_selector ?> .slider__item__column__item__background{
				<?php echo implode($column_background_styles['desktop'], ';') ?>
			}
		<?php endif ?>

		<?php if(isset($background_overlay_styles['desktop']) || isset($column_background_video_sources['desktop'])): ?>
			<?php echo $column_selector ?> .slider__item__column__item__background__overlay-color{
				<?php if(isset($background_overlay_styles['desktop'])): ?>
					<?php echo implode($background_overlay_styles['desktop'], ';') ?>
				<?php endif ?>
			}
		<?php endif ?>

		<?php echo $id ?> .slider__item__column__item__background__video{
			<?php echo !isset($column_background_video_sources['desktop']) ? 'display:none' : 'display:block' ?>
		}
	}

</style>








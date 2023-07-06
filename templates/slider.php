<?php 

// Get options
include( locate_template("template-parts/options/common.php", false, false) );
?>
<div class="section-inner <?php echo implode(' ', $classes)?>" style="<?php echo implode(';', $styles) ?>">
	<?php 
		// For section background
		include(locate_template('/template-parts/sections/background-media.php', false, false));
	?>
	<div class="<?php echo $container  ?>">
		<?php 
			// For section intro content
			include(locate_template('/template-parts/sections/intro-content.php', false, false));
		?>
		<div class="row">
			<div class="col-sm-12 column">
				<?php if(isset($section['heading2'])): ?>
					<h2 class="template-header section__title">
						<?php echo $section['heading2']; ?>
					</h2>
				<?php endif ?>

				<?php
					$slides = null;
					$slider_object_acf = get_fields($section['slider_object']);

					if(isset($slider_object_acf['slides'])) {
						$slides = $slider_object_acf['slides'];
						
						// Slides to show responsive
						$slides_to_show_values = [
							'mobile' => 1,
							'tablet' => 1,
							'desktop'=> 1
						];
	
						$last_slide_show_value = 'mobile';
						$slides_to_show_values['mobile'] = $slider_object_acf['slides_to_show'][$last_slide_show_value];
	
						if($slider_object_acf['slides_to_show']['tablet'] == 'inherit') {
							$slides_to_show_values['tablet'] = $slider_object_acf['slides_to_show'][$last_slide_show_value];
						}
						else {
							$slides_to_show_values['tablet'] = $slider_object_acf['slides_to_show']['tablet'];
							$last_slide_show_value = 'tablet';
						}
	
						if($slider_object_acf['slides_to_show']['desktop'] == 'inherit') {
							$slides_to_show_values['desktop'] = $slider_object_acf['slides_to_show'][$last_slide_show_value];
						}
						else {
							$slides_to_show_values['desktop'] = $slider_object_acf['slides_to_show']['desktop'];
						}
					}

					$autoplay = false;
					$slide_dots = false;

					if(isset($section['slide_dots'])) {
						if($section['slide_dots']) {
							$slide_dots = true;
						}
					}
					
					if(isset($section['autoplay'])) {
						if($section['autoplay']) {
							$autoplay = true;
						}
					}

					if(isset($section['autoplay'])) {
						if($section['autoplay']) {
							$autoplay = true;
							$autoplay_speed = 3000; // 3 seconds
							$pause_autoplay_on_hover = false;

							if(isset($section['auto_play_speed'])) {
								$autoplay_speed = $section['auto_play_speed'];
							}

							if(isset($section['pause_auto_play_on_mouse_hover'])) {
								if($section['pause_auto_play_on_mouse_hover']) {
									$pause_autoplay_on_hover = 'true';
								}
							}
						}
					}

					$slide_arrows = false;

					if(isset($section['previous_next_slide_arrows'])) {
						if($section['previous_next_slide_arrows']) {
							$slide_arrows = true;
						}
					}


				?>

				<?php if($slides): ?>
					<div class="slider ui-slider"
						data-slides-to-show-mobile="<?php echo $slides_to_show_values['mobile'] ?: 1 ?>"
						data-slides-to-show-tablet="<?php echo $slides_to_show_values['tablet'] ?: 1 ?>"
						data-slides-to-show-desktop="<?php echo $slides_to_show_values['desktop'] ?: 1 ?>"
						data-slides-to-scroll="<?php echo $slider_object_acf['slides_to_scroll'] ?: 1 ?>"
						data-slide-dots="<?php echo $slide_dots; ?>"
						data-slide-dots="<?php echo $slide_dots; ?>"
						data-autoplay="<?php echo $autoplay; ?>"
						<?php echo $autoplay ? 'data-autoplay-speed='.$autoplay_speed : ''; ?>
						data-pause-autoplay-on-hover="<?php echo $pause_autoplay_on_hover; ?>"
						>
						<div class="slider__items-wrapper">
							<?php $x=1; ?>
							<?php foreach($slides as $index => $slide): ?>
								<?php
									$slide_default_id = $id . '_slide_' . $index;
									$slide_id = $slide_default_id;
									$slide_classes = [];

									if(isset($slide['slide_id']) && $slide['slide_id']) {
										$slide_id = $slide['slide_id'];
									}

									$displaySlideClass = '';
									$is_first_slide = false;
									if($x > 1){
										$displaySlideClass = 'slick-slide-none';
									}
									if($x == 1){
										$is_first_slide = true;
									}
								?>
								<?php include( locate_template("template-parts/slides/" . $slider_object_acf['template_file'] . ".php", false, false) ); ?>
							<?php $x++; ?>
							<?php endforeach ?>
						</div>

						<?php if($slide_arrows || $slide_dots): ?>
							<div class="slider__controls">
								<?php if($slide_arrows): ?>
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls slider__controls__prev">
									<g id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">
										<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" fill="#5b7363" stroke="#fff" stroke-width="2.5">
											<rect width="48" height="48" rx="24" stroke="none"/>
											<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>
										</g>
										<path id="Path_277" class="arrow" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>
									</g>
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls slider__controls__next">
									<g id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">
										<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" fill="#5b7363" stroke="#fff" stroke-width="2.5">
											<rect width="48" height="48" rx="24" stroke="none"/>
											<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>
										</g>
										<path id="Path_211" class="arrow" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>
									</g>
								</svg>
								<?php endif ?>
								<?php if($slide_dots): ?>	
								<div class="slider__dots"></div>
								<?php endif ?>
							</div>
						<?php endif ?>
					</div>
				<?php endif ?>
				<?php 
					// For section Call to Action
					include get_template_directory() . '/template-parts/sections/call-to-action.php';
				?>
			</div>
		</div>
	</div>
</div>

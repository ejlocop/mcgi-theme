<?php

// Get options
include( locate_template("template-parts/options/common.php", false, false) );

$banner_section_title = $section['heading'] ? $section['heading'] : '';
?>
<div class="section-inner <?php echo join(' ', $classes)?>" style="<?php echo join(';', $styles) ?>">
	<?php 
		// display background image
		include get_template_directory() . '/template-parts/sections/background-media.php';
	?>
	<div class="<?php echo $container ?> content-overlay">
		<?php
			$banner_content_classes = [
				generate_column_sizes_classes($section['content_width']),
				generate_column_offset_classes($section['content_offset']),
				generate_column_content_alignment_classes($section['content_alignment']),
			];
			// echo '<pre>';
			// var_dump($section['call_to_action_link']);
			// echo '</pre>';
			// die;
		?>
		<div class="row">
			<div class="<?php echo implode(separator: ' ', array: $banner_content_classes) ?>">
				<?php echo flexi_generate_heading(
					'section',
					$banner_section_title,
					object_val($section, 'html_section_heading'),
					['class' => 'template-header section__title'],
					object_val($section, 'settings_section_title_as_h1')
				) ?>

				<?php if($section['content']): ?>
					<p><?php echo $section['content'] ?></p>
				<?php endif ?>
				
				<?php 
					// For section Call to Action
					include(locate_template("template-parts/sections/call-to-action.php", false, false));
				?>
			</div>
		</div>
	</div> 
</div>
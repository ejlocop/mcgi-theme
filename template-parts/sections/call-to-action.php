<?php if (isset($section['show_call_to_action']) && $section['show_call_to_action']) : ?>
	<?php if (isset($section['call_to_action_link']['url'])) : ?>
		<?php

		$call_to_action_classes = [
			//generate_column_sizes_classes($section['call_to_action_column_width']),
			//generate_column_offset_classes($section['call_to_action_column_offset']),
			generate_column_content_alignment_classes($section['call_to_action_content_alignment']),
		];

		$call_to_action_button_classes = [];
		//if($section['call_to_action_custom_button_width']) {
		if (true) {
			$call_to_action_classes[] = '--custom-button-width';
			$call_to_action_button_classes[] = generate_column_sizes_classes($section['call_to_action_button_width']);
		}
		/*else {
			$call_to_action_button_classes[] = 'col-sm-12';
		}*/
		?>
		<div class="section__action <?php echo implode(array: $call_to_action_classes, separator: ' ') ?>">
			<div class="row">
				<div class="section__action__btn-wrapper <?php echo implode(array: $call_to_action_button_classes, separator: ' ') ?>">
					<a href="<?php echo $section['call_to_action_link']['url']; ?>" class="<?php echo $section['call_to_action_styled'] ? 'btn section__action__btn' : '' ?>" target="<?php echo $section['call_to_action_link']['target'] ?>">
						<?php echo $section['call_to_action_link']['title'] ?>
					</a>
				</div>
			</div>
		</div>

	<?php endif ?>
<?php endif ?>
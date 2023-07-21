<?php
// Get options
include(locate_template("template-parts/options/common.php", false, false));



$classes[] = generate_column_alignment_classes($section['column_alignment']);

$tiles = $section['tiles'];

$has_posts = is_array($tiles) && count($tiles) > 0;

$number_of_columns_mobile = $section['number_of_columns']['mobile'];
$number_of_columns_tablet = $section['number_of_columns']['tablet'];
$number_of_columns_desktop = $section['number_of_columns']['desktop'];

if ($number_of_columns_tablet == 'inherit') {
	$number_of_columns_tablet = $number_of_columns_mobile;
}
if ($number_of_columns_desktop == 'inherit') {
	$number_of_columns_desktop = $number_of_columns_tablet;
}

?>

<div class="section-inner <?php echo implode(' ', $classes) ?>" style="<?php echo implode(';', $styles) ?>">

	<?php
	// For section background
	include(locate_template('/template-parts/sections/background-media.php', false, false));
	?>
	<div class="<?php echo $container  ?>">
		<?php
			// For section intro content
			include(locate_template('/template-parts/sections/intro-content.php', false, false));
		?>
		<?php if ($has_posts) :  ?>
			<div class="tiles-wrapper row">
				<div class="tiles">

					<div class="row columns tiles__items-wrapper">
						<?php foreach ($tiles as $tile) : ?>
							<?php
								$columns = fix_column_sizes($section['number_of_columns']);

								$column_class = [
									generate_column_sizes_classes($columns)
								];
							?>
							<div class="<?php echo implode(separator: ' ', array: $column_class) ?> tiles__item-wrapper">
								<?php include(locate_template("template-parts/tiles/" . $section['template_file'] . ".php", false, false)); ?>
							</div>
						<?php endforeach ?>
					</div>

				</div><!-- // tiles -->

				<?php
				// For section Call to Action
				include(locate_template('/template-parts/sections/call-to-action.php', false, false));
				?>

			</div>
		<?php endif; ?>
	</div>
</div>
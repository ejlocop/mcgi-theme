<?php
$acf_fields = get_fields($tile->ID);
$tile_data = [
	'title'      => $acf_fields['name'],
	'subheading' => $acf_fields['position'],
	'content'    => $acf_fields['information'],
	'excerpt'    => $acf_fields['information'],
	'thumbnail'  => $acf_fields['photo']
];
// $date = new DateTime($tile->post_date);
// echo '<pre>';
// print_r($acf_fields);
// echo '</pre>';
// die;
?>

<div class="tiles__item --card --revealed --people">

	<?php if (!is_null($tile_data['thumbnail'])) : ?>
		<div class="tiles__item__thumbnail">
			<img class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>">
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
</div>
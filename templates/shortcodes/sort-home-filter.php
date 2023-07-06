<?php
	$args = [
		'posts_per_page' => $atts['limit'] ?? '',
		'post_type' => 'home-designs',
		'post_status' => 'publish',
		'orderby' => 'post_date',
		'order' => 'DESC'
	];

	// get categories
	$categories = get_terms('home_design_dwelling_type', ['hide_empty' => false]);

	$post_action = get_permalink();

	$lot_width_ranges = get_set_of_range($a['lot_width_min'], $a['lot_width_max'], $a['lot_width_gap']);

	$lot_width_unit = $a['lot_width_unit'];

	$sizes_ranges = get_set_of_range($a['size_min'], $a['size_max'], $a['size_gap']);
	$size_unit = $a['size_unit'];
	$dwelling_type_id = (isset($_GET['dwelling_type']) && $_GET['dwelling_type'])? $_GET['dwelling_type'] : '';
	$lot_with_selected = (isset($_GET['lot_width']) && $_GET['lot_width'])? $_GET['lot_width'] : '';
	$size_selected = (isset($_GET['size']) && $_GET['size'])? $_GET['size'] : '';
	$bedrooms_selected = (isset($_GET['bedrooms']) && $_GET['bedrooms'])? $_GET['bedrooms'] : '';
	
?>
<form action="<?php echo $post_action; ?>" method="get" class="sort__filter__form">
	<div class="sort__filter__wrapper">
		<div class="sort__filter__items">
			<!-- block width -->
			<div class="filter__item">
				<label>Block width:</label>
				<div class="container_select">
					<select name="lot_width" id="lot_width" class="input_select" aria-invalid="false">
						<option value="">Block width</option>
						<?php $count = count($lot_width_ranges); ?>
						<?php foreach($lot_width_ranges as $key => $range): ?>
							<option 
								value="<?php echo $range ?>"
								<?php echo ($range == $lot_with_selected) ? 'selected' : '' ?>><?php echo $range . ' '.$lot_width_unit; ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<!-- Dwelling type -->
			<div class="filter__item">
				<label>Type:</label>
				<div class="container_select">
					<select name="dwelling_type" id="dwelling_type" class="input_select" aria-invalid="false">
						<option value="">Type</option>
						<?php foreach($categories as $category): ?>
								<option 
								value="<?php echo $category->term_taxonomy_id ?>"
								<?php echo ($category->term_taxonomy_id == $dwelling_type_id) ? 'selected' : '' ?>><?php echo $category->name ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<?php if(false): ?>
				<!-- Home size -->
				<div class="filter__item">
					<label>Home size:</label>
					<div class="container_select">
						<select name="size" id="size" class="input_select" aria-invalid="false">
							<option value="">Home size</option>
							<?php $count = count($sizes_ranges); ?>
							<?php foreach($sizes_ranges as $key => $range): ?>
								<option 
									value="<?php echo $range ?>"
									<?php echo ($range == $size_selected) ? 'selected' : '' ?>><?php echo $range . ' '.$size_unit; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			<?php endif ?>
			
			<!-- Bedrooms -->
			<div class="filter__item">
				<label>Bedrooms:</label>
				<div class="container_select">
					<select name="bedrooms" id="bedrooms" class="input_select" aria-invalid="false">
						<option value="">Bedrooms</option>
						<option value="all" <?php if( 'all' == $bedrooms_selected) echo ' selected="selected"'; ?>>All</option>
						<?php for ( $i = $a['bedroom_min'] ; $i <= $a['bedroom_max']; ++$i ) : ?>
							<?php if($i == 1) $label = 'bedroom'; else $label = 'bedrooms'; ?>
							<option value="<?php echo ($i == $a['bedroom_max'])? $i.'+ ' :  $i; ?>"<?php if( $i == $bedrooms_selected) echo ' selected="selected"'; ?>>
							<?php if ($i == $a['bedroom_max']): ?> 
							<?php echo $i.'+ '.$label; ?>
							<?php else: echo $i.' '.$label; endif;?>
						</option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="sort__filter__btn">
			<button type="submit" class="btn section__action__btn"> Apply Filter</button>
		</div>
	</div>
</form>
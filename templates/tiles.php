<?php 

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// Get options
include( locate_template("template-parts/options/common.php", false, false) );

$has_posts = false;
$is_dynamic = $section['tiles_source'] == 'dynamic' ? true : false;

$classes[] = generate_column_alignment_classes($section['column_alignment']);

$tiles = [];

if($is_dynamic) {
	$args = [];

	$args['posts_per_page'] = isset($section['results_to_show']) ? $section['results_to_show'] : 3;
	$args['post_type'] = $section['post_type'] ? $section['post_type'] : 'post';
	$args['post_status'] = 'publish';
	// echo '<pre>';
	// print_r($args);
	// echo '</pre>';
	// die;
	// Sort
	if(isset($section['sort_by'])) {
		switch($section['sort_by']) {
			case 'date_desc': 
				$args['orderby'] = 'post_date';
				$args['order'] = 'DESC';
				break;
			case 'date_asc': 
				$args['orderby'] = 'post_date';
				$args['order'] = 'ASC';
				break;
			case 'name_desc':
				$args['orderby'] = 'title';
				$args['order'] = 'DESC';
				break;
			case 'name_asc':
				$args['orderby'] = 'title';
				$args['order'] = 'ASC';
				break;
			case 'sort':
				$args['orderby'] = 'menu_order';
				$args['order'] = 'ASC';
				break;
			default:
				$args['orderby'] = 'post_date';
				$args['order'] = 'DESC';
				break;
		}
	}

	// If data source is Page
	if($section['post_type'] == 'page') {
		// Filter by post parent
		if($section['parent_pages']) {
			$args['post_parent__in'] = $section['parent_pages'];
		}
	}
	else {
		if($section['post_category']) {
			// Filter by category
			if(is_array($section['post_category'])) {
				$arg['category__in'] = $section['post_category'];
			}
			else {
				$arg['cat'] = $section['post_category'];
			}
		}
	}

	$query = new WP_Query($args);

	$tiles = $query->posts;

	// $has_posts = !empty($posts);
	if(!empty($tiles)) {
		$has_posts = true;
	}

	$section['template_file'] = $args['post_type'];
}
else {
	if($section['tiles']) {
		$tiles = $section['tiles'];
		$has_posts = true;
	}
}
// echo '<pre>';
// var_dump(fix_column_sizes($section['number_of_columns']));
// echo '</pre>';
// die;
?>

<?php if( !($section['when_no_items'] == 'hide' && !$has_posts) ):  ?>
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
			
			<?php if($is_dynamic): ?>
				<div class="tiles --dynamic"
					data-has-next-page="<?php echo $query->found_posts > $args['posts_per_page'] ? 'true' : 'false' ?>"
					data-per-page="<?php echo $args['posts_per_page'] ?>"
					<?php if($section['post_type'] != 'page'): ?>
						data-categories="<?php echo is_array($section['post_category']) ? json_encode($section['post_category']) : $section['post_category'] ?>"
					<?php endif ?>
					data-parent-page="<?php echo $section['post_type'] == 'page' ? json_encode($section['parent_pages']) : '' ?>"
				>
			<?php else: ?>
				<div class="tiles">
			<?php endif ?>
				<div class="row columns tiles__items-wrapper">
					<?php foreach($tiles as $tile): ?>
						<?php 
							$column_class = [
								generate_column_sizes_classes(fix_column_sizes($section['number_of_columns'])),
								"--tile-{$section['template_file']}"
							];
						?>
						<div class="<?php echo implode(array: $column_class, separator: ' ' )?> tiles__item-wrapper">
							<?php include( locate_template("template-parts/tiles/" . $section['template_file'] . ".php", false, false) ); ?>
						</div>
					<?php endforeach ?>
				</div>

				<?php if($is_dynamic): ?>
					<?php if($section['when_no_items'] == 'message' && !$has_posts): ?>
						<span class="tiles__no-results"><?php echo $section['no_items_message'] ?: 'No Results' ?></span>
					<?php endif; ?>

					<?php if($section['loading_more_results'] == 'button'): ?>
						<?php if($query->post_count < $query->found_posts): ?>
							<div class="tiles__load-more">
									<a href="#" class="btn tiles__load-more__btn" data-type="<?php echo $section['post_type'] ?>">
										LOAD MORE
									</a>
							<?php endif ?>
							<div class="tiles__loader text-center" style="display: none; margin-top: 10px;">
								<i class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i>
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php endif ?>
				<?php endif ?>
			</div>

			<?php
				// For section Call to Action
				include(locate_template('/template-parts/sections/call-to-action.php', false, false));
			?>
		</div>
	</div>
<?php endif ?>

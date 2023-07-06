<?php 
// Get options
include( locate_template("template-parts/options/common.php", false, false) );

$has_posts = false;
$is_dynamic = $section['tiles_source'] == 'dynamic' ? true : false;

$classes[] = generate_column_alignment_classes($section['column_alignment']);

$tiles = [];

$is_filterable = isset($section['filterable']) && $section['filterable'];
$is_searchable = isset($section['searchable']) && $section['searchable'];
$uses_custom_filter = $is_dynamic && isset($section['use_custom_filter']);

if($is_dynamic) {
	$args = [];

	$args['posts_per_page'] = isset($section['results_to_show']) ? $section['results_to_show'] : 3;
	$args['post_type'] = $section['post_types'] ? $section['post_types'] : 'post';
	$args['post_status'] = 'publish';

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
	if($section['post_types'] == 'page') {
		// Filter by post parent
		if($section['parent_pages']) {
			$args['post_parent__in'] = $section['parent_pages'];
		}
	}
	// If before and after port type
	elseif($section['post_types'] == 'before-after') {
		if(!empty($section['before_after_categories'])) {
			$tax_query = [
				'taxonomy' => 'before-after-category',
				'field' => 'slug',
				'terms' => []
			];

			foreach($section['before_after_categories'] as $category) {
				$slugs[] = $tax_query['terms'][] = $category->slug;
			}
			
			$args['tax_query'] = [
				$tax_query
			];
		}
	}
	else {
		if($section['post_category']) {
			// Filter by category
			if(is_array($section['post_category'])) {
				$args['category__in'] = $section['post_category'];
			}
			else {
				$args['cat'] = $section['post_category'];
			}
		}

		// override argument if term query string is present in the URL.
		if($is_filterable && isset($_GET['term'])) {
			// build query parameter depending on the filter by value
			if($section['filter']['filter_by'] === 'taxonomy') {
				$taxonomy = $section['post_types'] === 'post' ? 'post' : $section['post_types'] . '_tag';
				$args['tax_query'] = [
					[
						'taxonomy' => $taxonomy, // post 
						'field' => 'slug',
						'terms' => $_GET['term']
					]
				];
			}
			else if($section['filter']['filter_by'] === 'tags') {
				$args['tag'] = $_GET['term'];
			}
		}
	}

	// if searchable and is searching
	if ($is_searchable && isset($_GET['keyword']) && $_GET['keyword']) {
		// search by keyword
		$args['s'] = $_GET['keyword'];
	}

	// Filter by meta
	if($uses_custom_filter) {
		$args['meta_query'] = array_merge(
			[
				'relation' => 'AND'
			],
			[
				'key' => $section['meta']['key'],
				'value' => $section['meta']['value'],
				'compare' => '='
			]
		);
	}

	$args['meta_query'] = array('relation' => 'AND');

	$has_searched = false;

	// Custom
	if(isset($_GET['dwelling_type']) && $_GET['dwelling_type']) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'home_design_dwelling_type', // post 
				'field' => 'term_id',
				'terms' => $_GET['dwelling_type']
			]
		];
		$has_searched = true;
	}
	
	if(isset($_GET['bedrooms']) && $_GET['bedrooms']) {
		if($_GET['bedrooms'] != 'all') {
			
			if (str_contains($_GET['bedrooms'], '+')) {
				$compare = ">=";
				$bedrooms = str_replace('+','',$_GET['bedrooms']);
			}
			else {
				$bedrooms = $_GET['bedrooms'];
				$compare = "=";
			}
			
			array_push($args['meta_query'],
				[
					'key' => 'facades_$_no_of_bedrooms',
					'value' => $bedrooms,
					'type' => 'NUMERIC',
					'compare' => $compare
				]
			);
		}
		$has_searched = true;
	}

	if(isset($_GET['size']) && $_GET['size']) {	
		if (strpos($_GET['size'], '+') !== false) {
			array_push($args['meta_query'],
				[
					'key' => 'facades_$_size',
					'value' => substr_replace($_GET['size'] ,"",-1),
					'type' => 'NUMERIC',
					'compare' 	=> '>=',
				],
			);
		}
		else {
			$size_min = explode("-", $_GET['size'])[0];
			$size_max = explode("-", $_GET['size'])[1];

			$size_within_range = range($size_min, $size_max, 1);

			array_push($args['meta_query'],
				[
					'key' => 'facades_$_size',
					'value' => $size_within_range,
					'compare' 	=> 'IN',
					'type'    => 'numeric',
				]
			);
			
		}

		$has_searched = true;
	}

	if(isset($_GET['lot_width']) && $_GET['lot_width']) {	
		if (strpos($_GET['lot_width'], '+') !== false) {
			array_push($args['meta_query'],
				[
					'key' => 'facades_$_block_width',
					'value' => substr_replace($_GET['lot_width'] ,"",-1),
					'type' => 'NUMERIC',
					'compare' 	=> '>=',
				],
			);
		}
		else {
			$min = explode("-", $_GET['lot_width'])[0];
			$max = explode("-", $_GET['lot_width'])[1];

			$within_range = range($min, $max, 1);

			array_push($args['meta_query'],
				['relation' => 'AND',
					[
						'key' => 'facades_$_block_width',
						'value' => $min,
						'compare' => '>=',
						'type'    => 'DECIMAL',
					],
					[
						'key'     => 'facades_$_block_width',
						'value'   => $max,
						'compare' => '<=',
            			'type'    => 'DECIMAL',
					],
				]
			);
		}
		$has_searched = true;
	}

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args['paged'] = $paged;

	$query = new WP_Query($args);


	$tiles = $query->posts;


	// $has_posts = !empty($posts);
	if(!empty($tiles)) {
		$has_posts = true;
	}
}
else {
	if($section['tiles']) {
		$tiles = $section['tiles'];
		$has_posts = true;
	}
}

$number_of_columns_mobile = $section['number_of_columns']['mobile'];
$number_of_columns_tablet = $section['number_of_columns']['tablet'];
$number_of_columns_desktop = $section['number_of_columns']['desktop'];

if($number_of_columns_tablet == 'inherit') {
	$number_of_columns_tablet = $number_of_columns_mobile;
}
if($number_of_columns_desktop == 'inherit') {
	$number_of_columns_desktop = $number_of_columns_tablet;
}

if($is_filterable) {
	$classes[] = '--filterable';
}

?>

	<div class="section-inner <?php echo implode(' ', $classes)?>" style="<?php echo implode(';', $styles) ?>">

		<?php 
			// For section background
			include(locate_template('/template-parts/sections/background-media.php', false, false));
		?>
		<div class="<?php echo $container  ?>">
			<?php 
				// For section intro content
				include get_template_directory() . '/template-parts/sections/intro-content.php';
			?>
			<?php if( !($section['when_no_items'] == 'hide' && !$has_posts) ):  ?>
				<?php if($is_filterable): ?>
					<div class="tiles-wrapper row">
				<?php endif; ?>
				
					<?php if($is_dynamic): ?>
						<div class="tiles --dynamic <?php echo ab($is_filterable, 'col-xs-12 col-sm-9') ?>"
							data-has-next-page="<?php echo $query->found_posts > $args['posts_per_page'] ? 'true' : 'false' ?>"
							data-per-page="<?php echo $args['posts_per_page'] ?>"
							data-columns-mobile="<?php echo $number_of_columns_mobile ?>"
							data-columns-tablet="<?php echo $number_of_columns_tablet ?>"
							data-columns-desktop="<?php echo $number_of_columns_desktop ?>"
							<?php $results_response_type = is_array($section['results_response_type']) ? $section['results_response_type'][0] : $section['results_response_type']; ?>
							data-response-type="<?php echo $results_response_type ?>"
							<?php if($section['post_types'] != 'page'): ?>
								data-categories="<?php echo is_array($section['post_category']) ? json_encode($section['post_category']) : $section['post_category'] ?>"
							<?php endif ?>
							data-parent-page="<?php echo $section['post_types'] == 'page' ? json_encode($section['parent_pages']) : '' ?>"
							data-template="<?php echo $section['template_file'] ?>"
						>
					<?php else: ?>
						<div class="tiles">
					<?php endif ?>
						<div class="row columns tiles__items-wrapper">
							<?php foreach($tiles as $tile): ?>
								<?php 
									$columns = fix_column_sizes($section['number_of_columns']);

									$column_class = [
										generate_column_sizes_classes($columns)
									];
								?>
								<div class="<?php echo implode($column_class, ' ' )?> tiles__item-wrapper">
									<?php include( locate_template("template-parts/tiles/" . $section['template_file'] . ".php", false, false) ); ?>
								</div>
							<?php endforeach ?>
						</div>

						<?php if($is_dynamic): ?>
							<?php if($section['when_no_items'] == 'message' && !$has_posts): ?>
								<span class="tiles__no-results"><?php echo $section['no_items_message'] ?: 'No Results' ?></span>
							<?php endif; ?>
						<?php endif ?>
					</div><?php // tiles ?>

				<?php if($is_filterable): ?>
					<div class="tiles-filter col-xs-12 col-sm-3">
						<?php

							// get the all tags from the post type.
							$terms = get_terms([
								'taxonomy' => $section['post_types'] . '_tag',
								'hide_empty' => false,
							]);
						?>
						<?php if(!empty($terms)): ?>
							<h3 class="tiles-filter__heading">Filter by tags</h3>
							<ul class="tiles-filter__menu">
								<?php foreach($terms as $term): ?>
								<li class="tiles-filter__menu-item">
									<?php $link = '?' . http_build_query([
										'term' => $term->slug,
										'filter_by' => $section['filter']['filter_by']
									]); ?>
									<a href="<?php echo $link; ?>" rel="nofollow">
										<?php echo $term->name; ?>
									</a>
								</li>
								<?php endforeach; ?>
							</ul>
						<?php endif ?>

						<?php if($is_searchable == true): ?>
							<h3 class="tiles-filter__heading-search">Search</h3>
							<div class="tiles-filter__search">
								<form action="" method="GET">
									<input type="text" name="keyword" class="tiles-filter__search-input" placeholder="Keyword">
									<button class="btn tiles-filter__search-submit">Search</button>
								</form>
							</div>
						<?php endif ?>
					</div><?php // tiles-filter ?>
				<?php endif; ?>

				<?php if($section['loading_more_results'] == 'button'): ?>
					<?php if($query->post_count < $query->found_posts): ?>
						<div class="tiles__load-more">
							<a href="#" class="btn tiles__load-more__btn" data-type="<?php echo $section['post_types'] ?>">
								<?php echo $section['load_button_text'] ?>
							</a>
							<div class="text-center tiles__loader" style="display: none; margin-top: 10px;">
								<i class="fa fa-spinner fa-spin fa-3x fa-fw" aria-hidden="true"></i>
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					<?php endif ?>
				<?php endif ?>
				<?php if($section['loading_more_results'] == 'paginated'): ?>
					<?php
						$pagination_settings = [
							'base' 			=> preg_replace('/\?.*/', '', get_pagenum_link(1)) . '%_%',
							'format'    => 'page/%#%',
							'current'   => max(1, get_query_var('paged')),
							'total'     => $query->max_num_pages,
							'prev_next' => true,
							'prev_text'     => __('< Previous page'),
							'next_text'     => __('Next page >'),
						];

						$pagination_links = paginate_links($pagination_settings);
						$has_next_page = (max(1, get_query_var('paged')) <  $query->max_num_pages) ? true : false;
					?>
					<?php if($pagination_links): ?>
						<div class="pagination <?php echo ($has_next_page)? 'has_next': 'last__page'; ?>"> 
							<?php echo $pagination_links; ?>
						</div>
					<?php endif; ?>
				<?php endif ?>		
				<?php if($is_filterable): ?>
				</div><?php // tiles-wrapper ?>
				<?php endif; ?>

				<?php 
					// For section Call to Action
					include get_template_directory() . '/template-parts/sections/call-to-action.php';
				?>
			<?php elseif(!$has_posts && $has_searched): ?>
				<div class="tiles --no-result">
					<p class="no-result text-center">Sorry, your search criteria does not match any of our home designs. Please try again.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>

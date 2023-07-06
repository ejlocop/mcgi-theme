<?php
	$post_id = get_the_id();
	$tile_acf = get_fields();


	$tile_data['facades'] = array();
	foreach ($tile_acf['facades'] as $key => $facade) {

		$facade['bedrooms'] =  ($facade['no_of_bedrooms'] == 1) ? $facade['no_of_bedrooms'] . ' Bedroom' : $facade['no_of_bedrooms'] . ' Bedrooms';
		$facade['bathrooms'] = ($facade['no_of_bathrooms'] == 1) ? $facade['no_of_bathrooms'] . ' Bathroom' : $facade['no_of_bathrooms'] . ' Bathrooms';
		$facade['carparks'] = $facade['no_of_carparks'];
		$facade['living'] = ($facade['no_of_living_rooms'] == 1) ? $facade['no_of_living_rooms'] . ' Living' : $facade['no_of_living_rooms'] . ' Living';
		$facade['alfresco'] = ($facade['no_of_alfresco'] == 1) ? $facade['no_of_alfresco'] . ' Alfresco' : $facade['no_of_alfresco'] . ' Alfrescos';
		$facade['study'] = ($facade['no_of_study_rooms']) ? ($facade['no_of_study_rooms'] == 1) ?  '+ Study' : '+ ' . $facade['no_of_study_rooms'] . ' Study' : '';

		$facade['bedrooms'] =  ($facade['no_of_study_rooms'] > 0) ? $facade['bedrooms'] . '<br>' . $facade['study'] : $facade['bedrooms'];
		$facade['block_width'] = 'Block width: <br>' . $facade['block_width'] .' metres';
		$facade['flyer'] = $facade['upload_flyer'];
		$tile_data['facades'][] = $facade;
		

	}

	$tile_data['home_design_flyer'] = $tile_acf['home_design_flyer'];


$post_thumbnail = get_the_post_thumbnail_url();
if (!$post_thumbnail) {
	$post_thumbnail = get_field('default_thumbnail', 'options')['url'];
}
$tile_data['thumbnail'] = $post_thumbnail;

$tile_data['home_design_description'] = $tile_acf['home_design_description'];
$inclusions_brochure_file = get_field('homes_inclusions_brochure_file', 'options');
$inclusions_brochure_modal = "#" . get_field('modal_id', get_field('inclusions_brochure_modal', 'options'));

$enquire_button_link = get_field('enquire_button_link', 'options');
$enquire_params = [
	'id' => get_the_id()
];

$contact_email = get_field('contact_email', 'options');
?>

<section id="information" class="section section-two_columns section-home-design home-design">
	<div class="section-inner section-fadein-standard" style="">
		<div class="section__background">
			<div class="section__background__overlay-color"></div>
		</div>
		<div class="section__container container-fluid">
			<div class="row columns">
				<div class="column col-xs-12 col-md-6">
					<h1 class="column__heading"><?php echo get_the_title(); ?></h1>
					<div class="column__content block-content">
						<div class="home-design__details tiles__item__details" id="itemDetails_<?php echo $post_id; ?>">
							<?php if ($tile_data['facades']) : ?>
								<div class="tiles__item__details-item --bedrooms" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'bedrooms', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bedrooms.png" alt="Bedrooms"></div>
									<span><?php echo $tile_data['facades'][0]['bedrooms'] ?>
									</span>
								</div>
								<div class="tiles__item__details-item --bathrooms" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'bathrooms', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/bathrooms.png" alt="Bathrooms"></div>
									<span><?php echo $tile_data['facades'][0]['bathrooms'] ?></span>
								</div>
								<div class="tiles__item__details-item --carparks" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'carparks', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/carparks.png" alt="Carparks"></div>
									<span><?php echo $tile_data['facades'][0]['carparks'] ?></span>
								</div>
								<div class="tiles__item__details-item --living" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'living', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/livingroom.png" alt="Living"></div>
									<span><?php echo $tile_data['facades'][0]['living'] ?></span>
								</div>
								<div class="tiles__item__details-item --alfresco" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'alfresco', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/alfresco.png" alt="Alfresco"></div>
									<span><?php echo $tile_data['facades'][0]['alfresco'] ?></span>
								</div>
								<div class="tiles__item__details-item --block_width" data-item="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'block_width', 'floor_layout_name'))); ?>">
									<div class="icon"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/icons/block.png" alt="Block width"></div>
									<span><?php echo $tile_data['facades'][0]['block_width'] ?></span>
								</div>
							<?php endif ?>
						</div>

						<?php if ($tile_data['home_design_description']) : ?>
							<div class="home-design__description"><?php echo $tile_data['home_design_description'] ?></div>
						<?php endif ?>
					</div>


					<div class="section__action --text-xs-centre --text-md-left --custom-button-width">
						<div class="row">
							<div class="section__action__btn-wrapper col-xs-12 home-design__actions tiles__item__btn">
								<a class="btn --primary" href="<?php echo $inclusions_brochure_modal; ?>">Download flyer</a>
								<?php if ($inclusions_brochure_file && $inclusions_brochure_file['url']) : ?>
									<a class="btn --primary --inclusions" href="<?php echo $inclusions_brochure_modal; ?>">Download inclusions brochure</a>
								<?php endif ?>
								<a class="home-flyer skip-download hidden" href="<?php echo $tile_data['home_design_flyer']; ?>" download>Download</a>
							</div>
						</div>
					</div>

				</div>
				<?php if($tile_data['facades']): ?>
				<div class="column col-xs-12 col-md-6">
					<div class="column__content block-content home-design__floor-layouts">
						<div class="home-design__floor-layouts__heading">
								
							<ul class="block-content home-design__floor-layouts__flipper flipper" data-toggle="flip" data-target="#floorLayout" data-content-id="#itemDetails_<?php echo $post_id; ?>">
								<?php foreach ($tile_data['facades']  as $index => $facade) : ?>
									<li>
										<a class="<?php if($index === 0) echo 'active'; ?>" href="#layout_<?php echo str_replace(' ', '_', $facade['floor_layout_name']); ?>" nofollow><?php echo $facade['floor_layout_name']; ?></a>
									</li>
								<?php endforeach ?>
							</ul>
								
							<div class="home-design__floor-layouts__actions">
								<button type="button" class="flip-button" title="Flip Design">
									<svg xmlns="http://www.w3.org/2000/svg" width="42.475" height="42.104" viewBox="0 0 42.475 42.104">
										<g id="Group_157" data-name="Group 157" transform="translate(-9941.842 -1345.5)">
											<g id="Polygon_1" data-name="Polygon 1" transform="translate(9959.479 1345.5) rotate(90)" fill="rgba(255,255,255,0)">
												<path class="inside" d="M 39.35283660888672 16.63647651672363 L 2.750843048095703 16.63647651672363 L 21.05183601379395 1.304550290107727 L 39.35283660888672 16.63647651672363 Z" stroke="none"/>
												<path class="border" d="M 21.05183601379395 2.609095573425293 L 5.501663208007812 15.63647651672363 L 36.60200119018555 15.63647651672363 L 21.05183601379395 2.609095573425293 M 21.05183601379395 -3.814697265625e-06 L 42.10366439819336 17.63647651672363 L -3.814697265625e-06 17.63647651672363 L 21.05183601379395 -3.814697265625e-06 Z" stroke="none" fill="#707070"/>
											</g>
											<g id="Polygon_2" data-name="Polygon 2" transform="translate(9966.68 1387.604) rotate(-90)" fill="rgba(255,255,255,0)">
												<path class="inside" d="M 39.35283660888672 16.63647651672363 L 2.750843048095703 16.63647651672363 L 21.05183601379395 1.304550290107727 L 39.35283660888672 16.63647651672363 Z" stroke="none"/>
												<path class="border" d="M 21.05183601379395 2.609095573425293 L 5.501663208007812 15.63647651672363 L 36.60200119018555 15.63647651672363 L 21.05183601379395 2.609095573425293 M 21.05183601379395 -3.814697265625e-06 L 42.10366439819336 17.63647651672363 L -3.814697265625e-06 17.63647651672363 L 21.05183601379395 -3.814697265625e-06 Z" stroke="none" fill="#707070"/>
											</g>
											<line id="Line_8" data-name="Line 8" y2="41" transform="translate(9963.362 1346)" fill="none" stroke="#707070" stroke-width="2" stroke-dasharray="4 3"/>
										</g>
									</svg>
								</button>
								<?php 
									$mailto = "mailto:" . $contact_email . "?subject=I am interested in the ";
								?>
								<a class="btn --primary --inclusions" id="enquire" href="<?php echo $mailto . $tile_data['facades'][0]['facade_name']; ?>" data-facade-name="<?php echo htmlspecialchars(json_encode(array_column($tile_data['facades'], 'facade_name', 'floor_layout_name'))); ?>" data-mailto="<?php echo $mailto; ?>">Enquire</a>
							</div>
						</div>
						<div class="content__img home-design__floor-layouts__images" id="floorLayout">
							<?php foreach ($tile_data['facades'] as $index => $facade) : ?>
								<div class="tiles__item__floor-layout__wrapper" id="<?php echo "layout_" . str_replace(' ', '_', $facade['floor_layout_name']); ?>" <?php if ($index >= 1) : ?> style="display: none;" <?php endif ?>>
									<img class="tiles__item__floor-layout__img" src="<?php echo $facade['floor_layout_image'] ?>" alt="<?php echo $facade['floor_layout_name'] ?> floor layout">
									<img class="tiles__item__floor-layout__flip" src="<?php echo $facade['floor_layout_image_flipped'] ?>" alt="<?php echo $facade['floor_layout_name'] ?> flipped design" id="<?php echo "layout_" . str_replace(' ', '_', $facade['floor_layout_name']); ?>" style="display: none;">
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php if($tile_data['facades']): ?>
<section id="facades" class="section section-two_columns section-home-design home-design__facades">
	<div class="section-inner section-fadein-standard" style="">
		<div class="section__background">
			<div class="section__background__overlay-color"></div>
		</div>

		<div class="section__container container-fluid">
			<div class="row columns">
				<div class="column col-xs-12">

					<h3 class="column__heading">Facades</h3>
					<div class="column__content block-content">
						<div class="home-design__facades__image-wrapper">
							<div class="home-design__facades__image-controls">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls">
									<g id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">
										<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" fill="#5b7363" stroke="#fff" stroke-width="2.5">
											<rect width="48" height="48" rx="24" stroke="none"/>
											<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>
										</g>
										<path id="Path_277" class="arrow" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>
									</g>
								</svg>

								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls">
									<g id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">
										<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" fill="#5b7363" stroke="#fff" stroke-width="2.5">
											<rect width="48" height="48" rx="24" stroke="none"/>
											<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>
										</g>
										<path id="Path_211" class="arrow" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>
									</g>
								</svg>
							</div>
							<div class="home-design__facades__image" id="mainFacade">
								<?php foreach($tile_data['facades'] as $facade): ?>
									<img src="<?php echo $facade['facade_image']; ?>" data-image-id="<?php echo str_replace(' ', '_', $facade['floor_layout_name']); ?>" data-lazy-src="<?php echo $facade['facade_image']; ?>"/>
								<?php endforeach ?>
							</div>
						</div>
						<div class="home-design__facades__navs" id="navFacades">
							<?php foreach($tile_data['facades'] as $facade): ?>
								<div class="home-design__facades__navs-wrapper">
									<img class="home-design__facades__navs-image"  src="<?php echo $facade['facade_image']; ?>" data-lazy-src="<?php echo $facade['facade_image']; ?>"/>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
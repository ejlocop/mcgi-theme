<?php

/**
 * Template Name: Contact Page
 * Description: Contact Us Page
 * Template Post Type: page
 */
?>

<?php get_header(); ?>

<?php
$office_location = get_field('office_location', 'options');
$email_address = $office_location['email_address'] ? $office_location['email_address'] : get_field('email_address', 'options');
// echo '<pre>';
// print_r($office_location);
// echo '</pre>';
// die;
?>
<section id="section-contact" class="section section-contact section-two_columns ">
	<style></style>
	<div class="section-inner --th-df --md-nn --ts-xs-md --ts-md-lg --bs-xs-md --bs-md-lg section-fadein-standard">
		<div class="section__background">
			<div class="section__background__overlay-color"></div>
		</div>
		<style>
		</style>
		<div class="section__container container">
			<div class="row columns">
				<div class="column col-xs-12 col-sm-6 col-xs-offset-0 --company-info --text-xs-left">

					<h1 class="column__heading">Contact Us</h1>
					<div class="column__content block-content">
						<p class="location__item">
							<i class="location__item-icon fa fa-phone"></i>
							<span class="location__item-text">
								<?php foreach ($office_location['contact_numbers'] as $contact) : ?>
									<a href="tel:<?php echo $contact['number'] ?>"><?php echo $contact['number'] ?></a>
								<?php endforeach; ?>
							</span>
						</p>
						<p class="location__item">
							<i class="location__item-icon fa fa-envelope"></i>
							<a href="mailto:<?php echo $email_address ?>"><?php echo $email_address ?></a>
						</p>
						<p class="location__item">
							<i class="location__item-icon fa fa-map-marker"></i>
							<span class="location__item-text"><?php echo $office_location['address'] ?></span>
						</p>
						<?php if($google_map_embed_iframe = get_field('google_map_embed_iframe_code', 'options')): ?>
						<div class="map">
							<?php echo $google_map_embed_iframe ?>
						</div>
						<?php endif; ?>
					</div>

				</div>
				<div class="column col-xs-12 col-sm-6 col-xs-offset-0 --form --text-xs-left">
					<div class="column__content block-content">
						<p><?php echo get_field('form_content') ?></p>
						<?php echo do_shortcode('[contact-form-7 id="460" title="Contact Us Form"]') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
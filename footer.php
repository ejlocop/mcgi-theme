<?php

/**
 * Before Footer
 * 
 * inside div.layout__content-container
 */
$before_footer_items = get_field('before_footer', 'options');

$before_footer_excluded_pages = get_field('before_footer_excluded_pages', 'options');

$postID = get_queried_object_id();

// Check if the it is exluded in pages selected
if (!empty($before_footer_excluded_pages) && !in_array($postID, $before_footer_excluded_pages)) {
	if (!empty($before_footer_items)) {
		foreach ($before_footer_items as $key => $section_post) {

			$underlying_section = get_fields($section_post['section']);

			$layout = $underlying_section['layout'];

			// get inner section
			$section = $underlying_section[$layout];

			// generate flexi section
			$key = 'footer_' . $key;
			generate_flexi_section($key, $section, $layout);
		}
	}
}

// var_dump(get_field('social_media_accounts', 'options'));
// die;
$social_media_accounts = get_field('social_media_accounts', 'options')
?>
</div>
</div>
<footer class="footer" data-aos="fade">
	<div class="footer__columns --top">
		<div class="container footer__content">
			<div class="col-xs-12 col-md-4 footer__columns__item --column-1">
				<?php if ($footer_logo = get_field('company_logo', 'options')) : ?>
					<div class="footer__logo">
						<a class="logo" href="<?php echo get_option("siteurl"); ?>">
							<img class="footer__logo__img" src="<?php echo $footer_logo['sizes']['thumbnail'] ?>" alt="<?php echo bloginfo('name') ?>">
						</a>
					</div>
				<?php endif; ?>

				<?php if (is_array($social_media_accounts)) : ?>
					<ul class="footer__accounts-list">
						<?php foreach ($social_media_accounts as $account) : ?>
							<li class="footer__accounts-list_item">
								<a href="<?php echo $account['url']; ?>" target="_blank" title="<?php echo $account['name']; ?>">
									<i class="fa fa-<?php echo strtolower($account['platform']); ?>"></i>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="col-xs-12 col-md-4 footer__columns__item --column-2">
				<?php if (is_active_sidebar('footer_column_1')) : ?>
					<?php dynamic_sidebar('footer_column_1'); ?>
				<?php endif; ?>
			</div>

			<div class="col-xs-12 col-md-4 footer__columns__item --column-3">
				<?php if (is_active_sidebar('footer_column_2')) : ?>
					<?php dynamic_sidebar('footer_column_2'); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>
<script>
	window.config = {
		ajaxUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
		security: '<?php echo wp_create_nonce("load_more_posts"); ?>',
		blogUrl: '<?php echo get_permalink(get_option('page_for_posts')) ?>',
		assetsUrl: '<?php echo get_stylesheet_directory_uri() ?>'
	}
</script>
<?php wp_footer(); ?>
</body>

</html>
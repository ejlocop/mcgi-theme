<?php

/**
 * Before Footer
 * 
 * inside div.layout__content-container
 */
$before_footer_items = get_field('before_footer', 'options');

$before_footer_excluded_pages = get_field('before_footer_excluded_pages','options');

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


?>
	</div>
</div>
<footer class="footer">
	<div class="footer__columns --top">
		<div class="container footer__content">
			<div class="footer__columns__item --column-1">
				<?php if($footer_logo = get_field('footer_logo', 'options')): ?>
					<div class="footer__logo">
						<a class="logo" href="<?php echo get_option("siteurl"); ?>">
							<img class="footer__logo__img" src="<?php echo $footer_logo['url'] ?>" alt="<?php echo bloginfo('name') ?>">
						</a>
					</div>
				<?php endif ?>
			</div>

			<div class="footer__columns__item --column-2">
				<?php if ( is_active_sidebar( 'footer_column_2' ) ) : ?>
					<?php dynamic_sidebar( 'footer_column_2' ); ?>
				<?php endif; ?>
			</div>
				
			<div class="footer__columns__item --column-3">
				<?php if ( is_active_sidebar( 'footer_column_3' ) ) : ?>
					<?php dynamic_sidebar( 'footer_column_3' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="footer__columns --bottom">
		<div class="container footer__content">
			<div class="footer__columns__item --column-1">
				<?php if($footer_copyright = get_field('footer_copyright', 'option')): ?>
					<span class="footer__copyright">
						<?php echo str_replace('[curr_year]', date('Y'), $footer_copyright) ?>
					</span>
				<?php endif ?>
				<?php if($footer_credits = get_field('footer_credits', 'option')): ?>
					<span class="footer__credits"><?php echo $footer_credits ?></span>
				<?php endif ?>
			</div>

			<div class="footer__columns__item --column-2">
				<?php if($footer_credits_design_by = get_field('footer_credits_design_by', 'option')): ?>
					<span class="footer__credits"><?php echo $footer_credits_design_by ?></span>
				<?php endif ?>
			</div>
		</div>
	</div>
</footer>
<?php
// Get the Modals
$site_modals = get_field('modals', 'options');

if(! empty($site_modals)):
?>
	<?php foreach($site_modals as $modal):?>
		<?php
			$modal_acf_fields = get_fields($modal['modal_object']->ID);
		?>
			<div class="modal fade --position-center" id="<?php echo $modal_acf_fields['modal_id'] ?>" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<?php if($modal_acf_fields['modal_header']['enable_modal_header']): ?>
							<div class="modal-header">
								<?php if($modal_acf_fields['modal_header']['header_title']): ?>
									<span class="modal-header__text"><?php echo $modal_acf_fields['modal_header']['header_title'] ?></span>
								<?php endif ?>
								<?php if($modal_acf_fields['enable_close_button']): ?>
									<button type="button" class="close close-dialog" data-dismiss="modal" aria-label="Close"></button>
								<?php endif ?>
							</div>
						<?php endif ?>
						<div class="modal-body">
							<?php echo $modal_acf_fields['modal_body'] ?>
						</div>
					</div>
				</div>
			</div>
	<?php endforeach ?>
<?php endif ?>
<script>
	window.config = {
		ajaxUrl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
		security: '<?php echo wp_create_nonce("load_more_posts"); ?>',
		blogUrl: '<?php echo get_permalink( get_option( 'page_for_posts' ) ) ?>',
		assetsUrl: '<?php echo get_stylesheet_directory_uri() ?>'
	}
</script>
<?php wp_footer(); ?>
</body>
</html>
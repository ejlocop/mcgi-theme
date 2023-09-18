<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>
<?php

$pagename = '';
$body_class = '';

if ($wp_query->post) {
	// add page name to the body class
	$pagename = $wp_query->post->post_title;
	$body_class = 'page-' . str_replace(' ', '-', strtolower($pagename));
}

// main menu
$main_menu = [
	'menu'     	        => 'main',
	'theme_location'    => 'theme_main_nav',
	'container'	        => '',
	'menu_class'        => 'menu scroll-minimal'
];

?>

<body <?php body_class($body_class); ?>>
	<div class="layout__site-wrapper">
		<a href="#content" class="sr-only sr-only-focusable">Skip to main content</a>
		<div id="top"></div>

		<?php
		// echo '<pre>';
		// var_dump(get_field('header_action', 'options'));
		// die;
		// echo '</pre>';
		// die;
		?>

		<!-- Site header -->
		<header id="layout__header" class="layout__header">
			<div class="layout__header__container container">

				<div class="layout__header__sections --top">
					<div class="layout__header__sections__item --logo">
						<a class="logo" href="<?php echo get_option("siteurl"); ?>">
							<img class="logo__image" src="<?php echo get_field('header_logo', 'options')['url'] ?>" alt="<?php echo bloginfo('name') ?>" />
						</a>
					</div>
					<div class="layout__header__sections__item --menu">
						<?php wp_nav_menu($main_menu); ?>
					</div>
					<?php if ($header_action = get_field('header_action', 'options')) : ?>
						<div class="layout__header__sections__item --action">
							<div class="btn-group-contact">
								<a href="<?php echo $header_action['url'] ?>" class="btn btn__contact" title="<?php echo $header_action['title'] ?>">
									<?php echo $header_action['title'] ?>
								</a>
							</div>
						</div>
					<?php endif; ?>
					<div class="layout__header__sections__item --right__burger-menu">
						<a href="javascript: void(0);" class="btn-burger">
							<span></span>
							<span></span>
							<span></span>
						</a>
					</div>
				</div>
			</div>
		</header>

		<!-- Main Menu -->
		<div class="mobile-menu">
			<div class="mobile-menu__inner">
				<div class="mobile-menu__inner__burger-menu">
					<a href="javascript: void(0);" class="btn-burger">
						<span></span>
						<span></span>
						<span></span>
					</a>
				</div>
				<div class="mobile-menu__inner__menu">
					<?php wp_nav_menu($main_menu); ?>
				</div>
				<?php if ($header_action = get_field('header_action', 'options')) : ?>

					<div class="mobile-menu__inner__menu --bottom">
						<div class="btn-group-contact">
							<a href="<?php echo $header_action['url'] ?>" class="btn --light btn__contact" title="<?php echo $header_action['title'] ?>">
								<?php echo $header_action['title'] ?>
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="mobile-menu__backdrop"></div>
		</div>
		<!-- Page content -->
		<div id="content"></div>
		<div id="layout__content" class="layout__content">
			<div class="layout__content-container">
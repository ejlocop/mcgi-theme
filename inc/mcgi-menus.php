<?php

// Register nav menus
function mcgi_theme_register_menu() {
	// Footer
	register_nav_menu('menu_footer', __('Footer'));
}
add_action('init', 'mcgi_theme_register_menu');


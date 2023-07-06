<?php

// Register nav menus
function arkadian_theme_register_menu() {
	// Footer
	register_nav_menu('menu_footer', __('Footer'));
}
add_action('init', 'arkadian_theme_register_menu');


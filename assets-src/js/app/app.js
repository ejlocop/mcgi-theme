// app.js

jQuery(function ($) {
	menuBackgroundColor()
	function menuBackgroundColor() {
		const firstSectionHeight = $('#section-banner').outerHeight() / 2
		const $menu = $('header')

		$(document).on('scroll', function(e) {
			updateBgColor()
		})

		function updateBgColor() {
			
			const scrollTop = window.scrollY

			 // Calculate the scroll position relative to the height of the first section
			const alpha = Math.min(scrollTop / firstSectionHeight, 1)
			
			// Set the new background color for the menu
			$menu.css({
				'background-color': `rgba(27, 73, 187, ${alpha})`
			})
		}
	}
});
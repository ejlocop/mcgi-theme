// app.js

jQuery(function ($) {
	menuBackgroundColor()
	function menuBackgroundColor() {
		const firstSectionHeight = $('#section-banner').outerHeight() / 2
		const $menu = $('header')

		if(isMobile() && !$('body').hasClass('page-home')) {
			return
		}

		$(document).on('scroll', function(e) {
			updateBgColor()
		})

		function updateBgColor() {
			
			const scrollTop = window.scrollY

			 // Calculate the scroll position relative to the height of the first section
			const alpha = Math.min(scrollTop / firstSectionHeight, 1)
			
			// Set the new background color for the menu
			$menu.css({
				'background-color': `rgba(0, 0, 128, ${alpha})`
			})
		}
	}
	menuLinks()
	function menuLinks() {
		if(!$('body').hasClass('page-home')) {
			$('a[href=#section-whoweare],a[href=#section-founders],a[href=#section-services]').attr('href', window.location.origin)
		}

		const headerHeight = document.querySelector('header').clientHeight

		$('a[href=#section-whoweare],a[href=#section-founders],a[href=#section-services]').on('click', function(e) {
			e.preventDefault();
			const target = $(this).attr('href')
			console.log(document.querySelector(target).offsetTop + headerHeight)
			window.scrollTo({
				top: document.querySelector(target).offsetTop - (headerHeight),
				behavior: 'smooth'
			})
		})
	}
});
// app.js

jQuery(function ($) {
	menuBackgroundColor()
	function menuBackgroundColor() {
		const firstSectionHeight = $('#section-banner').outerHeight() / 2
		const $menu = $('header')

		if(isMobile() || !$('body').hasClass('page-home')) {
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
	animateOnScroll()
	function animateOnScroll() {
		if(typeof AOS == undefined) {
			return
		}
  		AOS.init();
	}
	
	menuLinks()
	function menuLinks() {
		if(!$('body').hasClass('page-home')) {
			$('a[href=#section-whoweare],a[href=#section-services]').each(function() {
				const $this = $(this);
				const href = $this.attr('href');
				$this.attr('href', window.location.origin + href);
			})
				
		}

		const headerHeight = document.querySelector('header').clientHeight

		$('a[href=#section-whoweare],a[href=#section-services]').on('click', function(e) {
			e.preventDefault();
			const target = $(this).attr('href')
			console.log(document.querySelector(target).offsetTop + headerHeight)
			window.scrollTo({
				top: document.querySelector(target).offsetTop - (headerHeight),
				behavior: 'smooth'
			})
		})
	}

	ourTeamSlider()
	function ourTeamSlider() {
		const $section = $('.page-our-team #section-gallery')
		const $slider = $section.find('.tiles__items-wrapper')

		$slider.slick({
			infinite: true,
			slidesToShow: 1,
			arrows: true,
			dots: false,
			slidesPerRow: 1,
			autoplay: false,
  			autoplaySpeed: 2000,
			mobileFirst: true,
			lazyLoad: 'ondemand',
			draggable: true,
			prevArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls">'+
				'<g class="group" id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">'+
					'<g class="group__bg" id="Rectangle_87" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path class="group__arrow" id="Path_277" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
			nextArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls">'+
				'<g class="group" id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">'+
					'<g class="group__bg" id="Rectangle_87" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path class="group__arrow" id="Path_211" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
		})

		sliderControlsElement()
	}
});
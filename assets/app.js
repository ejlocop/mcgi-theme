// helpers.js

function getHeader() {
	return jQuery('header');
}

function getHeaderHeight() {
	return getHeader().outerHeight();
}

function getWindowHeight() {
	return jQuery(window).height();
}

function sliderControlsElement() {
	return '<div class="slider__controls">' +
		'<div class="slider__controls__arrow-container --prev">' + 
			'<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls slider__controls__prev">'+
				'<g id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_277" class="arrow" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>'+
		'</div>' +
		'<div class="slider__controls__arrow-container --next">' + 
			'<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls">'+
				'<g id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_211" class="arrow" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>'+
		'</div>' +
	'</div>' +
	'<div class="slider__dots"></div>';
}

function isMobile() {
	return window.matchMedia("(max-width: 767px)").matches;
}

function isTablet() {
	return window.matchMedia("(max-width: 991px)").matches;
}
// app.js

jQuery(function ($) {
	
	header();
	// tilesSlider();
	// accordion();
	homeSlider();
	gallery();

	flipper()
	homeDesign()
	// homeListing

	function header() {
		$(window).scroll(function() {
			var top = $(this).scrollTop();
			if(!isTablet()) {
				if ( top > getHeaderHeight() ) {
					getHeader().addClass('--scroll');
					getHeader().removeClass('--scroll-to-top');
				}
				else {
					if(getHeader().hasClass('--scroll')) {
						getHeader().removeClass('--scroll');
						getHeader().addClass('--scroll-to-top');
					}
				}
			}

			if ( top > getHeaderHeight() ) {
				$('body').addClass('--scroll');
			}
			else {
				$('body').removeClass('--scroll');
			}
		});

		// Mobile menu behaviour
		$('.mobile-menu__inner__menu .menu-item > a').click(function(e) {
			var $link = $(this);
			var $menuItem  = $link.parent();

			if($menuItem.hasClass('menu-item-has-children')) {
				$menuItem.toggleClass('--expanded');
				e.preventDefault();
			}
		});
	}

	dashedLine();
	function dashedLine(){
		$('.section-tiles.--dashed').each(function() {
			var $sectionTiles = $(this);

				$sectionTiles.find('.tiles__item-wrapper').each(function() {
					 $(this).append('<div class="dashed-line"></div>');
				});

			
		});
	}

	function homeDesign() {
		var $enquire = $('#enquire')

		var enquire_link = $enquire.attr('href')
		$('.flip-button').on('click', function(e) {
			// e.preventDefault()

			$(this).toggleClass('active')

			const $wrapper = $('#floorLayout').children().filter(':visible')
			$wrapper.find('img').toggle()
		}).on('flipped', function(e) {
			$(this).removeClass('active')

			const $wrapper = $('#floorLayout').children().filter(':visible')
			$wrapper.find('.tiles__item__floor-layout__img').fadeIn(300)
			$wrapper.find('.tiles__item__floor-layout__flip').hide()
		})

		$('.single-home_designs ul[data-toggle=flip]').on('click', 'a', function(e) {
			var $key = $(this).attr('href').replace('#layout_', '');
			$key = $key.replace('_', " ");
			
			var $mailto = $enquire.data('mailto');
			var $names = $enquire.data('facade-name');
			$enquire.attr('href', $mailto + $names[$key]);
		})
	}

	function flipper() {
		$('[data-toggle=flip]').each(function() {
			var $flip = $(this)
			var $list = $($flip.data('target')).children()

			
			var $thumbnails = $($flip.data('target')).parent().find('.tiles__item__thumbnail')

			// toggler
			$flip.find('a').on('click', function(e) {
				e.preventDefault();
				
				var $toggler = $(this);

				if(!$toggler.hasClass('active')) {
					var $parentList = $toggler.parents('.flipper');
					var $dataItemsContainer = $($parentList.data('content-id'));
					var $key = $(this).text();
					$dataItemsContainer.find('.tiles__item__details-item').each(function() {
						var $dataItem = $(this).data('item');
						$(this).find('span').html($dataItem[$key]);
					});

					var $flyerLink = $('.flyer');
					if($flyerLink.length) {
						var $flyers = $flyerLink.parent().data('flyers');
						$flyerLink.attr('href', $flyers[$key]);
					}

					$flip.find('a').removeClass('active');

					$flip.parents('.tiles__item').find('.flipper a').removeClass('active');
					$flip.parents('.tiles__item').find("a[href='" + $toggler.attr('href') + "']").addClass('active');
					$toggler.addClass('active');

					$list.hide();
					$list.filter($toggler.attr('href')).fadeIn(300)

					if($thumbnails.length) {
						var $facadeNames = $thumbnails.find('.tiles__item__thumbnail__facade-name').data('facade-name');
						$thumbnails.find('.tiles__item__thumbnail__facade-name').text($facadeNames[$key]);

						$thumbnails.find('img').hide()
						$thumbnails.find('img').filter('[data-id="' + $toggler.attr('href').replace('#', '') + '"]').fadeIn(300)
					}
				}
				
				if($('.flip-button').length) {
					$('.flip-button').trigger('flipped')
				}
			})
		})
	}

	// homeCatalogue()
	// function homeCatalogue() {
	// 	$('[data-toggle=flip]').each(function() {
	// 		var $flip = $(this)

	// 		// list
	// 		var $list = $($flip.data('target')).children()
	// 		var $thumbnails = $list.next()

	// 		$flip.find('a').on('click', function(e) {
	// 			e.preventDefault()

				
	// 			var $toggler = $(this)

	// 			$thumbnails.hide()
	// 			$thumbnails.filter('[data-id="' + $toggler.attr('href').replace('#', '') + '"]').fadeIn(300)
	// 		})
	// 	})
	// }

	homeListing()
	function homeListing() {
		$('#facades').find('#mainFacade').slick({
			infinite: true,			
			// slidesToShow: 1,
			adaptiveHeight: true,
			slidesPerRow: 1,
			draggable: false,
			mobileFirst: true,
			asNavFor: '#navFacades',
			prevArrow: $('.home-design__facades__image-controls .slick-prev'),
			nextArrow: $('.home-design__facades__image-controls .slick-next')
		})
		$('#facades').find('#navFacades').slick({
			infinite: true,
			slidesToShow: 2,
			arrows: false,
			dots: false,
			slidesPerRow: 2,
			focusOnSelect: true,

			mobileFirst: true,
			asNavFor: '#mainFacade',
			responsive: [
				{
					breakpoint: 992,
					settings: {
						slidesPerRow: 3,
						slidesToShow: 3,
					}
				}
			]
		});

	}

	function homeSlider() {
		var $homeHeroSection = $('#home--hero-slider');
		var $slider = $homeHeroSection.find('.tiles__items-wrapper')
		
		// var $slider = $homeHeroSection.find('.ui-slider');
		// $slider.find('.slider__items-wrapper').slick("slickSetOption", "draggable", true, false);

		$slider.slick({
			infinite: true,
			slidesToShow: 1,
			arrows: false,
			dots: true,
			slidesPerRow: 1,
			mobileFirst: true,
			lazyLoad: 'ondemand',
			draggable: true
		})

	}

	ourHomeSlider()
	function ourHomeSlider() {
		var $displayHomeSlider = $('#display-home--slider')
		var $slider = $displayHomeSlider.find('.tiles__items-wrapper')

		$slider.slick({
			infinite: true,
			slidesToShow: 1,
			arrows: true,
			dots: false,
			slidesPerRow: 1,
			mobileFirst: true,
			// lazyLoad: 'ondemand',
			prevArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls">'+
				'<g id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_277" class="arrow" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
			nextArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls">'+
				'<g id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_211" class="arrow" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
		})
	}
	
	function gallery() {
		var $slider = $('body.page-gallery').find('#gallery--main-section .tiles .tiles__items-wrapper')
		$slider.slick({
			infinite: true,			
			// slidesToShow: 1,
			slidesPerRow: 1,
			draggable: false,
			mobileFirst: true,
			adaptiveHeight: false,
			arrows: true,
			dots: false,
			lazyLoad: 'ondemand',
			prevArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-prev slick-controls">'+
				'<g id="Group_124" data-name="Group 124" transform="translate(-1218.927 -1292.466)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1218.927 1292.466)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_277" class="arrow" data-name="Path 277" d="M0,10.4,10.113,0l9.574,10.4" transform="translate(1235.717 1327.653) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
			nextArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" class="slick-next slick-controls">'+
				'<g id="Group_155" data-name="Group 155" transform="translate(-1221.548 -1299.311)">'+
					'<g id="Rectangle_87" class="bg" data-name="Rectangle 87" transform="translate(1221.548 1299.311)" fill="#5b7363" stroke="#fff" stroke-width="2.5">'+
						'<rect width="48" height="48" rx="24" stroke="none"/>'+
						'<rect x="1.25" y="1.25" width="45.5" height="45.5" rx="22.75" fill="none"/>'+
					'</g>'+
					'<path id="Path_211" class="arrow" data-name="Path 211" d="M0,0,10.471,10.079,20.386,0" transform="translate(1242.733 1334.158) rotate(-90)" fill="none" stroke="#faf7f7" stroke-linecap="round" stroke-width="2.5"/>'+
				'</g>'+
			'</svg>',
			responsive: [
				{
				  breakpoint: 768,
				  settings: {
					adaptiveHeight: true,
				  }
				},
			]
		})
		var $galleryImages = $slider.find('img.tiles__item__thumbnail__img')
		var $thumbnailImages = $('#gallery--thumbnails .tiles__item-wrapper .tiles__item__thumbnail__img')
		window.$galleryImages = $galleryImages

		$slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
			var nextImage = $galleryImages.get(nextSlide + 1)
			var imageId = $(nextImage).data('id')
			var $thumbnailImage = $thumbnailImages.filter('img[data-id='+ imageId  +']')

			$thumbnailImages.parents('.tiles__item-wrapper').removeClass('active')
			$thumbnailImage.parents('.tiles__item-wrapper').addClass('active')
		})

		setTimeout(function() {
			$thumbnailImages.filter(':first').parents('.tiles__item-wrapper').addClass('active')
		}, 1000)

		const $thumbnailChildren = $('body.page-gallery').find('#gallery--thumbnails .tiles__items-wrapper').children()

		$('body.page-gallery #gallery--thumbnails').on('click', '.tiles__item-wrapper', function() {
			const $this = $(this)
			// console.log($thumbnailChildren, Array.from($thumbnailChildren))
			const index = Array.from($thumbnailChildren).findIndex(function(el) {
				return $this.is($(el))
			})
			$slider.slick('slickGoTo', index)
			// $this.addClass('active')
		})

	}

	downloadBrochure()
	function downloadBrochure(){

		var $page = $('.page-promotions,.page-k-studio,.page-our-inclusions,.single-home_designs')
		var $contentSection = $page.find('#promotions--content,.section-kstudio-process,#inclusions--content,#information')
		$contentSection.find('.section__action__btn-wrapper').find('a:not(.skip-download)').on('click', function(e) {
			e.preventDefault()

			var $link = $(this)
			
			$($link.attr('href')).modal('show')
		});

		$('body').find('form.download-brochure-form').on('submit', function(e) {
			// e.preventDefault()
			if(!$page.hasClass('single-home_designs')) {
				$(this).find('#download-brochure-link').get(0).click();
			}
		});
		
		
	}

	downloadFlyerInModal();
	function downloadFlyerInModal() {
		$(document).on('gform_confirmation_loaded', function(event, form_id) {
			$('.single-home_designs').find(".download-brochure-form a.download-flyer").on('click', function(e) {
				$('.single-home_designs').find('.home-design__actions a.home-flyer').get(0).click()
			});
		});
	
	}

	faqsPage();
	function faqsPage(){
		var $sectionFaqs = $('.section-faqs');

		$sectionFaqs.find('.tiles__item-wrapper').each(function(){
			var $link = $(this).find('.tiles__item__permalink');
			
			$link.on('click', function(e){
				e.preventDefault();

				var $parentItem = $link.parents('.tiles__item');

				if($parentItem.hasClass('--expanded')){
					$parentItem.removeClass('--expanded');
					$parentItem.find('.tiles__item__description').css({'max-height': '0'});

				}
				else {
					$parentItem.addClass('--expanded');
					var innerHeight = $parentItem.find('.tiles__item__description--inner').outerHeight();
					console.log(innerHeight);
					$parentItem.find('.tiles__item__description').css({'max-height': innerHeight});
				}
			});
		});
	}

	openPopup();
	function openPopup() {
		var $sectionPopUP = $('.section.pop-up');

		$sectionPopUP.find('.section__action__btn').click(function(e) {
			e.preventDefault();
			var $target = $(this).attr('href');
			$($target).modal('show');
		});
	}

	$('.smooth-scroll').find('.section__action__btn, .scroll-link').click(function(e) {
		e.preventDefault();
		var target = $(this).data('target') || $(this).attr('href');
		var $target = $(target).first();

		$headerHeight = $('.layout__header__sections.--bottom').outerHeight();

		// smooth scroll to form
		if($target.is(':visible')) {
			if($target.length) {
				$('html, body').animate({
					scrollTop: $target.position().top - $headerHeight
				}, 700);
			}
		} else {
			var t = setTimeout(function() {
				if($target.length) {
					$('html, body').animate({
						scrollTop: $target.position().top - $headerHeight
					}, 700);
				}
			}, 100);
		}
	});

	contentMap();
	
	function newMap($el) {
		var markers = $el.find('.marker');
		var args = {
			zoom:             parseInt($el.data('zoom')),
			scrollwheel:      false,
			disableDefaultUI: false,
			center:           new google.maps.LatLng(0, 0),
			mapTypeId:        google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: $el.hasClass('--disable-ui'),

		};

		if($el.hasClass('greyscale') || $el.hasClass('property-map')) {
			args['styles']	= [{
				'stylers':[{
					'saturation' : -100 
				}]
			}];
		}
		
		var map = new google.maps.Map( $el[0], args);

		map.markers = [];
		markers.each(function(){
			if ($(this).attr('data-lat') && $(this).attr('data-lng')) {
				addMapMarker($(this), map);
			}
		});

		var modalMap = $('#modal--property-map');
		if (modalMap.length) {
			modalMap.on('shown.bs.modal', function() {
				google.maps.event.trigger(map, 'resize');
				setMapCenter(map);
			});
		}

		setMapCenter(map);
		return map;
	}

	function addMapMarker( $marker, map ) {
		var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
		
		var markerConfig = {
			position: latlng,
			map:      map
		};
		if ($marker.attr('data-icon')) {
			markerConfig.icon = {
				url: $marker.attr('data-icon'),
				scaledSize: new google.maps.Size(50, 50),
				// origin: new google.maps.Point(0,0), // origin
				// anchor: new google.maps.Point(0, 0) // anchor
			};
		}
		var marker = new google.maps.Marker(markerConfig);

		map.markers.push(marker);
		if ($marker.html()) {
			var infowindow = new google.maps.InfoWindow({
				content : $marker.html(),
				pixelOffset: new google.maps.Size(0, 80),
				maxWidth: 140
			});

			infowindow.open( map, marker );

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open( map, marker );
			});
		}
		setMapCenter(map);
	}

	function setMapCenter( map ) {
		var bounds = new google.maps.LatLngBounds();
		$.each( map.markers, function( i, marker ){
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		});

		if (map.markers.length == 1) {
			marker = map.markers[0];
			var centreObject = { lat: bounds.getCenter().lat(), lng: bounds.getCenter().lng() };
			map.setCenter(centreObject);
			// map.setZoom( 16 );
		} else {
			map.fitBounds( bounds );
		}
	}

	function contentMap() {
		// delay to wait for zoogooglemaps to load
		var t = setTimeout(function() {
			$('.block-map__map').each(function(){
				map = newMap( $(this) );
			});
		}, 800);
	}
});
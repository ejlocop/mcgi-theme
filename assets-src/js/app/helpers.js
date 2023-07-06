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
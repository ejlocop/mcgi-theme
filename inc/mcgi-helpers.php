<?php

function get_set_of_range($min, $max, $step) {
	$range = array();
	$values = range($min, $max, $step);

	while($min < $max) {
		$numberTo = $min + $step;
		$range[]  =  $min. '-'. $numberTo;
		$min = $numberTo + 1;
	}
	$range[] = $min. '+';

	return $range;
}

if(!function_exists('get_platform_icon')) {
	function get_platform_icon(string $url) {
		// Get the host/domain from the URL
		$host = parse_url($url, PHP_URL_HOST);

		// Remove "www." from the beginning if present
		$host = preg_replace('/^www\./', '', $host);

		// Get only the domain name
		return explode('.', $host)[0];
	}
}
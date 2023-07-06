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
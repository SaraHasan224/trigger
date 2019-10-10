<?php

	function escape($str, $allow_tags = false) {
		if($allow_tags == false) {
			$str = strip_tags($str);
		}
		
		return addslashes($str);
	}
	
	function unescape($str) {
		return stripslashes($str);
	}
	
	function date_difference($date1, $date2) {
		
		$dt1 = new DateTime($date1);
		$dt2 = new DateTime($date2);
		
		$difference = $dt1->diff($dt2);
		return $difference->format("%r%a");
	}
	
	function dmy2ymd($date) {
		
		if(empty($date)) {
			return NULL;
		}
		
		$dt = explode("/", $date);
		return ($dt[2].'-'.$dt[1].'-'.$dt[0]);
	}
	
	function check_date($dt, $sep = "-") {
		if(trim($dt) == "")
			return false;
			
		$d = explode($sep, $dt);
		if(sizeof($d) != 3)
			return false;
			
		if(!ctype_digit($d[0]) || !ctype_digit($d[1]) || !ctype_digit($d[2]))
			return false;
			
		return checkdate($d[1], $d[2], $d[0]);
	}
	
	function make_slug($string = null, $separator = "-")
	{
		if (is_null($string)) {
			return "";
		}
		
		$string = mb_strtolower($string, "UTF-8");
		$string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
		$string = trim($string);
		$string = preg_replace("/[\s-]+/", " ", $string);
		$string = preg_replace("/[\s_]/", $separator, $string);
	
		return $string;
	}

function number_shorten($number) {
	if($number > 999999999) {
		return number_format(($number/1000000000))."B";
	} else if($number > 999999) {
		return number_format(($number/1000000))."M";
	} else if($number > 999) {
		return number_format(($number/1000))."K";
	} else {
		return $number;
	}
}
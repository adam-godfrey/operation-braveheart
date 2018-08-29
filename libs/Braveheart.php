<?php

// all the odds and sods functions that don't fit into a specific class
class Braveheart {

	public function __construct() {
	
	}
			
	// This function displays the number of millisecods it takes to execute a database query
	public static function getmicrotime() {
	
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	// this function rounds a value to the nearest half
	public function round_to_half($num) {
	
		if($num >= ($half = ($ceil = ceil($num))- 0.5) + 0.25)
		{
			return $ceil;
		}
		else if($num < $half - 0.25) 
		{
			return floor($num);
		}
		else 
		{
			return $half;
		}
	}
	
	public static function formatDate($val) {
	
		$arr = explode("-", $val);
		return date("d F Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
	}

	public function getMonth($val, $vals) {
	
		$arr = explode("-", $val);
		return date($vals, mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
	}
	
	public function GetRating($val) {		
		$ratings = array(
			"0" => "0%",
			"0.5" => "10%",
			"1" => "20%",
			"1.5" => "30%",
			"2" => "40%",
			"2.5" => "50%",
			"3" => "60%",
			"3.5" => "70%",
			"4" => "80%",
			"4.5" => "90%",
			"5" => "100%",
		);
		
		switch($val) {
			case 0:
				$rate = $ratings["0"];
				break;
			case 0.5:
				$rate = $ratings["0.5"];
				break;
			case 1:
				$rate = $ratings["1"];
				break;
			case 1.5:
				$rate = $ratings["1.5"];
				break;
			case 2:
				$rate = $ratings["2"];
				break;
			case 2.5:
				$rate = $ratings["2.5"];
				break;
			case 3:
				$rate = $ratings["3"];
				break;
			case 3.5:
				$rate = $ratings["3.5"];
				break;
			case 4:
				$rate = $ratings["4"];
				break;
			case 4.5:
				$rate = $ratings["4.5"];
				break;
			case 5:
				$rate = $ratings["5"];
				break;
			default:
		}
		
		return $rate;
	}
	
	public function getMargin($img,$w,$h) {
	
		list($width, $height) = getimagesize($img);

		$marginlr = ($width < $w) ? floor(($w-$width)/2) : "0";
		$margintb = ($height < $h) ? floor(($h-$height)/2) : "0";
		
		return array($marginlr, $margintb);
	}
	
	public function getDateDifference($start_date, $end_date) {

		$diff = abs(strtotime($end_date) - strtotime($start_date));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		
		if($years == 1) {
			$year_str = ' year';
		}
		else {
			$year_str = ' years';
		}
		if($months == 1) {
			$month_str = ' month';
		}
		else {
			$month_str = ' months';
		}
		if($days == 1) {
			$day_str = ' day';
		}
		else {
			$day_str = ' days';
		}
		
		if($years == 0) {
			
			if($months == 0) {
				
				return $days.$day_str;
			}
			return $months.$month_str. ' '.$days.$day_str;
		}
		else {
			return $years.$year_str.' '.$months.$month_str. ' '.$days.$day_str;
		}
	}
}
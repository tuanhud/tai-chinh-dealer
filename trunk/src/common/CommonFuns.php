<?php
class CommonFuns
{
	public static function int_to_date($int) {
		if (is_numeric($int)) {
			$time  = date("d/m/Y", $int);
			return $time;
		}
		return "";		
	}
	
	public static function int_to_date2($int) {
		if (is_numeric($int)) {
			$time  = date("d/m/Y H:i:s", $int);
			return $time;
		}
		return "";		
	}
	
	public static function isNullOrEmpty ($value) {
		if (is_null($value) || strlen($value) == 0)
			return true;
		return false;
	}
	
	function changnumbermoney($number) {
		$stemp = "";
		for(;;) {
			if(strlen($number) > 3) {
				$ext = substr($number, -3);
				$number = substr($number, 0, -3);
				$stemp = ".".$ext.$stemp;
			} else {
				$stemp = $number.$stemp;
				break;
			}
		}
		return $stemp;
	}
}
?>
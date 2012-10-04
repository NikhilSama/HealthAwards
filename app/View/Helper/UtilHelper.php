<?php
class UtilHelper extends AppHelper
{
	public $helpers = Array("Text",'Html','Session');
	public $colorArray = 																				array('#FFFF00','#9ACD32','#FF7F50','#0000FF','#A52A2A','#5F9EA0','#DC143C','#00FFFF','#B8860B','#A9A9A9','#BDB76B','#8B008B','#2F4F4F','#FF1493','#B0C4DE','#00FF7F','#BEC401','#ADB404','#33B204','#A2C000','#DFCD01','#CC000A');

	public function mnEncrypt($data){
		App::uses('EncryptComponent', 'Controller/Component');
		$obj=new EncryptComponent();
		return $obj->mnEncrypt($data);
	}

	public function mnDecrypt($data){
		App::uses('EncryptComponent', 'Controller/Component');
		$obj=new EncryptComponent();
		return $obj->mnDecrypt($data);
	}

	
function timeAgo($datetime, $granularity=1, $format='Y-m-d H:i:s') {

        $timestamp = strtotime($datetime);
        $difference = time() - $timestamp;

        if($difference < 0) return '0 seconds ago';             // if difference is lower than zero check server offset
        elseif($difference < 864000) {                                   // if difference is over 10 days show normal time form
            $periods = array('week' => 604800,'day' => 86400,'hr' => 3600,'min' => 60,'sec' => 1);
            $output = '';
            foreach($periods as $key => $value){

                    if($difference >= $value){

                            $time = round($difference / $value);
                            $difference %= $value;

                            $output .= ($output ? ' ' : '').$time.' ';
                            $output .= (($time > 1 && $key == 'day') ? $key.'s' : $key);

                            $granularity--;
                    }
                    if($granularity == 0) break;
            }
            return ($output ? $output : '0 seconds').' ago';
        }
        else return date($format, $timestamp);
	}
	public function getOrdinal($number=0)
	{
	// Handles special case three digit numbers ending
	// with 11, 12 or 13 - ie, 111th, 112th, 113th, 211th, et al
		if ($number > 99) {
			$intEndNum = substr($number,-2);
			if ($intEndNum >= 11 And $intEndNum <= 13) {
				switch ($intEndNum){
					case (11 or 12 or 13):
						return "th";
						break;
				}
			}
		}
		if ($number >= 21) {
		// Handles 21st, 22nd, 23rd, et al
			switch (substr($number,-1)) {
				case 0:
					return "th";
					break;
				case 1:
					return "st";
					break;
				case 2:
					return "nd";
					break;
				case 3:
					return "rd";
					break;
				case (4 || 5 || 6 || 7 || 8 || 9):
					return "th";
					break;
				}
		} else {
		// Handles 1st to 20th
			switch ($number){
				case 1:
					return "st";
					break;
				case 2:
					return "nd";
					break;
				case 3:
					return "rd";
					break;
				case (4 || 5 || 6 || 7 || 8 || 9 || 10 || 11 || 12 || 13 || 14 || 15 || 16 || 17 || 18 || 19 || 20):
					return "th";
					break;
			}
		}
	} // end func am_GetOrdinal

	
    function cleanSentizeString($string) {
 		$string = str_replace("\\r\\n", "", $string);
		$string = str_replace("><", "> <" , $string);
        return stripslashes($string);
    }
	public function isbrowser(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	return $useragent;
	}
	
	public function array_flatten(&$a,$pref='') {
   $ret=array();
   foreach ($a as $i => $j)
       if (is_array($j))
           $ret=array_merge($ret,$this->array_flatten($j,$pref.$i));
       else
           $ret[$pref.$i] = $j;
   return $ret;
   }

	public function date_diff($d1, $d2){
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);
		$d2 = (is_string($d2) ? strtotime($d2) : $d2);

		$diff_secs = abs($d1 - $d2);
		$base_year = min(date("Y", $d1), date("Y", $d2));

		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array(
			"years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff)
		);
	}	
	public function daysNameList($days){
		$datyNameArr = unserialize(DAYS_NAME);
		$tmpArr=array();
		$arr = explode(',',$days);
		foreach($arr as $val){
			if(isset($datyNameArr[$val]))
				$tmpArr[]=$datyNameArr[$val];
		}
		return implode(', ',$tmpArr);
	}
}

?>
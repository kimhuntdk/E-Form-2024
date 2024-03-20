<?php
define( 'DB_HOST', 'localhost' ); // set database host
define( 'DB_USER', 'smartfarmdev' ); // set database user
define( 'DB_PASS', 'smartfd' ); // set database password
define( 'DB_NAME', 'smartfarmdev' ); // set database name
define( 'SEND_ERRORS_TO', '' ); //set email notification email address
define( 'DISPLAY_DEBUG', true ); //display db errors?

require_once( 'class.db.php' );
$database = new DB();

/**
 * Filter all post data
 */
if( isset( $_POST ) )
{
    foreach( $_POST as $key => $value )
    {
        $_POST[$key] = $database->filter( $value );
    }
}

function tel_format_pst($mobile){
	$minus_sign = "-"; 
	$part1 = substr ( $mobile , 0 , -7 ); 
	$part2 = substr( $mobile , 3 , -3 ); 
	$part3 = substr( $mobile , 7 ); 
	return $part1. $minus_sign . $part2 . $minus_sign . $part3;
}

function thaiDate_pst($datetime) {
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	
    return $d."/".$m."/".$Y;
}

function DateThai1_pst($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strHour= date("H",strtotime($strDate));
    $strMinute= date("i",strtotime($strDate));
    $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "วันที่ $strDay $strMonthThai $strYear, เวลา $strHour:$strMinute";
}

function DateThai_shot_pst($strDate)
{
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("j",strtotime($strDate));
    $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "วันที่ $strDay $strMonthThai $strYear";
}

function date_format_convert_pst($date_get){
	$today = date("Y-m-d");
	list($byear, $bmonth, $bday)= explode("-",$date_get);
	list($tyear, $tmonth, $tday)= explode("-",$today);	
	$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
	$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
	$mage = ($mnow - $mbirthday);
	$u_y=date("Y", $mage)-1970;
	$u_m=date("m",$mage)-1;
	$u_d=date("d",$mage)-1;
	return "$u_y ปี $u_m เดือน $u_d วัน";
}

function timespan_pst($seconds = 1, $time = '')
{
	if ( ! is_numeric($seconds)){
		$seconds = 1;
	}
	if ( ! is_numeric($time)){
		$time = time();
	}
	if ($time <= $seconds){
		$seconds = 1;
	}
	else{
		$seconds = $time - $seconds;
	}
	$str = '';
	$years = floor($seconds / 31536000);
	if ($years > 0){	
		$str .= $years.' ปี, ';
	}	
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
    
	if ($years > 0 OR $months > 0){
		if ($months > 0){	
			$str .= $months.' เดือน, ';
		}	
		$seconds -= $months * 2628000;
	}
	$weeks = floor($seconds / 604800);
	if ($years > 0 OR $months > 0 OR $weeks > 0){
		if ($weeks > 0){	
			$str .= $weeks.' สัปดาห์, ';
		}
		$seconds -= $weeks * 604800;
	}			
	$days = floor($seconds / 86400);
	if ($months > 0 OR $weeks > 0 OR $days > 0){
		if ($days > 0){	
			$str .= $days.' วัน, ';
		}
		$seconds -= $days * 86400;
	}
	$hours = floor($seconds / 3600);
	if ($days > 0 OR $hours > 0){
		if ($hours > 0){
			$str .= $hours.' ชั่วโมง, ';
		}
		$seconds -= $hours * 3600;
	}
	$minutes = floor($seconds / 60);
	if ($days > 0 OR $hours > 0 OR $minutes > 0){
		if ($minutes > 0){	
			$str .= $minutes.' นาที, ';
		}
		$seconds -= $minutes * 60;
	}
	if ($str == ''){
		$str .= $seconds.' วินาที';
	}
	return substr(trim($str), 0, -1);
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function mobileDetect() {
    $_SESSION['mobile-detect'] = array();
    switch(true) {
        case (preg_match("/ipad/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'iPad';
            $_SESSION['mobile-detect']['manu'] = "Apple";
            return true;
            break;
        case (preg_match("/ipod/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'iPod';
            $_SESSION['mobile-detect']['manu'] = "Apple";
            return true;
            break;
        case (preg_match("/iphone/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'iPhone';
            $_SESSION['mobile-detect']['manu'] = "Apple";
            return true;
            break;
        case (preg_match("/android/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'Android';
            $_SESSION['mobile-detect']['manu'] = "Google";
            return true;
            break;
        case (preg_match("/blackberry/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'Blackberry';
            $_SESSION['mobile-detect']['manu'] = "RIM";
            return true;
            break;
        case (preg_match("/blackberry/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'Blackberry';
            $_SESSION['mobile-detect']['manu'] = "RIM";
            return true;
            break;
        case (preg_match("/windows ce; smartphone;|windows ce; iemobile/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'WindowsCE';
            $_SESSION['mobile-detect']['manu'] = "Microsoft";
            return true;
            break;
        case (preg_match("/touchpad|hpwos/i", $_SERVER['HTTP_USER_AGENT']));
            $_SESSION['mobile-detect']['device'] = 'HP TouchPad';
            $_SESSION['mobile-detect']['manu'] = "HP";
            return true;
            break;
        default:
            return false;
            break;
    }
}

?>
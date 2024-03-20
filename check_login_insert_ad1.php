<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "lib/nusoap.php" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
$user = "6750";
    	//======== check ว่าเคย insert  table หรือไม่ ================
		$sql_chk = " select advisorcode FROM  request_advisor WHERE  advisorcode=".$user ;
		$rs_chk = $mysqli->query( $sql_chk );
		$num_chk = $rs_chk->num_rows;
		if($num_chk==0){
		//======== insert table request_advisor ================ 
	$url = "http://202.28.34.2/webservice/JsonOfficergardtostudent.php?officercode=".$user;
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$results = json_decode($contents); 
	   foreach ($results as $key => $value) { 
    foreach ($value as $k => $v) { 
        if($k=="officercode"){
	        $officercode = $v;
		}
		if($k=="prefixname"){
		   $prefixname = $v;
		}
		if($k=="officername"){
		  $officername = $v;
		}
		if($k=="officersurname"){
		   $officersurname = $v;
		}
		if($k=="prefixnameeng"){
		  $prefixnameeng = $v;
		}
		if($k=="officernameeng"){
		  $officernameeng = $v;
		}
		if($k=="officersurnameeng"){
		  $officersurnameeng = $v; 
		}
	
		if($k=="facultyid"){
		  $facultyid = $v; 
		}
		if($k=="facultyname"){
		   $facultyname = $v;
		}
		if($k=="citizenid"){
		   $citizenid = $v;
		}
    }
    }
//เพิ่มข้อมูลอาจารย์
		     $sql = " INSERT INTO request_advisor (advisorcode,prefixname,advisorname,advisorsurname,prefixnameeng,advisornameeng ";
			 $sql .= ",advisorsurnameeng,facultyid,facultyname,citizenid,advisor_email,advisor_modifile)";
			 $sql.= "values('$officercode','$prefixname','$officername','$officersurname','$prefixnameeng','$officernameeng' ";
			 $sql.= ",'$officersurnameeng','$facultyid','$facultyname',$citizenid,'',Now())";
			 echo $sql;
			 $rs = $mysqli->query( $sql );
			  $_SESSION['SES_ID'] = session_id();
              $_SESSION["SES_LEVEL"] = "advisor_ses";
			  $_SESSION["SES_USER"] = $_REQUEST[ 'user' ];
} else {
	          $_SESSION['SES_ID'] = session_id();
              $_SESSION["SES_LEVEL"] = "advisor_ses";
			  $_SESSION["SES_USER"] = $_REQUEST[ 'user' ];
}

?>
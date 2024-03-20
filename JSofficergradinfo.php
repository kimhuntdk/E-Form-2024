<?php
    session_start();
    require_once( "inc/db_connect.php" );
    $mysqli = connect();
	//$sql_chk = " select std_faculty_id FROM  request_student WHERE  std_id_std=".$_SESSION['SES_STDCODE'] ;
   $sql_chk = " select std_faculty_id FROM  request_student WHERE  std_id_std='57011282001' ";
	$rs_chk = $mysqli->query( $sql_chk );
	$row_chk = $rs_chk->fetch_array();
	$url = "http://202.28.34.2/webservice/JsonOfficergard.php?fac=999";
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$results = json_decode($contents); 
	echo "<option value='0'>กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์</option>";
	foreach ($results as $key => $value) {   
    foreach ($value as $k => $v) { 
       if($k=="officercode"){
		   echo "<option value='$v'>";
		}
		if($k=="prefixname"){
		   echo $v;
		}
		if($k=="officername"){
		   echo $v."&nbsp;&nbsp;";
		}
		if($k=="officersurname"){
		   echo $v;
		}
    }
	echo "</option>";
}


?>

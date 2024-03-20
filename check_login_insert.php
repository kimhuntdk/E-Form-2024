<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "lib/nusoap.php" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
$user = $mysqli->real_escape_string($_REQUEST['user']);
$client = new SoapClient( "http://regpr.msu.ac.th/webservice/WsStudentinformation.php?wsdl");
$params = array(
	'studentcode' => $user //$_GET['stdcode']
);
$data = $client->__soapCall( "Studentinformation", $params );
 $data;

$mydata = json_decode( $data, true ); // json decode from web service


if ( count( $mydata ) == 0 ) {
	echo "Not found data!";
} else {

	foreach ( $mydata as $result ) {


		$STUDENTCODE = $result[ "STUDENTCODE" ];
		$SFACULTYID = $result["SFACULTYID"];
		$STUDENTNAME = $result[ "STUDENTNAME" ];
		$STUDENTSURNAME =  $result[ "STUDENTSURNAME" ];
		$CAMPUSNAME = $result[ "CAMPUSNAME" ];
		$LEVELNAME = $result[ "LEVELNAME" ];
		$PROGRAMNAME= $result[ "PROGRAMNAME" ];
		$STUDENTNAMEENG = $result[ "STUDENTNAMEENG" ];
		$STUDENTSURNAMEENG = $result[ "STUDENTSURNAMEENG" ];
		$CAMPUSNAMEENG = $result[ "CAMPUSNAMEENG" ];
		$LEVELNAMEENG = $result[ "LEVELNAMEENG" ];
		$PROGRAMNAMEENG = $result[ "PROGRAMNAMEENG" ];
	    $FACULTYNAMEENG = $result["FACULTYNAMEENG"];
	    $FACULTYNAME = $result["FACULTYNAME"];
		$CITIZENID = $result[ "CITIZENID" ];
		//======== check ว่าเคย insert  table หรือไม่ ================
		$sql_chk = " select std_id_std FROM  request_student WHERE  std_id_std=".$STUDENTCODE ;
		$rs_chk = $mysqli->query( $sql_chk );
		$num_chk = $rs_chk->num_rows;
		//======== insert table นิสิต ================ 
		if($num_chk == 0) {
			 $sql = " INSERT INTO request_student (std_id_std,std_id_crad,std_fname_th,std_lname_th,std_fname_en,std_lname_en ";
			 $sql .= ",std_province_th,std_degree_th,std_faculty_th,std_faculty_id,std_major_th,std_province_en,std_degree_en ";
			 $sql .= ",std_faculty_en,std_major_en,std_img,std_email,std_modifile)";
			 $sql.= "values('$STUDENTCODE','$CITIZENID','$STUDENTNAME','$STUDENTSURNAME','$STUDENTNAMEENG','$STUDENTSURNAMEENG' ";
			 $sql.= ",'$CAMPUSNAME','$LEVELNAME','$FACULTYNAME','$SFACULTYID','$PROGRAMNAME','$CAMPUSNAMEENG','$LEVELNAMEENG' ";
			 $sql.= ",'$FACULTYNAMEENG','$PROGRAMNAMEENG','-','-',Now())";
			 //echo $sql;
			 $rs = $mysqli->query( $sql );
			  $_SESSION['SES_ID'] = session_id();
              $_SESSION['SES_STDCODE'] 	= $STUDENTCODE;
			  $_SESSION['SES_STDNAME_FULL_TH'] 	= $STUDENTNAME." ".$STUDENTSURNAME;
			 if($rs){
				 echo 1; // เพิ่มข้อมูลสำเร็จ
			 }else {
				echo 2;	 // ไม่สามารถเพิ่มเข้อมูลได้
			}
		} else {
			  $_SESSION['SES_ID'] = session_id();
              $_SESSION['SES_STDCODE'] 	= $STUDENTCODE;
              $_SESSION['SES_STDNAME_FULL_TH'] 	= $STUDENTNAME." ".$STUDENTSURNAME;
			1;	// เคยเพิ่มข้อมูลแล้ว ให้สามารถ ผ่านเข้าสู่ระบบได้
		}

	}
}


?>
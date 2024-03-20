<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "lib/nusoap.php" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
if($_REQUEST['btn_send_mail_std']=='btn_send_mail_std'){
 $_REQUEST['adv_email_std'];

		//======== insert table นิสิต ================ 
		if($_REQUEST['adv_email_std']!='') {
	          $sql = "UPDATE request_student SET std_email='$_REQUEST[adv_email_std]',std_modifile=Now() WHERE std_id_std= ".$_SESSION['SES_STDCODE'];
			 //echo $sql;
			 $rs = $mysqli->query( $sql );
			
			 if($rs){
				 echo 1; // เพิ่มข้อมูลสำเร็จ
			 }else {
				echo 2;	 // ไม่สามารถเพิ่มเข้อมูลได้
			}
		
 }
}
// แก้ไข อีเมลอาจารย์
if($_REQUEST['btn_send_adv']=='btn_send_adv'){
 $_REQUEST['adv_email_adv'];

		//======== insert table  ================ 
		if($_REQUEST['adv_email_adv']!='') {
	          $sql = "UPDATE request_advisor SET advisor_email='$_REQUEST[adv_email_adv]',advisor_modifile=Now() WHERE advisorcode= ".$_SESSION['SES_USER'];
			// echo $sql;
			 $rs = $mysqli->query( $sql );
			
			 if($rs){
				 echo 1; // เพิ่มข้อมูลสำเร็จ
			 }else {
				echo 2;	 // ไม่สามารถเพิ่มเข้อมูลได้
			}
		
 }
}


?>
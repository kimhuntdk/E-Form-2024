<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "lib/nusoap.php" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
$type_id = $_REQUEST[type_id];
if($type_id==1){
	$page = "Request_Form_Certificate_Thesis_Advisor.php";
}else if($type_id==2){
	$page = "Request_Form_Certificate_Topic_Thesis.php";
}
$status = 1;
if($status ==1) {
$client = new nusoap_client( "http://regpr.msu.ac.th/webservice/WsStudentlogin.php?wsdl", true );
$params = array(
	'studentcode' => $_REQUEST[ 'user' ], 'out_password' => $_REQUEST[ 'pass' ]
);
$data = $client->call( "Studentlogin", $params );
//echo $data;

$mydata = json_decode( $data, true ); // json decode from web service


if ( count( $mydata ) == 0 ) {
	echo "Not found data!";
} else {
	?>
<meta charset="utf-8">
<?php
	foreach ( $mydata as $result ) {
	
		          if($result["xpass"]==1){
					   $_SESSION['SES_ID'] = session_id();
                       $_SESSION['SES_STDCODE'] 	= $_REQUEST[ 'user' ];
					  echo "<script>  window.location ='$page'; </script>"; // เข้าระบบได้
				  }elseif($result["xpass"]==0){
					  echo "<script> alert('ชื่อใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง'); window.location ='$page'; </script>"; // นิสิตเข้าระบบ ไม่ได้
				  }

	}
  }
} 


?>

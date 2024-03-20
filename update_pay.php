<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
$SES_USER = $_SESSION[ "SES_USER" ];
if ( $_SESSION[ "SES_LEVEL" ] != "staff_ses" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
$type_id = $_REQUEST[ type_id ];
$doc_id = $_REQUEST[ doc_id ];
$status = $_REQUEST[status];
if ( $type_id == 1 ) { // Del ลงทะเบียน Thesis เพิ่ม
	 $sql_ti = "UPDATE   request_taking_leave SET payment='$status' WHERE  doc_id = " . $doc_id;
	$rs_ti = $mysqli->query( $sql_ti );
	if ( $rs_ti ) {
		?>
		<script>
			alert( "successful" );
			window.location = 'staff.php';
		</script>
		<?php
	} else {
		?>
		<script>
			alert( "Error" );
		window.location = 'staff.php';
		</script>
		<?php

	}
} else if ( $type_id == 3 ) { // Del ลาพักกาเรียน
	$sql_tl = "UPDATE  request_registration_thesis_is  SET payment='$status' WHERE  doc_id = " . $doc_id; 
	$rs_tl = $mysqli->query( $sql_tl );
	if ( $rs_tl ) {
		?>
		<script>
			alert( "successful" );
			window.location = 'staff.php';
		</script>
		<?php
	} else {
		?>
		<script>
			alert( "Error" );
			window.location = 'staff.php';
		</script>
		<?php
	}
}
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Update</title>
</head>

<body>
</body>

</html>
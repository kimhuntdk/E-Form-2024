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
 $doc_id = base64_decode( $_REQUEST[ id ] );
$sql_del = "DELETE FROM request_doc WHERE  doc_id = " . $doc_id;
$rs_del = $mysqli->query( $sql_del );
if ( $type_id == 1 ) { // Del ลงทะเบียน Thesis เพิ่ม
	$sql_ti = "DELETE FROM request_registration_thesis_is WHERE  doc_id = " . $doc_id;
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
		
		</script>
		<?php

	}
} else if ( $type_id == 3 ) { // Del ลาพักกาเรียน
	$sql_tl = "DELETE FROM request_taking_leave WHERE  doc_id = " . $doc_id;
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
	<title>Delete</title>
</head>

<body>
</body>

</html>
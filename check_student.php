<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "lib/nusoap.php" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
$std_id = $_REQUEST['std_id'];
$client = new nusoap_client( "http://regpr.msu.ac.th/webservice/WsStudentinformation.php?wsdl", true );
$params = array(
	'studentcode' => $std_id //$_GET['stdcode']
);
$data = $client->call( "Studentinformation", $params );
//echo $data;

$mydata = json_decode( $data, true ); // json decode from web service


if ( count( $mydata ) == 0 ) {
	echo "Not found data!";
} else {

	foreach ( $mydata as $result ) {


	   	$STUDENTCODE = $result[ "STUDENTCODE" ];
		//$SFACULTYID = $result["SFACULTYID"];
	   echo $STUDENTNAME = $result[ "STUDENTNAME" ];
	   echo $STUDENTSURNAME =  $result[ "STUDENTSURNAME" ];
	   echo "<br>";
	   echo $PROGRAMNAME= $result[ "PROGRAMNAME" ];
		
	

	}
}


?>
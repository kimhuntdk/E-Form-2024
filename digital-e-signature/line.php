<?php 
    session_start();
    include ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");

			//============= แจ้งเตือน line
			define('LINE_API',"https://notify-api.line.me/api/notify");
 
			$token = "eXRBb7KxOV3gJmPXGSMO2BgkMEbH8FkwaLRsoftWwF0"; //ใส่Token ที่copy เอาไว้
			$str = "มีคำร้อง ตามระบบ e-Form 10.16"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

			$res = notify_message($str,$token);
			//print_r($res);
			function notify_message($message,$token){
			 $queryData = array('message' => $message);
			 $queryData = http_build_query($queryData,'','&');
			 $headerOptions = array( 
					 'http'=>array(
						'method'=>'POST',
						'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
								  ."Authorization: Bearer ".$token."\r\n"
								  ."Content-Length: ".strlen($queryData)."\r\n",
						'content' => $queryData
					 ),
			 );
			 $context = stream_context_create($headerOptions);
			 $result = file_get_contents(LINE_API,FALSE,$context);
			 $res = json_decode($result);
			 return $res;
			}

?>
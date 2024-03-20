<?php 
    session_start();
    require_once ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
	$result = array();
	$imagedata = base64_decode($_POST['img_data']);
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './doc_signs/'.$filename.'.png';
	file_put_contents($file_name,$imagedata);
	$result['status'] = 1;
	$result['file_name'] = $file_name;
	//echo json_encode($result);
	$semester = $mysqli->real_escape_string($_POST['semester']);
	$academic = $mysqli->real_escape_string($_POST['academic']);

	$advisor_chairman_status = $mysqli->real_escape_string($_POST['advisor_chairman_status']);							
	if (isset($_POST['argument'])) {
		$argument = $mysqli->real_escape_string($_POST['argument']);
		} else {
			$argument = "";
		}	
	$doc_id = $mysqli->real_escape_string($_POST['doc_id']);
    $std_id = $mysqli->real_escape_string($_POST['std_id']);
	if($advisor_chairman_status !=''){
		// อาจารย์ได้พิจารณาอกสารคำร้องลาพักการเรียน request_registration_thesis_is
		$sql = "Update request_taking_leave set advisor_chairman_status='$advisor_chairman_status',advisor_chairman_node='$argument',advisor_chairman_signature='$filename',advisor_chairman_date=Now() Where doc_id='$doc_id' ";
	    $rs_doc = $mysqli->query( $sql );
		if($rs_doc){
			//=== ส่ง email ข้อมูลอาจารย์
			/*$sql_mail = "SELECT prefixname,advisorname,advisorsurname,advisor_email FROM request_advisor WHERE advisorcode='5510' "; //session codeoffice 
			$rs_mail = $mysqli->query( $sql_mail );
			$row_mail = $rs_mail->fetch_array();
			$advisor_email = $row_mail["advisor_email"];
			$advisor_name_full = $row_mail["prefixname"].$row_mail["advisorname"]." ".$row_mail["advisorsurname"];*/
		    //== ข้อมูลนิสิต 
			$sql_std = "SELECT std_id_std,std_fname_th,std_lname_th,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=".$std_id;
			$rs_std = $mysqli->query( $sql_std );
			$row_std = $rs_std->fetch_array();
			$std_id_std = $row_std['std_id_std'];
			$std_degree_th = $row_std['std_degree_th'];
			$std_faculty_th = $row_std['std_faculty_th'];
			$date_now_th = DateThai1(date('Y-m-d H:i:s'));
			
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
				$mail->Host = "smtp.gmail.com";
				$mail->Port = 587;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
				$mail->isHTML();
				$mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
				$mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
				$mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
				$mail->SetFrom('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ลาพักการเรียน”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่บัณฑิตวิทยาลัย<br>
	เรื่อง คำร้องลาพักการเรียน <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ลาพักการเรียน” ภาคเรียนที่ $semester/$academic ของนิสิตชื่อ $row_std[std_fname_th] $row_std[std_lname_th] รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th  ได้โปรดรพิจารณาลงนามคำร้อง “ลาพักการเรียน” 
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('rateefa3@hotmail.com','เจ้าหน้าที่บัณฑิตวิทยาลัย'); //อีเมล์และชื่อผู้รับ
				$mail->addCC("jakkrid.b@msu.ac.th");
				//$mail->AddAddress('$advisor_email','$advisor_name_full'); //อีเมล์และชื่อผู้รับ

				$mail->Send();
			
	// 		//============= แจ้งเตือน line
	// 	/*	define('LINE_API',"https://notify-api.line.me/api/notify");
 
	// 		$token = "eXRBb7KxOV3gJmPXGSMO2BgkMEbH8FkwaLRsoftWwF0"; //ใส่Token ที่copy เอาไว้
	// 		$str = "มีคำร้อง ตามระบบ e-Form"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร

	// 		$res = notify_message($str,$token);
	// 		//print_r($res);
	// 		function notify_message($message,$token){
	// 		 $queryData = array('message' => $message);
	// 		 $queryData = http_build_query($queryData,'','&');
	// 		 $headerOptions = array( 
	// 				 'http'=>array(
	// 					'method'=>'POST',
	// 					'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
	// 							  ."Authorization: Bearer ".$token."\r\n"
	// 							  ."Content-Length: ".strlen($queryData)."\r\n",
	// 					'content' => $queryData
	// 				 ),
	// 		 );
	// 		 $context = stream_context_create($headerOptions);
	// 		 $result = file_get_contents(LINE_API,FALSE,$context);
	// 		 $res = json_decode($result);
	// 		 return $res;
	// 		}*/
			echo 1; //เพิ่มข้อมูลสำเร็จ
		} else {
			echo 2; //ไม่สามารถเพิ่มข้อมูลได้
		}
	} else {
		echo 3;	 //ไม่สามารถเพิ่มข้อมูลได้ทีแรก
	}
	
?>

<?php 
    session_start();
    include ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');


	//Location to where you want to created sign image
	$registration_division_status = trim($_POST['registration_division_status']);							
	$argument = trim($_POST['argument']); 	
	$doc_id = trim($_POST['doc_id']); 
     $std_id = trim($_POST['std_id']); 
	if($registration_division_status !=''){
		// อาจารย์ได้พิจารณาอกสารคำร้องลาพักการเรียน request_registration_thesis_is
		$sql = "Update request_retaining_student_status set registration_division_status='$registration_division_status',registration_division_node='$argument' Where doc_id='$doc_id' ";
	    $rs_doc = $mysqli->query( $sql );
		if($rs_doc){
		    //== ข้อมูลนิสิต 
			$sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=".$std_id;
			$rs_std = $mysqli->query( $sql_std );
			$row_std = $rs_std->fetch_array();
			$std_id_std = $row_std['std_id_std'];
			$std_degree_th = $row_std['std_degree_th'];
			$std_faculty_th = $row_std['std_faculty_th'];
			$std_name_full = $row_std['std_fname_en'].' '.$row_std['std_lname_en'] ;
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
				$mail->SetFrom  ('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ขอคืนสภาพการเป็นนิสิต Retaining Student Status”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่บัณฑิตวิทยาลัย<br>
	เรื่อง ขอคืนสภาพการเป็นนิสิต Retaining Student Status<br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ขอคืนสภาพการเป็นนิสิต Retaining Student Status” ของนิสิตชื่อ $std_name_full รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th  
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('jakkrid.b@msu.ac.th','เจ้าหน้าที่บัณฑิตวิทยาลัย'); //อีเมล์ผู้รับ
				//$mail->AddAddress('$advisor_email','$advisor_name_full'); //อีเมล์และชื่อผู้รับ
				
				$mail->Send();
			//=============
			echo 1; //เพิ่มข้อมูลสำเร็จ
		} else {
			echo 2; //ไม่สามารถเพิ่มข้อมูลได้
		}
	} else {
		echo 3;	 //ไม่สามารถเพิ่มข้อมูลได้ทีแรก
	
	}
	
?>
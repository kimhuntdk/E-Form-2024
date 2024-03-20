<?php 
    session_start();
    include ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	require_once('../PHPMailer/PHPMailerAutoload.php');
	$result = array();
	$imagedata = base64_decode($_POST['img_data']);
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './doc_signs/'.$filename.'.png';
	file_put_contents($file_name,$imagedata);
	$result['status'] = 1;
	$result['file_name'] = $file_name;
	$dean_admin_approve_disapprove = trim($_POST['dean_admin_approve_disapprove']);							
	$argument = trim($_POST['argument']); 	
	$doc_id = trim($_POST['doc_id']);
	$staff_id = trim($_POST['staff_id']); 	 	
	if($dean_admin_approve_disapprove !=''){
		// อาจารย์ได้พิจารณาอกสารคำร้องลาพักการเรียน request_registration_thesis_is
		$sql = "Update request_document_in set dean_admin_approve_disapprove='$dean_admin_approve_disapprove',dean_admin_node='$argument',dean_admin_signature='$filename',dean_admin_date=Now() Where doc_id='$doc_id' ";
	    $rs_doc = $mysqli->query( $sql );
		if($rs_doc){
			 //== ข้อมูเจ้าหน้าที่
           $sql_name = "SELECT staff_name,staff_id FROM request_staff WHERE staff_id='$staff_id' ";
               $rs_name = $mysqli->query( $sql_name );
             $row_name = $rs_name->fetch_array();
			 $staff_name = $row_name['staff_name'];
			 $staff_position = $row_name['staff_position'];
			 $staff_email = $row_name['staff_email'];
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
				$mail->Password = "123456789"; // ใส่รหัสผ่าน
				$mail->SetFrom = ('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] บันทึกข้อความ”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนคุณ $staff_name<br>
	เรื่อง คำร้องลาพักการเรียน <br><br>
	ระบบ e-Form Graduate MSU ผู้บริหารพิจารณา “บันทึกข้อความ”  $staff_name ตำแหน่ง $staff_position  เมื่อ$date_now_th   
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress($staff_email,$staff_name); //อีเมล์และชื่อผู้รับ
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
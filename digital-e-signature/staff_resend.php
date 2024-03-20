<?php 
    session_start();
    include ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	require_once('../PHPMailer/PHPMailerAutoload.php');
					
	 $doc_node = trim($_POST['doc_node']); 	
	 $doc_id = trim($_POST['doc_id']); 	
     $doc_type = trim($_POST['doc_type']); 
	//====หาหรัสนิสิต
	 $sql_doc = "SELECT doc_std_id FROM request_doc WHERE doc_id=".$doc_id;
	$rs_doc = $mysqli->query( $sql_doc );
	$row_doc = $rs_doc->fetch_array();
	 $row_doc['doc_std_id'];
	//====หาชื่อนิสิต
   $sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=".$row_doc['doc_std_id'];
	$rs_std = $mysqli->query( $sql_std );
	$row_std = $rs_std->fetch_array();
	
	if($doc_type==3){ //ลงทะเบียนเพิ่ม
		$sql_in = "INSERT INTO request_reject (doc_id,reject_node,doc_type,reject_date)VALUES('$doc_id','$doc_node',$doc_type,Now())";
		$mysqli->query($sql_in);
		
		$sql_up = "UPDATE request_registration_thesis_is SET registration_division_status=0 , registration_division_node='' WHERE doc_id=".$doc_id;
		$rs = $mysqli->query($sql_up);
		if($rs){
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
				$mail->SetFrom = ('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ลงทะเบียน Thesis/IS”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่กองทะเบียน<br>
	เรื่อง คำร้องลงทะเบียน Thesis/IS <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ลงทะเบียน Thesis/IS” ของนิสิตชื่อ $std_name_full รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th  
	ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('diskko@hotmail.com','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
				//$mail->AddAddress('$advisor_email','$advisor_name_full'); //อีเมล์และชื่อผู้รับ
				$mail->Send();
			echo 1;
		}else {
			echo 2;
		}
	
	} else if($doc_type==1){ //ลาพักการเรียน
		$sql_in = "INSERT INTO request_reject (doc_id,reject_node,doc_type,reject_date)VALUES('$doc_id','$doc_node',$doc_type,Now())";
		$mysqli->query($sql_in);
		
			$sql_up = "UPDATE request_taking_leave SET registration_division_status=0 , registration_division_node='' WHERE doc_id=".$doc_id;
		$rs = $mysqli->query($sql_up);
		if($rs){
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
				$mail->Password = "123456789"; // ใส่รหัสผ่าน
				$mail->SetFrom = ('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ลงทะเบียน Thesis/IS”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่กองทะเบียน<br>
	เรื่อง คำร้องลาพักการเรียน <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ลาพักการเรียน” ของนิสิตชื่อ $std_name_full รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th   
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('diskko@hotmail.com','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
				//$mail->AddAddress('$advisor_email','$advisor_name_full'); //อีเมล์และชื่อผู้รับ
				$mail->Send();
			echo 1;
		}else {
			echo 2;
		}
		
	} else if($doc_type==13){ //ลาพักการเรียน
		$sql_in = "INSERT INTO request_reject (doc_id,reject_node,doc_type,reject_date)VALUES('$doc_id','$doc_node',$doc_type,Now())";
		$mysqli->query($sql_in);
		
			$sql_up = "UPDATE request_retaining_student_status SET registration_division_status=0 , registration_division_node='' WHERE doc_id=".$doc_id;
		$rs = $mysqli->query($sql_up);
		if($rs){
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
				$mail->Password = "123456789"; // ใส่รหัสผ่าน
				$mail->SetFrom = ('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
				$mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ขอคืนสภาพการเป็นนิสิต/Retaining student status”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่กองทะเบียน<br>
	เรื่อง ขอคืนสภาพการเป็นนิสิต <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ขอคืนสภาพการเป็นนิสิต” ของนิสิตชื่อ $std_name_full รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th   
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('diskko@hotmail.com','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
				//$mail->AddAddress('$advisor_email','$advisor_name_full'); //อีเมล์และชื่อผู้รับ
				$mail->Send();
			echo 1;
		}else {
			echo 2;
		}
	}
	


?>
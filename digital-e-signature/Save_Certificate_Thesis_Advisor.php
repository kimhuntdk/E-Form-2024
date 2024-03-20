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
	$title_th = trim($_POST['title_th']);	
	$advisor_name = trim($_POST['advisor_name']);	
	$advisor_faculty = trim($_POST['advisor_faculty']);		
	$academic = trim($_POST['academic']);
	$email = trim($_POST['email']);										


	//==ตรวจสอบก่อนว่า เคยส่งลงทะเบียนเพิ่มใน เทอมเดี่ยวกัน หรือไม่
/*	$sql_chk = "SELECT rd.doc_type,rd.doc_std_id,rgt.subject_code,rgt.semester,rgt.academic,rgt.advisor_chairman_status FROM request_doc rd left join request_registration_thesis_is rgt on rd.doc_id = rgt.doc_id WHERE rd.doc_std_id=".$_SESSION["SES_STDCODE"];
	$rs_chk= $mysqli->query( $sql_chk );
	$row_chk = $rs_chk->fetch_array();
	$doc_type_ck = $row_chk['doc_type'];//ชนิดเอกสาร
	$doc_std_id_ck = $row_chk['doc_std_id'];//รหัสประจำตัวนิสิต
	$semester_ck = $row_chk['semester'];//ภาคเรียน
	$academic_ck = $row_chk['academic'];//ปีการศึกษา
	$advisor_chairman_status_ck = $row_chk['advisor_chairman_status'];// สถานะคำร้อง 0 มีการส่งคำร้องเข้าสู่ระบบ 1 อนุมัติ  2 ไม่อนุมัติ
	if($advisor_chairman_status_ck==0){
		if($doc_type_ck==3 and $semester_ck==$semester and $academic_ck==$academic){
			echo 4;//มีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา
			exit;
		}
	}*/
	//==insert table request_doc
	//รหัสประเภท 98 คือ หนังสือรับรองการเป็นอาจารย์ที่ปรึกษาวิทยานิพนธ์หลัก
	 $sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(98,'$_SESSION[SES_STDCODE]',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
	$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max[max_doc_id];
	$id_ = base64_encode($max_id);
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสารคำร้องลาพักการเรียน request_student_status_retention
		$sql_doc = "INSERT INTO request_certificate_thesis_advisor (doc_id,academic,subject,std_email,advisor_name,advisor_faculty,std_signature,std_date_signature) ";
		$sql_doc .= "values($max_id,'$academic','$title_th','$email','$advisor_name','$advisor_faculty','$filename',Now()) ";
	    //echo $sql_doc;
		$rs_doc = $mysqli->query( $sql_doc );
		if($rs_doc){
		    //== ข้อมูลนิสิต 

			
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
				$mail->Subject = "[e-Form Graduate MSU]”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียน เจ้าหน้าที่บัณฑิตวิทยาลัย<br>
	เรื่อง หนังสือรับรองการเป็นอาจารย์ที่ปรึกษาวิทยานิพนธ์หลัก <br><br>
		ด้วยข้าพเจ้า $name 
		 
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic/Doc-Certificate-of-Thesis-Advisor.php?id=$id_  
	เป็นที่เรียบร้อยแล้ว
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$$mail->AddAddress($email,'ผู้ยื่นคำร้อง'); //ผู้ยื่นคำร้อง
				$mail->addCC("watthanachai.s@msu.ac.th");//เจ้าหน้าที่
				//$mail->AddAddress($email,$advisor_name_full); //อีเมล์และชื่อผู้รับ
				$mail->Send();
			
			//=============
			
			echo 1; //เพิ่มข้อมูลสำเร็จ
		} else {
			echo 2; //ไม่สามารถเพิ่มข้อมูลได้
		}
	} else {
		echo 3;	 //ไม่สามารถเพิ่มข้อมูลได้ทีแรก
	}
	//echo json_encode($result);
?>
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
	$titlename = trim($_POST['titlename']);	
	$name = trim($_POST['name']);	
	$major = trim($_POST['major']);	
	$faculty = trim($_POST['faculty']);	
	$semester = trim($_POST['semester']);		
	$academic = trim($_POST['academic']);									
	$late_registration = trim($_POST['late_registration']);	
	$payment_chk = trim($_POST['payment_chk']);
	$payment_chk_date = trim($_POST['payment_chk_date']);
	$problem_bank_1 = trim($_POST['problem_bank_1']);
	$capital_form_2 = trim($_POST['capital_form_2']);
	$evidence_late = trim($_POST['evidence_late']);
	$photo_1 = trim($_POST['photo_1']);
	$printed_2 = trim($_POST['printed_2']);	
    $copy_payment_3 = trim($_POST['copy_payment_3']);
	$copy_id_card_4 = trim($_POST['copy_id_card_4']);
	$copy_house_5 = trim($_POST['copy_house_5']);
	$completed_transcript_6 = trim($_POST['completed_transcript_6']);
	$change_name_surname_7 = trim($_POST['change_name_surname_7']);
	$others_8 = trim($_POST['others_8']);
	$others = trim($_POST['others']);
	$certificate = trim($_POST['certificate']);
	$submit_document = trim($_POST['submit_document']);
	$phone = trim($_POST['phone']);	
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
	 $sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(99,'$_SESSION[SES_STDCODE]',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
	$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max['max_doc_id'];
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสารคำร้องลาพักการเรียน request_student_status_retention
		$sql_doc = "INSERT INTO request_memorandum_student (doc_id,titlename,name_surname,major,faculty,semester,academic,late_registration,payment_chk,problem_bank_1,capital_form_2,payment_chk_date,evidence_late,photo_1,printed_2,copy_payment_3,copy_id_card_4,copy_house_5,completed_transcript_6,change_name_surname_7,others_8,others_name,certificate,submit_document,phone,email,std_signature,std_date_signature) ";
		$sql_doc .= "values($max_id,'$titlename','$name','$major','$faculty','$semester','$academic','$late_registration','$payment_chk','$problem_bank_1','$capital_form_2','$payment_chk_date','$evidence_late','$photo_1','$printed_2','$copy_payment_3','$copy_id_card_4','$copy_house_5','$completed_transcript_6','$change_name_surname_7','$others_8','$others','$certificate','$submit_document','$phone','$email','$filename',Now()) ";
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
				$mail->Body = "เรียน $name<br>
	เรื่อง ยืนยันการส่งบันทึกข้อความ <br><br>
		ด้วยข้าพเจ้า $name  ผ่านการคัดเลือกขั้นสุดท้ายเพื่อเข้าศึกษาต่อได้ในสาขาวิชา $major มีความประสงค์ใคร่ขอความอนุเคราะห์ผ่อนผัน (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ในการรายงานตัวเข้าศึกษาต่อในระดับบัณฑิตศึกษา มหาวิทยาลัยมหาสารคาม
		 
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic  เป็นที่เรียบร้อยแล้ว
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress($email,$name); //อีเมล์และชื่อผู้รับ
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

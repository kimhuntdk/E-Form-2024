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
	$choose = trim($_POST['choose']);								
	$semester = trim($_POST['semester']);		
	$academic = trim($_POST['academic']);		
	$because = trim($_POST['because']);	
	$advisor = trim($_POST['advisor']);	
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
	$sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(5,'$_SESSION[SES_STDCODE]',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
	$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max[max_doc_id];
	//== การ เพิ่ม email ในการส่งคำร้อง
  	$sql_insert_mail = "INSERT INTO request_send_email (email_name,doc_id,doc_std_id,doc_date)values('$email','$max_id','$_SESSION[SES_STDCODE]',Now()) ";
	$mysqli->query( $sql_insert_mail );
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสารคำร้องลาพักการเรียน request_student_status_retention
		$sql_doc = "INSERT INTO request_changing_student_status (doc_id,semester,academic,because,choose,std_signature,std_date_signature,advisor_chairman) ";
		$sql_doc .= "values($max_id,'$semester','$academic','$because','$choose','$filename',Now(),'$advisor') ";
		//echo $sql_doc;
	    $rs_doc = $mysqli->query( $sql_doc );
		if($rs_doc){
			//=== ส่ง email ข้อมูลอาจารย์
			$sql_mail = "SELECT prefixname,advisorname,advisorsurname,advisor_email FROM request_advisor WHERE advisorcode='$advisor' ";
			$rs_mail = $mysqli->query( $sql_mail );
			$row_mail = $rs_mail->fetch_array();
			$advisor_email = $row_mail["advisor_email"];
			$advisor_name_full = $row_mail["prefixname"].$row_mail["advisorname"]." ".$row_mail["advisorsurname"];
		    //== ข้อมูลนิสิต 
			$sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=".$_SESSION['SES_STDCODE'];
			$rs_std = $mysqli->query( $sql_std );
			$row_std = $rs_std->fetch_array();
			$std_id_std = $row_std['std_id_std'];
			$std_degree_th = $row_std['std_degree_th'];
			$std_faculty_th = $row_std['std_faculty_th'];
			$date_now_th = DateThai1(date('Y-m-d H:i:s'));
			if($email!=""){
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
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “ขอปรับเปลี่ยนสภาพนิสิต”";  //หัวเรื่อง emal ที่ส่ง 
				$mail->Body = "เรียนอาจารย์ที่ปรึกษา $advisor_name_full<br>
	เรื่อง คำร้องขอปรับเปลี่ยนสภาพนิสิต <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ขอปรับเปลี่ยนสภาพนิสิต” ภาคเรียนที่ $semester/$academic ของนิสิตชื่อ $_SESSION[SES_STDNAME_FULL_TH] รหัส $std_id_std  นิสิต $std_degree_th คณะ$std_faculty_th เมื่อ $date_now_th  ได้โปรดรพิจารณาลงนามคำร้อง “ขอปรับเปลี่ยนสภาพนิสิต” 
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				//$mail->AddAddress('jakkrid.b@msu.ac.th','Advisor'); //อีเมล์และชื่อผู้รับ
				$mail->AddAddress($email,$advisor_name_full); //อีเมล์และชื่อผู้รับ
				$mail->Send();
			}
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
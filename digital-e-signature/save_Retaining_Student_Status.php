<?php
session_start();
include("../inc/db_connect.php");
require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
$mysqli = connect();
date_default_timezone_set("Asia/Bangkok");
$result = array();
$imagedata = base64_decode($_POST['img_data']);
$filename = md5(date("dmYhisA"));
//Location to where you want to created sign image
$file_name = './doc_signs/' . $filename . '.png';
file_put_contents($file_name, $imagedata);
$result['status'] = 1;
$result['file_name'] = $file_name;

$semester = $mysqli->real_escape_string($_POST['semester']);
$academic = $mysqli->real_escape_string($_POST['academic']);
$because = $mysqli->real_escape_string($_POST['because']);
$pay_semester = $mysqli->real_escape_string($_POST['pay_semester']);
if ($because != 'ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต') {
	$pay_semester = 0;
}
if ($pay_semester == "") {
	$pay_semester = NULL;
}
// รับเหตุผลว่าจะลาพักหรือลงทะเบียน
$doc_type_id = $mysqli->real_escape_string($_POST['doc_type_id']);

// เช็คว่าข้อมูลที่รับมาว่าหากลงทะเบียนเรียน
if ($doc_type_id == 3 && $doc_type_id != " ") {
$type_thesis = $mysqli->real_escape_string($_POST['type_thesis']);
$subject_code = $mysqli->real_escape_string($_POST['subject_code']);
$credits = $mysqli->real_escape_string($_POST['credits']);
$group = $mysqli->real_escape_string($_POST['group']);
$classid = $mysqli->real_escape_string($_POST['classid']);
$semester_cs = $mysqli->real_escape_string($_POST['semester_cs']);
$academic_cs = $mysqli->real_escape_string($_POST['academic_cs']);
$because_thesis = $mysqli->real_escape_string($_POST['because_thesis']);
} else {
// รับแค่ภาคเรียนหากระบุว่าภาคเรียนปัจจุบันต้องการลาพัก
	$type_thesis = NULL;
	$subject_code = NULL;
	$credits = NULL;
	$group = NULL;
	$classid = NULL;
	$semester_cs = $mysqli->real_escape_string($_POST['semester_cs']);
	$academic_cs = $mysqli->real_escape_string($_POST['academic_cs']);
	$because_thesis = NULL;
}

// 
$advisor = $mysqli->real_escape_string($_POST['advisor']);
$email = $mysqli->real_escape_string($_POST['email']);
$std_email = $mysqli->real_escape_string($_POST['std_email']);


$advisor_chairman_status = NULL;
$advisor_chairman_signature = NULL;
$advisor_chairman_node = NULL;
$argument = NULL;
$advisor_chairman_date = NULL;
$staff_grad_node = NULL;
$staff_grad_approve_disapprove = NULL;
$staff_grad_date = NULL;
$dean_admin = NULL;
$dean_admin_approve_disapprove = NULL;
$dean_admin_signature = NULL;
$dean_admin_node = NULL;
$dean_admin_date = NULL;
$registration_division_status = NULL;
$registration_division_node = NULL;
$payment = NULL;
//==ตรวจสอบก่อนว่า เคยส่งลงทะเบียนเพิ่มใน เทอมเดี่ยวกัน หรือไม่
/*	$sql_chk = "SELECT rd.doc_type,rd.doc_std_id,rgt.subject_code,rgt.semester,rgt.academic,rgt.advisor_chairman_status FROM request_doc rd left join request_taking_leave rgt on rd.doc_id = rgt.doc_id WHERE rd.doc_std_id=".$_SESSION["SES_STDCODE"];
		$rs_chk= $mysqli->query( $sql_chk );
		$row_chk = $rs_chk->fetch_array();
		$doc_type_ck = $row_chk['doc_type'];//ชนิดเอกสาร
		$doc_std_id_ck = $row_chk['doc_std_id'];//รหัสประจำตัวนิสิต
		$semester_ck = $row_chk['semester'];//ภาคเรียน
		$academic_ck = $row_chk['academic'];//ปีการศึกษา
		$advisor_chairman_status_ck = $row_chk['advisor_chairman_status'];// สถานะคำร้อง 0 มีการส่งคำร้องเข้าสู่ระบบ 1 อนุมัติ  2 ไม่อนุมัติ
		if($advisor_chairman_status_ck==0){
			if($doc_type_ck==1 and $semester_ck==$semester and $academic_ck==$academic){
				echo 4;//มีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา
				exit;
			}
		}*/

//==insert table request_doc
$sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(31,'$_SESSION[SES_STDCODE]',Now()) ";
$rs_request_doc = $mysqli->query($sql_request_doc);
//== หา row ล่าสุด 
$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
$rs_max = $mysqli->query($sql_max);
$row_max = $rs_max->fetch_array();
$max_id = $row_max['max_doc_id'];
if ($rs_request_doc) {
	// เพิ่มข้อมูลเอกสารคำร้องขอคืนสภาพการเป็นนิสิต
	$sql_doc = "INSERT INTO request_retaining_student_status (doc_id,semester,academic,because,pay_semester,std_email,std_signature,std_date_signature,advisor_chairman ";
	$sql_doc .= ",advisor_chairman_status,advisor_chairman_signature,advisor_chairman_node,argument,advisor_chairman_date,staff_grad_node ";
	$sql_doc .= ",staff_grad_approve_disapprove,staff_grad_date,dean_admin,dean_admin_approve_disapprove,dean_admin_signature ";
	$sql_doc .= ",dean_admin_node,dean_admin_date,registration_division_status,registration_division_node,payment ) ";
	$sql_doc .= "values($max_id,'$semester','$academic','$because','$pay_semester','$std_email','$filename',Now(),'$advisor' ";
	$sql_doc .= ", '0', 'NULL' , '', 'NULL', Now(), '', '0', Now(), '0', '0', 'NULL', '',Now(), '0', '', '0')";
	// echo $sql_doc;


	if ($rs_doc = $mysqli->query($sql_doc)) {
		// Get the last inserted ID from the info_expert table
		$retaining_student_id = $mysqli->insert_id;
	} else {
		//echo "no id";
	}

	// เพิ่มขอมูลเทอมที่ขอลาพักการเรียน
	$tl_semester_str = implode(',', $_POST['tl_semester']);
	$tl_academic_str = implode(',', $_POST['tl_academic']);

	$tl_semester_array = explode(",", $tl_semester_str);
	$tl_academic_array = explode(",", $tl_academic_str);

	$tl_semester_array = array_map('intval', $tl_semester_array);
	$tl_academic_array = array_map('intval', $tl_academic_array);


	// วนลูปเพื่อเพิ่มข้อมูลเทอมที่ขอลาพักการเรียนลงในฐานข้อมูล
	for ($i = 0; $i < count($tl_semester_array); $i++) {

		$tl_semester_value = $tl_semester_array[$i];
		$tl_academic_value = $tl_academic_array[$i];

		$sql_ac = "INSERT INTO request_retaining_student_status_academic (retaining_student_id, semester_a, academic_a, date_a)
               VALUES ($retaining_student_id, '$tl_semester_value', '$tl_academic_value', Now())";

		$mysqli->query($sql_ac);
	}
	if ($doc_type_id == 3) {
		$sql_cs = "INSERT INTO request_retaining_student_status_current_semester 
		(retaining_student_id, doc_type_id, semester, academic, status_thesis_is, subject_code, credits, group_id, classid, because, date)
		VALUES ($retaining_student_id, '$doc_type_id', '$semester_cs', '$academic_cs', '$type_thesis', '$subject_code', '$credits', '$group', '$classid', '$because_thesis', Now())";
		$mysqli->query($sql_cs);
	} else if ($doc_type_id == 1) {
		$sql_cs = "INSERT INTO request_retaining_student_status_current_semester 
		(retaining_student_id, doc_type_id, semester, academic, status_thesis_is, subject_code, credits, group_id, classid, because, date)
		VALUES ($retaining_student_id, '$doc_type_id', '$semester_cs', '$academic_cs', 'NULL', 'NULL', '0', '0', 'NULL', 'NULL', Now())";
		$mysqli->query($sql_cs);
	}

	// }
	if ($rs_doc) {
		//=== ส่ง email ข้อมูลอาจารย์
		$sql_mail = "SELECT prefixname,advisorname,advisorsurname,advisor_email FROM request_advisor WHERE advisorcode='$advisor' ";
		$rs_mail = $mysqli->query($sql_mail);
		$row_num_mail = $rs_mail->num_rows;
		if ($row_num_mail > 0) {
			$row_mail = $rs_mail->fetch_array();
			$advisor_email = $row_mail["advisor_email"];
			$advisor_name_full = $row_mail["prefixname"] . $row_mail["advisorname"] . " " . $row_mail["advisorsurname"];
		} else {
			$advisor_name_full = 'Advisor';
		}
		//
		//== ข้อมูลนิสิต 
		$sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=" . $_SESSION['SES_STDCODE'];
		$rs_std = $mysqli->query($sql_std);
		$row_std = $rs_std->fetch_array();
		$std_id_std = $row_std['std_id_std'];
		$std_degree_th = $row_std['std_degree_th'];
		$std_faculty_th = $row_std['std_faculty_th'];
		$date_now_th = DateThai1(date('Y-m-d H:i:s'));
		if ($email != "") {
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
			$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง ";  //หัวเรื่อง email ที่ส่ง
			$mail->Body = "เรียนอาจารย์ที่ปรึกษา $advisor_name_full<br>
					เรื่อง คำร้องขอคืนสภาพการเป็นนิสิต <br><br>
					ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “ขอคืนสภาพการเป็นนิสิต” ภาคเรียนที่ $semester/$academic ของนิสิตชื่อ $_SESSION[SES_STDNAME_FULL_TH] รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th  ได้โปรดรพิจารณาลงนามคำร้อง “ขอคืนสภาพการเป็นนิสิต” 
					ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
					<br><br>
					จึงเรียนมาเพื่อโปรดทราบ <br>
					งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
					กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
					"; //รายละเอียดที่ส่ง
			//$mail->AddAddress('jakkrid.b@msu.ac.th',$advisor_name_full); //อีเมล์และชื่อผู้รับ
			$mail->AddAddress($email, $advisor_name_full); //อีเมล์และชื่อผู้รับ
			$mail->Send();
		}
		// =============
		echo 1; //เพิ่มข้อมูลสำเร็จ
	} else {
		echo 2; //ไม่สามารถเพิ่มข้อมูลได้
	}
} else {
	echo 3;	 //ไม่สามารถเพิ่มข้อมูลได้ทีแรก
}

//echo json_encode($result);

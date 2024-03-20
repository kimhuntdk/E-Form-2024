<?php 
    session_start();
    include ("../inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	$result = array();
	$imagedata = base64_decode($_POST['img_data']);
	$filename = md5(date("dmYhisA"));
	//Location to where you want to created sign image
	$file_name = './doc_signs/'.$filename.'.png';
	file_put_contents($file_name,$imagedata);
	$result['status'] = 1;
	$result['file_name'] = $file_name;		
	$semester = trim($_POST['semester']);		
	$academic = trim($_POST['academic']);		
	$subject_completed_1 = trim($_POST['subject_completed_1']);
	$submitted_books_1 = trim($_POST['submitted_books_1']);
	$not_exam_ce_1 = trim($_POST['not_exam_ce_1']);	
 	$subject_completed_2 = trim($_POST['subject_completed_2']);	
	$thesis_12_credits_2 = trim($_POST['thesis_12_credits_2']);
	$connot_presen_2 = trim($_POST['connot_presen_2']);
	$subject_completed_3 = trim($_POST['subject_completed_3']);	
 	$complete_ge_3 = trim($_POST['complete_ge_3']);
	$connot_submit_9_3 = trim($_POST['connot_submit_9_3']);
	$subject_completed_4 = trim($_POST['subject_completed_4']);	
 	$thesis_is_completely_4= trim($_POST['thesis_is_completely_4']);
	$waiting_publication_4 = trim($_POST['waiting_publication_4']);
	$advisor = trim($_POST['advisor']);	
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
	$sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(13,'$_SESSION[SES_STDCODE]',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
	$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max[max_doc_id];
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสารคำร้องขอลงทะเบียนรักษาสภาพ  request_status_retention
		$sql_doc = "INSERT INTO request_status_retention (doc_id,semester,academic,std_signature,std_date_signature,subject_completed_1 ";
		$sql_doc.= ",submitted_books_1,not_exam_ce_1,subject_completed_2,thesis_12_credits_2,connot_presen_2,subject_completed_3,complete_ge_3";
		$sql_doc.= ",connot_submit_9_3,subject_completed_4,thesis_is_completely_4,waiting_publication_4)";
		$sql_doc .= "values($max_id,'$semester','$academic','$filename',Now() ";
		$sql_doc .= ",'$subject_completed_1','$submitted_books_1','$not_exam_ce_1','$subject_completed_2','$thesis_12_credits_2' ";
		$sql_doc .= ",'$connot_presen_2','$subject_completed_3','$complete_ge_3','$connot_submit_9_3','$subject_completed_4','$thesis_is_completely_4','$waiting_publication_4') ";
	    $rs_doc = $mysqli->query( $sql_doc );
		if($rs_doc){
			echo 1; //เพิ่มข้อมูลสำเร็จ
		} else {
			echo 2; //ไม่สามารถเพิ่มข้อมูลได้
		}
	} else {
		echo 3;	 //ไม่สามารถเพิ่มข้อมูลได้ทีแรก
	}
	//echo json_encode($result);
?>
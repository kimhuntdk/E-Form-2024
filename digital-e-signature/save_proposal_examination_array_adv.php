<?php 
    session_start();
    require_once ("../inc/db_connect.php");
    require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");

    //echo "มา";
   $sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_proposal_examination where std_code='$_REQUEST[std_id]' ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max['max_doc_id'];

	for($count = 0; $count<count($_POST['name_eaxm']); $count++)
		{
			$name_eaxm = $_POST['name_eaxm'][$count];
			$posi = $_POST['posi'][$count];
		
			$sql_doc = "INSERT INTO request_examination_list (exam_status,exam_name,exam_posi,doc_id) ";
		    $sql_doc .= "values(42,'$name_eaxm','$posi',$max_id) ";
	    //echo $sql_doc;
		    $rs_doc = $mysqli->query( $sql_doc );
		}
		echo 1;
	//print_r($name_eaxm);
	//print_r($posi);	
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

	//echo json_encode($result);
?>
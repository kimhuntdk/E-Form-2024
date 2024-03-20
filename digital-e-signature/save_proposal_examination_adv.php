<?php 
    session_start();
    require_once ("../inc/db_connect.php");
    require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
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
	$advisor = $_SESSION['SES_USER'];
	$semester = $mysqli->real_escape_string($_POST['semester']);		
	$academic = $mysqli->real_escape_string($_POST['academic']);	
	$date_exam = $mysqli->real_escape_string($_POST['date_exam']);	
	$room_exam = $mysqli->real_escape_string($_POST['room_exam']);
	$exam_time = $mysqli->real_escape_string($_POST['exam_time']);
    $std_id = $mysqli->real_escape_string($_POST['std_id']);	
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
	$sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(42,'$std_id',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
    $sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max['max_doc_id'];
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสาร
		$sql_doc = "INSERT INTO request_proposal_examination (doc_id,semester,academic,std_code,exam_day,exam_room,std_date_signature,advisor_status,advisor_signature,advisor_date_signature,advisor_code,exam_time) ";
		$sql_doc .= "values($max_id,'$semester','$academic','$std_id','$date_exam','$room_exam',Now(),'1','$filename',Now(),'$_SESSION[SES_USER]','$exam_time') ";
	    // echo $sql_doc;
		$rs_doc = $mysqli->query( $sql_doc );
		if($rs_doc){
			//== การ เพิ่ม email ในการส่งคำร้อง
			$sql_insert_mail = "INSERT INTO  request_send_email (email_name,doc_id,doc_std_id,doc_date)values('$email','$max_id','$_SESSION[SES_STDCODE]',Now()) ";
			$mysqli->query( $sql_insert_mail );			
			//=== ส่ง email ข้อมูลอาจารย์
			/*$sql_mail = "SELECT prefixname,advisorname,advisorsurname,advisor_email FROM request_advisor WHERE advisorcode='$_SESSION[SES_USER]' ";
			$rs_mail = $mysqli->query( $sql_mail );
			$row_mail = $rs_mail->fetch_array();
			$advisor_email = $row_mail["advisor_email"];
			$advisor_name_full = $row_mail["prefixname"].$row_mail["advisorname"]." ".$row_mail["advisorsurname"];*/
		    //== ข้อมูลนิสิต 
			$sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th,std_faculty_id FROM request_student WHERE std_id_std='$std_id' ";
			$rs_std = $mysqli->query( $sql_std );
			$row_std = $rs_std->fetch_array();
			$std_id_std = $row_std['std_id_std'];
			$std_degree_th = $row_std['std_degree_th'];
			$std_faculty_th = $row_std['std_faculty_th'];
			$std_faculty_id = $row_std['std_faculty_id'];
			$date_now_th = DateThai1(date('Y-m-d H:i:s'));
							//=====================Seach Staff=================
			$sql_staff = "SELECT staff_fac_title,staff_fac_name,staff_fac_surname,staff_email FROM request_staff_faculty WHERE staff_faculty_id=".$std_faculty_id;
			$rs_staff = $mysqli->query( $sql_staff );
			$row_staff = $rs_staff->fetch_array();
			$staff_fac_title = $row_staff['staff_fac_title'];
			$staff_fac_name = $row_staff['staff_fac_name'];
			$staff_fac_surname = $row_staff['staff_fac_surname'];
			$staff_email = $row_staff['staff_email'];
			$staff_name_full = $staff_fac_title.$staff_fac_name." ".$staff_fac_surname;
			//==================== End Staff ==================
			if($staff_email!=""){
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
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง “แต่งตั้งคณะกรรมสอบโครงร่าง”";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียนเจ้าหน้าที่ $staff_name_full<br>
	เรื่อง คำร้องแต่งตั้งคณะกรรมสอบโครงร่าง <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้อง “แต่งตั้งคณะกรรมสอบโครงร่าง” ของนิสิตชื่อ $_SESSION[SES_STDNAME_FULL_TH] รหัส $std_id_std  นิสิต$std_degree_th คณะ$std_faculty_th เมื่อ$date_now_th  ได้โปรดรพิจารณาลงนามคำร้อง “แต่งตั้งคณะกรรมสอบโครงร่าง” 
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				//$mail->AddAddress('jakkrid.b@msu.ac.th',$staff_name_full); //อีเมล์และชื่อผู้รับ
				$mail->AddAddress($staff_email,$staff_name_full); //อีเมล์และชื่อผู้รับ
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
<?php 
    session_start();
    include ("../inc/db_connect.php");
    require_once('../PHPMailer/PHPMailerAutoload.php');
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
	$dean_admin = trim($_POST['dean_admin']);		
	$subject = trim($_POST['subject']);		
	$node = trim($_POST['node']);	
	$email = trim($_POST['email']);	

	//==insert table request_doc
	$sql_request_doc = "INSERT INTO request_doc (doc_type,doc_std_id,doc_date)values(83,'SES_STAFF',Now()) ";
	$rs_request_doc = $mysqli->query( $sql_request_doc );
	//== หา row ล่าสุด 
	$sql_max = " SELECT MAX(doc_id) AS max_doc_id FROM request_doc ";
	$rs_max = $mysqli->query( $sql_max );
	$row_max = $rs_max->fetch_array();
	$max_id = $row_max[max_doc_id];
	if($rs_request_doc){
		// เพิ่มข้อมูลเอกสารคำร้องลาพักการเรียน request_registration_thesis_is
		$sql_doc = "INSERT INTO request_document_in (doc_id,staff_id,subject,node,per_signature,per_date_signature,dean_admin ) ";
		$sql_doc .= "values($max_id,$_SESSION[SES_ID],'$subject','$node','$filename',Now(),'$dean_admin') ";
	    //echo $sql_doc;
		$rs_doc = $mysqli->query( $sql_doc );
		if($rs_doc){
			//=== ส่ง email ข้อมูลอาจารย์
			$sql_mail = "SELECT staff_name,staff_email FROM request_staff WHERE staff_id='$dean_admin' ";
			$rs_mail = $mysqli->query( $sql_mail );
			$row_mail = $rs_mail->fetch_array();
			$advisor_email = $row_mail["staff_email"];
			$advisor_name_full = $row_mail["staff_name"];
		    //== ข้อมูลนิสิต 
			/*$sql_std = "SELECT std_id_std,std_fname_en,std_lname_en,std_degree_th,std_faculty_th FROM request_student WHERE std_id_std=".$_SESSION['SES_STDCODE'];
			$rs_std = $mysqli->query( $sql_std );
			$row_std = $rs_std->fetch_array();
			$std_id_std = $row_std['std_id_std'];
			$std_degree_th = $row_std['std_degree_th'];
			$std_faculty_th = $row_std['std_faculty_th'];
*/			$date_now_th = DateThai1(date('Y-m-d H:i:s'));
			if($advisor_email!=""){
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
				$mail->Subject = "[e-Form Graduate MSU] บุคลากรได้ส่งบันทึกข้อความ";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียน $advisor_name_full<br>
	เรื่อง $subject <br><br>
	$node
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress($advisor_email,$advisor_name_full); //อีเมล์และชื่อผู้รับ
				//$mail->AddAddress($email,$advisor_name_full); //อีเมล์และชื่อผู้รับ
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
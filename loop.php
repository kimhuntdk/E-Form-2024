<?php 
    @session_start();
    require_once ("inc/db_connect.php");
	require_once('SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
?>


<?php  
$doc_id = $_REQUEST['doc_id'];
$staff_grad_approve_disapprove = $_REQUEST['staff_status'];
  if($staff_grad_approve_disapprove==1){
	  
  $bath=$_POST['bath']; 
  $sub=$_POST['sub']; 
    $sql_up = "Update request_status_retention set staff_grad_approve_disapprove='$staff_grad_approve_disapprove'  Where doc_id=".$doc_id;
	$mysqli->query($sql_up);
   for($i=0;$i<count($_POST["bath"]);$i++)
    {
		//echo $_POST["bath"];
          if($bath[$i] !=0) {
	 	  $sql = "insert into request_fee_officer(doc_id,fee_name,fee_price)values('$doc_id','$sub[$i]','$bath[$i]')";
		  $rs = $mysqli->query($sql );
		 // continue;
		  }
		
     
    }
	$mail_test = "jakkrid.b@msu.ac.th";
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
				$mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง";  //หัวเรื่อง emal ที่ส่ง
				$mail->Body = "เรียน เจ้าหน้าที่กองทะเบียน <br>
	เรื่อง คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
	ผ่านระบบได้ที่นี้ คลิก https://grad.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
				$mail->AddAddress('diskko@hotmail.com','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
			//	$mail->AddAddress('warun_gef@hotmail.com','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
				$mail->Send();
	echo 1;
  }else { 
  	//echo 3;
  }
  //=================================
  if($staff_grad_approve_disapprove==2){
	  $argument = $_REQUEST['argument'];

        $sql = "Update request_status_retention set staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument',staff_grad_date=Now() Where doc_id='$doc_id' ";
		$rs_doc = $mysqli->query( $sql );
	    if($rs_doc){
			echo 1;
		}else {
			echo 2;
		}
  }else { 
  	echo 3;
  }
?>

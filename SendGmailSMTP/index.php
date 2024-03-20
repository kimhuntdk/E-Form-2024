<meta charset="utf-8">
test
<?php
require_once('PHPMailer/PHPMailerAutoload.php');
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
	$mail->FromName = "บัณฑิตวิทยาลัย มมส"; //ชื่อที่ใช้ในการส่ง
	$mail->Subject = "[e-Form MSU] นิสิตได้ส่งคำร้องลาพักการเรียน";  //หัวเรื่อง emal ที่ส่ง
	$mail->Body = "เรียนอาจารย์ที่ปรึกษา Test mail
<br>เรื่อง คำร้องลาพักการเรียน <br>
ระบบ e-Form MSU  ทดสอบ

<br><br>
จึงเรียนมาเพื่อโปรดทราบ<br>
บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
หากมีข้อสงสัยประการใด กรุณาติดต่อ graduate@msu.ac.th
"; //รายละเอียดที่ส่ง
	$mail->AddAddress('jakkrid.b@msu.ac.th','เจ้าหน้าที่กองทะเบียน'); //อีเมล์และชื่อผู้รับ
	
	//ส่วนของการแนบไฟล์ ซึ่งทดสอบแล้วแนบได้จริงทั้งไฟล์ .rar , .jpg , png ซึ่งคงมีหลายนามสกุลที่แนบได้
	//$mail->AddAttachment("files/1.rar");



	//ตรวจสอบว่าส่งผ่านหรือไม่
	if ($mail->Send()){
	echo "ข้อความของคุณได้ email";
	}else{
	echo "การส่งไม่สำเร็จ";
	}
?>
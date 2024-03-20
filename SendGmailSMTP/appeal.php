<meta charset="utf-8">

<?php
require_once('PHPMailer/PHPMailerAutoload.php');

if(isset($_POST['submit'])){
    $subject = $_POST['input_name'];
    $full_name = $_POST['input_name_en'];
    $email = $_POST['email'];
    $detail = $_POST['detial'];
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
	$mail->Subject = "[Hostline GS-MSU] ร้องเรียนบัณฑิตวิทยาลัย";  //หัวเรื่อง emal ที่ส่ง
	$mail->Body = "เรียนท่านคณบดีบัณฑิตวิทยาลัย
<br>เรื่อง $subject <br>
$detail

<br><br>
จึงเรียนมาเพื่อโปรดทราบ<br>
$full_name<br>
หากมีข้อสงสัยประการใด กรุณาติดต่อ $email
"; //รายละเอียดที่ส่ง8คณ
	$mail->AddAddress('k.chaimoon@msu.ac.th','คณบดีบัณฑิตวิทยาลัย'); //อีเมล์และชื่อผู้ครับ
	//$mail->AddAddress('jakkrid.b@msu.ac.th','คณบดีบัณฑิตวิทยาลัย'); //อีเมล์และชื่อผู้ครับ
	//ส่วนของการแนบไฟล์ ซึ่งทดสอบแล้วแนบได้จริงทั้งไฟล์ .rar , .jpg , png ซึ่งคงมีหลายนามสกุลที่แนบได้
	//$mail->AddAttachment("files/1.rar");



	//ตรวจสอบว่าส่งผ่านหรือไม่
	$mail->Send();
    echo "<script>alert('send data successfully'); window.location ='../../../'; </script>";
        
}else {
    
    echo "<script> window.location ='javascript:history.go(-1)'; </script>";
    
}

?>

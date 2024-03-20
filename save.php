<?php
@session_start();
include( "inc/db_connect.php" );
require_once( 'SendGmailSMTP/PHPMailer/PHPMailerAutoload.php' );
$mysqli = connect();
date_default_timezone_set( "Asia/Bangkok" );


$staff_grad_approve_disapprove = trim( $_POST[ 'staff_grad_approve_disapprove' ] );
$dean_admin = isset($_POST['dean_admin']) ? trim($_POST['dean_admin']) : '';
if ( $dean_admin == "" ) {
  $dean_admin = 0;
}
$argument_a = trim( $_POST[ 'argument' ] );

$update_srt = isset($_POST['Save_Staff_Thesis']) ? trim($_POST['Save_Staff_Thesis']) : '';
$Save_Staff_Leave = isset($_POST['Save_Staff_Leave']) ? trim($_POST['Save_Staff_Leave']) : '';
$Save_Staff_Retaining = isset($_POST['Save_Staff_Retaining']) ? trim($_POST['Save_Staff_Retaining']) : '';


$doc_id = trim( $_POST[ 'doc_id' ] );

if ( $update_srt == "Save_Staff_Thesis" ) { // Staff Save
  // เจ้าหน้าที่ได้ผ่านพิจารณาอกสารลงทะเบียน Thesis Is request_registration_thesis_is
  if ( $staff_grad_approve_disapprove == 2 ) { //กรณีมีแก้ไข ส่งคืนนิสิตให้เก็บลงอีก table request_repatriate
    $sql_in = "Insert into request_repatriate(doc_id,repatriate_node,repatriate_date)values('$doc_id','$argument_a',Now())";
    $mysqli->query( $sql_in );
    // ไปอัฟเดพ 
    $sql = "Update request_registration_thesis_is set staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_date=Now(),staff_grad_node='$argument_a' Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //$mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 3 ) { //กรณีใช้แบบฟอร์มผิดประเภท

    $sql = "Update request_registration_thesis_is set staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //$mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 1 ) { //กรณีผ่านเรื่องให้ผู้บริหารพิจารณา
    $sql = "Update request_registration_thesis_is set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //=============================================================
      $sql_dean = " SELECT staff_name,staff_email FROM request_staff Where staff_id = " . $dean_admin;
      $rs_dean = $mysqli->query( $sql_dean );
      $row_dean = $rs_dean->fetch_array();
      $dean_name = $row_dean[ 'staff_name' ];
      $dean_mail = $row_dean[ 'staff_email' ];
      //  $mail_test = "jakkrid.b@msu.ac.th";
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->isHTML();
      $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
      $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
      $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
      $mail->SetFrom( 'graduate@msu.ac.th' ); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
      $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
      $mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง"; //หัวเรื่อง emal ที่ส่ง
      $mail->Body = "เรียน $dean_name <br>
	เรื่อง คำร้องระบ e-Form <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
	ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
      $mail->AddAddress( $dean_mail, $dean_name ); //อีเมล์และชื่อผู้รับ
      //$mail->AddAddress('jakkrid.b@msu.ac.th','Jakkrid Boonseela'); //อีเมล์และชื่อผู้รับ

      //========END Mail==============================================
      $mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
    }
  } else {
    echo 3; //ไม่สามารถเพิ่มข้อมูลได้ทีแรก

  }
} elseif ( $Save_Staff_Leave == "Save_Staff_Leave" ) { // Staff Save
  // เจ้าหน้าที่ได้ผ่านพิจารณาเอกสารขอลาพักการเรียน takeleave
  if ( $staff_grad_approve_disapprove == 3 ) { //กรณีมีแก้ไข ส่งคืนนิสิตให้เก็บลงอีก table request_repatriate
    $sql_in = "Insert into request_repatriate(doc_id,repatriate_node,repatriate_date)values('$doc_id','$argument_a',Now())";
    $mysqli->query( $sql_in );
    // ไปอัฟเดพ 
    $sql = "Update request_taking_leave set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //=============================================================
      $sql_dean = " SELECT staff_name,staff_email FROM request_staff Where staff_id = " . $dean_admin;
      $rs_dean = $mysqli->query( $sql_dean );
      $row_dean = $rs_dean->fetch_array();
      $dean_name = $row_dean[ 'staff_name' ];
      $dean_mail = $row_dean[ 'staff_email' ];
      //  $mail_test = "jakkrid.b@msu.ac.th";
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->isHTML();
      $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
      $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
      $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
      $mail->SetFrom( 'graduate@msu.ac.th' ); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
      $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
      $mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง"; //หัวเรื่อง emal ที่ส่ง
      $mail->Body = "เรียน $dean_name <br>
				 เรื่อง คำร้องระบ e-Form <br><br>
				 ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
				 ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
				 <br><br>
				 จึงเรียนมาเพื่อโปรดทราบ <br>
				 งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
				 กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
				 "; //รายละเอียดที่ส่ง
      $mail->AddAddress( $dean_mail, $dean_name ); //อีเมล์และชื่อผู้รับ
      //$mail->AddAddress('jakkrid.b@msu.ac.th','Jakkrid Boonseela'); //อีเมล์และชื่อผู้รับ
      $mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 2 ) { //กรณีใช้แบบฟอร์มผิดประเภท

    $sql = "Update request_taking_leave set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //$mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 1 ) { //กรณีผ่านเรื่องให้ผู้บริหารพิจารณา
    $sql = "Update request_taking_leave set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //=============================================================
      $sql_dean = " SELECT staff_name,staff_email FROM request_staff Where staff_id = " . $dean_admin;
      $rs_dean = $mysqli->query( $sql_dean );
      $row_dean = $rs_dean->fetch_array();
      $dean_name = $row_dean[ 'staff_name' ];
      $dean_mail = $row_dean[ 'staff_email' ];
      $mail_test = "jakkrid.b@msu.ac.th";
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->isHTML();
      $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
      $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
      $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
      $mail->SetFrom( 'graduate@msu.ac.th' ); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
      $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
      $mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง"; //หัวเรื่อง emal ที่ส่ง
      $mail->Body = "เรียน $dean_name <br>
	เรื่อง คำร้องระบ e-Form <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
	ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
      $mail->AddAddress( $dean_mail, $dean_name ); //อีเมล์และชื่อผู้รับ
      //$mail->AddAddress('jakkrid.b@msu.ac.th','Jakkrid Boonseela'); //อีเมล์และชื่อผู้รับ
      $mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
    }
  } else {
    echo 3; //ไม่สามารถเพิ่มข้อมูลได้ทีแรก

  }

} elseif ( $Save_Staff_Retaining == "Save_Staff_Retaining" ) { // Staff Save
  // เจ้าหน้าที่ได้ผ่านพิจารณาเอกสารขอคืนสภาพการเป็นนิสิต retaining student status
  if ( $staff_grad_approve_disapprove == 3 ) { //กรณีมีแก้ไข ส่งคืนนิสิตให้เก็บลงอีก table request_repatriate
    $sql_in = "Insert into request_repatriate(doc_id,repatriate_node,repatriate_date)values('$doc_id','$argument_a',Now())";
    $mysqli->query( $sql_in );
    // ไปอัฟเดพ 
    $sql = "Update request_retaining_student_status set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //=============================================================
      $sql_dean = " SELECT staff_name,staff_email FROM request_staff Where staff_id = " . $dean_admin;
      $rs_dean = $mysqli->query( $sql_dean );
      $row_dean = $rs_dean->fetch_array();
      $dean_name = $row_dean[ 'staff_name' ];
      $dean_mail = $row_dean[ 'staff_email' ];
      //  $mail_test = "jakkrid.b@msu.ac.th";
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->isHTML();
      $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
      $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
      $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
      $mail->SetFrom( 'graduate@msu.ac.th' ); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
      $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
      $mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง"; //หัวเรื่อง emal ที่ส่ง
      $mail->Body = "เรียน $dean_name <br>
				 เรื่อง คำร้องระบ e-Form <br><br>
				 ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
				 ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
				 <br><br>
				 จึงเรียนมาเพื่อโปรดทราบ <br>
				 งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
				 กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
				 "; //รายละเอียดที่ส่ง
      $mail->AddAddress( $dean_mail, $dean_name ); //อีเมล์และชื่อผู้รับ
      //$mail->AddAddress('jakkrid.b@msu.ac.th','Jakkrid Boonseela'); //อีเมล์และชื่อผู้รับ
      $mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 2 ) { //กรณีใช้แบบฟอร์มผิดประเภท

    $sql = "Update request_retaining_student_status set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //$mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
      exit;
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
      exit;
    }
  }
  if ( $staff_grad_approve_disapprove == 1 ) { //กรณีผ่านเรื่องให้ผู้บริหารพิจารณา
    $sql = "Update request_retaining_student_status set dean_admin='$dean_admin',staff_grad_approve_disapprove='$staff_grad_approve_disapprove',staff_grad_node='$argument_a',staff_grad_date=Now() Where doc_id='$doc_id' ";
    $rs_doc = $mysqli->query( $sql );
    if ( $rs_doc ) {
      //=============================================================
      $sql_dean = " SELECT staff_name,staff_email FROM request_staff Where staff_id = " . $dean_admin;
      $rs_dean = $mysqli->query( $sql_dean );
      $row_dean = $rs_dean->fetch_array();
      $dean_name = $row_dean[ 'staff_name' ];
      $dean_mail = $row_dean[ 'staff_email' ];
      $mail_test = "jakkrid.b@msu.ac.th";
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
      $mail->isHTML();
      $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
      $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
      $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
      $mail->SetFrom( 'graduate@msu.ac.th' ); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน
      $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
      $mail->Subject = "[e-Form Graduate MSU] นิสิตได้ส่งคำร้อง"; //หัวเรื่อง emal ที่ส่ง
      $mail->Body = "เรียน $dean_name <br>
	เรื่อง คำร้องระบ e-Form <br><br>
	ระบบ e-Form Graduate MSU ได้ส่งคำร้องไปยังระบบ e-Form โปรดพิจารณาลงนามคำร้อง
	ผ่านระบบได้ที่นี้ คลิก https://gradis.msu.ac.th/electronic
    <br><br>
	จึงเรียนมาเพื่อโปรดทราบ <br>
	งานระบบสารสนเทศ บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม<br>
	กรณีพบปัญหา/ข้อสงสัย ติดต่อที่ graduate@msu.ac.th
	"; //รายละเอียดที่ส่ง
      $mail->AddAddress( $dean_mail, $dean_name ); //อีเมล์และชื่อผู้รับ
      //$mail->AddAddress('jakkrid.b@msu.ac.th','Jakkrid Boonseela'); //อีเมล์และชื่อผู้รับ
      $mail->Send();
      echo 1; //เพิ่มข้อมูลสำเร็จ
    } else {
      echo 2; //ไม่สามารถเพิ่มข้อมูลได้
    }
  } else {
    echo 3; //ไม่สามารถเพิ่มข้อมูลได้ทีแรก

  }

} elseif ( $_REQUEST[ 'edit_thesis_is' ] == "edit_thesis_is" ) { // Student แกไข ตาม Staff คำร้องลงทะเบียน Thesis  Save
  $type_thesis = trim( $_POST[ 'type_thesis' ] );
  $subject_code = trim( $_POST[ 'subject_code' ] );
  $credits = trim( $_POST[ 'credits' ] );
  $semester = trim( $_POST[ 'semester' ] );
  $academic = trim( $_POST[ 'academic' ] );
  $because = trim( $_POST[ 'because' ] );
  $sql = "Update request_registration_thesis_is set staff_grad_approve_disapprove=0,status_thesis_is='$type_thesis',subject_code='$subject_code',credits='$credits',semester='$semester',academic='$academic',because='$because' Where doc_id='$doc_id' ";
  $rs_doc = $mysqli->query( $sql );
  if ( $rs_doc ) {
    echo 1; //เพิ่มข้อมูลสำเร็จ
  } else {
    echo 2; //ไม่สามารถเพิ่มข้อมูลได้
  }

} elseif ( $_REQUEST[ 'edit_taking_leave' ] == "edit_taking_leave" ) { // Student แกไข ตาม Staff คำร้องลาพักการเรียน  Save
  $finished_assignment = trim( $_POST[ 'finished_assignment' ] );
  $unfinished_assignment = trim( $_POST[ 'unfinished_assignment' ] );
  $unstarting_assignment = trim( $_POST[ 'unstarting_assignment' ] );
  $semester = trim( $_POST[ 'semester' ] );
  $academic = trim( $_POST[ 'academic' ] );
  $because = trim( $_POST[ 'because' ] );
  $sql = "Update request_taking_leave set staff_grad_approve_disapprove=0,semester='$semester',academic='$academic',because='$because',finished_assigment='$finished_assignment',unfinished_assignment='$unfinished_assignment',unstarting_assignment='$unstarting_assignment' Where doc_id='$doc_id' ";
  $rs_doc = $mysqli->query( $sql );
  if ( $rs_doc ) {
    echo 1; //เพิ่มข้อมูลสำเร็จ
  } else {
    echo 2; //ไม่สามารถเพิ่มข้อมูลได้
  }

}
elseif ( $_REQUEST[ 'edit_retaining_student_status' ] == "edit_retaining_student_status" ) { // Student แกไข ตาม Staff คำร้องลาพักการเรียน  Save
  
  $takeLeave = trim( $_POST[ 'take_leave' ] );
  $ToTakeLeave = trim( $_POST[ 'to_take_leave' ] );
  $semester = trim( $_POST[ 'semester' ] );
  $academic = trim( $_POST[ 'academic' ] );
  $because = trim( $_POST[ 'because' ] );
  $sql = "Update request_taking_leave set staff_grad_approve_disapprove=0,semester='$semester',academic='$academic',because='$because',
          take_leave='$takeLeave',to_take_leave='$ToTakeLeave' Where doc_id='$doc_id' ";
  $rs_doc = $mysqli->query( $sql );
  if ( $rs_doc ) {
    echo 1; //เพิ่มข้อมูลสำเร็จ
  } else {
    echo 2; //ไม่สามารถเพิ่มข้อมูลได้
  }

}
?>
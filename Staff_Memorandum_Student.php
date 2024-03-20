<?php
session_start();
$doc_id = base64_decode( $_REQUEST[ doc_id ] );
require_once( "inc/db_connect.php" );
$mysqli = connect();
/*if ( $id == "" || $_SESSION[ "SES_STDCODE" ] == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}*/
$sql = "SELECT * FROM request_memorandum_student WHERE memorandum_id=" . $doc_id;
$result = $mysqli->query( $sql );
$row = $result->fetch_array();
?>
<!doctype html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Content-Language" content="th"/>
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="theme-color" content="#4188c9">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico"/>
	<!-- Generated: 2018-04-16 09:29:05 +0200 -->
	<title>e-Form Graduate School MSU</title>

	<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
  -->
	<script src="./assets/js/require.min.js"></script>
	<script>
		requirejs.config( {
			baseUrl: '.'
		} );
	</script>
	<!-- Dashboard Core -->
	<link href="./assets/css/dashboard.css" rel="stylesheet"/>
	<script src="./assets/js/dashboard.js"></script>
	<!-- c3.js Charts Plugin -->
	<link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet"/>
	<script src="./assets/plugins/charts-c3/plugin.js"></script>
	<!-- Google Maps Plugin -->
	<link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet"/>
	<script src="./assets/plugins/maps-google/plugin.js"></script>
	<!-- Input Mask Plugin -->
	<script src="./assets/plugins/input-mask/plugin.js"></script>
	<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="digital-e-signature/css/jquery-ui.css">
	<link href="digital-e-signature/css/jquery.signaturepad.css" rel="stylesheet">
	<script src="digital-e-signature/js/numeric-1.2.6.min.js"></script>
	<script src="digital-e-signature/js/bezier.js"></script>
	<script src="digital-e-signature/js/jquery.signaturepad.js"></script>
	<script type='text/javascript' src="digital-e-signature/js/html2canvas.js"></script>
	<!--<script src="./js/json2.min.js"></script>-->
<script type="text/javascript">
	$( document ).ready( function () {
		$( "#btnSaveSign" ).click( function () { //ส่งค่าไป Update คำร้อง
			var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
			var Save_Memorandum = $( "#Save_Memorandum" ).val();
			var argument_a = $( "#argument_a" ).val();

			if ( staff_grad_approve_disapprove === "1" ) {
				var dean_admin = $( "#dean_admin" ).val();
				if ( dean_admin === "0" ) {
					alert( "กรุณาเลือกผู้บริหาร เพื่อพิจารณาเรื่อง" );
					$( "#dean_admin" ).focus();
					return false;
				} else {
					$( "#show_loading" ).html( "<img src='images/loading.gif' width='100' height='100'>" );
					$( "#btnSaveSign" ).attr( 'disabled', 'disabled' );
					$.post(
						"save_memorandum_student.php",
						$( "#frm_add_memorandum" ).serializeArray(),
						function ( data ) {
							//alert(data);
							if ( data === "1" ) {
								alert( "Send Data Complete.." );
								window.location.href = 'staff.php';
							} else if ( data === "2" ) {
								alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง1" );
								window.location.href = 'staff.php';
							} else {
								alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
								window.location.href = 'staff.php';

							}
							$( "#show_loading" ).empty();
							$( "#btnSaveSign" ).removeAttr( 'disabled' );
						}
					);
				}
			} else if ( staff_grad_approve_disapprove === "2" || staff_grad_approve_disapprove === "3" ) {
				$( "#show_loading" ).html( "<img src='images/loading.gif' width='100' height='100'>" );
				$( "#btnSaveSign" ).attr( 'disabled', 'disabled' );
				$.post(
					"save_memorandum_student.php",
					$( "#frm_add_memorandum" ).serializeArray(),
					function ( data ) {
						//alert(data);
						if ( data === "1" ) {
							alert( "Send Data Complete.." );
							window.location.href = 'staff.php';
						} else if ( data === "2" ) {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';
						} else {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';

						}
						$( "#show_loading" ).empty();
						$( "#btnSaveSign" ).removeAttr( 'disabled' );

					}
				);
			}
		} );
		$( ".staff_grad_approve_disapprove" ).click( function () { //ตรวจสอบก่อนว่าส่งพิจารณาค่อยมีเลือกผู้บริหารแสดงออกมา
			var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
			if ( staff_grad_approve_disapprove == 1 ) {
				$( "#dean_admin" ).removeAttr( 'disabled' );
			} else {
				$( "#dean_admin" ).attr( 'disabled', 'disabled' );
				$( "#dean_admin" ).val( 0 );
			}

		} );
	} );
</script>

	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href="Text-Editor/editor.css" type="text/css" rel="stylesheet"/>
	</head>

	<body>
    <div class="page">
      <div class="page-main">
        <?php include("main_menu.php");?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                <?php
							/* if(isset($_GET['menu'])) {
							    $menu = $_GET['menu'];
							} else {
							    $menu = '';
							}
							switch ($menu) {
								//---------------------------------------method--------------------
								case "home":
										echo "Home";
										break;	
								case "login":
										echo "Login";
										break;
								case "profile":
										echo "Profile";
										break;
								case "form_request_doc":
										echo "Form";
										break;
								case "Request_Form_Taking_Leave":
										echo "แบบฟอร์มลาพักการเรียน";
										break;
								case "Request_Form_Registration_Thesis":
										echo "แบบฟอร์มลงทะเบียน Thesis/IS";
										break;
								case "Request_Form_Status_Retention_Special":
										echo "คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)";
										break;
								case "student":
										echo "ตรวจสอบสถานะคำร้อง";
										break;
								case "Student_Taking_Leave":
										echo "ตรวจสอบสถานะคำร้องลาพักการเรียน";
										break;
								case "Student_Registration_Thesis":
										echo "ตรวจสอบสถานะคำร้องลงทะเบียน Thesis/IS";
										break;
								//--------------------------------advisor---------------------------	
								case "advisor":
										echo "รายการเอกสาร";
										break;
								case "Advisor_Registration_Thesis":
										echo "รายการเอกสารรออนุมัติ";
										break;
								case "Advisor_Taking_Leave":
										echo "รายการเอกสารรออนุมัติ";
										break;
								//-------------------------------------staff-----------------------------
								case "staff":
										echo "รายการเอกสารรอตรวจสอบ";
										break;
								case "Staff_Registration_Thesis":
										echo 'คำร้องขอลงทะเบียน Thesis/IS';
										break;
								case "Staff_Taking_Leave":
										echo 'คำร้องขอลาพักการเรียน';
										break;
									//-------------------------------------admin ผู้บริหารบัณฑิตวิทยาลัย-----------------------------
								case "admin":
										echo "รายการเอกสารรอตรวจสอบ";
										break;
								case "Admin_Registration_Thesis":
										echo 'คำร้องขอลงทะเบียน Thesis/IS';
										break;
								case "Admin_Taking_Leave":
										echo 'คำร้องขอลาพักการเรียน';
										break;
								//-------------------------------------Home-----------------------
								case "home":
										echo "Home";
										break;	
								
								//------------------------------------------------------------------			
											
								default:
								//echo "Home";
										$src_page = 'home.php';
							   }*/

							?>
              </h1>
            </div>
            <?php

					//include $src_page;

					?>
            <div class="row row-cards row-deck">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">แบบฟอร์มบันทึกข้อความ (การชำระเงิน/หลักฐาน/รายงานตัวช้า) </h3>
                  </div>
                  <div class="card-body">
                    <div id="show_loading" align="center"></div>
                    <form action="javascipt:;" method="post" id="frm_add_memorandum" class="frm_add_memorandum" name="frm_add_memorandum">
                      
                      <!--             <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2">เรียนผู้บริหาร<span class="form-required">*</span></label>
                          <div class="col-sm-10">
                             <select class="custom-select" id="dean_admin" name="dean_admin" >
                          <option value="0" >เลือกผู้บริการ</option>
                          <option value="2" >คณบดีบัณฑิตวิทยาลัย</option>
                          <option value="3" >รองคณบดีบัณฑิตวิทยาลัย ฝ่ายบริหาร</option>
                          <option value="4" >รองคณบดีบัณฑิตวิทยาลัย ฝ่ายวิชาการ </option>
                          <option value="5" >รองคณบดีบัณฑิตวิทยาลัยฝ่ายประกันคุณภาพการศึกษาและกิจการพิเศษ</option>
                        </select>
                            <!--<select class="form-control" id="because" name="because">
														<option value="0">เลือก เนื่องจาก/ because</option>
														<option value="ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ">ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ</option>
														<option value="การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ">การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ</option>
														<option value="เจ็บป่วยจนต้องพักการรักษา">เจ็บป่วยจนต้องพักการรักษา</option>
														<option value="ความจำเป็นส่วนตัว">ความจำเป็นส่วนตัว</option>
													</select>
                          </div>
                        </div>
                      </div>-->
                      <label>    ด้วยข้าพเจ้า </label>
                      <div class="form-group col-sm-9">
                      
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นาย" <?php if($row['titlename']=="นาย") { echo "checked"; } ?> >
                <span class="custom-control-label">นาย</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นาง" <?php if($row['titlename']=="นาง") { echo "checked"; } ?>>
                <span class="custom-control-label">นาง</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นางสาว" <?php if($row['titlename']=="นางสาว") { echo "checked"; } ?>>
                <span class="custom-control-label">นางสาว</span> </label>
											
											</div>
										</div>
                                               <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-4">ชื่อ-สกุล<span class="form-required">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="txtname" name="txtname" value="<?=$row['name_surname'];?>">
                            <!--<select class="form-control" id="because" name="because">
														<option value="0">เลือก เนื่องจาก/ because</option>
														<option value="ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ">ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ</option>
														<option value="การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ">การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ</option>
														<option value="เจ็บป่วยจนต้องพักการรักษา">เจ็บป่วยจนต้องพักการรักษา</option>
														<option value="ความจำเป็นส่วนตัว">ความจำเป็นส่วนตัว</option>
													</select>--> 
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-4">ผ่านการคัดเลือกขั้นสุดท้ายเพื่อเข้าศึกษาต่อได้ในสาขาวิชา <span class="form-required">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="major" name="major" value="<?=$row['major'];?>">
                            <!--<select class="form-control" id="because" name="because">
														<option value="0">เลือก เนื่องจาก/ because</option>
														<option value="ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ">ถูกเกณฑ์หรือระดมเข้ารับราชการทหารกองประจำการ</option>
														<option value="การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ">การทำวิจัยในหลักสูตรหรือได้รับทุนแลกเปลี่ยนนิสิตระหว่างประเทศ</option>
														<option value="เจ็บป่วยจนต้องพักการรักษา">เจ็บป่วยจนต้องพักการรักษา</option>
														<option value="ความจำเป็นส่วนตัว">ความจำเป็นส่วนตัว</option>
													</select>--> 
                          </div>
                        </div>
                      </div>
                        <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-4">คณะ<span class="form-required">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="faculty" name="faculty" value="<?=$row['faculty'];?>">
                          
                          </div>
                        </div>
                      </div>
                      <label>ภาคการศึกษา/semester</label>
                      							<div class="form-group col-sm-9">
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" <?php if($row['semester']=="1") { echo "checked"; } ?> disabled  >
                            <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="semester" id="semester" value="2" <?php if($row['semester']=="2") { echo "checked"; } ?> disabled >
                            <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="semester" id="semester" value="3" <?php if($row['semester']=="3") { echo "checked"; } ?> disabled >
                            <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
											
											</div>
										</div>
										<div class="form-group">
											<label class="form-label"> ปีการศึกษา/ Academic year</label>
											<select class="custom-select" id="academic" name="academic" disabled>
												<option value="0">เลือก ปีการศึกษา/ Academic year</option>
                                                <option value="2565" <?php if($row[ 'academic']=="2565" ) { echo "selected"; } ?>>2565</option>
                                                <option value="2564" <?php if($row[ 'academic']=="2564" ) { echo "selected"; } ?>2564</option>
                                                <option value="2563" <?php if($row[ 'academic']=="2563" ) { echo "selected"; } ?>>2563</option>
                                                <option value="2562" <?php if($row[ 'academic']=="2562" ) { echo "selected"; } ?>>2562</option>
												<option value="2561" <?php if($row[ 'academic']=="2561" ) { echo "selected"; } ?>>2561</option>
												<option value="2560" <?php if($row[ 'academic']=="2560" ) { echo "selected"; } ?>>2560</option>
												<option value="2559" <?php if($row[ 'academic']=="2559" ) { echo "selected"; } ?>>2559</option>
												<option value="2558" <?php if($row[ 'academic']=="2558" ) { echo "selected"; } ?>>2558</option>
												<option value="2557" <?php if($row[ 'academic']=="2557" ) { echo "selected"; } ?>>2557</option>
												<option value="2556" <?php if($row[ 'academic']=="2556" ) { echo "selected"; } ?>>2556</option>
												<option value="2555" <?php if($row[ 'academic']=="2555" ) { echo "selected"; } ?>>2555</option>
												<option value="2554" <?php if($row[ 'academic']=="2554" ) { echo "selected"; } ?>>2554</option>
											</select>
										</div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-12">มีความประสงค์ใคร่ขอความอนุเคราะห์ผ่อนผัน (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ในการรายงานตัวเข้าศึกษาต่อในระดับบัณฑิตศึกษา มหาวิทยาลัยมหาสารคาม ดังนี้ <span class="form-required">*</span></label>
                          <div class="col-sm-12">
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="late_registration" class="custom-control-input" name="late_registration" value="1" <?php if($row['late_registration']=="1") { echo "checked"; } ?>>
                              <span class="custom-control-label">1. ขอรายงานตัวช้า (เพื่อรายงานตัวเพิ่มเติม) </span> </label>
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="payment_chk" class="custom-control-input" name="payment_chk" value="1" <?php if($row['payment_chk']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">2. การชำระค่าธรรมเนียมการศึกษา เนื่องจาก ดังนี้ โดยจะนำมาชำระในวันที่ </span> </label>
                            <input type="date" class="form-control" id="payment_chk_date" name="payment_chk_date" value="<?=$row['payment_chk_date'];?>">
                             <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="problem_bank_1" class="custom-control-input" name="problem_bank_1" value="1" <?php if($row['problem_bank_1']=="1") { echo "checked"; } ?>>
                              <span class="custom-control-label">2.1	ปัญหาด้านการเงิน</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="capital_form_chk2" class="custom-control-input" name="capital_form_chk2" value="1" <?php if($row['capital_form_2']!="") { echo "checked"; } ?> >
                              <span class="custom-control-label">2.2	รอผลพิจารณาทุน/กำลังเบิกจ่ายทุน จาก </span> </label>
                              <input type="text" class="form-control" id="capital_form_2" name="capital_form_2" disabled value="<?=$row['capital_form_2'];?>">
                         </div>
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="evidence_late" class="custom-control-input" name="evidence_late" value="1" <?php if($row['evidence_late']=="1") { echo "checked"; } ?>>
                              <span class="custom-control-label">3. ส่งเอกสารหลักฐานการรายงานตัวล่าช้า ดังนี้</span> </label>
                          </div>
                        </div>
                         <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="photo_1" class="custom-control-input" name="photo_1" value="1" <?php if($row['photo_1']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.1  รูปถ่าย 1 นิ้ว </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="printed_2" class="custom-control-input" name="printed_2" value="1" <?php if($row['printed_2']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.2 แบบรายงานตัวที่พิมพ์ผ่านระบบ Internet </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_payment_3" class="custom-control-input" name="copy_payment_3" value="1" <?php if($row['copy_payment_3']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.3 สําเนาใบชําระเงินผ่านธนาคาร</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_id_card_4" class="custom-control-input" name="copy_id_card_4" value="1" <?php if($row['copy_id_card_4']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.4 สําเนาบัตรประจําตัวประชาชนหรือบัตรข้าราชการ </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_house_5" class="custom-control-input" name="copy_house_5" value="1" <?php if($row['copy_house_5']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.5 สําเนาทะเบียนบ้าน</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="completed_transcript_6" class="custom-control-input" name="completed_transcript_6" value="1" <?php if($row['completed_transcript_6']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.6 สำเนาใบแสดงผลการเรียนที่สำเร็จการศึกษา  </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="change_name_surname_7" class="custom-control-input" name="change_name_surname_7" value="1" <?php if($row['change_name_surname_7']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.7 สำเนาเอกสารการเปลี่ยนชื่อ-สกุล </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="others_8" class="custom-control-input" name="others_8" value="1" <?php if($row['others_8']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">3.8 อื่นๆ </span> </label>
                               <input type="text" class="form-control" id="others" name="others" value="<?=$row['others_name'];?>">
                         </div>
                         
                      </div>
                          <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="certificate" class="custom-control-input" name="certificate" value="1" <?php if($row['certificate']=="1") { echo "checked"; } ?> >
                              <span class="custom-control-label">4. ขอหนังสือรับรองการสอบได้ (เพื่อประกอบการขอทุน) </span> </label>
                      <div class="form-group">
                        <div class="row align-items-center">
                           
                           
                              <span class="custom-control-label">ทั้งนี้ ข้าพเจ้าจะนำหลักฐานมาให้มหาวิทยาลัย ภายในวันที่ </span> 
                            <input type="date" class="form-control" id="submit_document" name="submit_document" value="<?=$row['submit_document'];?>"> หากพ้นกำหนดดังกล่าว จะถือว่าท่านสละสิทธิ์การเข้าศึกษา
                        </div>
                      </div>
                      
        		</div>
					<div class="form-group">
                    <div class="form-group col-sm-3">
											<label class="form-label">เบอร์ติดต่อ<span class="form-required">*</span> </label>
                                            </div>
                                            <div class="form-group col-sm-9">
											<input type="text" name="txtphone" id="txtphone" class="form-control" value="<?=$row['phone'];?>" >
                                            </div>
					</div>
                    <div class="form-group">
                    <div class="form-group col-sm-3">
											<label class="form-label">อีเมล<span class="form-required">*</span> </label></div>
											<div class="form-group col-sm-9">
                                            <input type="text" name="txtemail" id="txtemail" class="form-control" value="<?=$row['email'];?>">
                                            </div>
					</div>
                 	<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2 form-label">พิจารณาคำร้อง<span class="form-required">*</span></label>
												<div class="col-sm-10">
													<label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"    id="staff_grad_approve_disapprove" value="1" <?php if($row['staff_grad_approve_disapprove']=="1") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                              <span class="custom-control-label">เสนอเรื่องเพื่อพิจารณา</span> </label>
												
													<?php /*?> <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"   id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                  <span class="custom-control-label">แบบฟอร์ไม่ถูกต้อง</span> </label>
												

													<?php */?>
													<label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"  id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?> >
                              <span class="custom-control-label">ส่งคืนนิสิต</span>(มีแก้ไข) </label>
												
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="form-label">ส่งเรื่องให้ผู้บริหาร<span class="form-required">*</span></label>
											<select class="custom-select" id="dean_admin" name="dean_admin" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>
                          <option value="0"  <?php if($row[dean_admin] ==0) { echo "selected";}?> >เลือกผู้บริการ</option>
                          <option value="2" <?php if($row[dean_admin] ==2) { echo "selected";}?>>คณบดีบัณฑิตวิทยาลัย</option>
                          <option value="3" <?php if($row[dean_admin] ==3) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัย ฝ่ายบริหาร</option>
                          <option value="4" <?php if($row[dean_admin] ==4) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัย ฝ่ายวิชาการ </option>
                          <option value="5" <?php if($row[dean_admin] ==5) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัยฝ่ายประกันคุณภาพการศึกษาและกิจการพิเศษ</option>
                        </select>
										</div>
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">เหตุผล</label>
												<div class="col-sm-10">
													<textarea name="argument" id="argument" class="form-control" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>><?php echo $row['staff_grad_node'];?></textarea>
												</div>
											</div>
										</div>
										<div class="btn-list mt-4 text-left">
											<input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>">
											<input type="hidden" name="Save_Memorandum" value="Save_Memorandum">
											<button type="submit" id="btnSaveSign" class="btn btn-primary btn-space" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>Save Data</button>
											<button type="button" class="btn btn-secondary btn-space" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>Cancel</button>
										</div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="row">
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">First link</a></li>
                    <li><a href="#">Second link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Third link</a></li>
                    <li><a href="#">Fourth link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Fifth link</a></li>
                    <li><a href="#">Sixth link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Other link</a></li>
                    <li><a href="#">Last link</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
              Premium and Open Source dashboard template with responsive and high quality UI. For Free!
            </div>
          </div>
        </div>
      </div>-->
      <footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <div class="row align-items-center">
                <div class="col-auto"> 
                  <!--   <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                    <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                  </ul>--> 
                </div>
                <!--   <div class="col-auto">
                  <a href="https://github.com/tabler/tabler" class="btn btn-outline-primary btn-sm">Source code</a>
                </div>--> 
              </div>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center"> Copyright © 2018 บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม </div>
            <!-- Global site tag (gtag.js) - Google Analytics --> 
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125434499-1"></script> 
            <script>
						window.dataLayer = window.dataLayer || [];

						function gtag() {
							dataLayer.push( arguments );
						}
						gtag( 'js', new Date() );
						gtag( 'config', 'UA-125434499-1' );
					</script> 
          </div>
        </div>
      </footer>
    </div>
</body>
</html>

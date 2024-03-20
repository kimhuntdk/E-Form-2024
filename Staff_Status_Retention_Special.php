<?php
session_start();
$id = $_SESSION[ 'SES_ID' ];
require_once( "inc/db_connect.php" );
$mysqli = connect();
$SES_LEVEL = $_SESSION[ "SES_LEVEL" ];
$doc_id = base64_decode( $_REQUEST['doc_id'] );
if ( $SES_LEVEL == "staff_ses" || $_SESSION[ "SES_USER" ] == "" ) {
	
}
//=========แสดงข้อมูลนิสิตที่ยื่นเอกสาร======================
$sql = "SELECT * FROM request_doc LEFT JOIN request_status_retention ON request_doc.doc_id=request_status_retention.doc_id WHERE request_doc.doc_id=" . $doc_id;
$result = $mysqli->query( $sql );
$row = $result->fetch_array();
$staff_grad_approve_disapprove = $row[ 'staff_grad_approve_disapprove' ];
//=========แสดงข้อมูลนิสิต======================
$sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th,std_faculty_id FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
$rs_name = $mysqli->query( $sql_name );
$row_name = $rs_name->fetch_array();
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
    <script src='src/jquery-customselect.js'></script>
    <link href='src/jquery-customselect.css' rel='stylesheet'/>
    <script>
	 $( document ).ready(function() {
	 $( "#btn_send" ).click(function() {
	
    	$.post( "loop.php", $( "#frm_staf_status_special" ).serialize(),
		 function ( data ) {
			//alert(data);
			if ( data ==1 ) {
							alert( "Send Data Complete.." );
							window.location.href = 'staff.php';
						} else if ( data ==2 ) {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';
						} else {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';

						} 
		 }
		);
		});
	$( ".staff_grad_approve_disapprove" ).click(function() {
		var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
		//alert(staff_grad_approve_disapprove);
		$("#staff_status").val(staff_grad_approve_disapprove);
	});
    });
    </script>
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
        <h3 class="card-title">คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) Student Status Retention Form (Special case)</h3>
      </div>
          <div class="card-body">(ผ่านการตรวจสอบข้อมูลเบื้องต้นจากบัณฑิตวิทยาลัย)
        <div class="col-md-12 col-xl-12">
              <div class="card">
            <div class="card-status bg-yellow"></div>
            <div class="card-header">
                  <h3 class="card-title">ข้อมูลนิสิต</h3>
                  <div class="card-options"> <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a> <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> </div>
                </div>
            <div class="card-body">
                  <div id="show_loading" align="center"></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                      <tr>
                    <td><b>ชื่อ</b> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?>&nbsp;&nbsp;<b>รหัสประจำตัวนิสิต</b>&nbsp; <?php echo $row_name['std_id_std'];?>&nbsp; <?php echo $row_name['std_degree_th'];?> &nbsp; <?php echo $row_name['std_faculty_th'];?> &nbsp;<b>สาขา</b> <?php echo $row_name['std_major_th'];?></td>
                  </tr>
                      <tr>
                    <td></td>
                  </tr>
                    </tbody>
              </table>
                </div>
          </div>
            </div>
        <label class="form-label"> ภาคศึกษา/ semester<span class="form-required">*</span> </label>
        <div class="form-group col-sm-9">
              <div class="custom-controls-stacked">
            <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" <?php if($row['semester']=="1") { echo "checked"; } ?> disabled >
                  <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
            <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" name="semester" id="semester" value="2" <?php if($row['semester']=="2") { echo "checked"; } ?> disabled>
                  <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
            <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" name="semester" id="semester" value="3" <?php if($row['semester']=="3") { echo "checked"; } ?> disabled>
                  <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
          </div>
            </div>
        <div class="form-group">
              <label class="form-label"> ปีการศึกษา/ Academic year <span class="form-required">*</span> </label>
              <select class="custom-select" id="academic" name="academic" disabled>
            <option value="0">เลือก ปีการศึกษา/ Academic year</option>
           <option value="2565" <?php if($row[ 'academic']=="2565" ) { echo "selected"; } ?>>2565</option>
            <option value="2564" <?php if($row[ 'academic']=="2564" ) { echo "selected"; } ?>>2564</option>
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
            <label class="col-sm-12">กรณีที่ 1 (Case I) (ถ้าตอบใช่ทั้ง 3 ข้อ ลงทะเบียนกรณีพิเศษได้) (If you select 3 “YES”, you can register as special case)</label>
            <div class="form-group col-sm-12">
                  <div class="custom-controls-stacked">
                <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่าง ๆ ครบแล้ว	(I have completed all subject requirements for the curriculum)</label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="subject_completed_1" id="subject_completed_1" value="1" <?php if($row['subject_completed_1']=="1") { echo "checked"; } ?> disabled>
                      <span class="custom-control-label">ใช่ (YES)</span> </label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="subject_completed_1" id="subject_completed_1" value="2" <?php if($row['subject_completed_1']=="2") { echo "checked"; } ?> disabled>
                      <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
              </div>
                  <div class="custom-controls-stacked">
                <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าส่งวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ 1 เล่ม ให้งานบริหารบัณฑิตศึกษาแล้ว     (I was submitted thesis/IS 1 books to Graduate School)</label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="submitted_books_1" id="submitted_books_1" value="1" <?php if($row['submitted_books_1']=="1") { echo "checked"; } ?> disabled>
                      <span class="custom-control-label">ใช่ (YES)</span> </label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" name="submitted_books_1" id="submitted_books_1" value="2" <?php if($row['submitted_books_1']=="2") { echo "checked"; } ?> disabled>
                      <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                <div class="custom-controls-stacked">
                      <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้ายังสอบประมวลความรู้ไม่ผ่าน หรือยังไม่ได้สอบประมวลความรู้     (I was not completed for General Exam)</label>
                      <label class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" name="not_exam_ce_1" id="not_exam_ce_1" value="1" <?php if($row['not_exam_ce_1']=="1") { echo "checked"; } ?> disabled>
                    <span class="custom-control-label">ใช่ (YES)</span> </label>
                      <label class="custom-control custom-radio custom-control-inline">
                    <input type="radio" class="custom-control-input" name="not_exam_ce_1" id="not_exam_ce_1" value="2" <?php if($row['not_exam_ce_1']=="2") { echo "checked"; } ?> disabled>
                    <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                    </div>
              </div>
                  <hr>
                  <div class="row align-items-center">
                <label class="col-sm-12">กรณีที่ 2 (Case II) (ไม่ใช่ลงทะเบียนกรณีพิเศษ) (Unregister as special case)</label>
                <div class="form-group col-sm-12">
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่าง ๆ ครบแล้ว	(I have completed all subject requirements for the curriculum)</label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_2"  id="subject_completed_2" value="1" <?php if($row['subject_completed_2']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_2" id="subject_completed_2" value="2" <?php if($row['subject_completed_2']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                  </div>
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าลงหน่วยกิตวิทยานิพนธ์ครบ 12 หน่วยกิต หรือการศึกษาค้นคว้าอิสระครบ 6 หน่วยกิตแล้ว (I was register for thesis in 12 credits completely) </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="thesis_12_credits_2" id="thesis_12_credits_2" value="1" <?php if($row['thesis_12_credits_2']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="thesis_12_credits_2" id="thesis_12_credits_2" value="2" <?php if($row['thesis_12_credits_2']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                    <div class="custom-controls-stacked">
                          <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้าไม่สามารถสอบปากเปล่า หรือสอบรายงานการศึกษาค้นคว้าอิสระได้ทันในภาคเรียนที่แล้ว (Last semester, I cannot pass the oral test/do a presentation for my IS in time)</label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="connot_presen_2" id="connot_presen_2" value="1" <?php if($row['connot_presen_2']=="1") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ใช่ (YES)</span> </label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="connot_presen_2" id="connot_presen_2" value="2" <?php if($row['connot_presen_2']=="2") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        </div>
                  </div>
                      <hr>
                    </div>
              </div>
                  <div class="row align-items-center">
                <label class="col-sm-12">กรณีที่ 3 (Case III) (ถ้าตอบใช่ทั้ง  3  ข้อ  ลงทะเบียนกรณีพิเศษได้) (If you select 3 “YES”, you can register as special case)</label>
                <div class="form-group col-sm-12">
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่างๆครบแล้ว(I have completed all subject requirements for the curriculum)</label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_3" id="subject_completed_3" value="1" <?php if($row['subject_completed_3']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_3" id="subject_completed_3" value="2" <?php if($row['subject_completed_3']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                  </div>
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าสอบประมวลความรู้แล้ว (I was completed for GE Test)</label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="complete_ge_3" id="complete_ge_3" value="1" <?php if($row['complete_ge_3']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="complete_ge_3" id="complete_ge_3" value="2" <?php if($row['complete_ge_3']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                    <div class="custom-controls-stacked">
                          <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้าไม่สามารถส่งวิทยานิพนธ์ 1 เล่ม หรือการศึกษาค้นคว้าอิสระ 1 เล่ม ให้บัณฑิตวิทยาลัยได้ทันตามเวลาที่กำหนดไว้ (I cannot submit 9 thesis/IS to the Graduate School in time)</label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="connot_submit_9_3" id="connot_submit_9_3" value="1" <?php if($row['connot_submit_9_3']=="1") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ใช่ (YES)</span> </label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="connot_submit_9_3" id="connot_submit_9_3" value="2" <?php if($row['connot_submit_9_3']=="2") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        </div>
                  </div>
                      <hr>
                    </div>
              </div>
                  <div class="row align-items-center">
                <label class="col-sm-12">กรณีที่ 4 (Case IV) (ถ้าตอบใช่ทั้ง  3  ข้อ  ลงทะเบียนกรณีพิเศษได้) ) (If you select 3 “YES”, you can register as special case)</label>
                <div class="form-group col-sm-12">
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่างๆครบแล้ว(I have completed all subject requirements for the curriculum) </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_4" id="subject_completed_4" value="1" <?php if($row['subject_completed_4']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="subject_completed_4" id="subject_completed_4" value="2" <?php if($row['subject_completed_4']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                  </div>
                      <div class="custom-controls-stacked">
                    <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าส่งวิทยานิพนธ์เล่มสมบูรณ์ให้บัณฑิตวิทยาลัยได้ทันตามเวลาที่กำหนดไว้ (I was submitted thesis/IS completely with Graduate School)</label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="thesis_is_completely_4" id="thesis_is_completely_4" value="1" <?php if($row['thesis_is_completely_4']=="1") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ใช่ (YES)</span> </label>
                    <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="thesis_is_completely_4" id="thesis_is_completely_4" value="2" <?php if($row['thesis_is_completely_4']=="2") { echo "checked"; } ?> disabled>
                          <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                    <div class="custom-controls-stacked">
                          <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้ารอการตีพิมพ์หรือตอบรับการตีพิมพ์ผลงานวิทยานิพนธ์ (I am waiting for publication/ acceptance for publication of my thesis/IS)</label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="waiting_publication_4" id="waiting_publication_4" value="1" <?php if($row['waiting_publication_4']=="1") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ใช่ (YES)</span> </label>
                          <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" name="waiting_publication_4" id="waiting_publication_4" value="2" <?php if($row['waiting_publication_4']=="2") { echo "checked"; } ?> disabled>
                        <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        </div>
                  </div>
                      <hr>
                    </div>
              </div>
                </div>
          </div>
              
              <!-- <div class="row align-items-center">
            <label class="col-sm-12">กรณีได้อนุมัติให้ทำวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ/ Getting the approval to do thesis/independent study </label>
          </div>
          <div class="form-group">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="finished_a" class="custom-control-input" name="example-checkbox1" value="option1" >
                <span class="custom-control-label">งานที่ทำแล้วเสร็จ/ The finished assignment: </span>
                <input type="text" class="form-control" id="finished_assignment" placeholder="" disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unfinished_a" class="custom-control-input" name="example-checkbox2" value="option2">
                <span class="custom-control-label">งานที่กำลังทำ / The unfinished assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unfinished_assignment"  disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unstarting_a" class="custom-control-input" name="example-checkbox3" value="option3" >
                <span class="custom-control-label">งานที่ยังไม่ทำ/ The unstarting assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unstarting_assignment" disabled>
              </label>
            </div>
          </div>-->
            <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-3">ลงชื่อ/ signature และ ผู้ยื่นคำร้อง/ Applicant<span class="form-required">*</span></label>
                          <div class="col-sm-9"> <img src="digital-e-signature/doc_signs/<?=$row['std_signature'];?>.png"> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?> </div>
                        </div>
                      </div>
                   <div class="form-group">
            <div class="row align-items-center">
                  <label class="col-sm-3">ลงชื่อ/ signature เจ้าหน้าที่<span class="form-required">*</span></label>
                              <img src="<?=$row['staff_signature'];?>.png">
                </div>
          </div>
          <form  action="Javascript:void(0);" method="post" id="frm_staf_status_special" name="frm_staf_status_special">
              <div class="form-group">
            <div class="row align-items-center">
                  <label class="col-sm-2 form-label">พิจารณาคำร้อง<span class="form-required">*</span></label>
                  <div class="col-sm-10">
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"     id="staff_grad_approve_disapprove" value="1" <?php if($row['staff_grad_approve_disapprove']=="1") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                      <span class="custom-control-label">อนุมัติคำร้อง</span> </label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"     id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                      <span class="custom-control-label">แบบฟอร์ไม่ถูกต้อง</span> </label>
                <label class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"   id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?> >
                      <span class="custom-control-label">ส่งคืนนิสิต</span>(มีแก้ไข) </label>
              </div>
                </div>
          </div>
              	<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">เหตุผล</label>
												<div class="col-sm-10">
													<textarea name="argument" id="argument" class="form-control" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>><?php echo $row['staff_grad_node'];?></textarea>
												</div>
											</div>
										</div>
            <div class="form-group">
                  <div class="row align-items-center">
                <label class="col-sm-3">สรุป (สำหรับเจ้าหน้าที่) ( For the Officer)<span class="form-required">*</span></label>
              </div>
                </div>
                <?php
				
                	if($staff_grad_approve_disapprove!=0){
						$sql_fee = "select * from request_fee_officer where doc_id=".$row['doc_id'];
						$rs_fee = $mysqli->query($sql_fee);
						$i_fee=1;
						$sum_fee=0;
						foreach( $rs_fee as $row_fee) {
							echo $i_fee." ".$row_fee['fee_name']." จำนวน ".$row_fee['fee_price']." บาท";
							$fee = $row_fee['fee_price'];
							$sum_fee= $sum_fee + $fee;
							echo "<br>";
							$i_fee++;
						}
						echo "จำนวนรวม ".$sum_fee. "บาท";
					} else {
				?>
            <div class="form-group">
                  <div class="row align-items-center">
                <label class="col-sm-3">1. ค่าธรรมเนียมฯ (Fee)
                      <input type="hidden" name="sub[]" value="ค่าธรรมเนียมฯ (Fee)">
                    </label>
                <div class="col-sm-3">
                      <select class="form-control" name="bath[]">
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                  </select>
                      บาท (Baht) </div>
              </div>
                </div>
            <div class="form-group">
                  <div class="row align-items-center">
                <label class="col-sm-3">2.ค่าประกันฯ (a fee for certification)
                      <input type="hidden" name="sub[]" value="ค่าประกันฯ (a fee for certification)">
                    </label>
                <div class="col-sm-3">
                      <select class="form-control" name="bath[]">
                      <option value="0">ไม่เก็บค่าชำระ</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                  </select>
                      บาท (Baht) </div>
              </div>
                </div>
            <div class="form-group">
                  <div class="row align-items-center">
                <label class="col-sm-3">3.
                      <input type="text" name="sub[]" class="form-control" placeholder="ชื่อรายการ">
                    </label>
                <div class="col-sm-3">
                      <input type="text" class="form-control" name="bath[]" placeholder="จำนวนเงิน">
                      บาท (Baht) </div>
              </div>
                </div>
                <?php
					}
				?>
            <!--                 <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">ลงชื่อเจ้าหน้าที่/ signature staff<span class="form-required">*</span></label>
              <div class="col-sm-3">
                <div id="signArea" > 
                  <!--<h2 class="tag-ingo">Put signature below,</h2>
                  <div class="sig sigWrapper" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="250" height="100">
                    </canvas>
                  </div>
                </div>
                
      
              </div>
            </div>
          </div>-->
            <div>
                <input type="hidden" name="staff_status" id="staff_status">
                  <input type="hidden" name="doc_id" value="<?php echo $row['doc_id'];?>">
                  <button type="submit" class="btn btn-secondary btn-blue" name="dosubmit" id="btn_send"  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>Send Data</button>
                  <button type="button" class="btn btn-secondary btn-space">Cancel</button>
                </div>
          </form>
            </div>
      </div>
        </div>
  </div>
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
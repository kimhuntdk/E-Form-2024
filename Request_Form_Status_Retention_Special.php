<?php
session_start();
$id = $_SESSION[ 'SES_ID' ];
require_once( "inc/db_connect.php" );
$mysqli = connect();
if ( $id == "" || $_SESSION[ "SES_STDCODE" ] == "" ) {
	// echo "<script>window.location.href = 'logout.php'</script>";
	
	// หน้า alert บอกให้ login เข้าสู่ระบบก่อน
	echo "<script>
        function myFunction() {
            var result = confirm('กรุณาเข้าสู่ระบบ/Please Login');
            if (result) {
                // ถ้ากด ok ให้ไปที่หน้า login.php
                window.location.href = 'login.php';
            } else {
                window.location.href = 'logout.php';
            }
        }
        myFunction(); // เรียกใช้ฟังก์ชันทันที
    </script>";
}
$sql = "SELECT OpenTime, CloseTime FROM request_doc_type WHERE doc_type_id = 2"; // แก้ไขตามโครงสร้างของฐานข้อมูลของคุณ
$result = $mysqli->query($sql);
$row = $result->fetch_array();

date_default_timezone_set('Asia/Bangkok');  // ตั้งค่าให้เป็นเวลาท้องถิ่นที่ต้องการ
$current_time = time();
$start_time = strtotime($row['OpenTime']); // ตั้งเวลาเปิด
$end_time = strtotime($row['CloseTime']);   // ตั้งเวลาปิด

if ($current_time < $start_time || $current_time > $end_time) {
    // ถ้าไม่ได้อยู่ในช่วงเวลาที่เปิด ให้แสดงข้อความหรือ redirect ไปที่หน้าที่คุณต้องการ
	echo "<script>alert('ขณะนี้ไม่อยู่ในช่วงเวลาที่เปิดให้ส่งแบบฟอร์ม / not currently open for  E-form submission.'); window.location.href='form_request_doc2.php.';</script>";
    exit();
}
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

	$(document).ready(function(e){
        $("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
		$(document).ready(function() {
			$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		});
	
		$("#btnSaveSign").click(function(e){
			var semester = $( "input[type=radio][name=semester]:checked" ).val();
			var academic = $("#academic").val(); 
			
			var subject_completed_1 = $( "input[type=radio][name=subject_completed_1]:checked" ).val();
			var submitted_books_1 = $( "input[type=radio][name=submitted_books_1]:checked" ).val();
			var not_exam_ce_1 = $( "input[type=radio][name=not_exam_ce_1]:checked" ).val();
			var subject_completed_2 = $( "input[type=radio][name=subject_completed_2]:checked" ).val();
			var thesis_12_credits_2 = $( "input[type=radio][name=thesis_12_credits_2]:checked" ).val();
			var connot_presen_2 = $( "input[type=radio][name=connot_presen_2]:checked" ).val();
			var subject_completed_3 = $( "input[type=radio][name=subject_completed_3]:checked" ).val();
			var complete_ge_3 = $( "input[type=radio][name=complete_ge_3]:checked" ).val();
			var connot_submit_9_3 = $( "input[type=radio][name=connot_submit_9_3]:checked" ).val();
			var subject_completed_4 = $( "input[type=radio][name=subject_completed_4]:checked" ).val();
			var thesis_is_completely_4 = $( "input[type=radio][name=thesis_is_completely_4]:checked" ).val();
			var waiting_publication_4 = $( "input[type=radio][name=waiting_publication_4]:checked" ).val();
			var sig_chk =   $("#signArea").signaturePad().validateForm();
		

			 if(semester === undefined){
				alert("กรุณากรอกข้อมูลเทอม/semester");
				$("#semester").focus();
				return false;
			}
			if(academic == 0){
				alert("กรุณากรอกข้อมูลปีการศึกษา/ Academic year");
				$("#academic").focus();
				return false;
			}
	
		
			if(sig_chk == false) {
				alert("กรุณาลงลายชื่อ/signature");
				$("canvas").focus();
				return false;
			}
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function (canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
				
			/*		$.ajax({
						url: 'digital-e-signature/save_registration_thesis.php',
						data: { img_data:img_data,type_thesis:type_thesis,
								subject_code:subject_code,credits:credits,
								semester:semester,academic:academic,because:because
						 },
						type: 'post',
						dataType: 'json',
						success: function (response) {
						   //window.location.reload();
						}
					});*/
		/*				$.post( "digital-e-signature/save_registration_thesis.php", {
						img_data:img_data,type_thesis:type_thesis,
								subject_code:subject_code,credits:credits,
								semester:semester,academic:academic,because:because,advisor:advisor
					}, function ( data ) {
						if(data==1){
							alert("Send Data Complete..");
							window.location.href = 'index.php?menu=student';
						} else if(data==2) {
							alert("Send Data Error..2");
						} else if(data==3) {
							alert("Send Data Error..3");
						}else if(data==4) {
							alert("ไม่สามารถส่งคำร้องซ้ำได้ เนื่องจากมีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา/ประธานหลักสูตร");
						}
						//$("#result").html(data);

					} );*/
					$.post( "digital-e-signature/save_status_retention_special.php", {
							img_data: img_data,
							semester: semester,
							academic: academic,
							subject_completed_1: subject_completed_1,
							submitted_books_1: submitted_books_1,
							not_exam_ce_1: not_exam_ce_1,
							subject_completed_2: subject_completed_2,
							thesis_12_credits_2: thesis_12_credits_2,
							connot_presen_2: connot_presen_2,
							subject_completed_3: subject_completed_3,
							complete_ge_3: complete_ge_3,
							connot_submit_9_3: connot_submit_9_3,
							subject_completed_4: subject_completed_4,
							thesis_is_completely_4: thesis_is_completely_4,
							waiting_publication_4: waiting_publication_4
						}, function ( data ) {
                            $("#error").html(data);
							if ( data == 1 ) {
								alert( "Send Data Complete.." );
								window.location.href = 'student.php';
							} else if ( data == 2 ) {
								alert( "Send Data Error..2" );
							} else if ( data == 3 ) {
								alert( "Send Data Error..3" );
							} else if ( data == 4 ) {
								alert( "ไม่สามารถส่งคำร้องซ้ำได้ เนื่องจากมีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา/ประธานหลักสูตร" );
							}
							$( "#show_loading" ).empty();
							$( "#btnSaveSign" ).removeAttr( 'disabled' );
							//$("#result").html(data);

						} );
					
	
					
				}
			});
		});
		//return false;
	/*	$("#btnClearSign").click(function(e){
			$("#signArea").signaturePad().clearCanvas();
		});*/
	
		$("#btnClearSign2").click(function(e){
			$("#signArea").signaturePad().clearCanvas();
			return false;
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
        <form id="frm_status_retention" name="frm_status_retention" action="javascript:(0);" method="post" enctype="multipart/form-data">
        <label class="form-label"> ภาคศึกษา/ semester<span class="form-required">*</span> </label>
          <div class="form-group col-sm-9">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" >
                <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2">
                <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="3">
                <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label"> ปีการศึกษา/ Academic year <span class="form-required">*</span> </label>
            <select class="custom-select" id="academic" name="academic">
              <option value="0">เลือก ปีการศึกษา/ Academic year</option>
			  <option value="2566">2566</option>
              <!-- <option value="2565">2565</option>
              <option value="2564">2564</option>
              <option value="2563">2563</option>
              <option value="2562">2562</option>
              <option value="2561">2561</option>
              <option value="2560">2560</option>
              <option value="2559">2559</option>
              <option value="2558">2558</option>
              <option value="2557">2557</option>
              <option value="2556">2556</option>
              <option value="2555">2555</option>
              <option value="2554">2554</option> -->
            </select>
          </div>
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-12">กรณีที่ 1 (Case I) (ถ้าตอบใช่ทั้ง 3 ข้อ ลงทะเบียนกรณีพิเศษได้) (If you select 3 “YES”, you can register as special case)</label>
                  <div class="form-group col-sm-12">
               <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่าง ๆ ครบแล้ว	(I have completed all subject requirements for the curriculum)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_1" id="subject_completed_1" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_1" id="subject_completed_1" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
            </div>
                    <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าส่งวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ 1 เล่ม ให้งานบริหารบัณฑิตศึกษาแล้ว     (I was submitted thesis/IS 1 books to Graduate School)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="submitted_books_1" id="submitted_books_1" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="submitted_books_1" id="submitted_books_1" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้ายังสอบประมวลความรู้ไม่ผ่าน หรือยังไม่ได้สอบประมวลความรู้     (I was not completed for General Exam)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="not_exam_ce_1" id="not_exam_ce_1" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="not_exam_ce_1" id="not_exam_ce_1" value="2">
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
                <input type="radio" class="custom-control-input" name="subject_completed_2"  id="subject_completed_2" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_2" id="subject_completed_2" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
            </div>
                    <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าลงหน่วยกิตวิทยานิพนธ์ครบ 12 หน่วยกิต หรือการศึกษาค้นคว้าอิสระครบ 6 หน่วยกิตแล้ว (I was register for thesis in 12 credits completely) </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="thesis_12_credits_2" id="thesis_12_credits_2" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="thesis_12_credits_2" id="thesis_12_credits_2" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้าไม่สามารถสอบปากเปล่า หรือสอบรายงานการศึกษาค้นคว้าอิสระได้ทันในภาคเรียนที่แล้ว (Last semester, I cannot pass the oral test/do a presentation for my IS in time)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="connot_presen_2" id="connot_presen_2" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="connot_presen_2" id="connot_presen_2" value="2">
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
                <input type="radio" class="custom-control-input" name="subject_completed_3" id="subject_completed_3" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_3" id="subject_completed_3" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
            </div>
                    <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าสอบประมวลความรู้แล้ว (I was completed for GE Test)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="complete_ge_3" id="complete_ge_3" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="complete_ge_3" id="complete_ge_3" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้าไม่สามารถส่งวิทยานิพนธ์ 1 เล่ม หรือการศึกษาค้นคว้าอิสระ 1 เล่ม ให้บัณฑิตวิทยาลัยได้ทันตามเวลาที่กำหนดไว้ (I cannot submit 9 thesis/IS to the Graduate School in time)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="connot_submit_9_3" id="connot_submit_9_3" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="connot_submit_9_3" id="connot_submit_9_3" value="2">
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
              <label class="custom-control custom-radio custom-control-inline col-sm-9">1. ข้าพเจ้าเรียนรายวิชาต่างๆครบแล้ว(I have completed all subject requirements for the curriculum)  </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_4" id="subject_completed_4" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="subject_completed_4" id="subject_completed_4" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
            </div>
                    <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">2. ข้าพเจ้าส่งวิทยานิพนธ์เล่มสมบูรณ์ให้บัณฑิตวิทยาลัยได้ทันตามเวลาที่กำหนดไว้ (I was submitted thesis/IS completely with Graduate School)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="thesis_is_completely_4" id="thesis_is_completely_4" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="thesis_is_completely_4" id="thesis_is_completely_4" value="2">
                <span class="custom-control-label">ไม่ใช่ (NO)</span> </label>
                        <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline col-sm-9">3. ข้าพเจ้ารอการตีพิมพ์หรือตอบรับการตีพิมพ์ผลงานวิทยานิพนธ์ (I am waiting for publication/ acceptance for publication of my thesis/IS)</label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="waiting_publication_4" id="waiting_publication_4" value="1">
                <span class="custom-control-label">ใช่ (YES)</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="waiting_publication_4" id="waiting_publication_4" value="2">
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
              <label class="col-sm-2">ลงชื่อ/ signature <span class="form-required">*</span></label>
              <div class="col-sm-3">
                <div id="signArea" > 
                  <!--<h2 class="tag-ingo">Put signature below,</h2>-->
                  <div class="sig sigWrapper" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="250" height="100">
                    </canvas>
                  </div>
                </div>
                <button id="btnClearSign2" class="btn btn-secondary btn-space">Clar Signature</button>
                <!--<button id="btnSaveSign">Save Signature</button>--> 
              </div>
            </div>
          </div>
          <div class="btn-list mt-4 text-left">
            <button type="submit" id="btnSaveSign"  class="btn btn-primary btn-space">Save Data</button>
            <button type="button" class="btn btn-secondary btn-space">Cancel</button>
          </div>
              <div id="error"></div>
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
					<div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
						Copyright © 2018 บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม
					</div>
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
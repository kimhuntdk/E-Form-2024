<?php
session_start();
$id = $_SESSION[ 'SES_ID' ];
require_once( "inc/db_connect.php" );
$mysqli = connect();
/*if ( $id == "" || $_SESSION[ "SES_STDCODE" ] == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}*/
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
	<script type="text/javascript">
		$( document ).ready( function () {
			$( '#others_8' ).change( function () { //งานที่ทำแล้วเสร็จ
				if ( $( this ).is( ':checked' ) ) {
					$( "#others" ).removeAttr( 'disabled' );
				} else {
					$( "#others" ).attr( 'disabled', 'disabled' );
					$( "#others" ).val( '' );
				}
			} );
	        	$( '#capital_form_chk2' ).change( function () { //งานที่ทำแล้วเสร็จ
				if ( $( this ).is( ':checked' ) ) {
					$( "#capital_form_2" ).removeAttr( 'disabled' );
				} else {
					$( "#capital_form_2" ).attr( 'disabled', 'disabled' );
					$( "#capital_form_2" ).val( '' );
				}
			} );
	
			//$( "#advisor" ).customselect();
			//$("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
			$( document ).ready( function () {
				$( '#signArea' ).signaturePad( {
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				} );
			} );

			$( "#btnSaveSign" ).click( function ( e ) {
				var titlename = $( "input[type=radio][name=titlename]:checked" ).val();
				var name = $( "#txtname" ).val();
				var major = $( "#major" ).val();
				var faculty = $( "#faculty" ).val();
			    var semester = $( "input[type=radio][name=semester]:checked" ).val();
				var academic = $( "#academic" ).val();
				var late_registration = $( "input[type=checkbox][name=late_registration]:checked" ).val();
				var payment_chk = $( "input[type=checkbox][name=payment_chk]:checked" ).val();
				var payment_chk_date = $( "#payment_chk_date" ).val();
				var problem_bank_1 = $( "input[type=checkbox][name=problem_bank_1]:checked" ).val();
				var capital_form_chk2 = $( "input[type=checkbox][name=capital_form_chk2]:checked" ).val();
				var capital_form_2 = $( "#capital_form_2" ).val();		
				var evidence_late = $( "input[type=checkbox][name=evidence_late]:checked" ).val();
				var photo_1 = $( "input[type=checkbox][name=photo_1]:checked" ).val();
				var printed_2 = $( "input[type=checkbox][name=printed_2]:checked" ).val();
				var copy_payment_3 = $( "input[type=checkbox][name=copy_payment_3]:checked" ).val();
				var copy_id_card_4 = $( "input[type=checkbox][name=copy_id_card_4]:checked" ).val();
				var copy_house_5 = $( "input[type=checkbox][name=copy_house_5]:checked" ).val();
				var completed_transcript_6 = $( "input[type=checkbox][name=completed_transcript_6]:checked" ).val();
				var change_name_surname_7 = $( "input[type=checkbox][name=change_name_surname_7]:checked" ).val();
				var others_8 = $( "input[type=checkbox][name=others_8]:checked" ).val();
				var others = $("#others").val();
				var certificate = $( "input[type=checkbox][name=certificate]:checked" ).val();
				var submit_document = $("#submit_document").val();
				var phone = $("#txtphone").val();
				var email = $("#txtemail").val();
				var sig_chk = $( "#signArea" ).signaturePad().validateForm();
				//alert(payment_chk_date);
			  if(titlename === undefined){
        		alert("กรุณาเลือกคำนำหน้าชื่อ");
        		$("#titlename").focus();
        		return false;
        	}
			if ( name === "" ) {
					alert( "กรุณากรอกชื่อ สกุล" );
					$( "#txtname" ).focus();
					return false;
			}
			if ( major === "" ) {
					alert( "กรุณากรอกสาขา" );
					$( "#major" ).focus();
					return false;
			}
					if ( faculty === "" ) {
					alert( "กรุณากรอกคณะ" );
					$( "#faculty" ).focus();
					return false;
			}
            if(semester === undefined){
        		alert("กรุณากรอกข้อมูลเทอม/semesterให้ครบด้วยนะครับ");
        		$("#semester").focus();
        		return false;
        	}
        	if(academic == 0){
        		alert("กรุณากรอกข้อมูลปีการศึกษา/ Academic year");
        		$("#academic").focus();
        		return false;
        	}
			  if(late_registration === undefined && payment_chk === undefined && evidence_late === undefined && certificate===undefined){
        		alert("กรุณาเลือกกรณีใดกรณีหนึ่ง");
        		$("#late_registration").focus();
				
        		return false;
        	}
		    if(payment_chk != undefined){
				if(payment_chk_date ===""){
        		alert("กรุณาเลือกวันเที่");
        		$("#payment_chk_date").focus();
				
        		return false;
			    }
				if(problem_bank_1 === undefined && capital_form_chk2 === undefined){
        		alert("กรุณาเลือกข้อใดข้อหนึ่ง");
        		$("#problem_bank_1").focus();
				
        		return false;
			    }
        	}
		     	if(capital_form_chk2 != undefined){
					if(capital_form_2 ===""){
					alert("กรุณากรอกแหล่งที่มาของทุน");
					$("#capital_form_2").focus();
					return false;
					}
        	}
		     	if(submit_document ===""){
        		alert("กรุณาเลือกวันเที่");
        		$("#submit_document").focus();
        		return false;
        	}
			   if(phone ===""){
        		alert("กรุณากรอกเบอร์โทร");
        		$("#txtphone").focus();
        		return false;
        	}
			    if(email ===""){
        		alert("กรุณากรอกอีเมล");
        		$("#txtemail").focus();
        		return false;
        	}
	
				if ( sig_chk == false ) {
					alert( "กรุณาลงลายชื่อ.." );
					$( "canvas" ).focus();
					return false;
				}
				//== ตรวจสอบ email ==  
					/*var emailFilter=/^.+@.+\..{2,3}$/;
					var str=document.getElementById('email').value;
					if (!(emailFilter.test(str))) {
						alert('กรุณากรอก email ให้ถูกต้อง');
						return false; 
					}*/
				//alert(email);
				html2canvas( [ document.getElementById( 'sign-pad' ) ], {
					onrendered: function ( canvas ) {
						var canvas_img_data = canvas.toDataURL( 'image/png' );
						var img_data = canvas_img_data.replace( /^data:image\/(png|jpg);base64,/, "" );
						/*    var check_img = "iVBORw0KGgoAAAANSUhEUgAAAPoAAABkCAYAAACvgC0OAAACoElEQVR4Xu3XMQ0DMRREwTsApmH+eEzjADhSmihKk9pvzGBn/xa+99778ggQOFrgNvSj+xWOwFvA0B0CgYCAoQdKFpGAobsBAgEBQw+ULCIBQ3cDBAIChh4oWUQChu4GCAQEDD1QsogEDN0NEAgIGHqgZBEJGLobIBAQMPRAySISMHQ3QCAgYOiBkkUkYOhugEBAwNADJYtIwNDdAIGAgKEHShaRgKG7AQIBAUMPlCwiAUN3AwQCAoYeKFlEAobuBggEBAw9ULKIBAzdDRAICBh6oGQRCRi6GyAQEDD0QMkiEjB0N0AgIGDogZJFJGDoboBAQMDQAyWLSMDQ3QCBgIChB0oWkYChuwECAQFDD5QsIgFDdwMEAgKGHihZRAKG7gYIBAQMPVCyiAQM3Q0QCAgYeqBkEQkYuhsgEBAw9EDJIhIwdDdAICBg6IGSRSRg6G6AQEDA0AMli0jA0N0AgYCAoQdKFpGAobsBAgEBQw+ULCIBQ3cDBAIChh4oWUQChu4GCAQEDD1QsogEDN0NEAgIGHqgZBEJGLobIBAQMPRAySISMHQ3QCAgYOiBkkUkYOhugEBAwNADJYtIwNDdAIGAgKEHShaRgKG7AQIBAUMPlCwiAUN3AwQCAoYeKFlEAobuBggEBAw9ULKIBAzdDRAICBh6oGQRCRi6GyAQEDD0QMkiEjB0N0AgIGDogZJFJGDoboBAQMDQAyWLSMDQ3QCBgIChB0oWkYChuwECAQFDD5QsIgFDdwMEAgKGHihZRAKG7gYIBAR+hr7Wup7nCUQXkcCZAmOMa875Fc7Qz+xaqrDAX0MP+4hO4FgBf/RjqxWMwEfA0F0DgYCAoQdKFpGAobsBAgEBQw+ULCIBQ3cDBAIChh4oWUQChu4GCAQEXsNWmuS3svr2AAAAAElFTkSuQmCC";
							if(img_data===img_data){
								alert("ว่าง"); 
								return	false;
							}*/
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
						$( "#show_loading" ).html( "<img src='images/loading.gif' width='100' height='100'>" );
						$( "#btnSaveSign" ).attr( 'disabled', 'disabled' );

						$.post( "digital-e-signature/Save_Memorandum_Student.php", {
							img_data: img_data,
							titlename:titlename,
							name:name,
							major:major,
							faculty:faculty,
							semester: semester,	
							academic: academic,	
							late_registration: late_registration,	
							payment_chk: payment_chk,	
							payment_chk_date: payment_chk_date,	
							problem_bank_1: problem_bank_1,	
							capital_form_2: capital_form_2,	
							evidence_late: evidence_late,	
							photo_1: photo_1,	
							printed_2: printed_2,	
							copy_payment_3: copy_payment_3,	
							copy_id_card_4: copy_id_card_4,	
							copy_house_5: copy_house_5,	
							completed_transcript_6: completed_transcript_6,	
							change_name_surname_7: change_name_surname_7,	
							others_8: others_8,	
							certificate: certificate,
							others: others,	
							submit_document: submit_document,
							phone: phone,
							email:email

						}, function ( data ) {
							//alert(data);
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
				} );
			} );
			//return false;
			/*	$("#btnClearSign").click(function(e){
					$("#signArea").signaturePad().clearCanvas();
				});*/

			$( "#btnClearSign2" ).click( function ( e ) {
				$( "#signArea" ).signaturePad().clearCanvas();
				return false;
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
                      
                    
                     <div class="form-group">
                      <label>ด้วยข้าพเจ้า</label>
                   
                      <div class="form-group col-sm-9">
                      
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นาย" >
                <span class="custom-control-label">นาย</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นาง">
                <span class="custom-control-label">นาง</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="titlename" id="titlename" value="นางสาว">
                <span class="custom-control-label">นางสาว</span> </label>
											
											</div>
										</div>
                             </div>           
                       <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-4">ชื่อ-สกุล<span class="form-required">*</span></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="txtname" name="txtname">
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
                            <input type="text" class="form-control" id="major" name="major">
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
                            <input type="text" class="form-control" id="faculty" name="faculty">
                          
                          </div>
                        </div>
                      </div>
                     <div class="form-group">
                      <label>ภาคการศึกษา/semester</label>
                      <div class="form-group col-sm-9">
                      
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" checked >
                <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2">
                <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="3">
                <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>rd</sup> semester</span> </label>
											
											</div>
										</div>
                                        </div>
										<div class="form-group">
											<label class="form-label"> ปีการศึกษา/ Academic year <span class="form-required">*</span> </label>
											<select class="form-control" id="academic" name="academic">
												<option value="0">เลือก ปีการศึกษา/ Academic year</option>
                                                <option value="2565" selected>2565</option>
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
												<option value="2554">2554</option>
											</select>
										</div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-12">มีความประสงค์ใคร่ขอความอนุเคราะห์ผ่อนผัน (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ในการรายงานตัวเข้าศึกษาต่อในระดับบัณฑิตศึกษา มหาวิทยาลัยมหาสารคาม ดังนี้ <span class="form-required">*</span></label>
                          <div class="col-sm-12">
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="late_registration" class="custom-control-input" name="late_registration" value="1" >
                              <span class="custom-control-label">1. ขอรายงานตัวช้า (เพื่อรายงานตัวเพิ่มเติม) </span> </label>
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="payment_chk" class="custom-control-input" name="payment_chk" value="1" >
                              <span class="custom-control-label">2. การชำระค่าธรรมเนียมการศึกษา เนื่องจาก ดังนี้ (โดยจะนำมาชำระในวันที่)</span> </label>
                              <input type="date" class="form-control" id="payment_chk_date" name="payment_chk_date" required>
                         <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="problem_bank_1" class="custom-control-input" name="problem_bank_1" value="1" >
                              <span class="custom-control-label">2.1	ปัญหาด้านการเงิน</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="capital_form_chk2" class="custom-control-input" name="capital_form_chk2" value="1" >
                              <span class="custom-control-label">2.2	รอผลพิจารณาทุน/กำลังเบิกจ่ายทุน จาก </span> </label>
                              <input type="text" class="form-control" id="capital_form_2" name="capital_form_2" disabled>
                         </div>
                              
                            
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="evidence_late" class="custom-control-input" name="evidence_late" value="1" >
                              <span class="custom-control-label">3. ส่งเอกสารหลักฐานการรายงานตัวล่าช้า ดังนี้</span> </label>
                          </div>
                        </div>
                        
                         <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="photo_1" class="custom-control-input" name="photo_1" value="1" >
                              <span class="custom-control-label">3.1  รูปถ่าย 1 นิ้ว </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="printed_2" class="custom-control-input" name="printed_2" value="1" >
                              <span class="custom-control-label">3.2 แบบรายงานตัวที่พิมพ์ผ่านระบบ Internet </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_payment_3" class="custom-control-input" name="copy_payment_3" value="1" >
                              <span class="custom-control-label">3.3 สําเนาใบชําระเงินผ่านธนาคาร</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_id_card_4" class="custom-control-input" name="copy_id_card_4" value="1" >
                              <span class="custom-control-label">3.4 สําเนาบัตรประจําตัวประชาชนหรือบัตรข้าราชการ </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="copy_house_5" class="custom-control-input" name="copy_house_5" value="1" >
                              <span class="custom-control-label">3.5 สําเนาทะเบียนบ้าน</span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="completed_transcript_6" class="custom-control-input" name="completed_transcript_6" value="1" >
                              <span class="custom-control-label">3.6 สำเนาใบแสดงผลการเรียนที่สำเร็จการศึกษา  </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="change_name_surname_7" class="custom-control-input" name="change_name_surname_7" value="1" >
                              <span class="custom-control-label">3.7 สำเนาเอกสารการเปลี่ยนชื่อ-สกุล </span> </label>
                         </div>
                          <div class="col-sm-12">
                         <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="others_8" class="custom-control-input" name="others_8" value="1" >
                              <span class="custom-control-label">3.8 อื่นๆ </span> </label>
                               <input type="text" class="form-control" id="others" name="others" disabled>
                         </div>
                         
                      </div>
                            <label class="custom-control custom-checkbox">
                              <input type="checkbox" id="certificate" class="custom-control-input" name="certificate" value="1" >
                              <span class="custom-control-label">4. ขอหนังสือรับรองการสอบได้ (เพื่อประกอบการขอทุน) </span> </label>
                      <div class="form-group">
                        <div class="row align-items-center">
                           
                           
                              <span class="custom-control-label">ทั้งนี้ ข้าพเจ้าจะนำหลักฐานมาให้มหาวิทยาลัย ภายในวันที่ </span> 
                            <input type="date" class="form-control" id="submit_document" name="submit_document" required> หากพ้นกำหนดดังกล่าว จะถือว่าท่านสละสิทธิ์การเข้าศึกษา
                        </div>
                      </div>
                      
        		
					<div class="form-group">
                    <div class="form-group col-sm-3">
											<label class="form-label">เบอร์ติดต่อ<span class="form-required">*</span> </label>
                                            </div>
                                            <div class="form-group col-sm-9">
											<input type="text" name="txtphone" id="txtphone" class="form-control" required>
                                            </div>
					</div>
                    <div class="form-group">
                    <div class="form-group col-sm-3">
											<label class="form-label">อีเมล<span class="form-required">*</span> </label></div>
											<div class="form-group col-sm-9">
                                            <input type="text" name="txtemail" id="txtemail" class="form-control" required>
                                            </div>
					</div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2">ลงชื่อ/ signature <span class="form-required">*</span></label>
                          <div class="col-sm-3">
                            <div id="signArea"> 
                              <!--<h2 class="tag-ingo">Put signature below,</h2>-->
                              <div class="sig sigWrapper" style="height:auto;">
                                <div class="typed"></div>
                                <canvas class="sign-pad" id="sign-pad" width="250" height="100"> </canvas>
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

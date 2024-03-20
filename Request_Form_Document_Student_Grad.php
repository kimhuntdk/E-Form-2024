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
			$( '#finished_a' ).change( function () { //งานที่ทำแล้วเสร็จ
				if ( $( this ).is( ':checked' ) ) {
					$( "#finished_assignment" ).removeAttr( 'disabled' );
				} else {
					$( "#finished_assignment" ).attr( 'disabled', 'disabled' );
					$( "#finished_assignment" ).val( '' );
				}
			} );
			$( '#unfinished_a' ).change( function () { //งานที่กำลังทำ
				if ( $( this ).is( ':checked' ) ) {
					$( "#unfinished_assignment" ).removeAttr( 'disabled' );
				} else {
					$( "#unfinished_assignment" ).attr( 'disabled', 'disabled' );
					$( "#unfinished_assignment" ).val( '' );
				}
			} );
			$( '#unstarting_a' ).change( function () { //งานที่ยังไม่ทำ
				if ( $( this ).is( ':checked' ) ) {
					$( "#unstarting_assignment" ).removeAttr( 'disabled' );
				} else {
					$( "#unstarting_assignment" ).attr( 'disabled', 'disabled' );
					$( "#unstarting_assignment" ).val( '' );
				}
			} );
			$( "#advisor" ).customselect();
			//$("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
			$( document ).ready( function () {
				$( '#signArea' ).signaturePad( {
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				} );
			} );

			$( "#btnSaveSign" ).click( function ( e ) {
				var government= $( "#government" ).val();
				var subject = $( "#subject" ).val();
			    var node = $("#node").val();
				var sig_chk = $( "#signArea" ).signaturePad().validateForm();
					if ( government === "" ) {
					alert( "กรุณากรอกส่วนราชาการ" );
					$( "#subject" ).focus();
					return false;
				}
				if ( subject === "" ) {
					alert( "กรุณากรอกชื่อเรื่อง" );
					$( "#subject" ).focus();
					return false;
				}
			     if ( node === "" ) {
					alert("กรุณากรอกรายละเอียด");
					$( "#node" ).focus();
					return false;
				}
	
				if ( sig_chk == false ) {
					alert( "กรุณาลงลายชื่อ.." );
					$( "canvas" ).focus();
					return false;
				}

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

						$.post( "digital-e-signature/Save_Document_Student_Grad.php", {
							img_data: img_data,
							government:government,
							subject:subject,
							node: node

						}, function ( data ) {
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
                    <h3 class="card-title">แบบฟอร์มบันทึกข้อความ</h3>
                  </div>
                  <div class="card-body">
                    <div id="show_loading" align="center"></div>
                    <form action="Javascript:void(0);" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is" name="frm_add_thesis_is">
            
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
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2">ส่วนราชการ<span class="form-required">*</span></label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="government" name="government">
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
                          <label class="col-sm-2">เรื่อง<span class="form-required">*</span></label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="subject" name="subject">
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
                          <label class="col-sm-2">ข้อความ <span class="form-required">*</span></label>
                          <div class="col-sm-10">
                            <textarea name="node"  id="node" class="form-control ckeditor"></textarea>
                           
                         <!--   <input type="text" name="node"  id="node" class="form-control">-->
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
                    <?php /*?>  <div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-3">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์/คณบดีที่สังกัด
													(Advisor/Chairman of Thesis) <span class="form-required">*</span></label>
												<div class="col-sm-9">
													<select id="advisor" name="advisor" class="custom-select">
														<?php
												
														$url = "http://202.28.34.2/webservice/JsonOfficergard.php?fac=999";
														$contents = file_get_contents( $url );
														$contents = utf8_encode( $contents );
														$results = json_decode( $contents );
														echo "<option value='0'>กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์</option>";
														foreach ( $results as $key => $value ) {
															foreach ( $value as $k => $v ) {
																if ( $k == "officercode" ) {
																	echo "<option value='$v'>";
																}
																if ( $k == "prefixname" ) {
																	echo $v;
																}
																if ( $k == "officername" ) {
																	echo $v . "&nbsp;&nbsp;";
																}
																if ( $k == "officersurname" ) {
																	echo $v;
																}
															}
															echo "</option>";
														}


														?>

													</select>
												</div>
											</div>
							</div>
          
                               	<div class="form-group">
                                
                              <label class="col-sm-6">สถานะ(อาจารย์ที่ปรึกษา/ประธานหลักสูตร/คณบดีที่สังกัด)<span class="form-required">*</span></label>
                        
                        			<div class="form-group col-sm-9">
                                      
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="1" checked >
                <span class="custom-control-label">อาจารย์ที่ปรึกษา</label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="2">
                <span class="custom-control-label">ประธานหลักสูตร</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="3">
                <span class="custom-control-label">คณบดีที่สังกัด</span> </label>
											
											</div>
										</div>
                                        </div>
                      		<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">กรุณากรอกข้อมูลอีเมล(อาจารย์ที่ปรึกษา/ประธานหลักสูตร/คณบดีที่สังกัด) (ระบบแจ้งเตือนผ่านอีเมล)</label>
												<div class="col-sm-10"> 
													<input type="email" class="form-control" id="email" name="email" >
												
												</div>
											</div>
						</div><?php */?>
                 
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
                        <button type="submit" id="btnSaveSign" onClick="confirm_click_submit()" class="btn btn-primary btn-space">Save Data</button>
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
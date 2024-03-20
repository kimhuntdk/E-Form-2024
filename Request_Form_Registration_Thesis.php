<?php
session_start();
require_once("inc/db_connect.php");
$mysqli = connect();
$id = $_SESSION['SES_ID'];
if ($id == "" || $_SESSION["SES_STDCODE"] == "") {
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
$sql = "SELECT OpenTime, CloseTime FROM request_doc_type WHERE doc_type_id = 3"; // แก้ไขตามโครงสร้างของฐานข้อมูลของคุณ
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
	<meta http-equiv="Content-Language" content="th" />
	<meta name="msapplication-TileColor" content="#2d89ef">
	<meta name="theme-color" content="#4188c9">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<link rel="icon" href="./favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
	<!-- Generated: 2018-04-16 09:29:05 +0200 -->
	<title>e-Form Graduate School MSU</title>

	<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
-->
	<script src="./assets/js/require.min.js"></script>
	<script>
		requirejs.config({
			baseUrl: '.'
		});
	</script>
	<!-- Dashboard Core -->
	<link href="./assets/css/dashboard.css" rel="stylesheet" />
	<script src="./assets/js/dashboard.js"></script>
	<!-- c3.js Charts Plugin -->
	<link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
	<script src="./assets/plugins/charts-c3/plugin.js"></script>
	<!-- Google Maps Plugin -->
	<link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet" />
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
	<link href='src/jquery-customselect.css' rel='stylesheet' />
	<script>
		$(document).ready(function(e) {
			$("#subject_code").keyup(function() {
				var txt = $("#subject_code").val();
				var semester = $("input[type=radio][name=semester]:checked").val();
				var academic = $("#academic").val();
				// alert(academic);
				if (semester == undefined) {
					alert("กรุณาเลือกเทอม/ semester");
					$("#semester").focus();
					return false;
				}
				if (academic == 0) {
					alert("กรุณาเลือกปีการศึกษา/ academic");
					$("#academic").focus();
					return false;
				}
				//var number = $('#str').val().length
				/*     $("p").html(txt);
				       $("#show").html(number);*/
				if (txt != "" && semester != "" && academic != "") {
					$.post("JSCheckCourseClassid.php", {
						txt: txt,
						semester: semester,
						academic: academic
					}, function(result) {
						$("#group").html(result);
					});
				}
			});
			//$("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
			$("#advisor").customselect();
			$(document).ready(function() {
				$('#signArea').signaturePad({
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				});
			});

			$("#btnSaveSign").click(function(e) {
				var type_thesis = $("input[type=radio][name=type_thesis]:checked").val();
				var subject_code = $("#subject_code").val();
				var credits = $("#credits").val();
				var group = $("#group :selected").text();
				var classid = $("#group").val();
				var semester = $("input[type=radio][name=semester]:checked").val();
				var academic = $("#academic").val();
				var advisor = $("#advisor").val();
				var because = $("#because").val();
				var email = $("#email").val();
				var sig_chk = $("#signArea").signaturePad().validateForm();
				if (type_thesis === undefined) {
					alert("กรุณากรอกข้อมูล มีความประสงค์ขอลงทะเบียน/ would like to register");
					$("#type_thesis").focus();
					return false;
				}

				if (semester === undefined) {
					alert("กรุณากรอกข้อมูลเทอม/semesterให้ครบด้วยนะครับ");
					$("#semester").focus();
					return false;
				}
				if (academic == 0) {
					alert("กรุณากรอกข้อมูลปีการศึกษา/ Academic year");
					$("#academic").focus();
					return false;
				}

				if (subject_code === '') {
					alert("กรุณากรอกข้อมูลรหัสวิชา/ subject code");
					$("#subject_code").focus();
					return false;
				}
				//alert(group);
				if (group == 0 || group == null) {
					alert("กรุณากรอกกลุ่ม/ group code");
					$("#group").focus();
					return false;
				}

				if (credits === '') {
					alert("กรุณากรอกข้อมูลหน่วยกิต (credits)");
					$("#credits").focus();
					return false;
				}
				if (because == 0) {
					alert("กรุณาเลือกข้อมูลเนื่องจาก/ because");
					$("#because").focus();
					return false;
				}
				if (advisor == 0) {
					alert("กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์");
					$("#advisor").focus();
					return false;
				}
				if (sig_chk == false) {
					alert("กรุณาลงลายชื่อ..");
					$("canvas").focus();
					return false;
				}
				//== ตรวจสอบ email ==  
				var emailFilter = /^.+@.+\..{2,3}$/;
				var str = document.getElementById('email').value;
				if (!(emailFilter.test(str))) {
					alert('กรุณากรอก email ให้ถูกต้อง');
					return false;
				}
				//alert(email);
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function(canvas) {
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
						$("#show_loading").html("<img src='images/loading.gif' width='100' height='100'>");
						$("#btnSaveSign").attr('disabled', 'disabled');
						$.post("digital-e-signature/save_registration_thesis.php", {
							img_data: img_data,
							type_thesis: type_thesis,
							subject_code: subject_code,
							credits: credits,
							group: group,
							classid: classid,
							semester: semester,
							academic: academic,
							because: because,
							advisor: advisor,
							email: email
						}, function(data) {
							$("#error").html(data);
							if (data == 1) {
								alert("Send Data Complete..");
								window.location.href = 'student.php';
							} else if (data == 2) {
								alert("Send Data Error..2");
							} else if (data == 3) {
								alert("Send Data Error..3");
							} else if (data == 4) {
								alert("ไม่สามารถส่งคำร้องซ้ำได้ เนื่องจากมีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา/ประธานหลักสูตร");
							}
							//$("#result").html(data);
							$("#show_loading").empty();
							$("#btnSaveSign").removeAttr('disabled');

						});

					}
				});
			});
			//return false;
			/*	$("#btnClearSign").click(function(e){
					$("#signArea").signaturePad().clearCanvas();
				});*/

			$("#btnClearSign2").click(function(e) {
				$("#signArea").signaturePad().clearCanvas();
				return false;
			});
		});
	</script>


</head>

<body>
	<div class="page">
		<div class="page-main">
			<?php include("main_menu.php"); ?>
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
									<h3 class="card-title"><strong>Request Form for Registration for Thesis/IS </strong></h3>
								</div>
								<div class="card-body">
									<div id="show_loading" align="center"></div>
									<form action="Javascript:void(0);" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-12">มีความประสงค์ขอลงทะเบียน/ would like to register <span class="form-required">*</span> </label>
											</div>
										</div>
										<div class="form-group col-sm-9">
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
													<input type="radio" class="custom-control-input" name="type_thesis" id="type_thesis" value="Thesis">
													<span class="custom-control-label">Thesis</span> </label>
												<label class="custom-control custom-radio custom-control-inline">
													<input type="radio" class="custom-control-input" name="type_thesis" id="type_thesis" value="IS">
													<span class="custom-control-label">IS</span> </label>
											</div>
										</div>
										<div class="form-group col-sm-9">
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
													<input type="radio" class="custom-control-input" name="semester" id="semester" value="1">
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
											<select class="form-control" id="academic" name="academic">
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
											<div class="row align-items-right">
												<label class="col-sm-2 align-items-right">รหัสวิชา/ subject code<span class="form-required">*</span></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="รหัสวิชา" id="subject_code" name="subject code">
												</div>
												<label class="col-sm-2 align-items-right">กลุ่ม/ group code<span class="form-required">*</span></label>
												<div class="col-sm-2">
													<!--<input type="number" id="group" name="group" min="1" max="100" value="0" class="form-control" required>-->
													<select id="group" name="group" class="form-control" required>
														<option value="0" selected>-</option>
													</select>
												</div>
												<label class="col-sm-4">การระบุกลุ่มเรียน /อาจารย์ประจำกลุ่ม (ตรวจสอบจากตารางเรียนที่เปิดสอนของแต่ละภาคการศึกษาหรือติดต่อเจ้าหน้าที่คณะที่สังกัด)</label>
											</div>
										</div>
										<div class="form-group">
											<div class="row align-items-right">
												<label class="col-sm-2 align-items-right">เพิ่มอีก (more) <span class="form-required">*</span></label>
												<div class="col-sm-2">
													<input type="text" class="form-control" placeholder="จำนวนหน่วยกิต" id="credits" name="credits">
												</div>
												<label class="col-sm-2">หน่วยกิต (credits)</label>
											</div>
										</div>

										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">เนื่องจาก/ because <span class="form-required">*</span></label>
												<div class="col-sm-10">
													<!--<input type="text" class="form-control" id="because" name="because">-->
													<select class="form-control" id="because" name="because">
														<option value="0">เลือก เนื่องจาก/ because</option>
														<option value="สอบเค้าโครง">สอบเค้าโครง</option>
														<option value="รายงานความก้าวหน้า">รายงานความก้าวหน้า</option>
														<option value="สอบจบ">สอบจบ</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-3">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์
													(Advisor/Chairman of Thesis) <span class="form-required">*</span></label>
												<div class="col-sm-9">
													<select id="advisor" name="advisor" class="custom-select">
														<?php
														$sql_chk = " select std_faculty_id FROM  request_student WHERE  std_id_std=" . $_SESSION['SES_STDCODE'];
														$rs_chk = $mysqli->query($sql_chk);
														$row_chk = $rs_chk->fetch_array();
														$url = "http://202.28.34.2/webservice/JsonOfficergard.php?fac=999";
														$contents = file_get_contents($url);
														$contents = utf8_encode($contents);
														$results = json_decode($contents);
														echo "<option value='0'>กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์</option>";
														echo "<option value='15024'>รศ.ดร.ปราโมทย์  ทองกระจาย</option>";
														foreach ($results as $key => $value) {
															foreach ($value as $k => $v) {
																if ($k == "officercode") {
																	echo "<option value='$v'>";
																}
																if ($k == "prefixname") {
																	echo $v;
																}
																if ($k == "officername") {
																	echo $v . "&nbsp;&nbsp;";
																}
																if ($k == "officersurname") {
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
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">กรุณากรอกข้อมูลอีเมลอาจารย์ที่ปรึกษา (ระบบแจ้งเตือนผ่านอีเมล)</label>
												<div class="col-sm-10">
													<input type="email" class="form-control" id="email" name="email">

												</div>
											</div>
										</div>
										<div class="btn-list mt-4 text-left">
											<button type="submit" id="btnSaveSign" class="btn btn-primary btn-space">Save Data</button>
											<button type="reset" class="btn btn-secondary btn-space">Cancel</button>
										</div>
									</form>
									<div id="error"></div>
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
							dataLayer.push(arguments);
						}
						gtag('js', new Date());
						gtag('config', 'UA-125434499-1');
					</script>
				</div>
			</div>
		</footer>
	</div>
</body>

</html>

<!-- Jquery Core Js -->

<!-- Bootstrap Core Js -->
<!--<script src="digital-e-signature/js/bootstrap.min.js"></script>-->

<!-- Bootstrap Select Js -->
<!--<script src="digital-e-signature/js/bootstrap-select.js"></script>
-->
<?php
session_start();
$id = $_SESSION['SES_ID'];
require_once("inc/db_connect.php");
$mysqli = connect();
if ($id == "" || $_SESSION["SES_STDCODE"] == "") {
	// echo "<script>window.location.href = 'logout.php'</script>";

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

$sql = "SELECT OpenTime, CloseTime FROM request_doc_type WHERE doc_type_id = 31"; // แก้ไขตามโครงสร้างของฐานข้อมูลของคุณ
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
// ดึงข้อมูลนิสิต
if ($_SESSION['SES_STDCODE'] != "") {
	$sql_name = "SELECT * FROM request_student WHERE std_id_std=" . $_SESSION['SES_STDCODE'];
	$rs_name = $mysqli->query($sql_name);
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
	<script type="text/javascript">
		$(document).ready(function() {
			$("#academic, input[type=radio][name=semester]").change(function() {
				var semester = $("input[type=radio][name=semester]:checked").val();
				var academic = $("#academic").val();

				// แจ้งเมื่อเลือกภาคเรียน หรือ ปีการศึกษา
				//alert(academic);
				// if (semester == undefined) {
				// 	alert("กรุณาเลือกเทอม/ semester");
				// 	$("#semester").focus();
				// 	return false;
				// }
				// if (academic == 0) {
				// 	alert("กรุณาเลือกปีการศึกษา/ academic");
				// 	$("#academic").focus();
				// 	return false;
				// }

				if (semester != "" && academic != "") {
					$.post("JSCheck_rss.php", {
						semester: semester,
						academic: academic
					}, function(result) {
						$("#Showlist").html(result);
					});
				}
			});
			// ส่วนแสดงรหัสรายวิชา
			$("#subject_code").keyup(function() {
				var txt = $("#subject_code").val();
				var semester_cs = $("input[name='semester_cs']").val();
				var academic_cs = $("input[name='academic_cs']").val();

				// alert(academic);
				// if (semester == undefined) {
				// 	alert("กรุณาเลือกเทอม/ semester");
				// 	$("#semester").focus();
				// 	return false;
				// }
				// if (academic == 0) {
				// 	alert("กรุณาเลือกปีการศึกษา/ academic");
				// 	$("#academic").focus();
				// 	return false;
				// }
				//var number = $('#str').val().length
				/*     $("p").html(txt);
				       $("#show").html(number);*/

				if (txt != "" && semester_cs != "" && academic_cs != "") {
					$.post("JSCheckCourseClassid_form_retaining.php", {
						txt: txt,
						semester_cs: semester_cs,
						academic_cs: academic_cs
					}, function(result) {
						$("#group-s").html(result);
					});
				}
			});

			$("#advisor").customselect();
			//$("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
			$(document).ready(function() {
				$('#signArea').signaturePad({
					drawOnly: true,
					drawBezierCurves: true,
					lineTop: 90
				});
			});

			$("#btnSaveSign").click(function(e) {
				var semester = $("input[type=radio][name=semester]:checked").val();
				var academic = $("#academic").val();
				var advisor = $("#advisor").val();
				var because = $("#because").val();
				var pay_semester = $("#pay_semester").val();
				var email = $("#email").val();
				var std_email = $("#std_email").val();
				var sig_chk = $("#signArea").signaturePad().validateForm();

				//เทอมที่ต้องลาพัก 
				var tl_semester = $("input[name='tl_semester[]']").map(function() {
					return $(this).val();
				}).get();

				var tl_academic = $("input[name='tl_academic[]']").map(function() {
					return $(this).val();
				}).get();

				var tl_semester_str = tl_semester.join(',');
				var tl_academic_str = tl_academic.join(',');

				// ส่วนเลือกว่าจะลาพักหรือลงทะเบียนเรียน
				var doc_type_id = $("#doc_type_id").val();

				// ส่วนลงทะเบียน
				var type_thesis = $("input[type=radio][name=type_thesis]:checked").val();
				var subject_code = $("#subject_code").val();
				var credits = $("#credits").val();
				var group = $("#group-s :selected").text();
				var classid = $("#group-s").val();
				var semester_cs = $("input[name='semester_cs']").val();
				var academic_cs = $("input[name='academic_cs']").val();
				var because_thesis = $("#because_thesis").val();

				if (because == 0) {
					alert("กรุณากรอกข้อมูลเนื่องจาก/ because");
					$("#because").focus();
					return false;
				} else if (because == "ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต") {
					if (pay_semester == 0) {
						alert("กรุณเลือกภาคเรียน/semester");
						$("#pay_semester").focus();
						return false;
					}
				}
				if (semester === undefined) {
					alert("กรุณากรอกข้อมูลเทอม/semester");
					$("#semester").focus();
					return false;
				}
				if (academic == 0) {
					alert("กรุณาเลือกปีการศึกษา/ Academic Year");
					$("#academic").focus();
					return false;
				}
				// if (tl_semester == undefined) {
				// 	alert("กรุณาเลือก ภาคเรียน/semester ");
				// 	$("tl_semester[]").focus();
				// 	return false;
				// }

				// if (tl_academic == 0) {
				// 	alert("กรุณาเลือก ปีการศึกษา/Academic Year");
				// 	$("tl_academic[]").focus();
				// 	return false;
				// }

				if (doc_type_id == 0) {
					alert("กรุณาระบุว่าภาคเรียนปัจจุบันต้องการลาพักหรือลงทะเบียนเรียน/ Please indicate whether you want to take a leave of absence or register for classes in the current semester.");
					$("#doc_type_id").focus();
					return false;
				} else if (doc_type_id == "3") {
					if (type_thesis === undefined) {
						alert("กรุณากรอกข้อมูล มีความประสงค์ขอลงทะเบียน/ would like to register");
						$("#type_thesis").focus();
						return false;
					}
					if (subject_code === '') {
						alert("กรุณากรอกข้อมูลรหัสวิชา/ subject code");
						$("#subject_code").focus();
						return false;
					}
					//alert(group);

					// if (group == 0 || group == null) {
					// 	alert("กรุณากรอกกลุ่ม/ group code");
					// 	$("#group").focus();
					// 	return false;
					// }

					if (credits === '') {
						alert("กรุณากรอกข้อมูลหน่วยกิต (credits)");
						$("#credits").focus();
						return false;
					}
					if (because_thesis == 0) {
						alert("กรุณาระบุเหตุผลที่ต้องการลงทะเบียนเรียน/ Please specify the reason for wanting to register.");
						$("#because_thesis").focus();
						return false;
					}
				}
				if (advisor == 0) {
					alert("กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์");
					// alert(console.log(uniqueId));
					// alert(tl_academic);
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
				var std = document.getElementById('std_email').value;
				if (!(emailFilter.test(str))) {
					alert('กรุณากรอก email ให้ถูกต้อง');
					return false;
				}
				if (!(emailFilter.test(std))) {
					alert('กรุณากรอก email นิสิตให้ถูกต้อง');
					return false;
				}
				//alert(email);
				html2canvas([document.getElementById('sign-pad')], {
					onrendered: function(canvas) {
						var canvas_img_data = canvas.toDataURL('image/png');
						var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
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
						$("#show_loading").html("<img src='images/loading.gif' width='100' height='100'>");
						$("#btnSaveSign").attr('disabled', 'disabled');

						$.post("digital-e-signature/save_Retaining_Student_Status.php", {
							img_data: img_data,
							semester: semester,
							academic: academic,
							because: because,
							pay_semester: pay_semester,
							tl_semester: tl_semester,
							tl_academic: tl_academic,

							// เหตุผลว่าต้องการลาพักหรือลงทะเบียนเรียนในเทอมปัจจุบัน
							doc_type_id: doc_type_id,

							//ส่วนของลงทะเบียนเรียน 
							type_thesis: type_thesis,
							subject_code: subject_code,
							credits: credits,
							group: group,
							classid: classid,
							semester_cs: semester_cs,
							academic_cs: academic_cs,
							because_thesis: because_thesis,

							advisor: advisor,
							email: email,
							std_email: std_email
						}, function(data) {
							if (data == 1) {
								alert("Send Data Complete..");
								window.location.href = 'student.php';
							} else if (data == 2) {
								alert("Send Data Error..2");
							} else if (data == 3) {
								alert("Send Data Error..3");
							} else if (data == 4) {
								alert("ไม่สามารถส่งคำร้องซ้ำได้ เนื่องจากมีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา/ประธานหลักสูตร");
							} else {
								alert(console.log(data));
							}
							$("#show_loading").empty();
							$("#btnSaveSign").removeAttr('disabled');
							//$("#result").html(data);

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
									<h3 class="card-title"><U>Request Form Ratainting Student Status / คำร้องขอคืนสภาพการเป็นนิสิต</U></h3>
								</div>
								<div class="card-body">
									<div id="show_loading" align="center"></div>
									<form action="Javascript:void(0);" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">
										<div class="form-group col-sm-12">
											<div class="row align-items-center">
												<label>พ้นสภาพนิสิตเนื่องจาก/ because <span class="form-required">*</span></label>
												<div class="col-sm-4">
													<select class="form-control" id="because" name="because" onchange="toggleAdditionalOptions()">
														<option value="0">เนื่องจาก/ because</option>
														<option value="ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต">ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต </option>
														<option value="ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลามหาลัยกำหนด(ไม่ได้ชำระเงินภายในเวลาที่กำหนด)">ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลามหาลัยกำหนด (ไม่ได้ชำระเงินภายในเวลาที่กำหนด)
															<!-- did not completly enroll according to schedule (no payment within the due date.) -->
														</option>
													</select>
												</div>

												<div class="col-sm-4" id="additionalOptions" style="display: none;">
													<div class="row">
														<label>คือภาคเรียนที่ <span class="form-required">*</span></label>
														<div class="col-sm-6">
															<select class="form-control" id="pay_semester" name="pay_semester" placeholder="โปรดระบุเทอม" onchange="updateLastYear()">
																<option value="0">โปรดระบุเทอม/semester</option>
																<?php
																$sql_pay_semester = "SELECT * FROM request_rss	WHERE rss_id < (SELECT MAX(rss_id) FROM request_rss);
																";
																$result_pay_semester = $mysqli->query($sql_pay_semester);

																foreach ($result_pay_semester as $row_pay_semester) {
																?>
																	<option value="<?= $row_pay_semester["semester"] . "/" . $row_pay_semester["academic"]; ?>">
																		<?= $row_pay_semester["semester"] . "/"; ?>
																		<?= $row_pay_semester["academic"]; ?>
																	</option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- ส่วนที่จะแสดงเมื่อเลือก "ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต" -->
										<script>
											// เพิ่มฟังก์ชัน JavaScript เพื่อจัดการกับการแสดงผลของคำถามเพิ่มเติม
											function toggleAdditionalOptions() {
												// รับค่าที่เลือกจากเมนู dropdown
												var selectedValue = document.getElementById('because').value;
												var academicDropdown = document.getElementsByName("academic");
												var semesterRadioButtons = document.getElementsByName('semester');

												// ตรวจสอบว่าค่าที่เลือกเป็น "ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต" หรือไม่
												if (selectedValue === 'ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต') {
													// แสดงฟอร์มเพิ่มเติม
													document.getElementById('additionalOptions').style.display = 'block';
													// ปิดใช้งาน academic dropdown
													// for (var i = 0; i < academicDropdown.length; i++) {
													// 	academicDropdown[i].disabled = true;
													// }

													// // ปิดใช้งาน semester radio buttons
													// for (var j = 0; j < semesterRadioButtons.length; j++) {
													// 	semesterRadioButtons[j].disabled = true;
													// }
												} else {
													// ซ่อนฟอร์มเพิ่มเติม
													document.getElementById('additionalOptions').style.display = 'none';
													// เปิดใช้งาน academic dropdown
													// for (var k = 0; k < academicDropdown.length; k++) {
													// 	academicDropdown[k].disabled = false;
													// }

													// // เปิดใช้งาน semester radio buttons
													// for (var l = 0; l < semesterRadioButtons.length; l++) {
													// 	semesterRadioButtons[l].disabled = false;
													// }
												}

											}
										</script>
										<script>
											function updateLastYear() {
												// Get the selected value from the dropdown
												var selectedValue = document.getElementById("pay_semester").value;

												// Extract the year part from the selected value (assuming the format is "sem/year")
												var selectedSem = selectedValue.split("/")[0];
												var selectedYear = selectedValue.split("/")[1];

												// Update the value of lastYear
												lastYear = selectedYear;

												// Update the value in the academic dropdown
												// var academicDropdown = document.getElementsByName("academic");
												// for (var i = 0; i < academicDropdown.length; i++) {
												// 	academicDropdown[i].value = selectedYear;
												// }

												// // Update the value in the academic dropdown
												// var tlAcademicDropdown = document.getElementsByName("tl_academic[]");
												// for (var i = 0; i < tlAcademicDropdown.length; i++) {
												// 	tlAcademicDropdown[i].value = selectedYear;
												// }

												// var tlSemesterDropdown = document.getElementsByName("tl_semester[]");
												// for (var i = 0; i < tlSemesterDropdown.length; i++) {
												// 	tlSemesterDropdown[i].value = selectedSem;
												// }

												// var semesterRadioButtons = document.getElementsByName('semester');

												// for (var i = 0; i < semesterRadioButtons.length; i++) {
												// 	if (semesterRadioButtons[i].value === selectedSem) {
												// 		semesterRadioButtons[i].checked = true;
												// 	} else {
												// 		semesterRadioButtons[i].checked = false;
												// 	}
												// }
											}
										</script>
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-12">มีความประสงค์จะขอคืนสภาพการเป็นนิสิต/ Would like to retain student status from <span class="form-required">*</span> </label>
											</div>
										</div>

										<div class="form-group col-sm-9">
											<div class="custom-controls-stacked">
												<div class="row">
													<div class="col-md-6">
														<label class="form-label">ภาคการศึกษา/Semester</label>
														<div class="custom-controls-stacked">
															<label class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" name="semester" id="semester" value="1">
																<span class="custom-control-label">ภาคต้น/1<sup>st</sup> semester</span>
															</label>
															<label class="custom-control custom-radio custom-control-inline">
																<input type="radio" class="custom-control-input" name="semester" id="semester" value="2">
																<span class="custom-control-label">ภาคปลาย/2<sup>nd</sup> semester </span>
															</label>
														</div>
													</div>
													<?php
													// คำสั่ง SQL เลือก academic ที่มากที่สุดและน้อยที่สุด
													$sql_MM = "SELECT MAX(academic) AS max_academic, MIN(academic) AS min_academic FROM request_rss";
													$result_MM = $mysqli->query($sql_MM);

													// เช็คว่ามีข้อมูลหรือไม่
													if ($result_MM->num_rows > 0) {
														// อ่านข้อมูลจากแถวที่ได้
														$row_MM = $result_MM->fetch_assoc();
														$max_academic = $row_MM["max_academic"];
														$min_academic = $row_MM["min_academic"];
													} else {
														echo "0 results";
													}
													?>
													<div class="col-md-6">
														<label class="form-label">ปีการศึกษา/Academic year</label>														
														<select class="form-control" id="academic" name="academic">
															<option value="0">เลือก ปีการศึกษา/Academic year</option>
															<?php
															// สร้าง dropdown list โดยวนลูปตั้งแต่ academic ที่น้อยที่สุดไปจนถึง academic ที่มากที่สุด
															for ($i = $min_academic; $i <= $max_academic; $i++) {
																echo "<option value='$i'>$i</option>";
															}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row align-items-center">
											<label class="col-sm-12">และขอลาพักการเรียนที่พ้นสภาพจนถึง/ Would like to take a leave of absence in the <span class="form-required">*</span> </label>
										</div>

										<div class="form-group col-sm-12">
											<div class="custom-controls-stacked">
												<div class="row" id="Showlist">
													<!-- แสดงข้อมูลภาคเรียนและปีการศึกษาที่ต้องการจากลาพัก  -->
												</div>
											</div>
										</div>

										<!-- <script>
											function updateTLAcademic() {

												var selectedAcademicYear = document.getElementById('academic').value;

												// Update the value in the tl_academic dropdown
												var tlAcademicDropdown = document.getElementsByName("tl_academic[]");
												for (var i = 0; i < tlAcademicDropdown.length; i++) {
													tlAcademicDropdown[i].value = selectedAcademicYear;
												}
											}
										</script>
										<script>
											function updateTLSemester(selectedSemester) {
												var output = selectedSemester; // เก็บเฉพาะเลขภาคเรียนที่เลือก

												// อัปเดตค่าใน dropdown ของ tl_semester[]
												var tlSemesterDropdowns = document.getElementsByName('tl_semester[]');
												tlSemesterDropdowns[0].value = output;
											}
										</script> -->
										<div class="form-group col-sm-12">
											<div class="row align-items-center">
												<label>และในภาคเรียนปัจจุบัน/ and in the current semester <span class="form-required">*</span> </label>
												<div class="col-md-4">
													<select class="form-control" name="doc_type_id" id="doc_type_id" onchange="toggleCurrentSemester()">
														<option value="0">ระบุความประสงค์ภาคเรียนปัจจุบัน</option>
														<option value="1">มีความประสงค์ขอลาพักการเรียน/ Would like to take a leave </option>
														<option value="3">มีความประสงค์ขอลงทะเบียน/ would like to register
															<!-- did not completly enroll according to schedule (no payment within the due date.) -->
														</option>
													</select>
												</div>
											</div>
										</div>
										<!-- ดึงข้อมูลภาคการศึกษาและปีการศึกษาปัจบันมาแสดง -->
										<?php
										$sql_rss = "SELECT * FROM request_rss ORDER BY rss_id DESC LIMIT 1;";
										$result_rss = $mysqli->query($sql_rss);
										$row_rss = $result_rss->fetch_assoc();
										?>
										<!-- ส่วนเนื้อหาของลงทะเบียนเรียน -->
										<div class="form-group" id="thesis" style="display: none;">
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
											<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label class="form-label">ภาคเรียน/semester</label>
														<input class="form-control" type="text" name="semester_cs" readonly rows="7" value="<?php echo $row_rss['semester'] ?>">
													</div>
													<div class="col-md-4">
														<label class="form-label">ปีการศึกษา/Academic year</label>
														<input class="form-control" type="text" name="academic_cs" readonly rows="7" value="<?php echo $row_rss['academic'] ?>">
													</div>
												</div>
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
														<select id="group-s" name="group-s" class="form-control" required>
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
														<select class="form-control" id="because_thesis" name="because_thesis">
															<option value="0">เลือก เนื่องจาก/ because</option>
															<option value="สอบเค้าโครง">สอบเค้าโครง</option>
															<option value="รายงานความก้าวหน้า">รายงานความก้าวหน้า</option>
															<option value="สอบจบ">สอบจบ</option>
														</select>
													</div>
												</div>
											</div>
										</div>

										<!-- ส่วนแสดงข้อมูลลาพักเทอมปัจจุบัน -->
										<div id="TakeLeave" style="display: none;">
											<div class="form-group">
												<div class="row">
													<div class="col-md-4">
														<label class="form-label">ภาคเรียน/semester</label>
														<input class="form-control" type="text" name="semester_cs" readonly rows="7" value="<?php echo $row_rss['semester'] ?>">
													</div>
													<div class="col-md-4">
														<label class="form-label">ปีการศึกษา/Academic year</label>
														<input class="form-control" type="text" name="academic_cs" readonly rows="7" value="<?php echo $row_rss['academic'] ?>">
													</div>
												</div>
											</div>
										</div>


										<!-- ส่วนที่จะแสดงเมื่อเลือก "ขอลงทะเบียนเรียน" -->
										<script>
											// เพิ่มฟังก์ชัน JavaScript เพื่อจัดการกับการแสดงผลของคำถามเพิ่มเติม
											function toggleCurrentSemester() {
												// รับค่าที่เลือกจากเมนู dropdown
												var selectedValue = document.getElementById('doc_type_id').value;

												// ตรวจสอบว่าค่าที่เลือกเป็น "มีความประสงค์ขอลงทะเบียน" หรือไม่
												if (selectedValue === '3') {
													// แสดงฟอร์มเพิ่มเติม
													document.getElementById('thesis').style.display = 'block';
													document.getElementById('TakeLeave').style.display = 'none';

												} else {
													// ซ่อนฟอร์มเพิ่มเติม
													document.getElementById('thesis').style.display = 'none';
													document.getElementById('TakeLeave').style.display = 'block';

												}

											}
										</script>
										<!--  -->
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
															<canvas class="sign-pad" id="sign-pad" width="250" height="100">
															</canvas>

														</div>
													</div>
													<button id="btnClearSign2" class="btn btn-secondary btn-space">Clar Signature</button>
													<!--<button id="btnSaveSign">Save Signature</button>-->
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row align-items-center">
												<label class="col-sm-2">กรุณากรอกข้อมูลอีเมลอาจารย์ที่ปรึกษา (ระบบแจ้งเตือนผ่านอีเมล) <br>/ advisor's email address.</label>
												<div class="col-sm-10">
													<input type="email" class="form-control" id="email" name="email">

												</div>
											</div>
										</div>
										<?php
										while ($row_name = $rs_name->fetch_array()) {
											echo '<div class="form-group">
												<div class="row align-items-center">
													<label class="col-sm-2">กรุณากรอกข้อมูลอีเมลนิสิตที่ต้องการให้ส่ง email ไป (ระบบแจ้งเตือนผ่านอีเมล) <br> / student email address </label>
													<div class="col-sm-10">
														<input type="email" class="form-control" id="std_email" name="std_email" value="' . $row_name['std_id_std'] . '@msu.ac.th" >
													</div>
												</div>
											</div>';
										}
										?>

										<div class="btn-list mt-4 text-left">
											<button type="submit" id="btnSaveSign" name="submit" onClick="confirm_click_submit()" class="btn btn-primary btn-space">Save Data</button>
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
					<div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
						Copyright © 2018 บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม
					</div>
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
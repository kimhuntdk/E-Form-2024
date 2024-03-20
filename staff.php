<?php
session_start();
$SES_USER = $_SESSION["SES_USER"];
if ($_SESSION["SES_LEVEL"] != "staff_ses" || $SES_USER == "") {
	echo "<script>window.location.href = 'logout.php'</script>";
}

require_once("inc/db_connect.php");
$mysqli = connect();
$keyword = $_REQUEST['Keyword'];
$doc_status = $_REQUEST['doc_status'];
if ($_REQUEST['doc_status'] == 0) {
	$status_key = "(0)";
} else if ($_REQUEST['doc_status'] == 1) {
	$status_key = "(1)";
} else if ($_REQUEST['doc_status'] == 9) {
	$status_key = "(9)";
} else if ($_REQUEST['doc_status'] == 3) {
	$status_key = "(3)";
} else if ($_REQUEST['doc_status'] == 10) {
	$status_key = "(0,1,2,3,9)";
}
if ($_REQUEST['Keyword']) {

	$keyword_key = " AND request_doc.doc_std_id LIKE '$keyword'";
} else {
	$keyword = "";
}
$doc_type = $_REQUEST['doc_type'];
//== ลงทะเบียนเพิ่ม
if ($doc_type != "") {
	$keyword_doc_type = " AND request_doc.doc_type = '$doc_type'";
}
$sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.staff_grad_approve_disapprove!=2 AND request_registration_thesis_is.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY request_registration_thesis_is.advisor_chairman_status=1 DESC ,request_registration_thesis_is.staff_grad_approve_disapprove=0 DESC,request_doc.doc_date   DESC";
$result = $mysqli->query($sql);
//== ลาพักการเรียน
$sql_tl = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.staff_grad_approve_disapprove!=2 AND request_taking_leave.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY request_taking_leave.advisor_chairman_status=1 DESC ,request_taking_leave.staff_grad_approve_disapprove=0 DESC, request_doc.doc_date   DESC";
$result_tl = $mysqli->query($sql_tl);
//== คืนสภาพนิสิต
$sql_rs = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_retaining_student_status.staff_grad_approve_disapprove !=2 AND request_retaining_student_status.registration_division_status IN $status_key $keyword_key $keyword_doc_type  ORDER BY  request_retaining_student_status.advisor_chairman_status=1 DESC,request_retaining_student_status.staff_grad_approve_disapprove=0 DESC ,request_doc.doc_date DESC";
$result_rs = $mysqli->query($sql_rs);
//== ลงทะเบียนรักษาสภาพนิสิต 
$sql_sr = "SELECT * FROM request_doc LEFT JOIN request_student_status_retention ON request_doc.doc_id=request_student_status_retention.doc_id WHERE request_student_status_retention.staff_grad_approve_disapprove!=2 AND request_student_status_retention.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY  request_student_status_retention.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_sr = $mysqli->query($sql_sr);
//== ชำระค่าธรรมเนียมการศึกษา 
$sql_fp = "SELECT * FROM request_doc LEFT JOIN request_fee_payment ON request_doc.doc_id=request_fee_payment.doc_id WHERE request_fee_payment.staff_grad_approve_disapprove!=2 AND request_fee_payment.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY  request_fee_payment.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_fp = $mysqli->query($sql_fp);
//== ชำระค่าธรรมเนียมการศึกษา 
$sql_rw = "SELECT * FROM request_doc LEFT JOIN request_return_work ON request_doc.doc_id=request_return_work.doc_id WHERE request_return_work.staff_grad_approve_disapprove!=2 AND request_return_work.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY  request_return_work.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_rw = $mysqli->query($sql_rw);
//== ขอหนังสือรับรองการขยายเวลาศึกษาต่อ  
$sql_eps = "SELECT * FROM request_doc LEFT JOIN request_extension_period_study ON request_doc.doc_id=request_extension_period_study.doc_id WHERE request_extension_period_study.staff_grad_approve_disapprove!=2 AND request_extension_period_study.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY request_extension_period_study.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_eps = $mysqli->query($sql_eps);
//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน 
$sql_wrtl = "SELECT * FROM request_doc LEFT JOIN request_withdraw_registration_taking_leave ON request_doc.doc_id=request_withdraw_registration_taking_leave.doc_id WHERE request_withdraw_registration_taking_leave.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY request_withdraw_registration_taking_leave.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_wrtl = $mysqli->query($sql_wrtl);
//== ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration"
$sql_wtlr = "SELECT * FROM request_doc LEFT JOIN request_withdraw_taking_leave_registration ON request_doc.doc_id=request_withdraw_taking_leave_registration.doc_id WHERE request_withdraw_taking_leave_registration.registration_division_status IN $status_key $keyword_key $keyword_doc_type ORDER BY request_withdraw_taking_leave_registration.advisor_chairman_status=1 DESC ,request_doc.doc_date DESC";
$result_wtlr = $mysqli->query($sql_wtlr);
//== คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)
$sql_srfs = "SELECT * FROM request_doc LEFT JOIN request_status_retention ON request_doc.doc_id=request_status_retention.doc_id WHERE request_status_retention.staff_grad_approve_disapprove!=2 AND request_status_retention.registration_division_status=0 AND request_status_retention.staff_grad_approve_disapprove IN (0,1,2,3) $keyword_key $keyword_doc_type ";
$result_srfs = $mysqli->query($sql_srfs);
//== บันทึกขอรายงานตัวช้า
$sql_ms = "SELECT * FROM request_memorandum_student WHERE staff_grad_approve_disapprove IN (0,1,2,3)";
$result_ms = $mysqli->query($sql_ms);
//== บันทึกข้อความผ่านคณะ
$sql_ds = "SELECT * FROM request_doc LEFT JOIN request_document_student ON request_doc.doc_id=request_document_student.doc_id WHERE request_document_student.staff_grad_approve_disapprove IN (0,1,2,3) $keyword_key $keyword_doc_type";
$result_ds = $mysqli->query($sql_ds);
//== บันทึกข้อความไม่ต้องผ่านคณะ
$sql_dsg = "SELECT * FROM request_document_student_grad WHERE staff_grad_approve_disapprove IN (0,1,2,3)";
$result_dsg = $mysqli->query($sql_dsg);
//== ขอเปลี่ยนแผนการเรียน
$sql_csp = "SELECT * FROM request_doc LEFT JOIN request_change_study_program ON request_doc.doc_id=request_change_study_program.doc_id WHERE request_change_study_program.staff_grad_approve_disapprove IN (0,1,2,3)  $keyword_key $keyword_doc_type";
$result_csp = $mysqli->query($sql_csp);
//== ขอเปลี่ยนสาขาวิชา
$sql_cfs = "SELECT * FROM request_doc LEFT JOIN request_change_field_study ON request_doc.doc_id=request_change_field_study.doc_id WHERE request_change_field_study.staff_grad_approve_disapprove IN (0,1,2,3)  $keyword_key $keyword_doc_type";
$result_cfs = $mysqli->query($sql_cfs);
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
	<link href="./assets/css/dashboard.css?v999" rel="stylesheet" />
	<script src="./assets/js/dashboard.js"></script>
	<!-- c3.js Charts Plugin -->
	<link href="./assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
	<script src="./assets/plugins/charts-c3/plugin.js"></script>
	<!-- Google Maps Plugin -->
	<link href="./assets/plugins/maps-google/plugin.css" rel="stylesheet" />
	<script src="./assets/plugins/maps-google/plugin.js"></script>
	<!-- Input Mask Plugin -->
	<script src="./assets/plugins/input-mask/plugin.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<div class="page">
		<div class="page-main">
			<?php include("main_menu.php"); ?>
			<div class="my-3 my-md-5">
				<div class="container">
					<div class="page-header">
						<h1 class="page-title"> </h1>
					</div>

					<p><u>ตรวจสอบสถานะ REGISTRATION</u> </p>
					<form class="form-inline" action="#" method="post">
						<div class="form-group">
							<label class="sr-only">ค้นหา</label>
							<input type="text" class="form-control" id="inputPassword2" placeholder="รหัสประจำตัวนิสิต" name="Keyword">
							<select class="form-control" name="doc_type">
								<option value="0">เลือกคำร้อง</option>
								<option value="3">คำร้องลงทะเบียน Thesis/IS</option>
								<option value="1">คำร้องลาพักการเรียน</option>
								<option value="31">คำร้องขอคืนสภาพนิสิต</option>

							</select>
							<select class="form-control" name="doc_status">
								<option>Status</option>
								<option value="0">In Progress</option>
								<option value="1">Approved</option>
								<option value="9">Reject</option>
								<option value="10">All</option>

							</select>
						</div>
						<button type="submit" class="btn btn-default">Search</button>
					</form>

					<div class="row row-cards row-deck">
						<div class="col-12">
							<div class="card">
								<div class="table-responsive">
									<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i></th>
												<th>manage</th>
												<th>ADVISOR</th>
												<th>staff</th>
												<th>graduate</th>
												<th>Registration </th>
												<th>payment</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result as $row) {
											?>

												<tr>
													<td class="text-center">
														<?php
														$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
														$rs_name = $mysqli->query($sql_name);
														$row_name = $rs_name->fetch_array();
														?>

														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Registration_Thesis.php?doc_id=<?= base64_encode($row['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> <a href="#" data-id="<?= $row['doc_id']; ?>" data-typeid="3" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a> <a href="Staff_Del.php?id=<?= base64_encode($row['doc_id']); ?>&type_id=3" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a> </div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row['advisor_chairman_node'];
																																															} ?>"> Disapprove </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 2 && $advisor_chairman_status != 3) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['staff_grad_node'];
																																																} ?>"> Disapprove </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php
														$dean_admin_approve_disapprove = $row['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) {
														?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row['registration_division_node'];
																																																} ?>"> Rejected </button>

																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row['doc_id']; ?>" data-node="<?= $row['registration_division_node']; ?>" data-doctype="3"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> ยังไม่ชำระเงิน </button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name['std_fname_th']; ?>&nbsp;
															<?php echo $row_name['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type = $row['doc_type'];
														if ($doc_type == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											foreach ($result_tl as $row_tl) {
											?>
												<tr>
													<td class="text-center">
														<?php
														// echo $row_tl['doc_std_id'];
														$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
														//echo $row_tl['doc_std_id'];
														$rs_name1 = $mysqli->query($sql_name1);
														$row_name1 = $rs_name1->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Taking_Leave.php?doc_id=<?= base64_encode($row_tl['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_tl['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_tl['doc_id']); ?>&type_id=1" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_tl['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_tl['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_tl['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_tl['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_tl['doc_id']; ?>" data-node="<?= $row_tl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_tl['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name1['std_fname_th']; ?>&nbsp;
															<?php echo $row_name1['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name1['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_tl['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type1 = $row_tl['doc_type'];
														if ($doc_type1 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type1 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<!-- คำร้องขอคืนสภาพนิสิต -->
											<?php
											foreach ($result_rs as $row_rs) {
											?>
												<tr>
													<td class="text-center">
														<?php
														// echo $row_rs['doc_std_id'];
														$sql_name_rs = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rs[doc_std_id]' ";
														//echo $row_rs['doc_std_id'];
														$rs_name_rs = $mysqli->query($sql_name_rs);
														$row_name_rs = $rs_name_rs->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Retaining_Student_Status.php?doc_id=<?= base64_encode($row_rs['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview</a>
																<a href="#" data-id="<?= $row_rs['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="formPdf.php?doc_id=<?= base64_encode($row_rs['doc_id']); ?>" target="_blank" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> PDF</a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_rs['doc_id']); ?>&type_id=1" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_rs['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rs['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rs['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rs['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rs['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_rs['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status == 1) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_rs['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_rs['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rs['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_rs['doc_id']; ?>" data-node="<?= $row_rs['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_rs['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name_rs['std_fname_th']; ?>&nbsp;
															<?php echo $row_name_rs['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name_rs['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_rs['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type1 = $row_rs['doc_type'];
														if ($doc_type1 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type1 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type1 == 31) {
															echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Rataining Student Status";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<!-- คำร้องขอลงทะเบียนรักษาสภาพนิสิต -->
											<?php
											foreach ($result_sr as $row_sr) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name2 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
														$rs_name2 = $mysqli->query($sql_name2);
														$row_name2 = $rs_name2->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Student_Status_Retention.php?doc_id=<?= base64_encode($row_sr['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_sr['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_sr['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_sr['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_sr['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_sr['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_sr['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_sr['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_sr['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_sr['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_sr['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_sr['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_sr['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_tl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_tl['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_tl['doc_id']; ?>" data-node="<?= $row_tl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_sr['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name2['std_fname_th']; ?>&nbsp;
															<?php echo $row_name2['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name2['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_sr['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type2 = $row_sr['doc_type'];
														if ($doc_type2 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type2 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type1 == 31) {
															echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
														} else if ($doc_type2 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											foreach ($result_fp as $row_fp) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
														$rs_name3 = $mysqli->query($sql_name3);
														$row_name3 = $rs_name3->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Fee_Payment.php?doc_id=<?= base64_encode($row_fp['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_fp['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_fp['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_fp['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_fp['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_fp['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_fp['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_fp['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_fp['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_fp['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_fp['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_fp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_fp['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_fp['doc_id']; ?>" data-node="<?= $row_fp['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_fp['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name3['std_fname_th']; ?>&nbsp;
															<?php echo $row_name3['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name3['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_fp['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type3 = $row_fp['doc_type'];
														if ($doc_type3 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type3 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type1 == 31) {
															echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
														} else if ($doc_type3 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type3 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											foreach ($result_rw as $row_rw) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name4 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
														$rs_name4 = $mysqli->query($sql_name4);
														$row_name4 = $rs_name4->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Return_Work.php?doc_id=<?= base64_encode($row_rw['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_rw['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_rw['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_rw['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rw['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_rw['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_tl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_rw['staff_grad_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_rw['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_rw['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_rw['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_rw['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_rw['doc_id']; ?>" data-node="<?= $row_rw['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_rw['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name4['std_fname_th']; ?>&nbsp;
															<?php echo $row_name4['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name4['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_rw['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type4 = $row_rw['doc_type'];
														if ($doc_type4 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type4 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type4 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type4 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type4 == 12) {
															echo "คำร้องขอกลับเข้ารับราชการ  / Request Form for Return to Work ";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											foreach ($result_eps as $row_eps) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name5 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
														$rs_name5 = $mysqli->query($sql_name5);
														$row_name5 = $rs_name5->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Extension_Period_Study.php?doc_id=<?= base64_encode($row_eps['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_eps['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_eps['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_eps['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_eps['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_eps['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_eps['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_eps['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_eps['staff_grad_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_eps['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_eps['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_eps['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_eps['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_eps['doc_id']; ?>" data-node="<?= $row_eps['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_eps['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name5['std_fname_th']; ?>&nbsp;
															<?php echo $row_name5['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name5['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_eps['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type5 = $row_eps['doc_type'];
														if ($doc_type5 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type5 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type5 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type5 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type5 == 11) {

															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
														}
														?>
													</td>
												</tr>
											<?php
											}
											?>
											<?php
											foreach ($result_wrtl as $row_wrtl) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name6 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
														$rs_name6 = $mysqli->query($sql_name6);
														$row_name6 = $rs_name6->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Withdraw_Tegistration_Taking_Leave.php?doc_id=<?= base64_encode($row_wrtl['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_wrtl['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_wrtl['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_wrtl['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_wrtl['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_wrtl['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_wrtl['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_wrtl['doc_id']; ?>" data-node="<?= $row_wrtl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_wrtl['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name6['std_fname_th']; ?>&nbsp;
															<?php echo $row_name6['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name6['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_wrtl['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type6 = $row_wrtl['doc_type'];
														if ($doc_type6 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type6 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type6 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type6 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type6 == 11) {

															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
														} else if ($doc_type6 == 81) {

															echo "ขอถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน/Request Form for Leave  of Absence  to  Registratoin  ";
														}
														?></td>

													</td>
												</tr>
											<?php
											}
											?>

											<?php
											foreach ($result_wtlr as $row_wtlr) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name7 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
														$rs_name7 = $mysqli->query($sql_name7);
														$row_name7 = $rs_name7->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Withdraw_Taking_Leave_Registration.php?doc_id=<?= base64_encode($row_wtlr['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_wtlr['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_wtlr['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_wtlr['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_wrtl['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_wtlr['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_wtlr['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_wtlr['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_wrtl['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_wrtl['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_wrtl['doc_id']; ?>" data-node="<?= $row_wrtl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_wtlr['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name7['std_fname_th']; ?>&nbsp;
															<?php echo $row_name7['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name7['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_wtlr['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type7 = $row_wtlr['doc_type'];
														if ($doc_type7 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type7 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type7 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type7 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type7 == 11) {

															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
														} else if ($doc_type7 == 80) {

															echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														} else if ($doc_type7 == 81) {

															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}
														?>

													</td>

													</td>
												</tr>
											<?php
											}
											?>

										</tbody>

									</table>

									<!-- <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>STAFF</th>
												<th>Registration </th>
												<th>payment</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result_srfs as $row_srfs) {
											?>
												<tr>
													<td class="text-center">

														<?php

														$sql_name10 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_srfs[doc_std_id]' ";
														$rs_name10 = $mysqli->query($sql_name10);
														$row_name10 = $rs_name10->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Status_Retention_Special.php?doc_id=<?= base64_encode($row_srfs['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_srfs['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_srfs['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_srfs['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_srfs['registration_division_status'];
														if ($registration_division_status != 0) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_srfs['doc_id']; ?>" data-node="<?= $row_srfs['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_cfs['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name10['std_fname_th']; ?>&nbsp;
															<?php echo $row_name10['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name10['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_srfs['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type2 = $row_srfs['doc_type'];
														if ($doc_type2 == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type2 == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type2 == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type2 == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type2 == 11) {

															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
														} else if ($doc_type2 == 80) {

															echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														} else if ($doc_type2 == 81) {

															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														} else if ($doc_type2 == 9) {
															echo "คำร้องขอเปลี่ยนแผนการเรียน / Request Form to Change Study Program  ";
														} else if ($doc_type2 == 2) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) / Student Status Retention Form (Special case) ";
														}
														?>

													</td>

													</td>
												</tr>
											<?php
											}

											?>

											</tr>
										</tbody>
									</table> -->

									<!-- <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>STAFF</th>
												<th>graduate</th>
												<th>payment</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result_ms as $row_ms) {
											?>
												<tr>
													<td class="text-center">

														<?php

														/*	$sql_name10 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_srfs[doc_std_id]' ";
													$rs_name10 = $mysqli->query( $sql_name10 );
													$row_name10 = $rs_name10->fetch_array();*/
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Memorandum_Student.php?doc_id=<?= base64_encode($row_ms[memorandum_id]); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_ms[memorandum_id]; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_srfs['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_ms['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_ms['dean_admin_approve_disapprove'];
														if ($registration_division_status != 0) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_srfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_srfs['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_srfs['doc_id']; ?>" data-node="<?= $row_srfs['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $payment = $row_cfs['payment'];
														if ($payment != 0) {

															if ($payment == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
															<?php	} else if ($payment == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
															<?php	} else if ($payment == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
															<?php	} else if ($payment == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_ms['titlename']; ?>&nbsp;
															<?php echo $row_ms['name_surname']; ?>
														</div>
														<?php /*?><div class="small text-muted"> Send:
													<?php echo $row_srfs['doc_date'];?> </div><?php */ ?>
													</td>
													<td>
														<?php


														echo "บันทึกข้อความ (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ";

														?>

													</td>

													</td>
												</tr>
											<?php
											}

											?>
											</tr>
										</tbody>
									</table> -->
									<!--บันทึกข้อความ ที่ผ่านอาจารย์ที่ปรึกษา-->
									<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>ADVISOR</th>
												<th>STAFF</th>
												<th>graduate</th>
												<th>payment</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result_ds as $row_ds) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_nameds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
														$rs_nameds = $mysqli->query($sql_nameds);
														$row_nameds = $rs_nameds->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Document_Student.php?doc_id=<?= base64_encode($row_ds['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_ds['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_ds['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $advisor_chairman_status = $row_ds['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_ds['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_ds['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_ds['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_ds['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_ds['staff_grad_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_ds['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_ds['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_wrtl['doc_id']; ?>" data-node="<?= $row_wrtl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_nameds['std_fname_th']; ?>&nbsp;
															<?php echo $row_nameds['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_nameds['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_ds['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														$doc_type7ds = $row_ds['doc_type'];
														if ($doc_type7ds == 3) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ($doc_type7ds == 1) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ($doc_type7ds == 4) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ($doc_type7ds == 15) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
														} else if ($doc_type7ds == 11) {

															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
														} else if ($doc_type7ds == 80) {

															echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														} else if ($doc_type7ds == 70) {

															echo "บันทึกข้อความ";
														}
														?>

													</td>

													</td>
												</tr>
											<?php
											}
											?>
											</tr>
										</tbody>
									</table>
									<!--บันทึกข้อความไม่ต้องผ่านคณะ-->
									<!--บันทึกข้อความ ที่ผ่านอาจารย์ที่ปรึกษา-->
									<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>STAFF</th>
												<th>graduate</th>
												<th>payment</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result_dsg as $row_dsg) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_nameds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
														$rs_nameds = $mysqli->query($sql_nameds);
														$row_nameds = $rs_nameds->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Document_Student_Grad.php?doc_id=<?= base64_encode($row_dsg['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_dsg['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_dsg['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_dsg['staff_grad_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_dsg['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_dsg['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_ds['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_ds['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_dsg['doc_id']; ?>" data-node="<?= $row_dsg['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>

														<div class="small text-muted"> Send:
															<?php echo $row_dsg['doc_date']; ?> </div>
													</td>
													<td>
														<?php


														echo "บันทึกข้อความ";

														?>

													</td>

													</td>
												</tr>
											<?php
											}
											?>
											</tr>
										</tbody>
									</table>
									<!--เปลี่ยนแผนการเรียน-->
									<!-- <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>ADVISOR</th>
												<th>CHAIRMAN</th>
												<th>STAFF</th>
												<th>graduate</th>
												<th>payment</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($result_csp as $row_csp) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp[doc_std_id]' ";
														$rs_name_csp = $mysqli->query($sql_name_csp);
														$row_name_csp = $rs_name_csp->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Change_Study_Program.php?doc_id=<?= base64_encode($row_csp['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_csp['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_csp['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php echo   $advisor_chairman_status = $row_csp['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php echo      $chairman_board_status = $row_csp['chairman_board_status'];


														if ($chairman_board_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['chairman_board_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($chairman_board_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['chairman_board_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($chairman_board_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['chairman_board_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($chairman_board_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_csp['chairman_board_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_csp['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_csp['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_csp['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_csp['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_csp['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_wrtl['doc_id']; ?>" data-node="<?= $row_wrtl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name_csp['std_fname_th']; ?>&nbsp;
															<?php echo $row_name_csp['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name_csp['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_csp['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														echo "คำร้องเปลี่ยนแผนการเรียน";
														?>

													</td>

													</td>
												</tr>
											<?php
											}

											foreach ($result_cfs as $row_cfs) {
											?>
												<tr>
													<td class="text-center">
														<?php
														$sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs[doc_std_id]' ";
														$rs_name_csp = $mysqli->query($sql_name_csp);
														$row_name_csp = $rs_name_csp->fetch_array();
														?>
														<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
													</td>
													<td class="text-center">
														<div class="item-action dropdown">
															<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
															<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Form_Change_Field_Study.php?doc_id=<?= base64_encode($row_cfs['doc_id']); ?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview
																</a><a href="#" data-id="<?= $row_cfs['doc_id']; ?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a>
																<a href="Staff_Del.php?id=<?= base64_encode($row_cfs['doc_id']); ?>&type_id=4" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a>
															</div>
													</td>
													<td>
														<?php echo   $advisor_chairman_status = $row_cfs['advisor_chairman_status'];


														if ($advisor_chairman_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['advisor_chairman_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($advisor_chairman_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['advisor_chairman_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($advisor_chairman_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($advisor_chairman_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['advisor_chairman_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['advisor_chairman_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php echo      $chairman_board_status = $row_cfs['chairman_board_status'];


														if ($chairman_board_status == 0) { ?>
															<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['chairman_board_node'];
																																															} ?>"> In Progress </button>
														<?php	} else if ($chairman_board_status == 1) { ?>
															<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['chairman_board_node'];
																																															} ?>"> Approved </button>
														<?php	} else if ($chairman_board_status == 2) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['chairman_board_node'];
																																															} ?>"> Rejected </button>
														<?php	} else if ($chairman_board_status == 3) { ?>
															<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['chairman_board_node'] == " ") {
																																																echo "- ";
																																															} else {
																																																echo $row_cfs['chairman_board_node'];
																																															} ?>"> Rejected </button>
														<?php
														}

														?>
													</td>
													<td>
														<?php $staff_grad_approve_disapprove = $row_cfs['staff_grad_approve_disapprove'];
														if ($advisor_chairman_status != 0 && $advisor_chairman_status != 3 && $advisor_chairman_status != 2) {

															if ($staff_grad_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['staff_grad_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($staff_grad_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['staff_grad_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($staff_grad_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php	} else if ($staff_grad_approve_disapprove == 3) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['staff_grad_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['staff_grad_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $dean_admin_approve_disapprove = $row_cfs['dean_admin_approve_disapprove'];
														if ($staff_grad_approve_disapprove == 1) {

															if ($dean_admin_approve_disapprove == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['dean_admin_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($dean_admin_approve_disapprove == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['dean_admin_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($dean_admin_approve_disapprove == 2) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['dean_admin_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['dean_admin_node'];
																																																} ?>"> Rejected </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<?php $registration_division_status = $row_cfs['registration_division_status'];
														if ($dean_admin_approve_disapprove == 1) {

															if ($registration_division_status == 0) { ?>
																<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['registration_division_node'];
																																																} ?>"> In Progress </button>
															<?php	} else if ($registration_division_status == 1) { ?>
																<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['registration_division_node'];
																																																} ?>"> Approved </button>
															<?php	} else if ($registration_division_status == 9) { ?>
																<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if ($row_cfs['registration_division_node'] == " ") {
																																																	echo "- ";
																																																} else {
																																																	echo $row_cfs['registration_division_node'];
																																																} ?>"> Rejected </button>
																<button type="button" class="btn btn-primary on_submit" data-id="<?= $row_wrtl['doc_id']; ?>" data-node="<?= $row_wrtl['registration_division_node']; ?>" data-doctype="1"> Re-Send </button>
															<?php
															}
														} else {
															?>
															<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
														<?php
														}
														?>
													</td>
													<td>
														<div>
															<?php echo $row_name_csp['std_fname_th']; ?>&nbsp;
															<?php echo $row_name_csp['std_lname_th']; ?>
														</div>
														<div class="small text-muted"> ID:
															<?php echo $row_name_csp['std_id_std']; ?> </div>
														<div class="small text-muted"> Send:
															<?php echo $row_cfs['doc_date']; ?> </div>
													</td>
													<td>
														<?php
														echo "คำร้องเปลี่ยนสาขาวิชา";
														?>

													</td>

													</td>
												</tr>
											<?php
											}
											?>
											</tr>
										</tbody>
									</table> -->
									<!--สิ้นสุดการเปลี่ยนแผนการเรียน-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Modal Payment-->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">จัดการการจัดเงิน</h4>
					</div>
					<div class="modal-body">
					</div>
					<form class="frm_payment" action="update_pay.php" method="post" id="frm_payment" name="frm_payment">
						<div class="card-body p-6">

							<div class="form-group">
								<label class="form-label">Payment Status</label>
								<select id="status" name="status" class="custom-select">
									<option value="0">เลือกสถานะ</option>
									<option value="1">ชำระเงินเรียบร้อย</option>
									<option value="2">ยังไม่ชำระเงิน</option>
									<option value="3">พ้นสภาพ</option>
									</option>
								</select>
								<div id="show_data"></div>
							</div>
							<div class="form-footer">

								<button type="submit" class="btn btn-primary" id="hash-it">Submit</button>
								<input type="reset" name="reset" value="Reset" class="btn btn-primary">
							</div>
							<!--<div><h3>ระบบปิดปรับปรุง ต้องอภัยในความไม่สะดวก</h3></div>-->
						</div>
					</form>
				</div>
				<!--  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>-->
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
	<!--</div>-->
</body>

</html>
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	$(".docID").click(function() {
		var doc_id = $(this).attr("data-id");
		var typeid = $(this).attr("data-typeid");
		$("#show_data").html("<input type='hidden' name='doc_id' value='" + doc_id + "'><input type='hidden' name='type_id' value='" + typeid + "'> ");
	});
	$(".on_submit").click(function() {
		var doc_id = $(this).attr("data-id");
		var doc_node = $(this).attr("data-node");
		var doc_type = $(this).attr("data-doctype");

		$.post("digital-e-signature/staff_resend.php", {
			doc_id: doc_id,
			doc_node: doc_node,
			doc_type: doc_type

		}, function(data) {
			if (data == 1) {
				alert("Send Data Complete..");
				window.location.href = 'staff.php';
			} else if (data == 2) {
				alert("Send Data Error..2");
			}

			//$("#result").html(data);

		});
	});
</script>
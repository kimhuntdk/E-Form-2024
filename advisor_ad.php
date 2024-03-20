<?php
session_start();
$SES_USER = "13064";

require_once( "inc/db_connect.php" );
$mysqli = connect();
//== ลงทะเบียนเพิ่ม
$sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.advisor_chairman=" . $SES_USER;
$result = $mysqli->query( $sql );
//== ลาพักการเรียน
 $sql_tl = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.advisor_chairman=" . $SES_USER;
$result_tl = $mysqli->query( $sql_tl );
//== ลงทะเบียนรักษาสภาพ
$sql_sr = "SELECT * FROM request_doc LEFT JOIN request_student_status_retention ON request_doc.doc_id=request_student_status_retention.doc_id WHERE request_student_status_retention.advisor_chairman=" . $SES_USER;
$result_sr = $mysqli->query( $sql_sr );
//== ชำระค่าธรรมเนียมการศึกษา 
$sql_fp = "SELECT * FROM request_doc LEFT JOIN request_fee_payment ON request_doc.doc_id=request_fee_payment.doc_id WHERE request_fee_payment.advisor_chairman=" . $SES_USER;
$result_fp = $mysqli->query( $sql_fp );
//== คำร้องขอกลับเข้ารับราชการ 
$sql_rw = "SELECT * FROM request_doc LEFT JOIN request_return_work ON request_doc.doc_id=request_return_work.doc_id WHERE request_return_work.advisor_chairman=" . $SES_USER;
$result_rw = $mysqli->query( $sql_rw );
//== ขอหนังสือรับรองการขยายเวลาศึกษาต่อ 
$sql_eps = "SELECT * FROM request_doc LEFT JOIN request_extension_period_study ON request_doc.doc_id=request_extension_period_study.doc_id WHERE request_extension_period_study.advisor_chairman=" . $SES_USER;
$result_eps = $mysqli->query( $sql_eps );
//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน 
$sql_wrtl = "SELECT * FROM request_doc LEFT JOIN request_withdraw_registration_taking_leave ON request_doc.doc_id=request_withdraw_registration_taking_leave.doc_id WHERE request_withdraw_registration_taking_leave.advisor_chairman=" . $SES_USER;
$result_wrtl = $mysqli->query( $sql_wrtl );
//== ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน
$sql_wtlr = "SELECT * FROM request_doc LEFT JOIN request_withdraw_taking_leave_registration ON request_doc.doc_id=request_withdraw_taking_leave_registration.doc_id WHERE request_withdraw_taking_leave_registration.advisor_chairman=" . $SES_USER;
$result_wtlr = $mysqli->query( $sql_wtlr );
//== ขอบันทึกข้อความ
 $sql_ds = "SELECT * FROM request_document_student LEFT JOIN request_doc ON request_document_student.doc_id=request_doc.doc_id WHERE request_document_student.advisor_chairman=" . $SES_USER;
$result_ds = $mysqli->query( $sql_ds );
//== ขอหนังสือเปลี่ยนแปลงแผนการเรียน อาจารย์ที่ปรึกษา
$sql_csp = "SELECT * FROM request_doc LEFT JOIN request_change_study_program ON request_doc.doc_id=request_change_study_program.doc_id WHERE request_change_study_program.advisor_chairman=" . $SES_USER;
$result_csp = $mysqli->query( $sql_csp );
//== ขอหนังสือเปลี่ยนแปลงแผนการเรียน อาจารย์ประธานหลักสูตร
 $sql_csp_ch = "SELECT * FROM request_doc LEFT JOIN request_change_study_program ON request_doc.doc_id=request_change_study_program.doc_id WHERE request_change_study_program.advisor_chairman_status=1 AND request_change_study_program.chairman_board=" . $SES_USER;
$result_csp_ch = $mysqli->query( $sql_csp_ch );
//== ขอหนังสือเปลี่ยนสาขา อาจารย์ที่ปรึกษา
$sql_cfs = "SELECT * FROM request_doc LEFT JOIN request_change_field_study ON request_doc.doc_id=request_change_field_study.doc_id WHERE request_change_field_study.advisor_chairman=" . $SES_USER;
$result_cfs = $mysqli->query( $sql_cfs );
//== ขอหนังสือเปลี่ยนสาขา อาจารย์ประธานหลักสูตร
 $sql_cfs_ch = "SELECT * FROM request_doc LEFT JOIN request_change_field_study ON request_doc.doc_id=request_change_field_study.doc_id WHERE request_change_field_study.advisor_chairman_status=1 AND request_change_field_study.chairman_board=" . $SES_USER;
$result_cfs_ch = $mysqli->query( $sql_cfs_ch );
//== ขอหนังสือแต่งตั้งชื่อเรื่อง
 $sql_aa = "SELECT * FROM request_doc LEFT JOIN request_appointment_advisor ON request_doc.doc_id=request_appointment_advisor.doc_id WHERE request_appointment_advisor.advisor_code=" . $SES_USER;
$result_aa = $mysqli->query( $sql_aa );
//== ขอหนังสือแต่งตั้งคณะกรรมการสอบโครงร่าง
 $sql_pe = "SELECT * FROM request_doc LEFT JOIN request_proposal_examination ON request_doc.doc_id=request_proposal_examination.doc_id WHERE request_proposal_examination.advisor_code=" . $SES_USER;
$result_pe = $mysqli->query( $sql_pe );
//== ขอหนังสือแต่งตั้งคณะกรรมการสอบวิทยานิพนธ์
 $sql_te = "SELECT * FROM request_doc LEFT JOIN request_thesis_examination ON request_doc.doc_id=request_thesis_examination.doc_id WHERE request_thesis_examination.advisor_code=" . $SES_USER;
$result_te = $mysqli->query( $sql_te );

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

</head>

<body>
	<div class="page">
		<div class="page-main">
			<?php include("main_menu.php");?>
			<div class="my-3 my-md-5">
				<div class="container">
					<div class="page-header">
						<h1 class="page-title">
						</h1>
					</div>
					<div class="row row-cards row-deck">
						<div class="col-12">
							<div class="card">
								<div class="table-responsive">
                       
									<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>Status</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ( $result as $row ) {
												    $date = $row["std_date_signature"];//วันที่ส่ง
													$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
													$date_curent = date("Y-m-d");
													$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
													
													if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
													<tr>
												<td class="text-center">
													<?php
													$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
													$rs_name = $mysqli->query( $sql_name );
													$row_name = $rs_name->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Registration_Thesis.php?doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!--<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> -->
														</div>
												</td>
												<td>
													<?php
													$registration_thesis_status = $row[ 'advisor_chairman_status' ];
													if ( $registration_thesis_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $registration_thesis_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $registration_thesis_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name['std_fname_th'];?>&nbsp;
														<?php echo $row_name['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type = $row[ 'doc_type' ];
													if ( $doc_type == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													}
													?>
												</td>
											</tr>
												<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
													<tr>
												<td class="text-center">
													<?php
													$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
													$rs_name = $mysqli->query( $sql_name );
													$row_name = $rs_name->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Registration_Thesis.php?doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!--<a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> -->
														</div>
												</td>
												<td>
													<?php
													$registration_thesis_status = $row[ 'advisor_chairman_status' ];
													if ( $registration_thesis_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $registration_thesis_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $registration_thesis_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name['std_fname_th'];?>&nbsp;
														<?php echo $row_name['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type = $row[ 'doc_type' ];
													if ( $doc_type == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													}
													?>
												</td>
											</tr>
												<?php	}
												?>
											
											<?php
											}
											?>
											<?php
											foreach ( $result_tl as $row_tl ) {
											$date = $row_tl["std_date_signature"];//วันที่ส่ง
											$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
											$date_curent = date("Y-m-d");
											$stats_tl = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
											
											if($date_curent <= $date_  and $stats_tl==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Taking_Leave.php?doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_tl[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name1['std_fname_th'];?>&nbsp;
														<?php echo $row_name1['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_tl['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type1 = $row_tl[ 'doc_type' ];
													if ( $doc_type1 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type1 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													}
													?>
												</td>
											</tr>
										<?php	} else if($stats_tl==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Taking_Leave.php?doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_tl[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name1['std_fname_th'];?>&nbsp;
														<?php echo $row_name1['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_tl['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type1 = $row_tl[ 'doc_type' ];
													if ( $doc_type1 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type1 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													}
													?>
												</td>
											</tr>
										<?php	} 		
											?>
											
											<?php
											}
											?>
                                           <?php
											foreach ( $result_sr as $row_sr ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name2 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
													$rs_name2 = $mysqli->query( $sql_name2 );
													$row_name2 = $rs_name2->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Student_Status_Retention.php?doc_id=<?=base64_encode($row_sr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_sr[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name2['std_fname_th'];?>&nbsp;
														<?php echo $row_name2['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_sr['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type2 = $row_sr[ 'doc_type' ];
													if ( $doc_type2 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type2 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type2 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง  ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name2 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
													$rs_name2 = $mysqli->query( $sql_name2 );
													$row_name2 = $rs_name2->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Student_Status_Retention.php?doc_id=<?=base64_encode($row_sr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_sr[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name2['std_fname_th'];?>&nbsp;
														<?php echo $row_name2['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_sr['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type2 = $row_sr[ 'doc_type' ];
													if ( $doc_type2 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type2 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type2 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											}
											?>
                                            <?php
											foreach ( $result_fp as $row_fp ) {
											$date = $row["std_date_signature"];//วันที่ส่ง
											$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
											$date_curent = date("Y-m-d");
											$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
											
											if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Fee_Payment.php?doc_id=<?=base64_encode($row_fp[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_fp[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_fp['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type3 = $row_fp[ 'doc_type' ];
													if ( $doc_type3 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type3 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type3 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type3 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}
													?>
												</td>
											</tr>
										<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง  ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Fee_Payment.php?doc_id=<?=base64_encode($row_fp[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_fp[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_fp['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type3 = $row_fp[ 'doc_type' ];
													if ( $doc_type3 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type3 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type3 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type3 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}
													?>
												</td>
											</tr>
										<?php	}
											?>
											<?php
											}
											?>
											<?php
											foreach ( $result_rw as $row_rw ) {
												
											$date = $row["std_date_signature"];//วันที่ส่ง
											$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
											$date_curent = date("Y-m-d");
											$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
											
											if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Return_Work.php?doc_id=<?=base64_encode($row_rw[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_rw[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_rw['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type3 = $row_rw[ 'doc_type' ];
													if ( $doc_type3 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type3 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type3 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type3 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type3 == 12 ) {
														echo "คำร้องขอกลับเข้ารับราชการ  / Request Form for Return to Work ";
													}
													?>
												</td>
											</tr>
										<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง  ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Return_Work.php?doc_id=<?=base64_encode($row_rw[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_rw[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_rw['doc_date'];?> </div>
												</td>
												<td>
													<?php
													$doc_type3 = $row_rw[ 'doc_type' ];
													if ( $doc_type3 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type3 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type3 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type3 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type3 == 12 ) {
														echo "คำร้องขอกลับเข้ารับราชการ  / Request Form for Return to Work ";
													}
													?>
												</td>
											</tr>
										<?php	}
											?>
											
											<?php
											}
											?>
											<?php
											foreach ( $result_eps as $row_eps ) {
											$date = $row["std_date_signature"];//วันที่ส่ง
											$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
											$date_curent = date("Y-m-d");
											$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์											
											if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Extension_Period_Study.php?doc_id=<?=base64_encode($row_eps[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_eps[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_eps['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_eps[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													}
													?>
												</td>
											</tr>
										<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
											<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Extension_Period_Study.php?doc_id=<?=base64_encode($row_eps[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_eps[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_eps['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_eps[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													}
													?>
												</td>
											</tr>
										<?php	}
											?>
											
											<?php
											}
											?>
										  <?php
											foreach ( $result_wrtl as $row_wrtl ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์ ?>
												
											<?php	if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Withdraw_Registration_Taking_Leave.php?doc_id=<?=base64_encode($row_wrtl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_wrtl[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_wrtl['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_wrtl[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type5 == 81 ) {
														echo "ขออนุมัติถอนการลงทะเบียนเพื่อลาพักการเรียน  / Request Form for Withdrawal of Registration to Leave of Abesnce ";
													}
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Withdraw_Registration_Taking_Leave.php?doc_id=<?=base64_encode($row_wrtl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_wrtl[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_wrtl['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_wrtl[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type5 == 81 ) {
														echo "ขออนุมัติถอนการลงทะเบียนเพื่อลาพักการเรียน  / Request Form for Withdrawal of Registration to Leave of Abesnce ";
													}
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											}
											?>
                                              <?php
											foreach ( $result_wtlr as $row_wtlr ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง  ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Withdraw_Taking_Leave_Registration.php?doc_id=<?=base64_encode($row_wtlr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_wtlr[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_wtlr['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_wtlr[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type5 == 81 ) {
														echo "ขออนุมัติถอนการลงทะเบียนเพื่อลาพักการเรียน  / Request Form for Withdrawal of Registration to Leave of Abesnce ";
													}  else if ( $doc_type5 == 80 ) {
														echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration";
													}
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง  ?>
												<tr>
												<td class="text-center">
													<?php
													$sql_name3 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
													$rs_name3 = $mysqli->query( $sql_name3 );
													$row_name3 = $rs_name3->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Withdraw_Taking_Leave_Registration.php?doc_id=<?=base64_encode($row_wtlr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
												</td>
												<td>
													<?php
													$advisor_chairman_status = $row_wtlr[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name3['std_fname_th'];?>&nbsp;
														<?php echo $row_name3['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_wtlr['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_type5 = $row_wtlr[ 'doc_type' ];
													if ( $doc_type5 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type5 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type5 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_type5 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_type5 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type5 == 81 ) {
														echo "ขออนุมัติถอนการลงทะเบียนเพื่อลาพักการเรียน  / Request Form for Withdrawal of Registration to Leave of Abesnce ";
													}  else if ( $doc_type5 == 80 ) {
														echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration";
													}
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											}
											?>
                                            <?php
											 
											foreach ( $result_ds as $row_ds ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_namds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
													$rs_nameds = $mysqli->query($sql_namds);
													$row_nameds = $rs_nameds->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Form_Document_Student.php?doc_id=<?=base64_encode($row_ds[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_chairman_status = $row_ds[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_nameds['std_fname_th'];?>&nbsp;
														<?php echo $row_nameds['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_ds['doc_date'];?> </div>
												</td>
												<td>
													<?php
													 $doc_typeds = $row_ds[ 'doc_type' ];
													if ( $doc_typeds == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_typeds == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_typeds == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													}else if ( $doc_typeds == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment ";
													}else if ( $doc_typeds == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_typeds == 81 ) {
														echo "ขออนุมัติถอนการลงทะเบียนเพื่อลาพักการเรียน  / Request Form for Withdrawal of Registration to Leave of Abesnce ";
													}  else if ( $doc_typeds == 80 ) {
														echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration";
													}  else if ( $doc_typeds == 70 ) {
														echo "บันทึกข้อความ";
													}
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
                                             <?php
											 
											foreach ( $result_ds as $row_ds ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_namds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
													$rs_nameds = $mysqli->query($sql_namds);
													$row_nameds = $rs_nameds->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Form_Document_Student.php?doc_id=<?=base64_encode($row_ds[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_chairman_status = $row_ds[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_nameds['std_fname_th'];?>&nbsp;
														<?php echo $row_nameds['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_ds['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "บันทึกข้อความ";
													
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
                                              <?php
											 
											foreach ( $result_csp as $row_csp ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp[doc_std_id]' ";
													$rs_name_csp = $mysqli->query($sql_name_csp);
													$row_name_csp = $rs_name_csp->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Change_Study_Program.php?doc_id=<?=base64_encode($row_csp[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_chairman_status = $row_csp[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_csp['std_fname_th'];?>&nbsp;
														<?php echo $row_name_csp['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_csp['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนแผนการเรียน (อาจารย์ที่ปรึกษา)";
													
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
                                               <?php
											 
											foreach ( $result_cfs as $row_cfs ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_cfs = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs[doc_std_id]' ";
													$rs_name_cfs = $mysqli->query($sql_name_cfs);
													$row_name_cfs = $rs_name_cfs->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Form_Change_Field_Study.php?doc_id=<?=base64_encode($row_cfs[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_chairman_status = $row_cfs[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_cfs['std_fname_th'];?>&nbsp;
														<?php echo $row_name_cfs['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_cfs['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนสาขาวิชา (อาจารย์ที่ปรึกษา)";
													
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_cfs = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs[doc_std_id]' ";
													$rs_name_cfs = $mysqli->query($sql_name_cfs);
													$row_name_cfs = $rs_name_cfs->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Form_Change_Field_Study.php?doc_id=<?=base64_encode($row_cfs[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_chairman_status = $row_cfs[ 'advisor_chairman_status' ];
													if ( $advisor_chairman_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_chairman_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_chairman_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_cfs['std_fname_th'];?>&nbsp;
														<?php echo $row_name_cfs['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_cfs['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนสาขาวิชา (อาจารย์ที่ปรึกษา)";
													
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											
											}
											?>
                                             <?php
											 
											foreach ( $result_csp_ch as $row_csp_ch ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_csp_ch = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp_ch[doc_std_id]' ";
													$rs_name_csp_ch = $mysqli->query($sql_name_csp_ch);
													$row_name_csp_ch = $rs_name_csp_ch->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Chairman_Change_Study_Program.php?doc_id=<?=base64_encode($row_csp_ch[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $chairman_board_status = $row_csp_ch[ 'chairman_board_status' ];
													if ( $chairman_board_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $chairman_board_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $chairman_board_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_csp_ch['std_fname_th'];?>&nbsp;
														<?php echo $row_name_csp_ch['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_csp_ch['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนแผนการเรียน (ประธานหลักสูตร)";
													
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_csp_ch = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp_ch[doc_std_id]' ";
													$rs_name_csp_ch = $mysqli->query($sql_name_csp_ch);
													$row_name_csp_ch = $rs_name_csp_ch->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Chairman_Change_Study_Program.php?doc_id=<?=base64_encode($row_csp_ch[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $chairman_board_status = $row_csp_ch[ 'chairman_board_status' ];
													if ( $chairman_board_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $chairman_board_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $chairman_board_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_csp_ch['std_fname_th'];?>&nbsp;
														<?php echo $row_name_csp_ch['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_csp_ch['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนแผนการเรียน (ประธานหลักสูตร)";
													
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											
											}
											?>
                                                  <?php
											 
											foreach ( $result_cfs_ch as $row_cfs_ch ) {
												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_cfs_ch = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs_ch[doc_std_id]' ";
													$rs_name_cfs_ch = $mysqli->query($sql_name_cfs_ch);
													$row_name_cfs_ch = $rs_name_cfs_ch->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Chairman_Form_Change_Field_Study.php?doc_id=<?=base64_encode($row_cfs_ch[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $chairman_board_status = $row_cfs_ch[ 'chairman_board_status' ];
													if ( $chairman_board_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $chairman_board_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $chairman_board_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_cfs_ch['std_fname_th'];?>&nbsp;
														<?php echo $row_name_cfs_ch['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_cfs_ch['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนสาขาวิชา (ประธานหลักสูตร)";
													
													?>
												</td>
											</tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_cfs_ch = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs_ch[doc_std_id]' ";
													$rs_name_cfs_ch = $mysqli->query($sql_name_cfs_ch);
													$row_name_cfs_ch = $rs_name_cfs_ch->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Chairman_Form_Change_Field_Study.php?doc_id=<?=base64_encode($row_cfs_ch[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $chairman_board_status = $row_cfs_ch[ 'chairman_board_status' ];
													if ( $chairman_board_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $chairman_board_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $chairman_board_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_cfs_ch['std_fname_th'];?>&nbsp;
														<?php echo $row_name_cfs_ch['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_cfs_ch['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องขอเปลี่ยนสาขาวิชา (ประธานหลักสูตร)";
													
													?>
												</td>
											</tr>
											<?php	}
												?>
											
											<?php
											
											}
											?>
                                                        <?php
											 
											foreach ( $result_aa as $row_aa ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_aa = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_aa[doc_std_id]' ";
													$rs_name_aa = $mysqli->query($sql_name_aa);
													$row_name_aa = $rs_name_aa->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Form_Appointment.php?doc_id=<?=base64_encode($row_aa[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_status = $row_aa[ 'advisor_status' ];
													if ( $advisor_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_aa['std_fname_th'];?>&nbsp;
														<?php echo $row_name_aa['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_aa['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องแต่งตั้งขื่อเรื่องวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
                                                                   <?php
											 
											foreach ( $result_pe as $row_pe ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_pe = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_pe[doc_std_id]' ";
													$rs_name_pe = $mysqli->query($sql_name_pe);
													$row_name_pe = $rs_name_pe->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Proposal_Examination.php?doc_id=<?=base64_encode($row_pe[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_status = $row_pe[ 'advisor_status' ];
													if ( $advisor_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_pe['std_fname_th'];?>&nbsp;
														<?php echo $row_name_pe['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_pe['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องแต่งตั้งคณะกรรมการสอบโครงร่างวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
                                                <?php
											 
											foreach ( $result_te as $row_te ) {
												?>
											<tr>
												<td class="text-center">
													<?php
													//echo $ds;
													 $sql_name_te = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_te[doc_std_id]' ";
													$rs_name_te = $mysqli->query($sql_name_te);
													$row_name_te = $rs_name_te->fetch_array();
													?>
													<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
												</td>
												<td class="text-center">
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Advisor_Thesis_Examination.php?doc_id=<?=base64_encode($row_te[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
															<!-- <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>-->
														</div>
                                                       </div>
												</td>
												<td>
													<?php
													 $advisor_status = $row_te[ 'advisor_status' ];
													if ( $advisor_status == 0 ) {
														echo "<span class='text text-warning'>In Progress</span>";
													} else if ( $advisor_status == 1 ) {
														echo "<span class='text text-success'>Approved</span>";
													} else if ( $advisor_status == 2 ) {
														echo "<span class='text label-danger'>Rejected</span>";
													}
													?>
												</td>
												<td>
													<div>
														<?php echo $row_name_te['std_fname_th'];?>&nbsp;
														<?php echo $row_name_te['std_lname_th'];?>
													</div>
													<div class="small text-muted"> Send:
														<?php echo $row_te['doc_date'];?> </div>
												</td>
												<td>
													<?php
										
														echo "คำร้องแต่งตั้งคณะกรรมการสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													
													?>
												</td>
											</tr>
											<?php
											
											}
											?>
										</tbody>
									</table>
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

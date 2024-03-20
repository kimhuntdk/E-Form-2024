<?php
session_start();
//$id = $_SESSION[ "SES_ID" ];
//$SES_STDCODE = $_SESSION[ "SES_STDCODE" ];60010360011
$SES_STDCODE = "59010850007";
if ( $SES_STDCODE == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();

//== ลงทะเบียนเพิ่ม
$sql = "SELECT * FROM request_registration_thesis_is LEFT JOIN request_doc ON request_registration_thesis_is.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'   order by request_doc.doc_id desc";
$result = $mysqli->query( $sql );
$num_result = $result->num_rows;
//== ลาพักการเรียน
$sql_tl = "SELECT * FROM request_taking_leave LEFT JOIN request_doc ON request_taking_leave.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_tl = $mysqli->query( $sql_tl );
$num_result_tl = $result_tl->num_rows;
//== ลงทะเบียนรักษาสภาพนิสิต 
$sql_sr = "SELECT * FROM request_student_status_retention LEFT JOIN request_doc ON request_student_status_retention.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_sr = $mysqli->query( $sql_sr );
$num_result_sr = $result_sr->num_rows;
//== ชำระค่าธรรมเนียมการศึกษา 
$sql_fp = "SELECT * FROM request_fee_payment LEFT JOIN request_doc ON request_fee_payment.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_fp = $mysqli->query( $sql_fp );
$num_result_fp = $result_fp->num_rows;
//== คำร้องขอกลับเข้ารับราชการ  
$sql_rw = "SELECT * FROM request_return_work LEFT JOIN request_doc ON request_return_work.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_rw = $mysqli->query( $sql_rw );
//== ขอหนังสือรับรองการขยายเวลาศึกษาต่อ  
$sql_eps = "SELECT * FROM request_extension_period_study LEFT JOIN request_doc ON request_extension_period_study.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_eps = $mysqli->query( $sql_eps );
//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  
$sql_wrtl = "SELECT * FROM request_withdraw_registration_taking_leave LEFT JOIN request_doc ON request_withdraw_registration_taking_leave.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_wrtl = $mysqli->query( $sql_wrtl );
//== ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน
$sql_wtlr = "SELECT * FROM request_withdraw_taking_leave_registration LEFT JOIN request_doc ON request_withdraw_taking_leave_registration.doc_id=request_doc.doc_id Where request_doc.doc_std_id='$SES_STDCODE'  order by request_doc.doc_id desc ";
$result_wtlr = $mysqli->query( $sql_wtlr );
//== คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)
 echo  $sql_srfs = "SELECT * FROM request_doc LEFT JOIN request_status_retention ON request_doc.doc_id=request_status_retention.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' AND request_doc.doc_type=13 order by request_doc.doc_id desc ";
$result_srfs = $mysqli->query( $sql_srfs );
//== บันทึกขอรายงานตัวช้า
 $sql_ms = "SELECT * FROM request_memorandum_student LEFT JOIN request_doc ON  request_memorandum_student.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE'";
$result_ms = $mysqli->query( $sql_ms );
//== บันทึกข้อความผ่านคณะ
 $sql_ds = "SELECT * FROM request_document_student LEFT JOIN request_doc ON request_document_student.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_ds = $mysqli->query( $sql_ds );
//== บันทึกข้อความไม่ต้องผ่านคณะ
 $sql_dsg = "SELECT * FROM request_document_student_grad LEFT JOIN request_doc ON request_document_student_grad.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_dsg = $mysqli->query( $sql_dsg );
//== เปลี่ยนแผนการเรียน
$sql_csp = "SELECT * FROM request_change_study_program LEFT JOIN request_doc ON request_change_study_program.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_csp = $mysqli->query( $sql_csp );
//== เปลี่ยนสาขาวิชา
 $sql_cfs = "SELECT * FROM request_change_field_study LEFT JOIN request_doc ON request_change_field_study.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_cfs_ = $mysqli->query( $sql_cfs );
//== แต่งตั้งชื่อเรื่อง
$sql_aa = "SELECT * FROM request_appointment_advisor LEFT JOIN request_doc ON request_appointment_advisor.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_aa = $mysqli->query( $sql_aa );
//== แต่งตั้งสอบโครงร่าง
$sql_pe = "SELECT * FROM request_proposal_examination LEFT JOIN request_doc ON request_proposal_examination.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
$result_pe = $mysqli->query( $sql_pe );
//== แต่งตั้งสอบสอบวิทยานิพนธ์
$sql_te = "SELECT * FROM request_thesis_examination LEFT JOIN request_doc ON request_thesis_examination.doc_id=request_doc.doc_id WHERE request_doc.doc_std_id='$SES_STDCODE' ";
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
      <h1 class="page-title"> </h1>
    </div>
<?php

					//include $src_page;

					?>
<div class="row row-cards row-deck">
<div class="col-12">
<div class="card">
<div class="table-responsive">
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>advisor</th>
        <th>staff</th>
        <th>graduate</th>
        <th>Registration </th>
        <th>Student</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
											$i = 1;
											foreach ( $result as $row ) {
												//

												$date = $row["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
													$rs_name = $mysqli->query( $sql_name );
													$row_name = $rs_name->fetch_array();
													echo $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Registration_Thesis&doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                    $staff_grad_approve_disapprove = $row['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Disapprove </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php
														$dean_admin_approve_disapprove = $row[ 'dean_admin_approve_disapprove' ];
														if ( $staff_grad_approve_disapprove == 1 ) {

															if ( $dean_admin_approve_disapprove == 0 ) {
																?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                      $registration_division_status = $row['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row['doc_date'];?> </div></td>
        <td><?php
														$doc_type = $row[ 'doc_type' ];
														if ( $doc_type == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?></td>
      </tr>
          <?php
												} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
													$rs_name = $mysqli->query( $sql_name );
													$row_name = $rs_name->fetch_array();
													echo $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Registration_Thesis&doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                    $staff_grad_approve_disapprove = $row['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['staff_grad_node']==" "){echo "- ";}else{echo $row['staff_grad_node'];}?>"> Disapprove </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php
														$dean_admin_approve_disapprove = $row[ 'dean_admin_approve_disapprove' ];
														if ( $staff_grad_approve_disapprove == 1 ) {

															if ( $dean_admin_approve_disapprove == 0 ) {
																?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row['dean_admin_node']==" "){echo "- ";}else{echo $row['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                      $registration_division_status = $row['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row['doc_date'];?> </div></td>
        <td><?php
														$doc_type = $row[ 'doc_type' ];
														if ( $doc_type == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?></td>
      </tr>
          <?php
												}
												?>
          <?php
											$i++;
											}
											?>
          <?php
											$iii = 0;
											foreach ( $result_tl as $row_tl ) {
											$date = $row_tl["std_date_signature"];//วันที่ส่ง
											$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
											$date_curent = date("Y-m-d");
											$stats = $row_tl["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
											
											if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_tl[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_tl['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_tl['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_tl['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_tl['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_tl[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?></td>
      </tr>
          <?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_tl[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_tl['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['staff_grad_node']==" "){echo "- ";}else{echo $row_tl['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_tl['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['dean_admin_node']==" "){echo "- ";}else{echo $row_tl['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_tl['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_tl['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_tl[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}
														?></td>
      </tr>
          <?php
											}

												?>
          <?php
											$iii++;
											}
											?>
          <?php
											$sr = 0;
											foreach ( $result_sr as $row_sr ) {
                                                    $date = $row_sr["std_date_signature"];//วันที่ส่ง
													$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
													$date_curent = date("Y-m-d");
													$stats = $row_sr["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
													
													if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_sr[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_sr['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_sr['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_sr['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_sr['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_sr[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														}
														?></td>
      </tr>
          <?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_sr[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_sr['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_sr['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['staff_grad_node']==" "){echo "- ";}else{echo $row_sr['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_sr['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_sr['dean_admin_node']==" "){echo "- ";}else{echo $row_sr['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_sr['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_sr['registration_division_node']==" "){echo "- ";}else{echo $row_sr['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_sr['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_sr[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														}
														?></td>
      </tr>
          <?php	}
												?>
          <?php
											$sr++;
											}
											?>
          <?php
											$fp = 0;
											foreach ( $result_fp as $row_fp ) {
													$date = $row_fp["std_date_signature"];//วันที่ส่ง
													$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
													$date_curent = date("Y-m-d");
													$stats = $row_fp["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
													
													if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง  ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_fp[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_fp['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_fp['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_fp['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_fp['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_fp[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}
														?></td>
      </tr>
          <?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_tl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_fp[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_fp['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_fp['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['staff_grad_node']==" "){echo "- ";}else{echo $row_fp['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_fp['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_fp['dean_admin_node']==" "){echo "- ";}else{echo $row_fp['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_fp['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_fp['registration_division_node']==" "){echo "- ";}else{echo $row_fp['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_fp['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_fp[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}
														?></td>
      </tr>
          <?php	}
												?>
          <?php
											$fp++;
											}
											?>
          <?php
											$rw = 0;
											foreach ( $result_rw as $row_rw ) {
												$date = $row_rw["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row_rw["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_rw[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_rw[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_rw['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_rw['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_rw['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_rw['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_fp[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}
														?></td>
      </tr>
												<?php } else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												 <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_rw[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_rw[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['advisor_chairman_node']==" "){echo "- ";}else{echo $row_rw['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_rw['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['staff_grad_node']==" "){echo "- ";}else{echo $row_rw['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_rw['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_rw['dean_admin_node']==" "){echo "- ";}else{echo $row_rw['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_rw['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_rw['registration_division_node']==" "){echo "- ";}else{echo $row_rw['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_rw['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_fp[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}
														?></td>
      </tr>
												<?php }
												?>
          
          <?php
											$rw++;
											}
											?>
          <?php
											$eps = 0;
											foreach ( $result_eps as $row_eps ) {
												$date = $row_eps["std_date_signature"];//วันที่ส่ง
												$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
												$date_curent = date("Y-m-d");
												$stats = $row_eps["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												
												if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
												<tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_eps[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_eps[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_eps['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_eps['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_eps['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_eps['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_eps[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}
														?></td>
      </tr>
											<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
												<tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_eps[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_eps[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['advisor_chairman_node']==" "){echo "- ";}else{echo $row_eps['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_eps['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['staff_grad_node']==" "){echo "- ";}else{echo $row_eps['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_eps['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_eps['dean_admin_node']==" "){echo "- ";}else{echo $row_eps['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_eps['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_eps['registration_division_node']==" "){echo "- ";}else{echo $row_eps['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_eps['doc_date'];?> </div></td>
        <td><?php
														$doc_type1 = $row_eps[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}
														?></td>
      </tr>
											<?php	}
												?>
        
          <?php
											$eps++;
											}
											?>
          <?php
											$wrtl = 0;
											foreach ( $result_wrtl as $row_wrtl ) {
													$date = $row["std_date_signature"];//วันที่ส่ง
													$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
													$date_curent = date("Y-m-d");
													$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
													
													if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
													
													          <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_wrtl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_wrtl[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_wrtl['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_wrtl['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_wrtl['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_wrtl['doc_date'];?> </div></td>
        <td><?php
														 $doc_type1 = $row_wrtl[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}  else if ( $doc_type1 == 81 ) {
															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
														}
														?></td>
      </tr>
													
												<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
															  <tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_wrtl[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_wrtl[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wrtl['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_wrtl['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['staff_grad_node']==" "){echo "- ";}else{echo $row_wrtl['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_wrtl['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wrtl['dean_admin_node']==" "){echo "- ";}else{echo $row_wrtl['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_wrtl['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wrtl['registration_division_node']==" "){echo "- ";}else{echo $row_wrtl['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_wrtl['doc_date'];?> </div></td>
        <td><?php
														 $doc_type1 = $row_wrtl[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														}  else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}  else if ( $doc_type1 == 81 ) {
															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
														}
														?></td>
      </tr>
												<?php	}
												?>

          <?php
											$eps++;
											}
											?>
          <?php
											$wrtl = 0;
											foreach ( $result_wtlr as $row_wtlr ) {
														$date = $row["std_date_signature"];//วันที่ส่ง
														$date_ =  date("Y-m-d", strtotime("+6 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
														$date_curent = date("Y-m-d");
														$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
														
														if($date_curent <= $date_  and $stats==0 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง ?>
														<tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_wtlr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_wtlr[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_wtlr['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_wtlr['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_wtlr['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_wtlr['doc_date'];?> </div></td>
        <td><?php
														  $doc_type1 = $row_wtlr[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
											
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}  else if ( $doc_type1 == 81 ) {
															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
														} else if ( $doc_type1 == 80 ) {
															echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}
														?></td>
      </tr>
													<?php	} else if($stats==1 ) { // อาจารย์อนุมัติ ให้แสดง ?>
														<tr>
        <td class="text-center"><?php
													$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
													$rs_name1 = $mysqli->query( $sql_name1 );
													$row_name1 = $rs_name1->fetch_array();
													echo $ii + $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Taking_Leave&doc_id=<?=base64_encode($row_wtlr[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_wtlr[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['advisor_chairman_node']==" "){echo "- ";}else{echo $row_wtlr['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_wtlr['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['staff_grad_node']==" "){echo "- ";}else{echo $row_wtlr['staff_grad_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_wtlr['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_wtlr['dean_admin_node']==" "){echo "- ";}else{echo $row_wtlr['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                       $registration_division_status = $row_wtlr['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_wtlr['registration_division_node']==" "){echo "- ";}else{echo $row_wtlr['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_wtlr['doc_date'];?> </div></td>
        <td><?php
														  $doc_type1 = $row_wtlr[ 'doc_type' ];
														if ( $doc_type1 == 3 ) {
															echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
														} else if ( $doc_type1 == 1 ) {
															echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
											
														} else if ( $doc_type1 == 4 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
														} else if ( $doc_type1 == 15 ) {
															echo "คำร้องชำระค่าธรรมเนียมการศึกษา /Request Form for Fee Payment ";
														}  else if ( $doc_type1 == 12 ) {
															echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work  ";
														}  else if ( $doc_type1 == 11 ) {
															echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ /Request Form for Extension Period of Study  ";
														}  else if ( $doc_type1 == 81 ) {
															echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
														} else if ( $doc_type1 == 80 ) {
															echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}
														?></td>
      </tr>
													<?php	}
												?>
          
          <?php
											$eps++;
											}
											?>
        </tbody>
  </table>
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>STAFF</th>
        <th>Registration </th>
        <th>Student</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
										  $rsfs = 1;
											foreach ( $result_srfs as $row_srfs ) { //รักษษสภาพกรณีพิเศษ
												
												?>
          <tr>
        <td class="text-center"><?php
										
													$sql_name_srfs = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_srfs[doc_std_id]' ";
													$rs_name_srfs = $mysqli->query( $sql_name_srfs );
													$row_nameSrfs = $rs_name_srfs->fetch_array();
												
                                                	echo $rsfs;
												?></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_srfs['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove==1) {
                            $staff_grad_approve_disapprove;	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php  $registration_division_status = $row_srfs['registration_division_status'];
			  					if($registration_division_status==1) {
                   $registration_division_status; 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><div> <?php echo $row_nameSrfs['std_fname_th'];?>&nbsp; <?php echo $row_nameSrfs['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_srfs['doc_date'];?> </div></td>
        <td><?php
													 $doc_type2 = $row_srfs[ 'doc_type' ];
													if ( $doc_type2 == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type2 == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type2 == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													} else if ( $doc_type2 == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
													}else if ( $doc_type2 == 11 ) {
														
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type2 == 80 ) {
														
														echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}   else if ( $doc_type2 == 9 ) {
															echo "คำร้องขอเปลี่ยนแผนการเรียน / Request Form to Change Study Program  ";
														}    else if ( $doc_type2 == 13 ) {
															echo "คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) / Student Status Retention Form (Special case) ";
														} 
														?></td>
          </td>
      </tr>
          <?php
											$rsfs++;
											}
											
											?>
            </tr>
          
        </tbody>
  </table>
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
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
										   $ms=1;
											foreach ( $result_ms as $row_ms ) {
												?>
          <tr>
        <td class="text-center"><?php
													$sql_name_ms = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ms[doc_std_id]' ";
													$rs_name_ms = $mysqli->query( $sql_name_ms );
													$row_namems = $rs_name_ms->fetch_array();
                                                	echo $ms;
												?></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_ms['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove!=0) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['staff_grad_node']==" "){echo "- ";}else{echo $row_srfs['staff_grad_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php                       $registration_division_status = $row_ms['dean_admin_approve_disapprove'];
			  					if($registration_division_status!=0) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php                      $payment = $row_cfs['payment'];
			  					if($payment!=0) {
                           	 	
								   if($payment==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
              <?php	}else if($payment==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
              <?php	}else if($payment==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="">ยังไม่ชำระเงิน</button>
              <?php	}else if($payment==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> พ้นสภาพ </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><div> <?php echo $row_nameSrfs['std_fname_th'];?>&nbsp; <?php echo $row_nameSrfs['std_lname_th'];?> </div>
              <?php /*?><div class="small text-muted"> Send:
													<?php echo $row_srfs['doc_date'];?> </div><?php */?></td>
        <td><?php
													 
													
															echo "บันทึกข้อความ (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ";
														
														?></td>
          </td>
      </tr>
          <?php
											$ms++;
											}
											
											?>
            </tr>
          
        </tbody>
  </table>
      <!--บันทึกข้อความ ที่ผ่านอาจารย์ที่ปรึกษา-->
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>ADVISOR</th>
        <th>STAFF</th>
        <th>graduate</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
								            $ds=1;
											foreach ( $result_ds as $row_ds ) {
												?>
          <tr>
        <td class="text-center"><?php
													 $sql_name_ds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
													$rs_name_ds = $mysqli->query( $sql_name_ds );
													$row_nameds = $rs_name_ds->fetch_array();
                                                 echo $ds;
												?></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $advisor_chairman_status = $row_ds['advisor_chairman_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['advisor_chairman_node']==" "){echo "- ";}else{echo $row_ds['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($advisor_chairman_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['advisor_chairman_node']==" "){echo "- ";}else{echo $row_ds['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($advisor_chairman_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['advisor_chairman_node']==" "){echo "- ";}else{echo $row_ds['advisor_chairman_node'];}?>"> Rejected </button>
              <?php	}else if($advisor_chairman_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['advisor_chairman_node']==" "){echo "- ";}else{echo $row_ds['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_ds['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_ds['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><div> <?php echo $row_nameds['std_fname_th'];?>&nbsp; <?php echo $row_nameds['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_ds['doc_date'];?> </div></td>
        <td><?php
													echo $doc_type7ds = $row_ds[ 'doc_type' ];
													if ( $doc_type7ds == 3 ) {
														echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
													} else if ( $doc_type7ds == 1 ) {
														echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
													} else if ( $doc_type7ds == 4 ) {
														echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
													} else if ( $doc_type7ds == 15 ) {
														echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
													}else if ( $doc_type7ds == 11 ) {
														
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
													} else if ( $doc_type7ds == 80 ) {
														
														echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}   else if ( $doc_type7ds == 70 ) {
														
														echo "บันทึกข้อความ";
														}
														?></td>
          </td>
      </tr>
          <?php
											$ds++;
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
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>STAFF</th>
        <th>graduate</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
								   $dsg=1;
											foreach ( $result_dsg as $row_dsg ) {
												?>
          <tr>
        <td class="text-center"><?php
											     $sql_name_dsg = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_dsg[doc_std_id]' ";
													$rs_name_dsg = $mysqli->query( $sql_name_dsg );
													$row_namedsg = $rs_name_dsg->fetch_array();
                                             echo $dsg;
											 ?></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_dsg['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_ds['staff_grad_node']==" "){echo "- ";}else{echo $row_ds['staff_grad_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_dsg['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_ds['dean_admin_node']==" "){echo "- ";}else{echo $row_ds['dean_admin_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><div> <?php echo $row_namedsg['std_fname_th'];?>&nbsp; <?php echo $row_namedsg['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_dsg['doc_date'];?> </div></td>
        <td><?php
													
														
														echo "บันทึกข้อความ";
													
														?></td>
          </td>
      </tr>
          <?php
											$dsg++;
											}
											?>
            </tr>
          
        </tbody>
  </table>
      <!--เปลี่ยนแผนการเรียน-->
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
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
											foreach ( $result_csp as $row_csp ) {
												?>
          <tr>
        <td class="text-center"><?php
													$sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp[doc_std_id]' ";
													$rs_name_csp = $mysqli->query( $sql_name_csp );
													$row_name_csp = $rs_name_csp->fetch_array();
													?>
              <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $advisor_chairman_status = $row_csp['advisor_chairman_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_csp['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($advisor_chairman_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_csp['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($advisor_chairman_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_csp['advisor_chairman_node'];}?>"> Rejected </button>
              <?php	}else if($advisor_chairman_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['advisor_chairman_node']==" "){echo "- ";}else{echo $row_csp['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><?php                       $chairman_board_status = $row_csp['chairman_board_status'];
			             
                           	 	
								if($chairman_board_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['chairman_board_node']==" "){echo "- ";}else{echo $row_csp['chairman_board_node'];}?>"> In Progress </button>
              <?php	}else if($chairman_board_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['chairman_board_node']==" "){echo "- ";}else{echo $row_csp['chairman_board_node'];}?>"> Approved </button>
              <?php	}else if($chairman_board_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['chairman_board_node']==" "){echo "- ";}else{echo $row_csp['chairman_board_node'];}?>"> Rejected </button>
              <?php	}else if($chairman_board_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['chairman_board_node']==" "){echo "- ";}else{echo $row_csp['chairman_board_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><?php                       $staff_grad_approve_disapprove = $row_csp['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['staff_grad_node']==" "){echo "- ";}else{echo $row_csp['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['staff_grad_node']==" "){echo "- ";}else{echo $row_csp['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['staff_grad_node']==" "){echo "- ";}else{echo $row_csp['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['staff_grad_node']==" "){echo "- ";}else{echo $row_csp['staff_grad_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php  $dean_admin_approve_disapprove = $row_csp['dean_admin_approve_disapprove'];
			  					if($staff_grad_approve_disapprove==1) { 
                           	 	
								if($dean_admin_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_csp['dean_admin_node']==" "){echo "- ";}else{echo $row_csp['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_csp['dean_admin_node']==" "){echo "- ";}else{echo $row_csp['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_csp['dean_admin_node']==" "){echo "- ";}else{echo $row_csp['dean_admin_node'];}?>"> Rejected </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><?php                       $registration_division_status = $row_csp['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['registration_division_node']==" "){echo "- ";}else{echo $row_csp['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['registration_division_node']==" "){echo "- ";}else{echo $row_csp['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_csp['registration_division_node']==" "){echo "- ";}else{echo $row_csp['registration_division_node'];} ?>"> Rejected </button>
              <button type="button" class="btn btn-primary on_submit"  data-id="<?=$row_wrtl[doc_id];?>" data-node="<?=$row_wrtl['registration_division_node'];?>" data-doctype="1" > Re-Send </button>
              <?php
													}
													} else {
														?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
													}
													?></td>
        <td><div> <?php echo $row_name_csp['std_fname_th'];?>&nbsp; <?php echo $row_name_csp['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_csp['doc_date'];?> </div></td>
        <td><?php
														echo "คำร้องเปลี่ยนแผนการเรียน";
													?></td>
          </td>
      </tr>
          <?php
											}
									
                                            
                                            	?>
           </tr>
        </tbody>
  </table>
      <!--สิ้นสุดการเปลี่ยนแผนการเรียน--> 
      <!--แต่งตั้งชื่อเรือ่ง-->
       <!--เปลี่ยนสาขาวิชา-->
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
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
                                            
                                            	foreach ($result_cfs_ as $row_cfs) 
												{ ?>
												
	                                           <tr>
        <td class="text-center"><?php
													$sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs[doc_std_id]' ";
													$rs_name = $mysqli->query( $sql_name );
													$row_cfs_name = $rs_name->fetch_array();
													echo $i;
													?>
              
              <!--                <div class="avatar d-block" style="background-image: url(demo/faces/female/26.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
-->
            <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="?menu=Student_Registration_Thesis&doc_id=<?=base64_encode($row_cfs[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php
														$registration_thesis_status = $row_cfs[ 'advisor_chairman_status' ];
														if ( $registration_thesis_status == 0 ) {
															?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['advisor_chairman_node']==" "){echo "- ";}else{echo $row_cfs['advisor_chairman_node'];}?>"> In Progress </button>
              <?php	}else if($registration_thesis_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['advisor_chairman_node']==" "){echo "- ";}else{echo $row_cfs['advisor_chairman_node'];}?>"> Approved </button>
              <?php	}else if($registration_thesis_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['advisor_chairman_node']==" "){echo "- ";}else{echo $row_cfs['advisor_chairman_node'];}?>"> Rejected </button>
              <?php
														}
														?></td>
                                                         <td><?php                       $chairman_board_status = $row_cfs['chairman_board_status'];
			             
                           	 	
								if($chairman_board_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['chairman_board_node']==" "){echo "- ";}else{echo $row_cfs['chairman_board_node'];}?>"> In Progress </button>
              <?php	}else if($chairman_board_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['chairman_board_node']==" "){echo "- ";}else{echo $row_cfs['chairman_board_node'];}?>"> Approved </button>
              <?php	}else if($chairman_board_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['chairman_board_node']==" "){echo "- ";}else{echo $row_cfs['chairman_board_node'];}?>"> Rejected </button>
              <?php	}else if($chairman_board_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['chairman_board_node']==" "){echo "- ";}else{echo $row_cfs['chairman_board_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><?php                    $staff_grad_approve_disapprove = $row_cfs['staff_grad_approve_disapprove'];
			                    if($registration_thesis_status==1) {
                           	 	
								if($staff_grad_approve_disapprove==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['staff_grad_node']==" "){echo "- ";}else{echo $row_cfs['staff_grad_node'];}?>"> In Progress </button>
              <?php	}else if($staff_grad_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['staff_grad_node']==" "){echo "- ";}else{echo $row_cfs['staff_grad_node'];}?>"> Approved </button>
              <?php	}else if($staff_grad_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['staff_grad_node']==" "){echo "- ";}else{echo $row_cfs['staff_grad_node'];}?>"> Rejected </button>
              <?php	}else if($staff_grad_approve_disapprove==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['staff_grad_node']==" "){echo "- ";}else{echo $row_cfs['staff_grad_node'];}?>"> Disapprove </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php
														$dean_admin_approve_disapprove = $row_cfs[ 'dean_admin_approve_disapprove' ];
														if ( $staff_grad_approve_disapprove == 1 ) {

															if ( $dean_admin_approve_disapprove == 0 ) {
																?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['dean_admin_node']==" "){echo "- ";}else{echo $row_cfs['dean_admin_node'];}?>"> In Progress </button>
              <?php	}else if($dean_admin_approve_disapprove==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['dean_admin_node']==" "){echo "- ";}else{echo $row_cfs['dean_admin_node'];}?>"> Approved </button>
              <?php	}else if($dean_admin_approve_disapprove==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php  if($row_cfs['dean_admin_node']==" "){echo "- ";}else{echo $row_cfs['dean_admin_node'];}?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><?php                      $registration_division_status = $row_cfs['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['registration_division_node']==" "){echo "- ";}else{echo $row_cfs['registration_division_node'];} ?>"> In Progress </button>
              <?php	}else if($registration_division_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['registration_division_node']==" "){echo "- ";}else{echo $row_cfs['registration_division_node'];} ?>"> Approved </button>
              <?php	}else if($registration_division_status==9) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_cfs['registration_division_node']==" "){echo "- ";}else{echo $row_cfs['registration_division_node'];} ?>"> Rejected </button>
              <?php
														}
														} else {
															?>
              <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="left"> None </button>
              <?php
														}
														?></td>
        <td><div> <?php echo $row_cfs_name['std_fname_th'];?>&nbsp; <?php echo $row_cfs_name['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_cfs['doc_date'];?> </div></td>
        <td><?php
												echo "คำร้องเปลี่ยนสาขาวิชา";
														?></td>
      </tr>
        
										 <?php    }
									   	 ?>
      
          
        </tbody>
  </table>
      <!--สิ้นสุดการเปลี่ยนสาขาวิชา--> 
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>ADVISOR</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
											foreach ( $result_aa as $row_aa ) {
												?>
          <tr>
        <td class="text-center"><?php
													$sql_name_aa = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_aa[doc_std_id]' ";
													$rs_name_aa = $mysqli->query( $sql_name_aa );
													$row_name_aa = $rs_name_aa->fetch_array();
													?>
              <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $advisor_chairman_status = $row_aa['advisor_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_aa['advisor_node']==" "){echo "- ";}else{echo $row_cfs['advisor_node'];}?>"> In Progress </button>
              <?php	}else if($advisor_chairman_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_aa['advisor_node']==" "){echo "- ";}else{echo $row_cfs['advisor_node'];}?>"> Approved </button>
              <?php	}else if($advisor_chairman_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_aa['advisor_node']==" "){echo "- ";}else{echo $row_cfs['advisor_node'];}?>"> Rejected </button>
              <?php	}else if($advisor_chairman_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_aa['advisor_node']==" "){echo "- ";}else{echo $row_cfs['advisor_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><div> <?php echo $row_name_aa['std_fname_th'];?>&nbsp; <?php echo $row_name_aa['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_aa['doc_date'];?> </div></td>
        <td><?php
														echo "คำร้องแต่งตั้งชื่อเรื่องวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													?></td>
          </td>
      </tr>
          <?php
											}
											?>
            </tr>
          
        </tbody>
  </table>
      <!--สิ้นสุดการแต่งตั้งชื่อเรื่อง->
                                           <!--แต่งตั้งกรรมการสอบโครงร่าง-->
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>ADVISOR</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
											foreach ( $result_pe as $row_pe ) {
												?>
          <tr>
        <td class="text-center"><?php
													$sql_name_pe = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_pe[doc_std_id]' ";
													$rs_name_pe = $mysqli->query( $sql_name_pe );
													$row_name_pe = $rs_name_pe->fetch_array();
													?>
              <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $advisor_chairman_status = $row_pe['advisor_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_pe['advisor_node']==" "){echo "- ";}else{echo $row_pe['advisor_node'];}?>"> In Progress </button>
              <?php	}else if($advisor_chairman_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_pe['advisor_node']==" "){echo "- ";}else{echo $row_pe['advisor_node'];}?>"> Approved </button>
              <?php	}else if($advisor_chairman_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_pe['advisor_node']==" "){echo "- ";}else{echo $row_pe['advisor_node'];}?>"> Rejected </button>
              <?php	}else if($advisor_chairman_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_pe['advisor_node']==" "){echo "- ";}else{echo $row_pe['advisor_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><div> <?php echo $row_name_pe['std_fname_th'];?>&nbsp; <?php echo $row_name_pe['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_pe['doc_date'];?> </div></td>
        <td><?php
														echo "คำร้องแต่งตั้งกรรมการสอบโครงร่างวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													?></td>
          </td>
      </tr>
          <?php
											}
											?>
            </tr>
          
        </tbody>
  </table>
      <!--สิ้นสุดการแต่งตัั้งกรรมการสอบโครงร่าง->
                                            <!--แต่งตั้งกรรมการสอบวิทยานิพนธ์-->
      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
    <thead>
          <tr>
        <th class="text-center w-1"><i class="icon-people"></i> </th>
        <th>manage</th>
        <th>ADVISOR</th>
        <th>Subject</th>
      </tr>
        </thead>
    <tbody>
          <?php
											foreach ( $result_te as $row_te ) {
												?>
          <tr>
        <td class="text-center"><?php
													$sql_name_te = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_te[doc_std_id]' ";
													$rs_name_te = $mysqli->query( $sql_name_te );
													$row_name_te = $rs_name_te->fetch_array();
													?>
              <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
        <td class="text-center"><div class="item-action dropdown">
              <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
              <div class="dropdown-menu dropdown-menu-right"> <a href="#" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> </div></td>
        <td><?php                       $advisor_chairman_status = $row_te['advisor_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
              <button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_te['advisor_node']==" "){echo "- ";}else{echo $row_te['advisor_node'];}?>"> In Progress </button>
              <?php	}else if($advisor_chairman_status==1) { ?>
              <button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_te['advisor_node']==" "){echo "- ";}else{echo $row_te['advisor_node'];}?>"> Approved </button>
              <?php	}else if($advisor_chairman_status==2) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_te['advisor_node']==" "){echo "- ";}else{echo $row_te['advisor_node'];}?>"> Rejected </button>
              <?php	}else if($advisor_chairman_status==3) { ?>
              <button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_te['advisor_node']==" "){echo "- ";}else{echo $row_te['advisor_node'];}?>"> Rejected </button>
              <?php
													}

													?></td>
        <td><div> <?php echo $row_name_te['std_fname_th'];?>&nbsp; <?php echo $row_name_te['std_lname_th'];?> </div>
              <div class="small text-muted"> Send: <?php echo $row_te['doc_date'];?> </div></td>
        <td><?php
														echo "คำร้องแต่งตั้งกรรมการสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ";
													?></td>
          </td>
      </tr>
          <?php
											}
											?>
            </tr>
          
        </tbody>
  </table>
      <!--สิ้นสุดการแต่งตัั้งกรรมการสอบวิทยานิพนธ์->
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
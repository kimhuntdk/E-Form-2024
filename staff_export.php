<?php
session_start();
$SES_USER = $_SESSION[ "SES_USER" ];
if ( $_SESSION[ "SES_LEVEL" ] != "staff_ses" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();
$keyword = $_REQUEST['Keyword'];
$doc_status = $_REQUEST['doc_status'];
if ( $_REQUEST[ 'doc_status' ] == 0 ) { 
	$status_key = "(0)";
} else if($_REQUEST[ 'doc_status' ] == 1 ) {
	$status_key = "(1)";
} else if($_REQUEST[ 'doc_status' ] == 9 ) {
	$status_key = "(9)";
}  else if($_REQUEST[ 'doc_status' ] == 3 ) {
	$status_key = "(3)";
} else if($_REQUEST[ 'doc_status' ] == 10) {
	$status_key= "(0,1,2,3,9)";
    $key_sreach=1;
}
if ( $keyword) {

	$keyword_key = " AND request_doc.doc_std_id LIKE '$keyword'";

} else {
	$keyword = "";
}
$doc_type = $_REQUEST['doc_type'];
//== ลงทะเบียนเพิ่ม
if ( $doc_type != "" ) {
	$keyword_doc_type = " AND request_doc.doc_type = '$doc_type'";
}
  $sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.dean_admin_approve_disapprove=1 AND request_doc.doc_date > '2022-12-12 08:30:00'  ";
$result = $mysqli->query( $sql );
//echo $result->num_rows;

//== ลาพักการเรียน
echo  $sql_tl = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.dean_admin_approve_disapprove=1 AND request_doc.doc_date > '2022-12-11 08:30:00'  ";
$result_tl = $mysqli->query( $sql_tl );
//== ลงทะเบียนรักษาสภาพนิสิต 

//== คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)
 $sql_srfs = "SELECT * FROM request_doc LEFT JOIN request_status_retention ON request_doc.doc_id=request_status_retention.doc_id WHERE request_status_retention.staff_grad_approve_disapprove!=2 AND request_status_retention.registration_division_status=0 AND request_doc.doc_date > '2022-12-12 08:30:00' AND request_status_retention.staff_grad_approve_disapprove IN (0,1,2,3) $keyword_key $keyword_doc_type";
$result_srfs = $mysqli->query( $sql_srfs );

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
					<p>ตรวจสอบสถานะ REGISTRATION </p>
					<form class="form-inline" action="#" method="post">
						<div class="form-group">
							<label class="sr-only">ค้นหา</label>
							<input type="text" class="form-control" id="inputPassword2" placeholder="รหัสประจำตัวนิสิต" name="Keyword">
							<select class="form-control" name="doc_type">
								<option value="0">เลือกคำร้อง</option>
								<option value="3">คำร้องลงทะเบียน Thesis/IS</option>
								<option value="1">คำร้องลาพักการเรียน</option>
							</select>
								<select class="form-control" name="doc_status">
								<option value="">Status</option>
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
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>ADVISOR</th>
												<th>staff</th>
												<th>graduate</th>
												<th>Registration </th>
												<th>payment</th>
												<th>เทอม</th>
												<th>ปี</th>
												<th>Thesis/IS</th>
												<th>รายวิชา</th>
												<th>จำนวนหน่วยกิต</th>
												<th>classid</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ( $result as $row ) {
												    $date = $row["std_date_signature"];//วันที่ส่ง
													$date_ =  date("Y-m-d", strtotime("+8 day", strtotime($date))); // เพิ่มขึ้นทีละ 1 วัน
													$date_curent = date("Y-m-d");
													$stats = $row["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
												   // echo "วันที่ปัจจุบัน ".$date_curent." <= "."วันที่ส่ง".$date_;
                                                    if(2==2){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง 
													//if($date_curent <= $date_  and $stats==0 || $stats==1 || $stats==2){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง 
												?>
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
                                                     <?php
                                                     echo  $row['doc_id'];
                                                     ?>
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Registration_Thesis_ch.php?doc_id=<?=base64_encode($row['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a><?php /*?> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a> <a href="#" data-id="<?=$row;?>" data-typeid="3" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a> <a href="Staff_Del.php?id=<?=base64_encode($row);?>&type_id=3" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a><?php */?> </div>
												</td>
												<td>
													<?php                    $advisor_chairman_status = $row['advisor_chairman_status'];
			                
                           	 	
								if($advisor_chairman_status==0){ ?>
													<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> In Progress </button>
													<?php	}else if($advisor_chairman_status==1) { ?>
													<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Approved </button>
													<?php	}else if($advisor_chairman_status==2) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Rejected </button>
													<?php	}else if($advisor_chairman_status==3) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['advisor_chairman_node']==" "){echo "- ";}else{echo $row['advisor_chairman_node'];}?>"> Disapprove </button>
													<?php
													}

													?>
												</td>
												<td>
													<?php                    $staff_grad_approve_disapprove = $row['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove!=0) {
                           	 	
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
													?>
												</td>
												<td>
													<?php
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
													?>
												</td>
												<td>
													<?php                      $registration_division_status = $row['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
													<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> In Progress </button>
													<?php	}else if($registration_division_status==1) { ?>
													<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Approved </button>
													<?php	}else if($registration_division_status==9) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row['registration_division_node']==" "){echo "- ";}else{echo $row['registration_division_node'];} ?>"> Rejected </button>
													
													<button type="button" class="btn btn-primary on_submit"  data-id="<?=$row['doc_id'];?>" data-node="<?=$row['registration_division_node'];?>" data-doctype="3" > Re-Send </button>
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
													<?php                      $payment = $row['payment'];
			  					if($payment!=0) {
                           	 	
								if($payment==0){ ?>
													<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content=""> In Progress </button>
													<?php	}else if($payment==1) { ?>
													<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content=""> Completed </button>
													<?php	}else if($payment==2) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content=""> ยังไม่ชำระเงิน </button>
													<?php	}else if($payment==3) { ?>
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
												<td>&nbsp;<?=$row['semester'];?></td>
												<td>&nbsp;<?=$row['academic'];?></td>
												<td><?=$row['status_thesis_is'];?></td>
												<td>&nbsp;<?=$row['subject_code'];?></td>
												<td><?=$row['credits'];?></td>
												<td>&nbsp;<?=$row['classid'];?></td>
												<td>
													<div>
														<?php echo $row_name['std_fname_th'];?>&nbsp;
														<?php echo $row_name['std_lname_th'];?>
													</div>
                                                    <div class="small text-muted"> ID:
														<?php echo $row_name['std_id_std'];?> </div>
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
											$stats = $row_tl["advisor_chairman_status"]; // สถานการอนุมัติของอาจารย์
										
                                           
											if(2==1 ){ // แสดงภายใน 7 วัน นับตั้งแต่วันที่ส่ง 
								            //echo "22222";
                                            ?>
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
                                                  <?php
                                                     echo  $row_tl['doc_id'];
                                                     ?>
													<div class="item-action dropdown">
														<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
														<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Taking_Leave_ch.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a><?php /*?> <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview 
														</a><a href="#" data-id="<?=$row_tl['doc_id'];?>" data-typeid="1" class="dropdown-item docID" data-toggle="modal" data-target="#myModal"><i class="dropdown-icon fe fe-file-text"></i> Payment </a> 
														<a href="Staff_Del.php?id=<?=base64_encode($row_tl['doc_id']);?>&type_id=1" class="dropdown-item"><i class="dropdown-icon fe fe-minus-circle"></i> Delete </a> <?php */?></div>
												</td>
												<td>
													<?php                       $advisor_chairman_status = $row_tl['advisor_chairman_status'];
			             
                           	 	
								if($advisor_chairman_status==0){ ?>
													<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> In Progress </button>
													<?php	}else if($advisor_chairman_status==1) { ?>
													<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Approved </button>
													<?php	}else if($advisor_chairman_status==2) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Rejected </button>
													<?php	}else if($advisor_chairman_status==3) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['advisor_chairman_node']==" "){echo "- ";}else{echo $row_tl['advisor_chairman_node'];}?>"> Rejected </button>
													<?php
													}

													?>
												</td>
												<td>
													<?php                       $staff_grad_approve_disapprove = $row_tl['staff_grad_approve_disapprove'];
			                    if($staff_grad_approve_disapprove!=0) {
                           	 	
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
													?>
												</td>
												<td>
													<?php  $dean_admin_approve_disapprove = $row_tl['dean_admin_approve_disapprove'];
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
													?>
												</td>
												<td>
													<?php                       $registration_division_status = $row_tl['registration_division_status'];
			  					if($dean_admin_approve_disapprove==1) {
                           	 	
								if($registration_division_status==0){ ?>
													<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> In Progress </button>
													<?php	}else if($registration_division_status==1) { ?>
													<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Approved </button>
													<?php	}else if($registration_division_status==9) { ?>
													<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_tl['registration_division_node']==" "){echo "- ";}else{echo $row_tl['registration_division_node'];} ?>"> Rejected </button>
													<button type="button" class="btn btn-primary on_submit"  data-id="<?=$row_tl['doc_id'];?>" data-node="<?=$row_tl['registration_division_node'];?>" data-doctype="1" > Re-Send </button>
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
													<?php                      $payment = $row_tl['payment'];
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
													?>
												</td>
												<td><?=$row_tl['semester'];?></td>
												<td><?=$row_tl['academic'];?></td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>
													<div>
														<?php echo $row_name1['std_fname_th'];?>&nbsp;
														<?php echo $row_name1['std_lname_th'];?>
													</div>
                                                     <div class="small text-muted"> ID:
														<?php echo $row_name1['std_id_std'];?> </div>
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
                                           
                                        </tr>
                                        </tbody>
                                        </table>
                                   <!-- รักษาสภาพ -->
							            <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr>
												<th class="text-center w-1"><i class="icon-people"></i></th>
												<th>manage</th>
												<th>STAFF</th>
												<th>Registration</th>
												<th>payment</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
                                          <?php
											foreach ( $result_srfs as $row_srfs ) {
												?>
                                        <tr>
											<td class="text-center">
                                             
												<?php
													
													$sql_name10 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_srfs[doc_std_id]' ";
													$rs_name10 = $mysqli->query( $sql_name10 );
													$row_name10 = $rs_name10->fetch_array();
													?>
												<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
										    </td>
											<td class="text-center">
												<div class="item-action dropdown">
													<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
													<div class="dropdown-menu dropdown-menu-right"> <a href="Staff_Status_Retention_Special_ch.php?doc_id=<?=base64_encode($row_srfs['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>  </div>
										    </td>
											<td>
												<?php                       $staff_grad_approve_disapprove = $row_srfs['staff_grad_approve_disapprove'];
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
													?>
										    </td>
											<td>
												<?php                       $registration_division_status = $row_srfs['registration_division_status'];
			  					if($registration_division_status!=0) {
                           	 	
								if($registration_division_status==0){ ?>
												<button type="button" class="btn btn-warning" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> In Progress </button>
												<?php	}else if($registration_division_status==1) { ?>
												<button type="button" class="btn btn-success" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Approved </button>
												<?php	}else if($registration_division_status==9) { ?>
												<button type="button" class="btn btn-danger" data-container="body" data-toggle="popover" data-placement="left" data-content="<?php if($row_srfs['registration_division_node']==" "){echo "- ";}else{echo $row_srfs['registration_division_node'];} ?>"> Rejected </button>
												<button type="button" class="btn btn-primary on_submit"  data-id="<?=$row_srfs['doc_id'];?>" data-node="<?=$row_srfs['registration_division_node'];?>" data-doctype="1" > Re-Send </button>
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
												<?php                      $payment = $row_cfs['payment'];
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
													?>
										    </td>
											<td>
												<div>
													<?php echo $row_name10['std_fname_th'];?>&nbsp;
													<?php echo $row_name10['std_lname_th'];?>
											    </div>
                                                <div class="small text-muted"> ID:
														<?php echo $row_name10['std_id_std'];?> </div>
												<div class="small text-muted"> Send:
													<?php echo $row_srfs['doc_date'];?> </div>
										    </td>
											<td>
												<?php
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
														} else if ( $doc_type2 == 81 ) {
														
														echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Leave  of Absence  to  Registratoin  ";
														}   else if ( $doc_type2 == 9 ) {
															echo "คำร้องขอเปลี่ยนแผนการเรียน / Request Form to Change Study Program  ";
														}    else if ( $doc_type2 == 13 ) {
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
                                  </table>

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
								dataLayer.push( arguments );
							}
							gtag( 'js', new Date() );
							gtag( 'config', 'UA-125434499-1' );
						</script>
					</div>
				</div>
			</footer>
		<!--</div>-->
</body>

</html>
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	$( ".docID" ).click( function () {
		var doc_id = $( this ).attr( "data-id" );
		var typeid = $( this ).attr( "data-typeid" );
		$( "#show_data" ).html( "<input type='hidden' name='doc_id' value='" + doc_id + "'><input type='hidden' name='type_id' value='" + typeid + "'> " );
	} );
	$(".on_submit").click( function(){
		var doc_id = $( this ).attr( "data-id" );
		var doc_node = $( this ).attr( "data-node" );
		var doc_type = $( this ).attr( "data-doctype" );
		
						$.post( "digital-e-signature/staff_resend.php", {
							doc_id: doc_id,
							doc_node: doc_node,
							doc_type: doc_type

						}, function ( data ) {
							if ( data == 1 ) {
								alert( "Send Data Complete.." );
								window.location.href = 'staff.php';
							} else if ( data == 2 ) {
								alert( "Send Data Error..2" );
							} 
					
							//$("#result").html(data);

						} );
	 });
</script>
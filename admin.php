<?php
session_start();
$SES_USER = $_SESSION[ "SES_USER" ];
$staff_id = $_SESSION[ "SES_STEFF_ID" ];
$_SESSION[ "SES_LEVEL" ];
if ( $_SESSION[ "SES_LEVEL" ] != "admin_ses" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();

if (isset($_POST['submit'])) {
  $keyword	= $_REQUEST['ddlstatus'];
	if ( $keyword == 0 ) {
	
		$request_registration_thesis_is = ' AND request_registration_thesis_is.dean_admin_approve_disapprove=0';
		$request_taking_leave = ' AND request_taking_leave.dean_admin_approve_disapprove=0';
		$request_retaining_student_status = ' AND request_retaining_student_status.dean_admin_approve_disapprove=0';
		$request_student_status_retention = ' AND request_student_status_retention.dean_admin_approve_disapprove=0';
		$request_fee_payment = ' AND request_fee_payment.dean_admin_approve_disapprove=0';
		$request_return_work = ' AND request_return_work.dean_admin_approve_disapprove=0';
		$request_extension_period_study = ' AND request_extension_period_study.dean_admin_approve_disapprove=0';
		$request_withdraw_registration_taking_leave = ' AND request_withdraw_registration_taking_leave.dean_admin_approve_disapprove=0';
		$request_withdraw_taking_leave_registration = ' AND request_withdraw_taking_leave_registration.dean_admin_approve_disapprove=0';
		$request_change_study_program = ' AND request_change_study_program.dean_admin_approve_disapprove=0';
		$request_change_field_study = ' AND request_change_field_study.dean_admin_approve_disapprove=0';
	
	} else if ($keyword== 2){
		
		$request_registration_thesis_is = ' AND request_registration_thesis_is.dean_admin_approve_disapprove=1';
		$request_taking_leave = ' AND request_taking_leave.dean_admin_approve_disapprove=1';
		$request_retaining_student_status = ' AND request_retaining_student_status.dean_admin_approve_disapprove=1';
		$request_student_status_retention = ' AND request_student_status_retention.dean_admin_approve_disapprove=1';
		$request_fee_payment = ' AND request_fee_payment.dean_admin_approve_disapprove=1';
		$request_return_work = ' AND request_return_work.dean_admin_approve_disapprove=1';
		$request_extension_period_study = ' AND request_extension_period_study.dean_admin_approve_disapprove=1';
		$request_withdraw_registration_taking_leave= ' AND request_withdraw_registration_taking_leave.dean_admin_approve_disapprove=1';
		$request_withdraw_taking_leave_registration= ' AND request_withdraw_taking_leave_registration.dean_admin_approve_disapprove=1';
		$request_change_study_program = ' AND request_change_study_program.dean_admin_approve_disapprove=1';
		$request_change_field_study = ' AND request_change_field_study.dean_admin_approve_disapprove=1';
		}
		
		else if ($keyword == 3){
		
		$request_registration_thesis_is = ' AND request_registration_thesis_is.dean_admin_approve_disapprove IN (0,1,2)';
		$request_taking_leave = ' AND request_taking_leave.dean_admin_approve_disapprove IN (0,1,2)';
		$request_retaining_student_status = ' AND request_retaining_student_status.dean_admin_approve_disapprove IN (0,1,2)';
		$request_student_status_retention = ' AND request_student_status_retention.dean_admin_approve_disapprove IN (0,1,2)';
		$request_fee_payment = ' AND request_fee_payment.dean_admin_approve_disapprove IN (0,1,2)';
		$request_return_work = ' AND request_return_work.dean_admin_approve_disapprove IN (0,1,2)';
		$request_extension_period_study = ' AND request_extension_period_study.dean_admin_approve_disapprove IN (0,1,2)';
		$request_withdraw_registration_taking_leave= ' AND request_withdraw_registration_taking_leave.dean_admin_approve_disapprove IN (0,1,2)';
		$request_withdraw_taking_leave_registration= ' AND request_withdraw_taking_leave_registration.dean_admin_approve_disapprove IN (0,1,2)';
		$request_change_study_program= ' AND request_change_study_program.dean_admin_approve_disapprove IN (0,1,2)';
		$request_change_field_study = ' AND request_change_field_study.dean_admin_approve_disapprove IN (0,1,2)';
	
		}
		
	
	 else {
		$request_registration_thesis_is = '';
		$request_taking_leave = '';
		$request_retaining_student_status = '';
		$request_student_status_retention = '';
		$request_fee_payment = '';
		$request_return_work = '';
		$request_extension_period_study = '';
		$request_withdraw_registration_taking_leave = '';
		$request_withdraw_taking_leave_registration = '';
		$request_change_study_program = '';
		$request_change_field_study = '';
		$keyword = '';
	}
	//== ลงทะเบียนเพิ่ม
	  $sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.staff_grad_approve_disapprove=1 $request_registration_thesis_is AND request_registration_thesis_is.dean_admin=$staff_id ";
	$result = $mysqli->query( $sql );
	//== ลาพักการเรียน
	 $sql_tl = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.staff_grad_approve_disapprove=1 $request_taking_leave AND request_taking_leave.dean_admin=$staff_id ";
	$result_tl = $mysqli->query( $sql_tl );
	// == ขอคืนสภาพการเป็นนิสิต
	$sql_rs = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_retaining_student_status.staff_grad_approve_disapprove=1 $request_retaining_student_status AND request_retaining_student_status.dean_admin=$staff_id ";
	$result_rs = $mysqli->query( $sql_rs );
	//== ลงทะเบียนรักษาสภาพนิสิต 
	  $sql_sr = "SELECT * FROM request_doc LEFT JOIN request_student_status_retention ON request_doc.doc_id=request_student_status_retention.doc_id WHERE request_student_status_retention.staff_grad_approve_disapprove=1 $request_student_status_retention AND request_student_status_retention.dean_admin=$staff_id ";
	$result_sr = $mysqli->query( $sql_sr );
	//== ชำระค่าธรรมเนียมการศึกษา  
		  $sql_fp = "SELECT * FROM request_doc LEFT JOIN request_fee_payment ON request_doc.doc_id=request_fee_payment.doc_id WHERE request_fee_payment.staff_grad_approve_disapprove=1 $request_fee_payment AND request_fee_payment.dean_admin=$staff_id ";
	$result_fp = $mysqli->query( $sql_fp );
	//== คำร้องขอกลับเข้ารับราชการ  
		  $sql_rw = "SELECT * FROM request_doc LEFT JOIN request_return_work ON request_doc.doc_id=request_return_work.doc_id WHERE request_return_work.staff_grad_approve_disapprove=1 $request_return_work AND request_return_work.dean_admin=$staff_id ";
	$result_rw = $mysqli->query( $sql_rw );
	//== ขอหนังสือรับรองการขยายเวลาศึกษาต่อ   
		  $sql_eps = "SELECT * FROM request_doc LEFT JOIN request_extension_period_study ON request_doc.doc_id=request_extension_period_study.doc_id WHERE request_extension_period_study.staff_grad_approve_disapprove=1 $request_extension_period_study AND request_extension_period_study.dean_admin=$staff_id ";
	$result_eps = $mysqli->query( $sql_eps );
	//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน   
		  $sql_wrtl = "SELECT * FROM request_doc LEFT JOIN request_withdraw_registration_taking_leave ON request_doc.doc_id=request_withdraw_registration_taking_leave.doc_id WHERE request_withdraw_registration_taking_leave.staff_grad_approve_disapprove=1 $request_withdraw_registration_taking_leave AND request_withdraw_registration_taking_leave.dean_admin=$staff_id ";
	$result_wrtl = $mysqli->query( $sql_wrtl );
	//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน   
		  $sql_wtlr = "SELECT * FROM request_doc LEFT JOIN request_withdraw_taking_leave_registration ON request_doc.doc_id=request_withdraw_taking_leave_registration.doc_id WHERE request_withdraw_taking_leave_registration.staff_grad_approve_disapprove=1 $request_withdraw_taking_leave_registration AND request_withdraw_taking_leave_registration.dean_admin=$staff_id ";
	$result_wtlr = $mysqli->query( $sql_wtlr );
	//== บันทึกภายในองค์กร
	 $sql_pre_in = "SELECT * FROM request_doc LEFT JOIN request_document_in ON request_doc.doc_id=request_document_in.doc_id WHERE dean_admin=$staff_id ";
	$result_per_in = $mysqli->query( $sql_pre_in );
	//== บันทึกภายในองค์กร
		 $sql_ms = "SELECT * FROM request_memorandum_student  WHERE dean_admin=$staff_id ";
	$result_ms = $mysqli->query( $sql_ms );
	//== บันทึกนิสิต ผ่านคณะ
	 $sql_ds = "SELECT * FROM request_doc LEFT JOIN request_document_student ON request_doc.doc_id=request_document_student.doc_id WHERE dean_admin=$staff_id and request_document_student.dean_admin_approve_disapprove=0  ";
	$result_ds = $mysqli->query( $sql_ds );
	//== บันทึกข้อความไม่ต้องผ่านคณะ
	
	 $sql_dsg = "SELECT * FROM request_doc LEFT JOIN request_document_student_grad ON request_doc.doc_id=request_document_student_grad.doc_id WHERE request_document_student_grad.staff_grad_approve_disapprove=1 and request_document_student_grad.dean_admin_approve_disapprove=0 ";
	$result_dsg = $mysqli->query( $sql_dsg );
	//== คำร้องเปลี่ยนแผนการเรียน
	  $sql_csp = "SELECT * FROM request_doc LEFT JOIN request_change_study_program ON request_doc.doc_id=request_change_study_program.doc_id WHERE request_change_study_program.staff_grad_approve_disapprove=1 $request_change_study_program AND request_change_study_program.dean_admin=$staff_id ";
	$result_csp = $mysqli->query( $sql_csp );
	//== คำร้องเปลี่ยนแผนการเรียน
	 $sql_cfs = "SELECT * FROM request_doc LEFT JOIN request_change_field_study ON request_doc.doc_id=request_change_field_study.doc_id WHERE request_change_field_study.staff_grad_approve_disapprove=1 $request_change_field_study AND request_change_field_study.dean_admin=$staff_id ";
	$result_cfs = $mysqli->query( $sql_cfs );
} else {
	$request_registration_thesis_is = ' AND request_registration_thesis_is.dean_admin_approve_disapprove=0';
	$request_taking_leave = ' AND request_taking_leave.dean_admin_approve_disapprove=0';
	$request_retaining_student_status = ' AND request_retaining_student_status.dean_admin_approve_disapprove=0';
	$request_student_status_retention = ' AND request_student_status_retention.dean_admin_approve_disapprove=0';
	$request_fee_payment = ' AND request_fee_payment.dean_admin_approve_disapprove=0';
	$request_return_work = ' AND request_return_work.dean_admin_approve_disapprove=0';
	$request_extension_period_study = ' AND request_extension_period_study.dean_admin_approve_disapprove=0';
	$request_withdraw_registration_taking_leave = ' AND request_withdraw_registration_taking_leave.dean_admin_approve_disapprove=0';
	$request_withdraw_taking_leave_registration = ' AND request_withdraw_taking_leave_registration.dean_admin_approve_disapprove=0';
	$request_change_study_program = ' AND request_change_study_program.dean_admin_approve_disapprove=0';
	$request_change_field_study = ' AND request_change_field_study.dean_admin_approve_disapprove=0';
		//== ลงทะเบียนเพิ่ม
		$sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.staff_grad_approve_disapprove=1 $request_registration_thesis_is AND request_registration_thesis_is.dean_admin=$staff_id ";
		$result = $mysqli->query( $sql );
		//== ลาพักการเรียน
		 $sql_tl = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.staff_grad_approve_disapprove=1 $request_taking_leave AND request_taking_leave.dean_admin=$staff_id ";
		$result_tl = $mysqli->query( $sql_tl );
		// == ขอคืนสภาพการเป็นนิสิต
		$sql_rs = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_retaining_student_status.staff_grad_approve_disapprove=1 $request_retaining_student_status AND request_retaining_student_status.dean_admin=$staff_id ";
		$result_rs = $mysqli->query( $sql_rs );
		//== ลงทะเบียนรักษาสภาพนิสิต 
		  $sql_sr = "SELECT * FROM request_doc LEFT JOIN request_student_status_retention ON request_doc.doc_id=request_student_status_retention.doc_id WHERE request_student_status_retention.staff_grad_approve_disapprove=1 $request_student_status_retention AND request_student_status_retention.dean_admin=$staff_id ";
		$result_sr = $mysqli->query( $sql_sr );
		//== ชำระค่าธรรมเนียมการศึกษา  
			  $sql_fp = "SELECT * FROM request_doc LEFT JOIN request_fee_payment ON request_doc.doc_id=request_fee_payment.doc_id WHERE request_fee_payment.staff_grad_approve_disapprove=1 $request_fee_payment AND request_fee_payment.dean_admin=$staff_id ";
		$result_fp = $mysqli->query( $sql_fp );
		//== คำร้องขอกลับเข้ารับราชการ  
			  $sql_rw = "SELECT * FROM request_doc LEFT JOIN request_return_work ON request_doc.doc_id=request_return_work.doc_id WHERE request_return_work.staff_grad_approve_disapprove=1 $request_return_work AND request_return_work.dean_admin=$staff_id ";
		$result_rw = $mysqli->query( $sql_rw );
		//== ขอหนังสือรับรองการขยายเวลาศึกษาต่อ   
			  $sql_eps = "SELECT * FROM request_doc LEFT JOIN request_extension_period_study ON request_doc.doc_id=request_extension_period_study.doc_id WHERE request_extension_period_study.staff_grad_approve_disapprove=1 $request_extension_period_study AND request_extension_period_study.dean_admin=$staff_id ";
		$result_eps = $mysqli->query( $sql_eps );
		//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน   
			  $sql_wrtl = "SELECT * FROM request_doc LEFT JOIN request_withdraw_registration_taking_leave ON request_doc.doc_id=request_withdraw_registration_taking_leave.doc_id WHERE request_withdraw_registration_taking_leave.staff_grad_approve_disapprove=1 $request_withdraw_registration_taking_leave AND request_withdraw_registration_taking_leave.dean_admin=$staff_id ";
		$result_wrtl = $mysqli->query( $sql_wrtl );
		//== ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน   
			  $sql_wtlr = "SELECT * FROM request_doc LEFT JOIN request_withdraw_taking_leave_registration ON request_doc.doc_id=request_withdraw_taking_leave_registration.doc_id WHERE request_withdraw_taking_leave_registration.staff_grad_approve_disapprove=1 $request_withdraw_taking_leave_registration AND request_withdraw_taking_leave_registration.dean_admin=$staff_id ";
		$result_wtlr = $mysqli->query( $sql_wtlr );
		//== บันทึกภายในองค์กร
		 $sql_pre_in = "SELECT * FROM request_doc LEFT JOIN request_document_in ON request_doc.doc_id=request_document_in.doc_id WHERE dean_admin=$staff_id ";
		$result_per_in = $mysqli->query( $sql_pre_in );
		//== บันทึกภายในองค์กร
			 $sql_ms = "SELECT * FROM request_memorandum_student  WHERE dean_admin=$staff_id ";
		$result_ms = $mysqli->query( $sql_ms );
		//== บันทึกนิสิต ผ่านคณะ
		 $sql_ds = "SELECT * FROM request_doc LEFT JOIN request_document_student ON request_doc.doc_id=request_document_student.doc_id WHERE dean_admin=$staff_id and request_document_student.dean_admin_approve_disapprove=0  ";
		$result_ds = $mysqli->query( $sql_ds );
		//== บันทึกข้อความไม่ต้องผ่านคณะ
		
		 $sql_dsg = "SELECT * FROM request_doc LEFT JOIN request_document_student_grad ON request_doc.doc_id=request_document_student_grad.doc_id WHERE request_document_student_grad.staff_grad_approve_disapprove=1 and request_document_student_grad.dean_admin_approve_disapprove=0 ";
		$result_dsg = $mysqli->query( $sql_dsg );
		//== คำร้องเปลี่ยนแผนการเรียน
		  $sql_csp = "SELECT * FROM request_doc LEFT JOIN request_change_study_program ON request_doc.doc_id=request_change_study_program.doc_id WHERE request_change_study_program.staff_grad_approve_disapprove=1 $request_change_study_program AND request_change_study_program.dean_admin=$staff_id ";
		$result_csp = $mysqli->query( $sql_csp );
		//== คำร้องเปลี่ยนแผนการเรียน
		 $sql_cfs = "SELECT * FROM request_doc LEFT JOIN request_change_field_study ON request_doc.doc_id=request_change_field_study.doc_id WHERE request_change_field_study.staff_grad_approve_disapprove=1 $request_change_field_study AND request_change_field_study.dean_admin=$staff_id ";
		$result_cfs = $mysqli->query( $sql_cfs );

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
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
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
    <!-- Latest compiled and minified CSS -->


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
            <form class="form-inline" action="#" method="post">
              <div class="form-group">
                <label class="sr-only" for="exampleInputEmail3">เลือกสถานะเอกสาร</label>
                                    <select name="ddlstatus" class="form-control">
                                    	<option value="0">In Progress</option>
                                        <option value="2">Approved</option>
                                        <option value="3">ALL</option>
                                    </select>
              </div>
              <button type="submit" name="submit" class="btn btn-default">Search</button>
            </form>
            
                     
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="table-responsive">
                  
                  <div style="margin:5px;">

  <!-- Nav tabs -->
  
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">&nbsp;&nbsp;&nbsp;<a href="#home" aria-controls="home" class="btn btn-primary" role="tab" data-toggle="tab">นิสิต</a></li>&nbsp;&nbsp;&nbsp;
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" class="btn btn-primary" data-toggle="tab">บุคลากร</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"><i class="icon-people"></i> </th>
                          <th>manage</th>
                          <th>Status</th>
                          <th>Student</th>
                          <th>Subject</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						foreach ( $result as $row ) {
							?>
                        <tr>
                          <td class="text-center"><?php
	                         "kkkkkkkkkk";
								 $sql_name = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std =".$row['doc_std_id'];
								$rs_name = $mysqli->query( $sql_name );
								$row_name = $rs_name->fetch_array();
								//echo $row['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Registration_Thesis.php?doc_id=<?=base64_encode($row['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Registration_Thesis_Perview.php?doc_id=<?=base64_encode($row['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
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
						foreach ( $result_tl as $row_tl ) {
							?>
                        <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_tl[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Taking_Leave.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_tl[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_tl[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
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
						<!-- ขอคืนสภาพการเป็นนิสิต -->
						<?php
						foreach ( $result_rs as $row_rs ) {
							?>
                        <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rs[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Retaining_Student_status.php?doc_id=<?=base64_encode($row_rs['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_rs[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_rs[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                          <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
                            <div class="small text-muted"> Send: <?php echo $row_rs['doc_date'];?> </div></td>
                          <td><?php
								$doc_type1 = $row_rs[ 'doc_type' ];
								if ( $doc_type1 == 3 ) {
									echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
								} else if ( $doc_type1 == 1 ) {
									echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
								} else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								?></td>
                        </tr>
                        <?php
						}
						?>
                         <?php
						foreach ( $result_sr as $row_sr ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_sr[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Student_Status_Retention.php?doc_id=<?=base64_encode($row_sr['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_sr[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_sr[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
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
								}
								else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								}
								?></td>
                        </tr>        
                        <?php
						}
						?>
                         <?php
						foreach ( $result_fp as $row_fp ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_fp[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Fee_Payment.php?doc_id=<?=base64_encode($row_fp['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_fp[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_fp[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
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
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_type1 == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								}
								?></td>
                        </tr>        
                        <?php
						}
						?>
                               <?php
						foreach ( $result_rw as $row_rw ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_rw[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Return_Work.php?doc_id=<?=base64_encode($row_rw['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_rw[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_rw[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                          <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
                            <div class="small text-muted"> Send: <?php echo $row_rw['doc_date'];?> </div></td>
                          <td><?php
								$doc_type1 = $row_rw[ 'doc_type' ];
								if ( $doc_type1 == 3 ) {
									echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
								} else if ( $doc_type1 == 1 ) {
									echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_type1 == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								} else if ( $doc_type1 == 12 ) {
										echo "คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work ";
								}
								?></td>
                        </tr>        
                        <?php
						}
						?>
                      <?php
						foreach ( $result_eps as $row_eps ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_eps[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Extension_Period_Study.php?doc_id=<?=base64_encode($row_eps['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_eps[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_eps[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
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
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_type1 == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								}else if ( $doc_type1 == 11 ) {
														echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
								}
								?></td>
                        </tr>        
                        <?php
						}
						?>
                       <?php
						foreach ( $result_wrtl as $row_wrtl ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wrtl[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Withdraw_Registration_Taking_Leave.php?doc_id=<?=base64_encode($row_wrtl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_wrtl[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_wrtl[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                          <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
                            <div class="small text-muted"> Send: <?php echo $row_wrtl['doc_date'];?> </div></td>
                          <td><?php
								echo $doc_type1 = $row_wrtl[ 'doc_type' ];
								if ( $doc_type1 == 3 ) {
									echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
								} else if ( $doc_type1 == 1 ) {
									echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_type1 == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								}else if ( $doc_type1 == 11 ) {
									echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
								} else if ( $doc_type1 == 81 ) {
									echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
								}
								?></td>
                        </tr>        
                        <?php
						}
						?>
                                       <?php
						foreach ( $result_wtlr as $row_wtlr ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Withdraw_Taking_Leave_Registration.php?doc_id=<?=base64_encode($row_wtlr['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_wtlr[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_wtlr[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                          <td><div> <?php echo $row_name1['std_fname_th'];?>&nbsp; <?php echo $row_name1['std_lname_th'];?> </div>
                            <div class="small text-muted"> Send: <?php echo $row_wtlr['doc_date'];?> </div></td>
                          <td><?php
								echo $doc_type1 = $row_wtlr[ 'doc_type' ];
								if ( $doc_type1 == 3 ) {
									echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
								} else if ( $doc_type1 == 1 ) {
									echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_type1 == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_type1 == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								}else if ( $doc_type1 == 11 ) {
									echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
								} else if ( $doc_type1 == 81 ) {
									echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
								} else if ( $doc_type1 == 80 ) {
									echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration";
								} 
								?></td>
                        </tr>        
                        <?php
						}
						?>
                                        <?php
						foreach ( $result_ms as $row_ms ) {
							?>
                             <tr>
                          <td class="text-center"><?php
								/*$sql_name1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_wtlr[doc_std_id]' ";
								$rs_name1 = $mysqli->query( $sql_name1 );
								$row_name1 = $rs_name1->fetch_array();*/
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Memorandum_Student.php?doc_id=<?=base64_encode($row_ms['memorandum_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								$registration_thesis_status = $row_ms[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_ms[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                          <td><div> <?php echo $row_ms['titlename'];?>&nbsp; <?php echo $row_ms['name_surname'];?> </div>
                            <div class="small text-muted">  </div></td>
                          <td><?php
								echo "บันทึกข้อความ (การชำระเงิน/หลักฐาน/รายงานตัวช้า) ";
								?></td>
                        </tr>        
                        <?php
						}
						?>
                         <?php
						foreach ( $result_ds as $row_ds ) {
							?>
                              <tr>
                                <td class="text-center"><?php
								$sql_nameds = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_ds[doc_std_id]' ";
								$rs_nameds = $mysqli->query( $sql_nameds );
								$row_nameds = $rs_nameds->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                                  <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                                <td class="text-center"><div class="item-action dropdown">
                                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                                  <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Document_Student.php?doc_id=<?=base64_encode($row_ds['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                                  </div></td>
                                <td><?php
								$registration_thesis_status = $row_ds[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_ds[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                                <td><div> <?php echo $row_nameds['std_fname_th'];?>&nbsp; <?php echo $row_nameds['std_lname_th'];?> </div>
                                  <div class="small text-muted"> Send: <?php echo $row_ds['doc_date'];?> </div></td>
                                <td><?php
								 $doc_typeds = $row_ds[ 'doc_type' ];
								if ( $doc_typeds == 3 ) {
									echo "คำร้องขอลงทะเบียน Thesis/Request Form for Registration for for Thesis/IS";
								} else if ( $doc_typeds == 1 ) {
									echo "คำร้องขอลาพักการเรียน/Request Form for Taking a Leave";
								}else if ( $doc_type1 == 31 ) {
									echo "คำร้องขอคืนสภาพการเป็นนิสิต/Request Form Ratainting Student Status";
								}
								else if ( $doc_typeds == 4 ) {
									echo "คำร้องขอลงทะเบียนรักษาสภาพนิสิต /Student Status Retention Form ";
								} else if ( $doc_typeds == 15 ) {
										echo "คำร้องชำระค่าธรรมเนียมการศึกษา  /Request Form for Fee Payment  ";
								}else if ( $doc_typeds == 11 ) {
									echo "คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ  / Request Form for Extension Period of Study ";
								} else if ( $doc_typeds == 81 ) {
									echo "ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน  /Request Form for Withdrawal of Registratoin  to  Absence  ";
								} else if ( $doc_typeds == 80 ) {
									echo "ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน  / Request Form for Withdrawal of Leave of Absence to Registration";
								} else if ( $doc_typeds == 70 ) {
									echo "บันทึกข้อความ";
								} 
								?></td>
                              </tr>
                              <?php
						}
						?>
                         <?php
						foreach ( $result_dsg as $row_dsg ) {
							?>
                        <tr>
                          <td class="text-center"><?php
								$sql_nameds1 = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_dsg[doc_std_id]' ";
								$rs_nameds1 = $mysqli->query( $sql_nameds1 );
								$row_nameds = $rs_nameds1->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Document_Student_Grad.php?doc_id=<?=base64_encode($row_dsg['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Registration_Thesis_Perview.php?doc_id=<?=base64_encode($row['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								
								 $dean_admin_approve_disapprove = $row_dsg[ 'dean_admin_approve_disapprove' ];
								

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								
								?></td>
                          <td><div> <?php echo $row_nameds['std_fname_th'];?>&nbsp; <?php echo $row_nameds['std_lname_th'];?>  </div>
                            <div class="small text-muted"> Send: <?php echo $row_dsg['doc_date'];?> </div></td>
                          <td><?php
								
									echo "บันทึกข้อความ";
							 
								?></td>
                        </tr>
                        <?php
						}
						?>
                        <?php
						foreach ( $result_csp as $row_csp ) {
							?>
                              <tr>
                                <td class="text-center"><?php
								$sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_csp[doc_std_id]' ";
								$rs_name_csp = $mysqli->query( $sql_name_csp );
								$row_name_csp = $rs_name_csp->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                                  <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                                <td class="text-center"><div class="item-action dropdown">
                                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                                  <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Change_Study_Program.php?doc_id=<?=base64_encode($row_csp['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                                  </div></td>
                                <td><?php
								$registration_thesis_status = $row_csp[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_csp[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                                <td><div> <?php echo $row_name_csp['std_fname_th'];?>&nbsp; <?php echo $row_name_csp['std_lname_th'];?> </div>
                                  <div class="small text-muted"> Send: <?php echo $row_csp['doc_date'];?> </div></td>
                                <td><?php
							
									echo "คำร้องเปลี่ยนแผนการเรียน";
								
								?>
								<?php echo $row_csp['doc_id'];?>
								</td>
                              </tr>
                              <?php
						}
						?>
                         <?php
						foreach ( $result_cfs as $row_cfs ) {
							?>
                              <tr>
                                <td class="text-center"><?php
								$sql_name_csp = "Select std_id_std,std_fname_th,std_lname_th FROM request_student WHERE std_id_std = '$row_cfs[doc_std_id]' ";
								$rs_name_csp = $mysqli->query( $sql_name_csp );
								$row_name_csp = $rs_name_csp->fetch_array();
								//echo $row_tl['doc_id'];
								?>
                                  <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                                <td class="text-center"><div class="item-action dropdown">
                                  <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                                  <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Form_Change_Field_Study.php?doc_id=<?=base64_encode($row_cfs['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <?php /*?><a href="Request_Form_Taking_Leave_Perview.php?doc_id=<?=base64_encode($row_tl['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                                  </div></td>
                                <td><?php
								$registration_thesis_status = $row_cfs[ 'staff_grad_approve_disapprove' ];
								$dean_admin_approve_disapprove = $row_cfs[ 'dean_admin_approve_disapprove' ];
								if ( $registration_thesis_status == 1 ) {

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								} else {
									echo "<span class='text text-default'>None</span>";
								}
								?></td>
                                <td><div> <?php echo $row_name_csp['std_fname_th'];?>&nbsp; <?php echo $row_name_csp['std_lname_th'];?> </div>
                                  <div class="small text-muted"> Send: <?php echo $row_cfs['doc_date'];?> </div></td>
                                <td><?php
							
									echo "คำร้องเปลี่ยนสาขาวิชา";
								
								?></td>
                              </tr>
                              <?php
						}
						?>
                      </tbody>
                    </table>
            
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                      <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"><i class="icon-people"></i> </th>
                          <th>manage</th>
                          <th>Status</th>
                          <th>Student</th>
                          <th>Subject</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
						foreach ( $result_per_in as $row_per_in ) {
							?>
                        <tr>
                          <td class="text-center"><?php
								 $sql_name = "SELECT staff_name FROM request_staff WHERE staff_id='$row_per_in[staff_id]' ";
			                    $rs_name = $mysqli->query( $sql_name );
								$row_name = $rs_name->fetch_array();
								//echo $row['doc_id'];
								?>
                            <div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div></td>
                          <td class="text-center"><div class="item-action dropdown">
                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
                            <div class="dropdown-menu dropdown-menu-right"> <a href="Admin_Form_Document_in.php?doc_id=<?=base64_encode($row_per_in['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                              <?php /*?><a href="Request_Form_Registration_Thesis_Perview.php?doc_id=<?=base64_encode($row['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-file"></i> Perview </a>
										<?php */?>
                            </div></td>
                          <td><?php
								
								 $dean_admin_approve_disapprove = $row_per_in[ 'dean_admin_approve_disapprove' ];
								

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								
								?></td>
                          <td><div> <?php echo $row_name['staff_name'];?>&nbsp;  </div>
                            <div class="small text-muted"> Send: <?php echo $row_per_in['doc_date'];?> </div></td>
                          <td><?php
								$doc_type = $row_per_in[ 'doc_type' ];
								if ( $doc_type == 83 ) {
									echo "บันทึกข้อความ";
								} 
								?></td>
                        </tr>
                        <?php
						}
						?>
                      </tbody>
                    </table>
                    
                    </div>
                      </div>

                    </div>
<!--Tab -->
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
						<li><a href="#">First link</a>
						</li>
						<li><a href="#">Second link</a>
						</li>
					</ul>
				</div>
				<div class="col-6 col-md-3">
					<ul class="list-unstyled mb-0">
						<li><a href="#">Third link</a>
						</li>
						<li><a href="#">Fourth link</a>
						</li>
					</ul>
				</div>
				<div class="col-6 col-md-3">
					<ul class="list-unstyled mb-0">
						<li><a href="#">Fifth link</a>
						</li>
						<li><a href="#">Sixth link</a>
						</li>
					</ul>
				</div>
				<div class="col-6 col-md-3">
					<ul class="list-unstyled mb-0">
						<li><a href="#">Other link</a>
						</li>
						<li><a href="#">Last link</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-lg-4 mt-4 mt-lg-0">
			Premium and Open Source dashboard template with responsive and high quality UI. For Free!
		</div>
	</div>
</div> <
      /div>-->
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
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-125434499-1');
</script> 
          </div>
        </div>
      </footer>
    </div>
</body>
</html>

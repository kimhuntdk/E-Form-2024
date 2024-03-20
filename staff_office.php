<?php
session_start();
$SES_USER = $_SESSION[ "SES_USER" ];
$fac_id = $_SESSION["SES_fAC"];
if ( $_SESSION[ "SES_LEVEL" ] != "office" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();

//== ขอหนังสือแต่งตั้งชื่อเรื่อง
 $sql_aa = "SELECT * FROM request_doc INNER JOIN request_appointment_advisor ON request_doc.doc_id=request_appointment_advisor.doc_id INNER JOIN request_student ON request_appointment_advisor.std_code=request_student.std_id_std WHERE request_student.std_faculty_id=" . $fac_id;
$result_aa = $mysqli->query( $sql_aa );
//== ขอหนังสือแต่งตั้งคณะกรรมการสอบโครงร่าง
 $sql_pe = "SELECT * FROM request_doc INNER JOIN request_proposal_examination ON request_doc.doc_id=request_proposal_examination.doc_id INNER JOIN request_student ON request_proposal_examination.std_code=request_student.std_id_std WHERE request_student.std_faculty_id=" . $fac_id;
$result_pe = $mysqli->query( $sql_pe );
//== ขอหนังสือแต่งตั้งคณะกรรมการสอบวิทยานิพนธ์

 $sql_te = "SELECT * FROM request_doc INNER JOIN request_thesis_examination ON request_doc.doc_id=request_thesis_examination.doc_id INNER JOIN request_student ON request_thesis_examination.std_code=request_student.std_id_std WHERE request_student.std_faculty_id=" . $fac_id;
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
												<th>Download</th>
												<th>Advisor</th>
												<th>Student</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
						
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
														<div class="dropdown-menu dropdown-menu-right"> <a href="export_title_ts.php?doc_id=<?=base64_encode($row_aa['doc_id']);?>" class="dropdown-item" target="_blank"><i class="dropdown-icon fe fe-tag"></i> Action </a>
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
                                                    <div class="small text-muted"> ID:
														<?php echo $row_aa['std_code'];?> </div>
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
														<div class="dropdown-menu dropdown-menu-right"> <a href="export_proposal_examination.php?doc_id=<?=base64_encode($row_pe['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
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
                                                     <div class="small text-muted"> ID:
														<?php echo $row_pe['std_code'];?> </div>
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
														<div class="dropdown-menu dropdown-menu-right"> <a href="export_thesis_examination.php?doc_id=<?=base64_encode($row_te['doc_id']);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
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
                                                    <div class="small text-muted"> ID:
														<?php echo $row_te['std_code'];?> </div>
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

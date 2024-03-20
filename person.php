<?php
session_start();
$SES_USER = $_SESSION[ "SES_USER" ];
$staff_id=$_SESSION["SES_ID"];
if ( $_SESSION[ "SES_LEVEL" ] != "person_ses" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();
//== ตรวจสอบว่า
$sql = "SELECT * FROM request_doc LEFT JOIN request_document_in ON request_doc.doc_id=request_document_in.doc_id WHERE request_document_in.staff_id=$staff_id";
$result = $mysqli->query( $sql );
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
												<th class="text-center w-1"><i class="icon-people"></i>
												</th>
												<th>manage</th>
												<th>board</th>
												<th>person</th>
												<th>Subject</th>
											</tr>
										</thead>
										<tbody>
                                          <?php
											foreach ( $result as $row ) {
												?>
                                        <tr>
											<td class="text-center">
                                             
								<?php
								 $sql_name = "SELECT staff_name FROM request_staff WHERE staff_id='$row[staff_id]' ";
			                    $rs_name = $mysqli->query( $sql_name );
								$row_name = $rs_name->fetch_array();
								//echo $row[doc_id];
								?>
												<div class="avatar d-block" style="background-image: url(images/user.jpg)"> <span class="avatar-status bg-green"></span> </div>
										    </td>
											<td class="text-center">
												<div class="item-action dropdown">
													<a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-settings"></i></a>
													<div class="dropdown-menu dropdown-menu-right"> <a href="Preson_Form_Document_in.php?doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>  <a href="word.php?doc_id=<?=base64_encode($row[doc_id]);?>" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Export Word </a>
												   
										    </td>
											<td>
												<?php
								
								 $dean_admin_approve_disapprove = $row[ 'dean_admin_approve_disapprove' ];
								

									if ( $dean_admin_approve_disapprove == 0 ) {
										echo "<span class='text text-warning'>In Progress</span>";
									} else if ( $dean_admin_approve_disapprove == 1 ) {
										echo "<span class='text text-success'>Approved</span>";
									} else if ( $dean_admin_approve_disapprove == 2 ) {
										echo "<span class='text text-danger'>Rejected</span>";
									}
								
								?>
										    </td>
											<td>
												<div>
													<?php echo $row_name['staff_name'];?>&nbsp; 
											    </div>
												<div class="small text-muted"> Send:
													<?php echo $row['doc_date'];?> </div>
										    </td>
											<td>
												<?php
								$doc_type = $row[ 'doc_type' ];
								if ( $doc_type == 83 ) {
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
		</div>
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
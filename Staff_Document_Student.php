<?php
session_start();
$SES_LEVEL = $_SESSION[ "SES_LEVEL" ];
$doc_id = base64_decode( $_REQUEST[ doc_id ] );
if ( $$SES_LEVEL == "staff_ses" || $_SESSION[ "SES_USER" ] == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();
//=========แสดงข้อมูลนิสิตที่ยื่นเอกสาร======================
$sql = "SELECT * FROM request_doc LEFT JOIN request_document_student ON request_doc.doc_id=request_document_student.doc_id WHERE request_doc.doc_id=" . $doc_id;
$result = $mysqli->query( $sql );
$row = $result->fetch_array();
$staff_grad_approve_disapprove = $row[ 'staff_grad_approve_disapprove' ];
//=========แสดงข้อมูลนิสิต======================
$sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th,std_faculty_id FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
$rs_name = $mysqli->query( $sql_name );
$row_name = $rs_name->fetch_array();
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
            <div class="row row-cards row-deck">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">บันทึกข้อความ  (Graduate Student)</h3>
                  </div>
                  <div class="card-body">
                    <div class="col-md-12 col-xl-12">
                      <div class="card">
                        <div class="card-status bg-yellow"></div>
                        <div class="card-header">
                          <h3 class="card-title">ข้อมูลนิสิต</h3>
                          <div class="card-options"> <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a> <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> </div>
                        </div>
                        <div class="card-body">
                          <div id="show_loading" align="center"></div>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                              <tr>
                                <td><b>ชื่อ</b> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?>&nbsp;&nbsp;<b>รหัสประจำตัวนิสิต</b>&nbsp; <?php echo $row_name['std_id_std'];?>&nbsp; <?php echo $row_name['std_degree_th'];?> &nbsp; <?php echo $row_name['std_faculty_th'];?> &nbsp;<b>สาขา</b> <?php echo $row_name['std_major_th'];?></td>
                              </tr>
                              <tr>
                                <td></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <form action="Javascript:void(0);" method="post" id="frm_add_change_study_program" class="frm_add_change_study_program">
                             <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2">ส่วนราชการ<span class="form-required">*</span></label>
                          <div class="col-sm-10">
                            <?=$row['government'];?>
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
                            <?=$row['subject'];?>
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
                            <?=$row['node'];?>
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
                          <label class="col-sm-3">ลงชื่อ/ signature และ ผู้ยื่นคำร้อง/ Applicant<span class="form-required">*</span></label>
                          <div class="col-sm-9"> <img src="digital-e-signature/doc_signs/<?=$row['std_signature'];?>.png"> <?php echo $row_name['std_fname_th'];?>&nbsp; <?php echo $row_name['std_lname_th'];?> </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-3">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์
                            (Advisor/Chairman of Thesis) <span class="form-required">*</span></label>
                          <div class="col-sm-9">
                            <p>
                              <?=$row['advisor_chairman_node'];?>
                            </p>
                            <img src="digital-e-signature/doc_signs/<?=$row['advisor_chairman_signature'];?>.png">
                            <?php

									 $sql_advisor = "Select prefixname,advisorname,advisorsurname FROM request_advisor WHERE advisorcode = '$row[advisor_chairman]' ";
									 $rs_advisor = $mysqli->query($sql_advisor);
									  $row_advisor = $rs_advisor->fetch_array();
										echo $row_advisor['prefixname'].$row_advisor['advisorname']." ".$row_advisor['advisorsurname'];
										echo $row[advisor_chairman];
										if($row_advisor['advisorname']==""){
												$url = "http://202.28.34.2/webservice/JsonOfficergardtostudent.php?officercode=" . $row[advisor_chairman];
												$contents = file_get_contents($url); 
												$contents = utf8_encode($contents); 
												$results = json_decode($contents); 
												foreach ($results as $key => $value) { 
												foreach ($value as $k => $v) { 
													if ( $k == "officercode" ) 
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
										}
										}
									  ?>
                          </div>
                        </div>
                      </div>
                                    	<div class="form-group">
                                
                              <label class="col-sm-6">สถานะ(อาจารย์ที่ปรึกษา/ประธานหลักสูตร/คณบดีที่สังกัด)<span class="form-required">*</span></label>
                        
                        			<div class="form-group col-sm-9">
                                      
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="1" <?php if($row['advisor_chairman_dean_status']=="1") { echo "checked"; } ?> >
                <span class="custom-control-label">อาจารย์ที่ปรึกษา</label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="2" <?php if($row['advisor_chairman_dean_status']=="2") { echo "checked"; } ?>>
                <span class="custom-control-label">ประธานหลักสูตร</span> </label>
											
												<label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_dean_status" id="advisor_chairman_dean_status" value="3" <?php if($row['advisor_chairman_dean_status']=="3") { echo "checked"; } ?>>
                <span class="custom-control-label">คณบดีที่สังกัด</span> </label>
											
											</div>
										</div>
                                        </div>
                      <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2 form-label">พิจารณาคำร้อง<span class="form-required">*</span></label>
                          <div class="col-sm-10">
                            <label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"    id="staff_grad_approve_disapprove" value="1" <?php if($row['staff_grad_approve_disapprove']=="1") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                              <span class="custom-control-label">เสนอเรื่องเพื่อพิจารณา</span> </label>
                            <?php /*?> <label class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"   id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>  >
                  <span class="custom-control-label">แบบฟอร์ไม่ถูกต้อง</span> </label>
												

													<?php */?>
                            <label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"  id="staff_grad_approve_disapprove" value="2" <?php if($row['staff_grad_approve_disapprove']=="2") { echo "checked"; } ?>  <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?> >
                              <span class="custom-control-label">ส่งคืนนิสิต</span>(มีแก้ไข) </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label">ส่งเรื่องให้ผู้บริหาร<span class="form-required">*</span></label>
                        <select class="custom-select" id="dean_admin" name="dean_admin" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>
                          <option value="0"  <?php if($row[dean_admin] ==0) { echo "selected";}?> >เลือกผู้บริการ</option>
                          <option value="2" <?php if($row[dean_admin] ==2) { echo "selected";}?>>คณบดีบัณฑิตวิทยาลัย</option>
                          <option value="3" <?php if($row[dean_admin] ==3) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัย ฝ่ายบริหาร</option>
                          <option value="4" <?php if($row[dean_admin] ==4) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัย ฝ่ายวิชาการ </option>
                          <option value="5" <?php if($row[dean_admin] ==5) { echo "selected";}?>>รองคณบดีบัณฑิตวิทยาลัยฝ่ายประกันคุณภาพการศึกษาและกิจการพิเศษ</option>
                        </select>
                      </div>
                          <div class="form-group">
                        <div class="row align-items-center">
                          <label class="col-sm-2">เหตุผล</label>
                          <div class="col-sm-10">
                            <textarea name="argument" id="argument" class="form-control" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>><?php echo $row['staff_grad_node'];?></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row align-items-center">
                         
                          <img src="singnager_p.png"><br>
                            <label class="col-sm-2">นางศรินทร์ยา เกียงขวา</label>
                           <label class="col-sm-2">หัวหน้ากลุ่มงานบริหาร</label>
                        </div>
                      </div>
                      <div class="btn-list mt-4 text-left">
                        <input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>">
                        <input type="hidden" name="Save_Staff_document_student" value="Save_Staff_document_student">
                        <button type="submit" id="btnSaveSign" class="btn btn-primary btn-space" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>Save Data</button>
                        <button type="button" class="btn btn-secondary btn-space" <?php if($staff_grad_approve_disapprove !=0) { echo "disabled";}?>>Cancel</button>
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
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	$( document ).ready( function () {
		$( "#btnSaveSign" ).click( function () { //ส่งค่าไป Update คำร้อง
			var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
			var Save_Staff_Thesis = $( "#Save_Staff_Thesis" ).val();
			var argument_a = $( "#argument_a" ).val();

			if ( staff_grad_approve_disapprove === "1" ) {
				var dean_admin = $( "#dean_admin" ).val();
				if ( dean_admin === "0" ) {
					alert( "กรุณาเลือกผู้บริหาร เพื่อพิจารณาเรื่อง" );
					$( "#dean_admin" ).focus();
					return false;
				} else {
					$( "#show_loading" ).html( "<img src='images/loading.gif' width='100' height='100'>" );
					$( "#btnSaveSign" ).attr( 'disabled', 'disabled' );
					$.post(
						"save_document_student.php",
						$( "#frm_add_change_study_program" ).serializeArray(),
						function ( data ) {
							//alert(data);
							if ( data === "1" ) {
								alert( "Send Data Complete.." );
								window.location.href = 'staff.php';
							} else if ( data === "2" ) {
								alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง1" );
								window.location.href = 'staff.php';
							} else {
								alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
								window.location.href = 'staff.php';

							}
							$( "#show_loading" ).empty();
							$( "#btnSaveSign" ).removeAttr( 'disabled' );
						}
					);
				}
			} else if ( staff_grad_approve_disapprove === "2" || staff_grad_approve_disapprove === "3" ) {
				$( "#show_loading" ).html( "<img src='images/loading.gif' width='100' height='100'>" );
				$( "#btnSaveSign" ).attr( 'disabled', 'disabled' );
				$.post(
					"save_document_student.php",
					$( "#frm_add_change_study_program" ).serializeArray(),
					function ( data ) {
						//alert(data);
						if ( data === "1" ) {
							alert( "Send Data Complete.." );
							window.location.href = 'staff.php';
						} else if ( data === "2" ) {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';
						} else {
							alert( "ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง" );
							window.location.href = 'staff.php';

						}
						$( "#show_loading" ).empty();
						$( "#btnSaveSign" ).removeAttr( 'disabled' );

					}
				);
			}
		} );
		$( ".staff_grad_approve_disapprove" ).click( function () { //ตรวจสอบก่อนว่าส่งพิจารณาค่อยมีเลือกผู้บริหารแสดงออกมา
			var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
			if ( staff_grad_approve_disapprove == 1 ) {
				$( "#dean_admin" ).removeAttr( 'disabled' );
			} else {
				$( "#dean_admin" ).attr( 'disabled', 'disabled' );
				$( "#dean_admin" ).val( 0 );
			}

		} );
	} );
</script>
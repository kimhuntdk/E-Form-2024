<?php
session_start();
$id = $_SESSION['SES_ID'];
$doc_id = base64_decode($_REQUEST['doc_id']);
if ($id == "" || $_SESSION["SES_USER"] == "") {
  echo "<script>window.location.href = 'logout.php'</script>";
}
require_once("inc/db_connect.php");
$mysqli = connect();
//=========แสดงข้อมูลนิสิตที่ยื่นเอกสาร======================
$sql = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_doc.doc_id=" . $doc_id;
$result = $mysqli->query($sql);
$row = $result->fetch_array();
$advisor_chairman_status = $row['advisor_chairman_status'];
//=========แสดงข้อมูลนิสิต======================
$sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
$rs_name = $mysqli->query($sql_name);
$row_name = $rs_name->fetch_array();

// แสดงข้อมูล ภาคการศึกษาที่ต้องการลาพัก
$sql_a = "SELECT * FROM request_retaining_student_status_academic WHERE retaining_student_id = $row[retaining_student_id]";
$result = $mysqli->query($sql_a);

// ดึงข้อมูลความประสงค์ของภาคเรียนปัจจุบัน
$sql_cs = "SELECT * FROM request_retaining_student_status_current_semester WHERE retaining_student_id = $row[retaining_student_id]";
$result_cs = $mysqli->query($sql_cs);
$row_cs = $result_cs->fetch_array();

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
          <div class="row row-cards row-deck">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Request Form Ratainting Student Status</h3>
                </div>
                <div class="card-body">
                  <div id="show_loading" align="center"></div>
                  <div class="col-md-12 col-xl-12">
                    <div class="card">
                      <div class="card-status bg-yellow"></div>
                      <div class="card-header">
                        <h3 class="card-title">ข้อมูลนิสิต</h3>
                        <div class="card-options"> <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a> <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a> </div>
                      </div>
                      <div class="card-body">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tbody>
                            <tr>
                              <td><b>ชื่อ</b> <?php echo $row_name['std_fname_th']; ?>&nbsp; <?php echo $row_name['std_lname_th']; ?>&nbsp;&nbsp;<b>รหัสประจำตัวนิสิต</b>&nbsp; <?php echo $row_name['std_id_std']; ?>&nbsp; <?php echo $row_name['std_degree_th']; ?> &nbsp; <?php echo $row_name['std_faculty_th']; ?> &nbsp;<b>สาขา</b> <?php echo $row_name['std_major_th']; ?></td>
                            </tr>
                            <tr>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <form action="Javascript:void(0);" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">
                    <div class="form-group">
                      <div class="form-group col-sm-12">
                        <div class="row align-items-center">
                          <label>พ้นสภาพนิสิตเนื่องจาก/ because <span class="form-required">*</span></label>
                          <?php if ($row['because'] == "ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต") { ?>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" readonly value="<?php echo 'ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต'; ?>">
                            </div>
                          <?php } else { ?>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" readonly value="<?php echo 'ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลามหาลัยกำหนด(ไม่ได้ชำระเงินภายในเวลาที่กำหนด)'; ?>">
                            </div>
                          <?php } ?>
                          <?php if ($row['because'] == "ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต") { ?>
                            <div class=" col-sm-4">
                              <div class="row">
                                <label>คือภาคเรียนที่ <span class="form-required">*</span></label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" readonly value="<?php echo $row['pay_semester'] ?>">
                                </div>
                              </div>
                            </div>
                        </div>
                      <?php  }  ?>
                      </div>
                    </div>
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
                                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" <?php if ($row['semester'] == "1") {
                                                                                                                            echo "checked";
                                                                                                                          } ?> disabled>
                                <span class="custom-control-label">ภาคต้น/1<sup>st</sup> semester</span>
                              </label>
                              <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2" <?php if ($row['semester'] == "2") {
                                                                                                                            echo "checked";
                                                                                                                          } ?> disabled>
                                <span class="custom-control-label">ภาคปลาย/2<sup>nd</sup> semester </span>
                              </label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label">ปีการศึกษา/Academic year</label>
                            <input type="text" class="form-control" readonly value="<?php echo $row['academic'] ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row align-items-center">
                      <label class="col-sm-12">ขอลาพักการเรียนที่พ้นสภาพจนถึง/ Would like to take a leave of absence i the <span class="form-required">*</span> </label>
                    </div>
                    <div class="form-group col-sm-12" id="retain">
                      <div class="custom-controls-stacked">
                        <?php while ($rs_a = $result->fetch_array()) {
                        ?>
                          <div class="row">
                            <div class="col-md-4">
                              <label class="form-label">ภาคเรียน/semester</label>
                              <input class="form-control" type="text" readonly value="<?php echo $rs_a['semester_a'] ?>">
                            </div>
                            <div class="col-md-4">
                              <label class="form-label">ปีการศึกษา/Academic year</label>
                              <input class="form-control" type="text" readonly value="<?php echo $rs_a['academic_a'] ?>">
                            </div>
                            <!-- <div class="col-md-2">
														<label class="form-label"><br></label>
														<button type="button" class="btn btn-primary" onclick="addJournalEntry()">เพิ่มช่อง</button>
													</div> -->
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group col-sm-12">
                      <div class="row align-items-center">
                      <label>และในภาคเรียนปัจจุบัน/ and in the current semester <span class="form-required">*</span> </label>
                        <div class="col-md-6">
                          <input class="form-control" type="text" readonly value=" <?php if ($row_cs['doc_type_id'] == 1) {
                                                                                      echo 'มีความประสงค์ขอลาพักการเรียน/ Would like to take a leave';
                                                                                    } else if ($row_cs['doc_type_id'] == 3) {
                                                                                      echo 'มีความประสงค์ขอลงทะเบียน/ would like to register';
                                                                                    }
                                                                                    ?>">
                        </div>
                      </div>
                    </div>

                    <?php if ($row_cs['doc_type_id'] == 3) { ?>
                      <!-- ส่วนเนื้อหาของลงทะเบียนเรียน -->
                      <div class="form-group" id="thesis">
                        <div class="form-group col-sm-9">
                          <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" name="type_thesis" id="type_thesis" value="Thesis" <?php if ($row_cs['status_thesis_is'] == "Thesis") {
                                                                                                                                    echo "checked";
                                                                                                                                  } ?> disabled>
                              <span class="custom-control-label">Thesis</span> </label>
                            <label class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" name="type_thesis" id="type_thesis" value="IS" <?php if ($row_cs['status_thesis_is'] == "is") {
                                                                                                                                echo "checked";
                                                                                                                              } ?> disabled>
                              <span class="custom-control-label">IS</span> </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <label class="form-label">ภาคเรียน/semester</label>
                              <input class="form-control" type="text" name="semester_cs" readonly rows="7" value="<?php echo $row_cs['semester'] ?>">
                            </div>
                            <div class="col-md-4">
                              <label class="form-label">ปีการศึกษา/Academic year</label>
                              <input id="group" class="form-control" type="text" name="academic_cs" readonly rows="7" value="<?php echo $row_cs['academic'] ?>">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row align-items-right">
                            <label class="col-sm-2 align-items-right">รหัสวิชา/ subject code<span class="form-required">*</span></label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" placeholder="รหัสวิชา" id="subject_code" name="subject code" readonly value="<?php echo $row_cs['subject_code'] ?>">
                            </div>
                            <label class="col-sm-2 align-items-right">กลุ่ม/ group code<span class="form-required">*</span></label>
                            <div class="col-sm-2">
                              <!--<input type="number" id="group" name="group" min="1" max="100" value="0" class="form-control" required>-->
                              <input type="text" class="form-control" readonly value="<?php echo $row_cs['group_id'] ?>">

                            </div>
                            <label class="col-sm-4">การระบุกลุ่มเรียน /อาจารย์ประจำกลุ่ม (ตรวจสอบจากตารางเรียนที่เปิดสอนของแต่ละภาคการศึกษาหรือติดต่อเจ้าหน้าที่คณะที่สังกัด)</label>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="row align-items-right">
                            <label class="col-sm-2 align-items-right">เพิ่มอีก (more) <span class="form-required">*</span></label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" placeholder="จำนวนหน่วยกิต" id="credits" name="credits" readonly value="<?php echo $row_cs['credits'] ?>">
                            </div>
                            <label class="col-sm-2">หน่วยกิต (credits)</label>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="row align-items-center">
                            <label class="col-sm-2">เนื่องจาก/ because <span class="form-required">*</span></label>
                            <div class="col-sm-4">
                              <!--<input type="text" class="form-control" id="because" name="because">-->
                              <input type="text" class="form-control" readonly value="<?php if ($row_cs['because'] == 'สอบเค้าโครง') {
                                                                                        echo 'สอบเค้าโครง';
                                                                                      } else if ($row_cs['because'] == 'รายงานความก้าวหน้า') {
                                                                                        echo 'รายงานความก้าวหน้า';
                                                                                      } else if ($row_cs['because'] == 'สอบจบ') {
                                                                                        echo 'สอบจบ';
                                                                                      } ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } else if ($row_cs['doc_type_id'] == 1) { ?>

                      <!-- ส่วนแสดงข้อมูลลาพักเทอมปัจจุบัน -->
                      <div id="TakeLeave">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-4">
                              <label class="form-label">ภาคเรียน/semester</label>
                              <input class="form-control" type="text" name="semester_cs" readonly rows="7" value="<?php echo $row_cs['semester'] ?>">
                            </div>
                            <div class="col-md-4">
                              <label class="form-label">ปีการศึกษา/Academic year</label>
                              <input id="group" class="form-control" type="text" name="academic_cs" readonly rows="7" value="<?php echo $row_cs['academic'] ?>">
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                    <div class="form-group">
                      <div class="row align-items-center">
                        <label class="col-sm-3">ลงชื่อ/ signature และ ผู้ยื่นคำร้อง/ Applicant<span class="form-required">*</span></label>
                        <div class="col-sm-9"> <img src="digital-e-signature/doc_signs/<?= $row['std_signature']; ?>.png"> <?php echo $row_name['std_fname_th']; ?>&nbsp; <?php echo $row_name['std_lname_th']; ?> </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row align-items-center">
                        <label class="col-sm-2">พิจารณาคำร้อง<span class="form-required">*</span></label>
                        <div class="col-sm-10">
                          <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="advisor_chairman_status" <?php if ($row['advisor_chairman_status'] == "1") {
                                                                                                              echo "checked";
                                                                                                            } ?> id="advisor_chairman_status" value="1" <?php if ($advisor_chairman_status != 0) {
                                                                                                                                                          echo "disabled";
                                                                                                                                                        } ?>>
                            <span class="custom-control-label">อนุมัติ</span> </label>
                          <label class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" name="advisor_chairman_status" <?php if ($row['advisor_chairman_status'] == "2") {
                                                                                                              echo "checked";
                                                                                                            } ?> id="advisor_chairman_status" value="2" <?php if ($advisor_chairman_status != 0) {
                                                                                                                                                          echo "disabled";
                                                                                                                                                        } ?>>
                            <span class="custom-control-label">ไม่อนุมัติ</span> </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row align-items-center">
                        <label class="col-sm-2">เหตุผล<span class="form-required">*</span></label>
                        <div class="col-sm-10">
                          <textarea name="argument" id="argument" class="form-control" placeholder="ความคิดเห็นอาจารย์" <?php if ($advisor_chairman_status != 0) {
                                                                                                                          echo "disabled";
                                                                                                                        } ?>><?php echo $row['advisor_chairman_node']; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <?php

                    $sql_advisor = "Select prefixname,advisorname,advisorsurname FROM request_advisor WHERE advisorcode = '$row[advisor_chairman]' ";
                    $rs_advisor = $mysqli->query($sql_advisor);
                    $row_advisor = $rs_advisor->fetch_array();

                    ?>
                    <div class="form-group">
                      <div class="row align-items-center">
                        <label class="col-sm-2">ลงชื่อ/ signature อาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์
                          (Advisor/Chairman of Thesis)<span class="form-required">*</span></label>
                        <div class="col-sm-3">
                          <?php if ($advisor_chairman_status != 0) {

                          ?>
                            <img src="digital-e-signature/doc_signs/<?= $row["advisor_chairman_signature"]; ?>.png">
                            <?php echo $row_advisor['prefixname'] . $row_advisor['advisorname'] . " " . $row_advisor['advisorsurname']; ?>
                          <?php } else { ?>
                            <div id="signArea">

                              <!--<h2 class="tag-ingo">Put signature below,</h2>-->
                              <div class="sig sigWrapper" style="height:auto;">
                                <div class="typed"></div>
                                <canvas class="sign-pad" id="sign-pad" width="250" height="100"> </canvas>
                              </div>
                            </div>
                            <button id="btnClearSign2" class="btn btn-secondary btn-space">Clear Signature</button>
                          <?php } ?>
                          <!--<button id="btnSaveSign">Save Signature</button>-->
                        </div>
                      </div>
                    </div>
                    <div class="btn-list mt-4 text-left">
                      <input type="hidden" name="doc_id" id="doc_id" value="<?= $doc_id ?>">
                      <input type="hidden" name="std_id" id="std_id" value="<?php echo $row_name['std_id_std']; ?>">
                      <button type="submit" id="btnSaveSign" class="btn btn-primary btn-space" <?php if ($advisor_chairman_status != 0) {
                                                                                                  echo "disabled";
                                                                                                } ?>>Save Data</button>
                      <button type="button" class="btn btn-secondary btn-space" <?php if ($advisor_chairman_status != 0) {
                                                                                  echo "disabled";
                                                                                } ?>>Cancel</button>
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
<link rel="stylesheet" href="digital-e-signature/css/jquery-ui.css">
<link href="digital-e-signature/css/jquery.signaturepad.css" rel="stylesheet">
<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="digital-e-signature/js/numeric-1.2.6.min.js"></script>
<script src="digital-e-signature/js/bezier.js"></script>
<script src="digital-e-signature/js/jquery.signaturepad.js"></script>
<script type='text/javascript' src="digital-e-signature/js/html2canvas.js"></script>
<script type="text/javascript">
  $(document).ready(function(e) {
    //$("#advisor").load("JSofficergradinfo.php");// select option อาจารย์ที่ปรึกษา
    $(document).ready(function() {
      $('#signArea').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90
      });
    });

    $("#btnSaveSign").click(function(e) {
      var advisor_chairman_status = $("input[type=radio][name=advisor_chairman_status]:checked").val();
      var argument = $("#argument").val();
      var doc_id = $("#doc_id").val();
      var std_id = $("#std_id").val();
      var semester = $("#semester").val();
      var academic = $("#academic").val();
      var sig_chk = $("#signArea").signaturePad().validateForm();
      if (advisor_chairman_status === undefined) {
        alert("กรุณากรอกข้อมูลเลือกสถานะการพิจารณาคำร้องด้วยนะค่ะ");
        $("#advisor_chairman_status").focus();
        return false;
      }
      if (sig_chk == false) {
        alert("กรุณาลงลายชื่อ..");
        $("canvas").focus();
        return false;
      }
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
          $.post("digital-e-signature/update_status_Retaining.php", {
            img_data: img_data,
            advisor_chairman_status: advisor_chairman_status,
            argument: argument,
            semester: semester,
            academic: academic,
            std_id: std_id,
            doc_id: doc_id
          }, function(data) {

            if (data == 1) {
              alert("Send Data Complete..");
              window.location.href = 'advisor.php';
            } else if (data == 2) {
              alert("Send Data Error..2");
            } else if (data == 3) {
              alert("Send Data Error..3");
            } else {
              alert(console.log(data));

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
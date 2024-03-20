<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("lib/nusoap.php");
require_once("inc/db_connect.php");
$mysqli = connect();

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
  <link href="./assets/css/dashboard.css?v500" rel="stylesheet" />
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

          <?php
          if ($_SESSION['SES_STDCODE'] != "") {
            $sql = "SELECT * FROM request_student WHERE std_id_std=" . $_SESSION['SES_STDCODE'];
            $rs = $mysqli->query($sql);
            $row = $rs->fetch_array();
          ?>
            <div class="my-3 my-md-5">
              <div class="container">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card card-profile">
                      <div class="card-header"></div>
                      <div class="card-body text-center">
                        <?php
                        if ($row['std_img'] == '') {
                        ?>
                          <img class="card-profile-img" src="images/user.jpg">
                        <?php
                        } else {
                        ?>
                          <img class="card-profile-img" src="images/users/<?= $row['std_img']; ?>">
                        <?php
                        }
                        ?>
                        <h3 class="mb-3"><?php echo $_SESSION['SES_STDNAME_FULL_TH']; ?></h3>
                        <p class="mb-4">
                          แก้ไขรูปโปรไฟล์
                        </p>
                        <form action="javascript:;" method="post" enctype="multipart/form-data" name="form1" id="form1">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file">
                            <label class="custom-file-label">Choose file</label>
                          </div>
                          <br />
                          <!--<button type="button" id="iSubmit"  onClick="setVal()" class="btn btn-primary">Edit</button>-->
                        </form>

                      </div>
                    </div>

                  </div>
                  <div class="col-lg-8">
                    <div class="card">
                      <div class="card-header"> ข้อมูลพื้นฐาน
                        <!--       <div class="input-group">
                      <input type="text" class="form-control" placeholder="Message">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-secondary">
                          <i class="fe fe-camera"></i>
                        </button>
                      </div>
                    </div>-->
                      </div>
                      <div>
                        <form name="frm_std_mail" id="frm_std_mail" method="post" action="javascript:;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                            <tbody>

                              <tr>
                                <td align="right">Student ID :</td>
                                <td>&nbsp;<?php echo $row['std_id_std']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Fullname (TH)</td>
                                <td>&nbsp;<?php echo $row['std_fname_th']; ?>&nbsp;&nbsp;<?php echo $row['std_lname_th']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Fullname (EN)</td>
                                <td>&nbsp;<?php echo $row['std_fname_en']; ?>&nbsp;&nbsp;<?php echo $row['std_lname_en']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Degree Name (TH)</td>
                                <td><?php echo $row['std_degree_th']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Degree Name (EN)</td>
                                <td><?php echo $row['std_degree_en']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Field of Study (TH)</td>
                                <td>&nbsp;<?php echo $row['std_major_th']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Field of Study (EN)</td>
                                <td>&nbsp;<?php echo $row['std_major_en']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Faculty / College Name (TH)</td>
                                <td>&nbsp;<?php echo $row['std_faculty_th']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Faculty / College Name (EN)</td>
                                <td>&nbsp;<?php echo $row['std_faculty_en']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">E-mail</td>
                                <td><input type="text" name="adv_email_std" id="adv_email_std" class="form-control" value="<?php echo $row['std_email']; ?>"></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;
                                  <input type="submit" id="btn_send_mail_std" value="Edit Email" class="btn btn-info">
                                </td>
                              </tr>
                              <!-- <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr> -->
                            </tbody>
                          </table>
                        </form>
                        <div class="alert alert-warning">
                          <strong>Warning!</strong> กรุณากรอก e-mail เพราะระบบมีการแจ้งเตือนคำร้องไปยัง email ทุกครั้งมีการการส่งคำร้อง
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          <?php
          } else  if ($_SESSION["SES_USER"] != '') {
            $sql = "SELECT * FROM request_advisor WHERE advisorcode=" . $_SESSION['SES_USER'];
            $rs = $mysqli->query($sql);
            $row = $rs->fetch_array();
          ?>
            <div class="my-3 my-md-5">
              <div class="container">
                <div class="row">

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-header"> ข้อมูลพื้นฐาน
                        <!--       <div class="input-group">
                      <input type="text" class="form-control" placeholder="Message">
                      <div class="input-group-append">
                        <button type="button" class="btn btn-secondary">
                          <i class="fe fe-camera"></i>
                        </button>
                      </div>
                    </div>-->
                      </div>
                      <div>
                        <form id="frm_profile" name="frm_profile" action="javascript:;" method="post">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
                            <tbody>

                              <tr>
                                <td align="right">Prefixname :</td>
                                <td>&nbsp;<?php echo $row['prefixname']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Fullname (TH)</td>
                                <td>&nbsp;<?php echo $row['advisorname']; ?>&nbsp;&nbsp;<?php echo $row['advisorsurname']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Fullname (EN)</td>
                                <td>&nbsp;<?php echo $row['advisornameeng']; ?>&nbsp;&nbsp;<?php echo $row['advisorsurnameeng']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">Faculty / College Name</td>
                                <td>&nbsp;<?php echo $row['facultyname']; ?></td>
                              </tr>
                              <tr>
                                <td align="right">E-mail</td>
                                <td><input type="text" name="adv_email_adv" id="adv_email_adv" class="form-control" value="<?php echo $row['advisor_email']; ?>"></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;<input type="submit" id="btn_send_adv" value="Edit Email" class="btn btn-info"></td>
                              </tr>
                            </tbody>
                          </table>
                        </form>
                        <div class="alert alert-warning">
                          <strong>Warning!</strong> กรุณากรอก e-mail เพราะระบบมีการแจ้งเตือนคำร้องไปยัง email ทุกครั้งมีการการส่งคำร้อง
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>

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





<script type="text/javascript" src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
  $.ajaxSetup({
    cache: false,
    contentType: false,
    processData: false
  });
  $(document).on("change", "#form1", function(e) {
    //Do something

    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.post("update_data.php", formData, function(data) {
      //alert(data);
      if (data == 1) {
        window.location.reload();
      } else if (data == 2) {
        alert("ไม่สามารถแก้ไขรูปประจำตัวได้");
      } else {
        alert("ไม่สามารถแก้ไขรูปประจำตัวได้");
      }
      //$("#ShowDatifa").html(gData); 
    });
  });
  //====แก้ไข email นิสิต =====
  $("#btn_send_mail_std").click(function(e) {
    var adv_email_std = $("#adv_email_std").val();

    e.preventDefault();
    var formData = new FormData();
    formData.append('adv_email_std', adv_email_std);
    formData.append('btn_send_mail_std', 'btn_send_mail_std');
    $.post("update_email.php", formData, function(data) {
      //alert(data);
      if (data == 1) {
        alert("แก้ไขข้อมูลสำเร็จ");
        window.location.reload();
      } else if (data == 2) {
        alert("ไม่สามารถแก้ไขได้");
      } else {
        alert("ไม่สามารถแก้ไขได้");
      }
      //$("#ShowDatifa").html(gData); 
    });
  });
  //====แก้ไข email อาจารย์ =====
  $("#btn_send_adv").click(function(e) {
    var adv_email_adv = $("#adv_email_adv").val();

    e.preventDefault();
    var formData = new FormData();
    formData.append('adv_email_adv', adv_email_adv);
    formData.append('btn_send_adv', 'btn_send_adv');
    $.post("update_email.php", formData, function(data) {
      //alert(data);
      if (data == 1) {
        alert("แก้ไขข้อมูลสำเร็จ");
        window.location.reload();
      } else if (data == 2) {
        alert("ไม่สามารถแก้ไขได้");
      } else {
        alert("ไม่สามารถแก้ไขได้");
      }
      //$("#ShowDatifa").html(gData); 
    });
  });
</script>
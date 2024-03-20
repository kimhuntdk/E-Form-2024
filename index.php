<?PHP
session_start();
/*include 'menu.php';
?>
<?php
if(!$_SESSION['refreshed']){
$_SESSION['refreshed'] = true;
echo '<meta http-equiv="refresh" content="0;URL=index.php">';
ob_end_flush();
exit();
}*/
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
  <link href="./assets/css/dashboard.css?v55" rel="stylesheet" />
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

          //include $src_page;

          ?>
          <div class="row row-cards row-deck">
            <div class="col-12">
              <div class="card">
                <div class="table-responsive">
                  <img src="images/bgbaner.jpg">
                  <hr>
                  <img src="images/chrome.jpg">
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
            <div class="slide-container">
              <div class="slide-content">
                Copyright © 2018-2020 บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม แจ้งปัญหาการใช้งานหรือเสนอแนะได้ที่ผู้ดูแลระบบ e-Form
                นางศรินทร์ยา เกียวขวา email : sarinya.k@msu.ac.th, sarinya.grad@gmail.com โทรศัพท์ 043-754412 ภายใน 1631 (วันเวลาราชการ)
              </div>
            </div>
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
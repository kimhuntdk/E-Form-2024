<?php
session_start();
$SES_USER = $_SESSION[ "SES_USER" ];
if ( $_SESSION[ "SES_LEVEL" ] != "person_ses" || $SES_USER == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}
?>
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
                  <div class="card-header">
                    <h3 class="card-title">ประเภทแบบฟอร์ม</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">No.</th>
                          <th>เอกสาร</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="text-muted">ทบบัณฑิตวิทยาลัย 0183</span></td>
                          <td><a href="Request_Form_Document_in.php" class="text-inherit">บันทึกข้อความ(ภายในบัณฑิตวิทยาลัย)</a></td>
                          <td class="text-right"><!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                          <div class="dropdown"> <a href="Request_Form_Document_in.php" class="btn btn-secondary btn-sm" >Actions</a> </div></td>
                          <td><!--     <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>--></td>
                        </tr>
                        <!-- <tr>
                          <td>ทบ.มมส/โท-เอก 13</td>
                          <td><a href="?menu=Request_Form_Status_Retention_Special" class="text-inherit">คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) /Student Status Retention Form (Special case) </a></td>
                          <td class="text-right">
                          <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                          <div class="dropdown">
                              <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                            </div>
                          </td>
                          <td>
                        <!--    <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>
                          </td>
                        </tr>-->
                       
                      </tbody>
                    </table>

                  </div>
                  <br>
                  <hr>

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

<?php
$user = $_POST[ 'user' ];
$pass = md5( md5( md5( $_POST[ 'pass' ] ) ) );
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
						<h1 class="page-title">

						</h1>
					</div>


					<?php

					//include $src_page;

					?>
					<div class="col-12">
						<div class="row">
							<div class="col col-login mx-auto">
								<div class="text-center mb-6">
									<!--<img src="./assets/brand/tabler.svg" class="h-6" alt="">-->
								</div>
								<form class="frm_login" action="javascript:;" method="post" id="frm_login" name="frm_login">
									<div class="card-body p-6">
										<div class="card-title">เข้าสู่ระบบด้วยชื่อใช้งานและรหัสผ่านเดียวกับระบบลงทะเบียน(REG)</div>
												<div class="form-group">
											<label class="form-label">Status</label>
											<select id="status" name="status" class="custom-select">
												<option value="0">เลือกสถานะ</option>
												<option value="1">นิสิตระดับบัณฑิตศึกษา/Student Graduate</option>
												<option value="2">อาจารย์ระดับบัณฑิตศึกษา/Advisor</option>
												<option value="3">เจ้าหน้าที่บัณฑิตวิทยาลัย/Staff</option>
												<option value="4">ผู้บริหารบัณฑิตวิทยาลัย/Administrator
												</option>
											</select>
										</div>
										<div class="form-group">
											<label class="form-label">Username</label>
											<input type="text" class="form-control" name="user" id="user" placeholder="Username">
										</div>
										<div class="form-group">
											<label class="form-label">
												Password

											</label>


											<input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
										</div>
								
										<div class="form-footer">
											<button type="submit" class="btn btn-primary btn-block" id="hash-it" onclick="return login()">Sign in</button>
										</div>
										<!--<div><h3>ระบบปิดปรับปรุง ต้องอภัยในความไม่สะดวก</h3></div>-->
									</div>
								</form>

								<div id="result"></div>
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



<script src="assets/js/vendors/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	function login() {
		var user = $( "#user" ).val();
		var pass = $( "#pass" ).val();
		var status = $( "#status" ).val();
		if ( status == 0 ) {
			alert( "Please Status" );
			$( "#status" ).focus();
			return false;
		}
		//alert(user+pass);
		if ( user == "" ) {
			alert( "Please Username" );
			$( "#user" ).focus();
			return false;
		}
		if ( pass == "" ) {
			alert( "Please Password" );
			$( "#pass" ).focus();
			return false;
		}
		
		// สำหรับนิสิต
		if ( user !== "" && pass !== "" && status !== 0 ) {
			$.post( "check_login.php", {
				user: user,
				pass: pass,
				status: status
			}, function ( data ) {
				//alert(data);
				if ( data == 1 ) {
					//ส่งไปตรวจว่าเคยเพิ่มลงฐานข้อมูลนิสิตหรือยัง
					$.post( "check_login_insert.php", {
						user: user
					}, function ( data ) {

						$("#result").html(data);

					} );
					setTimeout( function () {
						//window.location.href = 'form_request_doc.php';
					}, 1000 );
				} else if ( data == 2 ) {

					$.post( "check_login_insert_ad.php", {
						user: user
					}, function ( data ) {
						//alert( data );
						//$("#result").html(data);

					} );
					setTimeout( function () {
						window.location.href = 'advisor.php';
					}, 1000 );
				} else if ( data == 3 ) {

					setTimeout( function () {
						window.location.href = 'staff.php';
					}, 1000 );
				} else if ( data == 4 ) {

					setTimeout( function () {
						window.location.href = 'admin.php';
					}, 1000 );
				}else if ( data == 10 ) {

					setTimeout( function () {
						window.location.href = 'form_request_persor.php';
					}, 1000 );
				}else if ( data == 11 ) {

					setTimeout( function () {
						window.location.href = 'staff_ch.php';
					}, 1000 );
				}else if ( data == 20 ) {

					setTimeout( function () {
						window.location.href = 'staff_office.php';
					}, 1000 );
				} else {
					alert( "ไม่สามารถ login เข้าสู่ระบบได้ กรุณาตรวจสอบ Username และ Password อีกครั้ง เป็นตัวเดียวกันกับ ระบบลงทะเบียน reg.msu.ac.th" );
				}

			} );

		}
		// สำหรับอาจารย์
		/*		if ( user !== "" && pass !== "" && status==2 ) {
					$.post( "check_login.php", {
						user: user,
						pass: pass
					}, function ( data ) {
						//alert(data);
						if ( data == 1 ) {
		                    //ส่งไปตรวจว่าเคยเพิ่มลงฐานข้อมูลนิสิตหรือยัง
							$.post( "check_login_insert.php", {
								user: user
							}, function ( data ) {
								
								//$("#result").html(data);

							} );
							    setTimeout( function () {
								window.location.href = 'index.php?menu=home';
							}, 1000 );
						} else {
							alert( "ไม่สามารถ login เข้าสู่ระบบได้ กรุณาตรวจสอบ Username และ Password อีกครั้ง เป็นตัวเดียวกันกับ ระบบลงทะเบียน reg.msu.ac.th" );
						}

					} );

				}
				//สำหรับเจ้าหน้าที่บัณฑิต
				if ( user !== "" && pass !== "" && status==3 ) {
					$.post( "check_login.php", {
						user: user,
						pass: pass
					}, function ( data ) {
						//alert(data);
						if ( data == 1 ) {
		                    //ส่งไปตรวจว่าเคยเพิ่มลงฐานข้อมูลนิสิตหรือยัง
							$.post( "check_login_insert.php", {
								user: user
							}, function ( data ) {
								
								//$("#result").html(data);

							} );
							    setTimeout( function () {
								window.location.href = 'index.php?menu=home';
							}, 1000 );
						} else {
							alert( "ไม่สามารถ login เข้าสู่ระบบได้ กรุณาตรวจสอบ Username และ Password อีกครั้ง เป็นตัวเดียวกันกับ ระบบลงทะเบียน reg.msu.ac.th" );
						}

					} );

				}
				//สำหรับผู้บริหารบัณฑิต
				if ( user !== "" && pass !== "" && status==4 ) {
					$.post( "check_login.php", {
						user: user,
						pass: pass
					}, function ( data ) {
						//alert(data);
						if ( data == 1 ) {
		                    //ส่งไปตรวจว่าเคยเพิ่มลงฐานข้อมูลนิสิตหรือยัง
							$.post( "check_login_insert.php", {
								user: user
							}, function ( data ) {
								
								//$("#result").html(data);

							} );
							    setTimeout( function () {
								window.location.href = 'index.php?menu=home';
							}, 1000 );
						} else {
							alert( "ไม่สามารถ login เข้าสู่ระบบได้ กรุณาตรวจสอบ Username และ Password อีกครั้ง เป็นตัวเดียวกันกับ ระบบลงทะเบียน reg.msu.ac.th" );
						}

					} );

				}
				// สำหรับผู้ดูแลระบบ
				if ( user !== "" && pass !== "" && status==5 ) {
					$.post( "check_login.php", {
						user: user,
						pass: pass
					}, function ( data ) {
						//alert(data);
						if ( data == 1 ) {
		                    //ส่งไปตรวจว่าเคยเพิ่มลงฐานข้อมูลนิสิตหรือยัง
							$.post( "check_login_insert.php", {
								user: user
							}, function ( data ) {
								
								//$("#result").html(data);

							} );
							    setTimeout( function () {
								window.location.href = 'index.php?menu=home';
							}, 1000 );
						} else {
							alert( "ไม่สามารถ login เข้าสู่ระบบได้ กรุณาตรวจสอบ Username และ Password อีกครั้ง เป็นตัวเดียวกันกับ ระบบลงทะเบียน reg.msu.ac.th" );
						}

					} );

				}
				*/
			}
		</script>
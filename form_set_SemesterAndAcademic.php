<?php
session_start();

$SES_USER = $_SESSION["SES_USER"];

// เช็คสิทธิ์การเข้าใช้งาน
if ($_SESSION["SES_LEVEL"] != "staff_ses" || $SES_USER == "") {
	echo "<script>window.location.href = 'logout.php'</script>";
}

require_once("inc/db_connect.php");
$mysqli = connect();

$sql = "SELECT * FROM request_doc_type";
$result = $mysqli->query($sql);

date_default_timezone_set('Asia/Bangkok');
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

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		img {
			width: 50px;
			border-radius: 50px;
		}

		input {
			border: 2px solid gray;
			border-radius: 20px;
			padding: 12px 10px;
			text-align: center;
			width: 250px;
		}

		button {
			border: none;
			border-radius: 10px;
			padding: 12px 10px;
			text-align: center;
			cursor: pointer;
			background: coral;
			color: whitesmoke;
		}

		#container {
			width: 80%;
			aspect-ratio: 5/2;
			margin: auto;
			border: solid black 2px;
			overflow-x: hidden;
			overflow-y: scroll;
			scroll-snap-type: y mandatory;
		}
	</style>
</head>

<body>
	<div class="page">
		<div class="page-main">
			<?php include("main_menu.php"); ?>
			<div class="my-3 my-md-5">
				<div class="container">
					<div class="page-header">
						<h1 class="page-title"> กำหนดภาคเรียนและปีการศึกษาล่าสุดที่เปิดรับฟอร์มคืนสภาพ</h1>
					</div>
					<div class="alert alert-info alert-dismissible" role="alert" >
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>ชี้แจง </strong> <br>
						1. ตารางฝั่งซ้ายใช้สำหรับดูภาคเรียนและปีการศึกษาที่ใช้สำหรับขอคืนสภาพนิสิต เรียงจากภาคเรียนปัจจุบัน<br>
						2. ตารางฝั่งขวาใช้สำหรับเพิ่มภาคเรียนและปีการศึกษา<br>
						3. การทำงานของปุ่ม<br>
						&nbsp;&nbsp;&nbsp;&nbsp;- ปุ่มแก้ไข หรือ ปุ่มสีเหลือง ใช้สำหรับแก้ไขข้อมูลเมื่อเพิ่มข้อมูลผิด <br>
						&nbsp;&nbsp;&nbsp;&nbsp;- ปุ่มลบ หรือ ปุ่มสีแดง ใช้สำหรับลบข้อมูลที่ต้องการ <br>
						4. แถบสีเขียว <button class="btn" style="background-color: #1aff1a;"></button> หรือแถบบนสุดคือภาคเรียนปัจจุบันที่จะนำไปใช้ระบุว่า นิสิตต้องการจะลาพักหรือลงทะเบียนเรียน <br>
						5. ภาคเรียนและปีการศึกษาที่อยู่ล่างสุดของตารางคือภาคเรียนที่สามารถขอคืนสภาพตั้งแต่ภาคเรียนนั้นได้ <br>
						<strong>หมายเหตุ</strong> <br>
						1. ตารางนี้ใช้สำหรับเพิ่มภาคเรียนและปีการศึกษาที่ใช้สำหรับฟอร์มขอคืนสภาพนิสิตเท่านั้น <br>
						2. ภาคเรียนที่แสดงออกทั้งหมดจพถูกนำไปใช้ในการแสดงข้อมูลในหน้าเว็บและ PDF <br>
						3. <strong>ภาคเรียนและปีการศึกษาต้องเรียงจากปัจจุบันไปจนถึงที่ต้องการตามลำดับ เพราะระบบจะใช้ข้อมูลนี้ในการแสดงข้อมูลและ PDF</strong>
						
						<!-- <span class="form-required">***</span>หมายเหตุ -->
					</div>

					<div class="row row-cards row-deck">
						<div class="col-6">
							<h3>ตารางแสดงข้อมูลเทอมที่ขอคืนสภาพและลาพักได้</h3>
							<div class="card">
								<div class="table-responsive" style="overflow-y: scroll; height: 250px;">
									<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
										<thead>
											<tr class="text-center w-1" >
												<th style="font-size: large;">ภาคเรียนที่</th>
												<th style="font-size: large;">ปีการศึกษาที่</th>
												<th style="font-size: large; width: 20px;">จัดการ</th>
											</tr>
										</thead>
										<?php
										$sql_rss = "SELECT * FROM request_rss ORDER BY rss_id DESC";
										$result_rss = $mysqli->query($sql_rss);
										?>
										<?php
										$counter = 0; // เริ่มต้นนับจำนวนแถว
										foreach ($result_rss as $row_rss) {
											$counter++; // เพิ่มจำนวนแถวทุกครั้งที่วน loop
										?>
											<tbody <?php if ($counter == 1) echo 'style="background-color: #1aff1a;"'; ?>>
												<tr>
													<td style="text-align: center; width: 50px; font-size: large;">
														<?php echo $row_rss['semester']; ?>
													</td>
													<td style="text-align: center; width: 50px; font-size: large;">
														<?php echo $row_rss['academic']; ?>
													</td>
													<td style="text-align: center;">
														<button type="button" class="btn" style="background-color: #ffff00; color: black;" data-toggle="modal" data-target="#exampleModalLong" onclick="edit_data(<?= $row_rss['rss_id']; ?>)"> แก้ไข</button>
														<button type="button" class="btn " style="background-color: #ff0000;" onclick="delete_data(<?= $row_rss['rss_id']; ?>)"> ลบ</button>
													</td>

												</tr>
											<?php } ?>
											</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-6">
							<h3>เพิ่มภาคเรียนปัจจุบัน</h3>
							<div class="card">
								<form method="post" action="update_semesterAndAcademic.php" onsubmit="return confirmUpdate();">
									<div class="row">
										<div class="col-md-12" style="margin: 20px 0px 0px 10px ;">
											<label>ระบุภาคเรียนที่ต้องการจะเปิด</label>
											<label class="form-label" style="text-align: center;">
												<div class="form-group col-sm-9">
													<div class="custom-controls-stacked">
														<label class="custom-control custom-radio custom-control-inline">
															<input type="radio" class="custom-control-input" name="semester" id="semester" value="1">
															<span class="custom-control-label">ภาคต้น/1<sup>st</sup> semester</span>
														</label>
														<label class="custom-control custom-radio custom-control-inline">
															<input type="radio" class="custom-control-input" name="semester" id="semester" value="2">
															<span class="custom-control-label">ภาคปลาย/2<sup>nd</sup> semester</span>
														</label>
													</div>
												</div>
											</label>
										</div>
										<div class="col-md-12" style="margin: 0px 0px 0px 10px;">
											<label>ระบุปีการศึกษาที่ต้องการจะเปิด</label>
											<label class=" form-label">
												<div class="form-group col-sm-9">
													<input type="text" name="academic" id="academic" placeholder="ระบุปีการศึกษา/Academic year" value="">
												</div>
											</label>
										</div>
									</div>
									<div style="text-align: center; margin-bottom: 10px;">
										<button style="background-color: #008CBA;" type="submit" name="update" onclick="return">เพิ่ม</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<div id="show_data_status"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
</body>
<!-- ฟังก์ชันแจ้งเตือนผู้ใช้ -->
<script>
	// แจ้งว่าต้องการ"ยืนยันการอัพเดตหรือไม่"
	function confirmUpdate() {
		// ฟังก์ชันตรวจสอบว่าข้อมู,ที่ใส่เข้ามาถูกต้องหรือไม่ 
		// var semester = document.getElementById('semester').value;
		var semester = document.querySelector('input[name="semester"]:checked');
		var academic = document.getElementById('academic').value;

		// ตรวจสอบว่า semester และ academic ไม่เป็นค่าว่าง
		if (!semester) {
			alert('กรุณาระบุภาคการศึกษา');
			$("#semester").focus();
			return false;
		}
		if (academic === "") {
			alert('กรุณาระบุปีการศึกษา');
			$("#academic").focus();
			return false;
		}

		// ตรวจสอบว่า academic เป็นตัวเลขหรือไม่
		if (isNaN(academic)) {
			alert('ปีการศึกษาไม่ถูกต้อง');
			return false;
		}

		var confirmMsg = confirm('คุณต้องเพิ่มภาคเรียนและปีการศึกษาใช่หรือไม่');
		if (confirmMsg) {
			// User confirmed, form submission will continue
			return true;
		} else {
			// User cancelled, form submission will stop
			return false;
		}
	}
	// แจ้งเตือนว่าเอพเดตข้อมูลสำเร็จหรือไม่
	<?php

	if (isset($_SESSION['check_data'])) {
		echo "alert('ไม่สามารเพิ่มได้ เพราะมีภาคการศึกษาและปีการศึกษานี้แล้ว');";
		unset($_SESSION['check_data']);
	} else {
		if (isset($_SESSION['insert_success'])) {
			echo 'alert("เพิ่มข้อมูลเรียบร้อยแล้ว");';
			unset($_SESSION['insert_success']);
		}
		if (isset($_SESSION['insert_error'])) {
			echo 'alert("ไม่สามารถเพิ่มข้อมูลได้");';
			unset($_SESSION['insert_error']);
		}
	}

	?>
</script>

<script>
	function edit_data(id) { //จัดการสถานะคำร้อง
		// console.log("ID sent to edit_data function: ", id);

		var chk_id = id;
		// console.log("chk_ID sent to edit_data function: ", chk_id);
		// alert(type_doc);
		$.ajax({
			url: 'edit_semesterAndAcademic.php',
			type: 'POST',
			data: {
				chk_id: chk_id
			},
			success: function(data) {
				//alert(data);
				if (data != '') {
					$("#show_data_status").html(data);
				} else {
					$("#show_data_status").html(data);
				}
			}

		});
	}
</script>

<!-- ตำแหน่งในไฟล์ HTML/JavaScript หลัก -->
<script>
	function delete_data(id) {
		var confirmDelete = confirm("คุณแน่ใจหรือไม่ที่ต้องการลบรายการนี้?");
		if (confirmDelete) {
			$.ajax({
				url: 'delete_semesterAndAcademic.php',
				type: 'POST',
				data: {
					delete_id: id
				},
				success: function(response) {
					alert(response); // แสดงข้อความที่ส่งกลับจากไฟล์ PHP
					// โหลดหน้าเว็บใหม่หลังจากลบข้อมูลสำเร็จ
					window.location.reload();
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		}
	}
</script>

</html>
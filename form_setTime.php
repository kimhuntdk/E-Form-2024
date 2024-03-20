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
	<!-- boot -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- Generated: 2018-04-16 09:29:05 +0200 -->
	<title>e-Form Graduate School MSU</title>

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Flatpickr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
	</style>
</head>

<body>
	<script>
		// ตรวจสอบว่า jQuery ถูกโหลดเรียบร้อย
		if (typeof jQuery != 'undefined') {
			console.log('jQuery is loaded.');
			// ทำสิ่งที่คุณต้องการดำเนินการกับ jQuery ที่นี่
		} else {
			console.log('jQuery is not loaded.');
		}
	</script>
	<div class="page">
		<div class="page-main">
			<?php include("main_menu.php"); ?>
			<div class="my-3 my-md-5">
				<div class="container">
					<div class="page-header">
						<h1 class="page-title"> กำหนดเวลาเปิด-ปิดฟอร์ม</h1>
					</div>
					<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong>ชี้แจง!!! </strong> <br>
						1. เครื่องหมายสถานะ <i class="fa fa-check-square" style="font-size:24px;color:green"></i> หมายถึง Form เปิดให้เข้าใช้งานได้อยู่ <br>
						2. เครื่องหมายสถานะ <i class="fa fa-times-rectangle" style="font-size:24px;color:red"></i> หมายถึง Form ปิดให้เข้าใช้งานแล้ว </strong><br>
						3. ปุ่ม Accept ใช้สำหรับ Update เฉพาะ Form <br>
						4. หากแก้ไข Form มากกว่า 1 Form สามารถ Update ทุก Form ที่แก้ไขได้ตรงที่ปุ่ม All Accept ด้านล่างได้ <br>
						<!-- <span class="form-required">***</span>หมายเหตุ -->
					</div>
					<div class="row row-cards row-deck">
						<div class="col-12">
							<div class="card">
								<form method="post" action="update_times.php" onsubmit="return confirmUpdate();">
									<div class="table-responsive">
										<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
											<thead>
												<tr class="text-center w-1">
													<th style="font-size: large;">สถานะของฟอร์ม</th>
													<th style="font-size: large;">ชื่อฟอร์ม</th>
													<th style="font-size: large;">เวลาเปิด</th>
													<th style="font-size: large;">เวลาปิด</th>
													<th style="font-size: large;">การดำเนินการ</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$currentTimestamp = time();
												foreach ($result as $row) {
													$dateOpenTime = new DateTime($row['OpenTime']);
													$dateCloseTime = new DateTime($row['CloseTime']);
													$formattedOpenTime = $dateOpenTime->format('Y-m-d\ H:i:s');
													$formattedCloseTime = $dateCloseTime->format('Y-m-d\ H:i:s');

													$openTimestamp = strtotime($row['OpenTime']);
													$closeTimestamp = strtotime($row['CloseTime']);
													$withinTimeRange = ($currentTimestamp >= $openTimestamp && $currentTimestamp <= $closeTimestamp);
												?>
													<tr <?php  if($withinTimeRange){ ?> class="success" <?php } else { ?> class="danger" <?php } ?>>
														<td style="text-align: center;">
															<?php
															// แสดงไอคอน Font Awesome ตามเงื่อนไขที่เวลาอยู่ในช่วงเวลาหรือไม่
															if ($withinTimeRange) {
																echo '<i class="fa fa-check-square" style="font-size:32px;color:green"></i>';
															} else {
																echo '<i class="fa fa-times-rectangle" style="font-size:32px;color:red"></i>';
															}
															?>
														</td>
														<td style="width: 500px;">
															<?php echo $row['doc_type_name'] ?>
														</td>
														<td style="width: 150px;">
															<input class="flatpickr" type="text" name="openTime[<?php echo $row['doc_type_id']; ?>]" value="<?php echo $formattedOpenTime ?>">
														</td>
														<td>
															<input class="flatpickr" type="text" name="closeTime[<?php echo $row['doc_type_id']; ?>]" value="<?php echo $formattedCloseTime; ?>">
														</td>
														<td style="text-align: center;">
															<button style="background-color: yellow; color: black;" type="submit" name="update" value="<?php echo $row['doc_type_id']; ?>">Accept</button>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
							</div>
							<div style="text-align: center;">
								<button style="background-color: #008CBA;" type="submit" name="update_all" onclick="return confirm('คุณแน่ใจหรือว่าต้องการอัปเดตทุกประเภทของเอกสาร?');">All Accept</button>
							</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(".flatpickr").flatpickr({
			enableTime: true,
			dateFormat: "Y-m-d H:i"
		});

		function confirmUpdate() {
			return confirm("ต้องการยืนยันการกำหนดเวลาเปิด-ปิดฟอร์มใช่หรือไม่?");
		}
	</script>
</body>

</html>
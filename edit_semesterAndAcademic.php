<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("inc/db_connect.php");
$mysqli = connect();

$chk_id = $_POST['chk_id'];
// if(isset($_POST['chk_id'])) {
//       // ดำเนินการเมื่อ chk_id ถูกตั้งค่า
//       $chk_id = $_POST['chk_id'];
//       // ตรวจสอบต่อไป...
//   } else {
//       // ดำเนินการเมื่อ chk_id ไม่ถูกตั้งค่า
//       echo "ค่า chk_id ไม่ได้รับค่ามา";
//   }
//$user = $_SESSION['SES_EN_REG_USER'];

$sql = "SELECT * FROM request_rss  WHERE rss_id = $chk_id";
$result = $mysqli->query($sql);
$row = $result->fetch_array();
// echo $row['semester'];

$semester = $row['semester'];
$academic = $row['academic'];

?>
<form class="needs-validation" name="form_gs" action="edit_semesterAndAcademic_save.php" method="post">
      <!-- <h4 class="bg-warning">Form จัดการสถานะ : </h4> -->
      <div class="col-md-8">
            <label>ภาคเรียนที่ :</label>
            <input type="text" name="semester" placeholder="" value="<?php echo $semester; ?>">
      </div>
      <div class="col-md-8">
            <label>ปีการศึกษาที่ :</label>
            <input type="text" name="academic" placeholder="" value="<?php echo $academic; ?>">
      </div>
      <hr class="mb-4">

      <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg btn-block">
      <input type="hidden" name="rss_id" value="<?= $chk_id; ?>">
</form>
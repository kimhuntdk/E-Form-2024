<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require_once("inc/db_connect.php");
$mysqli = connect();

if (isset($_POST['submit'])) {
      $id = $_POST['rss_id'];
      $semester = $_POST['semester'];
      $academic = $_POST['academic'];

      // ตรวจสอบว่าข้อมูลที่รับเข้ามาเป็นตัวเลขหรือไม่
    if (!is_numeric($semester) || !is_numeric($academic)) {
      ?>
      <script>
          // แสดง Alert เมื่อข้อมูลไม่ใช่ตัวเลข
          alert("ข้อมูลไม่ถูกต้อง ต้องเป็นตัวเลขเท่านั้น");
          // นำผู้ใช้กลับไปยังหน้าก่อนหน้า
          history.back();
      </script>
      <?php
      exit(); // หยุดการทำงานของสคริปต์เมื่อข้อมูลไม่ใช่ตัวเลข
  }

      $updateSql = "UPDATE request_rss SET semester = ?, academic = ? WHERE rss_id = ?";
      $stmtAll = $mysqli->prepare($updateSql);
      $stmtAll->bind_param("iii", $semester, $academic, $id);
      $stmtAll->execute();
      $stmtAll->close();

     
?>
      <script>
             // แสดง Alert เมื่ออัปเดตข้อมูลสำเร็จ
             alert("แก้ไขข้อมูลสำเร็จ");
            // นำผู้ใช้กลับไปยังหน้าก่อนหน้า
            history.back();
      </script>
<?php

}
exit();
?>
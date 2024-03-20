<?php
session_start();

// เชื่อมต่อฐานข้อมูล
require_once("inc/db_connect.php");
$mysqli = connect();

// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if(isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // ลบข้อมูลโดยใช้คำสั่ง SQL
    $sql = "DELETE FROM request_rss WHERE rss_id = $delete_id";

    if($mysqli->query($sql) === TRUE) {
        // ส่งข้อความกลับเมื่อลบสำเร็จ
        echo "ลบข้อมูลสำเร็จ";
    } else {
        // ส่งข้อความกลับเมื่อเกิดข้อผิดพลาดในการลบ
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $mysqli->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$mysqli->close();
?>

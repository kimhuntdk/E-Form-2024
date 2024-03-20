<?php
session_start();
require_once("inc/db_connect.php");
$mysqli = connect();

if (isset($_POST['update'])) {

    $semester = $_POST['semester'];
    $academic = $_POST['academic'];
    // ตรวจสอบว่ามีภาคการศึกษาและปีการศึกษานี้อยู่ในฐานข้อมูลแล้วหรือไม่
    $checkSql = "SELECT * FROM request_rss WHERE semester = ? AND academic = ?";
    $checkStmt = $mysqli->prepare($checkSql);
    $checkStmt->bind_param("ii", $semester, $academic);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // ถ้ามีข้อมูลอยู่แล้ว
        $_SESSION['check_data'] = true;
        // echo "<script>alert('มีภาคการศึกษาและปีการศึกษานี้แล้ว');</script>";
    } else {
        // ถ้ายังไม่มีข้อมูลในฐานข้อมูล
        $updateSql = "INSERT INTO request_rss SET semester = ?, academic = ?";
        $stmt = $mysqli->prepare($updateSql);
        $stmt->bind_param("ii", $semester, $academic);
        $success = $stmt->execute(); // เก็บผลการ execute เพื่อใช้ในการตรวจสอบ
        $stmt->close();

        if ($success) {
            $_SESSION['insert_success'] = true;
        } else {
            $_SESSION['insert_error'] = true;
        }
    }
    $checkStmt->close();
}

// Redirect กลับไปยังหน้าเดิม
header("Location: form_set_semesterAndAcademic.php");
exit();

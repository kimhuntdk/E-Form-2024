<?php
session_start();
include("inc/db_connect.php");
// require_once('../SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
require_once('../electronic/SendGmailSMTP/PHPMailer/PHPMailerAutoload.php');
$mysqli = connect();
date_default_timezone_set("Asia/Bangkok");
$user = $_POST['user'];

// Check if the user exists in request_student table
$sql_check_student = "SELECT std_id_std FROM request_student WHERE std_id_std = ?";
$stmt_check_student = $mysqli->prepare($sql_check_student);
$stmt_check_student->bind_param("s", $user);
$stmt_check_student->execute();
$result_student = $stmt_check_student->get_result();

// Check if the user exists in request_advisor table
$sql_check_advisor = "SELECT advisorcode,advisor_email FROM request_advisor WHERE advisorcode = ?";
$stmt_check_advisor = $mysqli->prepare($sql_check_advisor);
$stmt_check_advisor->bind_param("s", $user);
$stmt_check_advisor->execute();
$result_advisor = $stmt_check_advisor->get_result();

if ($result_student->num_rows > 0) {
    $table = "request_student";
    $row_check = "std_id_std";
} elseif ($result_advisor->num_rows > 0) {
    $table = "request_advisor";
    $row_check = "advisorcode";
    $user_data = $result_advisor->fetch_assoc(); // ดึงข้อมูลผู้ใช้จาก mysqli_result เป็นอาร์เรย์
} else {
    // Handle case when user is not found in any table
    echo '<script>
            alert("ไม่พบบัญชีผู้ใช้นี้ กรุณาใส่ข้อมูลให้ถูกต้อง"); 
            window.history.go(-1);
          </script>';
    exit; // Stop execution if user not found
}


$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time());

$sql_update = "UPDATE $table
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE $row_check = ? ";
$stmt_update = $mysqli->prepare($sql_update);
$stmt_update->bind_param("sss", $token_hash, $expiry, $user);

$stmt_update->execute();

if ($mysqli->affected_rows) {
    if ($table  == "request_student") {
        $Address = $user . '@msu.ac.th';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
        $mail->isHTML();
        $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
        $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
        $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
        $mail->SetFrom('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแสดงให้เห็นตรงไหน
        $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
        $mail->Subject = "Password Reset";  //หัวเรื่อง email ที่ส่ง
        $mail->Body = <<<END
        หากท่านต้องการเปลี่ยนรหัสผ่าน Click <a href="http://localhost/electronic/reset-password.php?token=$token">here</a>
        เพื่อเปลี่ยนรหัสผ่านของคุณ
        END;
        // $mail->AddAddress($Address); //อีเมล์และชื่อผู้รับ
        $mail->AddAddress('62011212115@msu.ac.th'); //อีเมล์และชื่อผู้รับ
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "ไม่สามารถส่งอีเมลไปได้ : {$mail->ErrorInfo}";
        }
        echo '<script>alert("Send email completed");window.history.go(-1);</script>';
    } elseif ($table == "request_advisor") {
        if ($user_data['advisor_email'] != "") {
            $Address = $user_datar['advisor_email'];
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 587;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
            $mail->isHTML();
            $mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
            $mail->Username = "graduate@msu.ac.th"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
            $mail->Password = "@graduate12345"; // ใส่รหัสผ่าน
            $mail->SetFrom('graduate@msu.ac.th'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแสดงให้เห็นตรงไหน
            $mail->FromName = "บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม"; //ชื่อที่ใช้ในการส่ง
            $mail->Subject = "Password Reset";  //หัวเรื่อง email ที่ส่ง
            $mail->Body = <<<END
        หากท่านต้องการเปลี่ยนรหัสผ่าน Click <a href="http://localhost/electronic/reset-password.php?token=$token">here</a>
        เพื่อเปลี่ยนรหัสผ่านของคุณ
        END;
            // $mail->AddAddress($Address); //อีเมล์และชื่อผู้รับ
            $mail->AddAddress('62011212115@msu.ac.th'); //อีเมล์และชื่อผู้รับ
            try {
                $mail->send();
            } catch (Exception $e) {
                echo "ไม่สามารถส่งอีเมลไปได้ : {$mail->ErrorInfo}";
            }
            echo '<script>alert("Send email completed!!");window.history.go(-1);</script>';
        } else {
            echo '<script>alert("ไม่พบ Email ของผู้ใช้นี้ กรุณาไปเพิ่ม Email ของท่านลงในข้อมูล");window.history.go(-1);</script>';
        }
    }
} else {
    echo '<script>
            alert("ไม่พบบัญชีผู้ใช้นี้ กรุณาใส่ข้อมูลให้ถูกต้อง"); 
            window.history.go(-1);
          </script>';
}

<?php
include("inc/db_connect.php");
$mysqli = connect();

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

// Check if the user exists in request_student table
$sql_check_student = "SELECT * FROM request_student WHERE reset_token_hash = ?";
$stmt_check_student = $mysqli->prepare($sql_check_student);
$stmt_check_student->bind_param("s", $token_hash);
$stmt_check_student->execute();
$result_student = $stmt_check_student->get_result();

// Check if the user exists in request_advisor table
$sql_check_advisor = "SELECT * FROM request_advisor WHERE reset_token_hash = ?";
$stmt_check_advisor = $mysqli->prepare($sql_check_advisor);
$stmt_check_advisor->bind_param("s", $token_hash);
$stmt_check_advisor->execute();
$result_advisor = $stmt_check_advisor->get_result();

if ($result_student->num_rows > 0) {
    $table = "request_student";
    $row_check = "std_id_std";
} elseif ($result_advisor->num_rows > 0) {
    $table = "request_advisor";
    $row_check = "advisorcode";
} else {
    // Handle case when user is not found in any table
    echo '<script>
            alert("เซคชั่นหมดอายุ"); 
            window.history.go(-1);
          </script>';
    exit; // Stop execution if user not found
}

$sql = "SELECT * FROM $table
        WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

if ($table == "request_student") {
    $sql_updeat = "UPDATE request_student 
        SET  std_password = ? , 
             reset_token_hash = NULL ,
             reset_token_expires_at = NULL
        WHERE std_id_std = ?";

    $stmt = $mysqli->prepare($sql_updeat);
    $stmt->bind_param("ss", $password_hash, $user['std_id_std']);

    $stmt->execute();

    echo '<script>alert("รหัสผ่านของคุณถูกอัปเดตแล้ว");</script>';

} elseif ($table == "request_advisor") {
    $sql_updeat = "UPDATE request_advisor 
        SET  advisor_password = ? , 
             reset_token_hash = NULL ,
             reset_token_expires_at = NULL
        WHERE advisorcode = ?";

    $stmt = $mysqli->prepare($sql_updeat);
    $stmt->bind_param("ss", $password_hash, $user['advisorcode']);

    $stmt->execute();

    echo '<script>alert("รหัสผ่านของคุณถูกอัปเดตแล้ว")
    ;window.location.href = "login.php";</script>';
}

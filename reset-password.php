<?php
include("inc/db_connect.php");
$mysqli = connect();

$token = $_GET["token"];
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

} elseif ($result_advisor->num_rows > 0) {
    $table = "request_advisor";

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
    // die("token not found");
    die("ไม่พบเซคชั่นนี้");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    // die("token has expired");
    die("เซคชั่นหมดอายุ");
}

// echo "token is valid and hasn't expired";
?>
<!DOCTYPE html>
<html>

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

    <!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
-->
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
    <style type="text/css">
        #verify_math {
            display: block;
            height: 21px;
        }

        #verify_math span {
            display: block;
            height: 21px;
            width: 30px;
            position: relative;
            float: left;
            text-align: center;
            line-height: 20px;
            color: #000;
        }

        #verify_math span.digital {
            background: url(chk_cap/images/digi_img.jpg) left top no-repeat;
        }

        .col-login {
            max-width: 35rem;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="page-main">
            <div class="my-3 my-md-5">
                <div class="page-header">
                    <h1 class="page-title"> </h1>
                </div>
                <div class="col-12" style="margin-top: 10%;">
                    <div class="row">
                        <div class="col col-login mx-auto"> <!--class -->
                            <form class="card frm_login" action="reset-password-process.php" method="post" id="reset_password" style="border-radius: 1rem;" onsubmit="return validateForm();">
                                <div class="card_body p-6">
                                    <div class="card-herder">
                                        <h2>เปลี่ยนรหัสผ่าน</h2>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                                        <label class="col-sm-12">รหัสผ่านใหม่</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" style="height: 50px;" name="password" id="password" placeholder="รหัสผ่านใหม่">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">แสดง</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">ยืนยันรหัสผ่าน</label>
                                        <input type="password" class="form-control" style="height: 50px;" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่าน">
                                    </div>
                                    <div id="passwordLength" style="color: red;"></div>
                                    <div id="passwordChar" style="color: red;"></div>
                                    <div id="passwordDigit" style="color: red;"></div>
                                    <div id="passwordMatchMessage" style="color: red;"></div>
                                    <div style="text-align: end;">
                                        <!-- <button type="button" class="btn" onclick="window.location.href='login.php';">ยกเลิก</button> -->
                                        <button type="submit" class="btn btn-info">ยืนยัน</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ส่วนแสดงรหัสผ่าน
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? 'แสดง' : 'ซ่อน';
        });

        // ตรวจสอบความยาวของรหัสผ่าน
        document.getElementById('password').addEventListener('keyup', function() {
            const passwordValue = this.value;
            const passwordLengthElement = document.getElementById('passwordLength');
            if (passwordValue.length >= 8) {
                passwordLengthElement.textContent = '✓ รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัว';
                passwordLengthElement.style.color = 'green';
            } else {
                passwordLengthElement.textContent = '✗ รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัว';
                passwordLengthElement.style.color = 'red';
            }

            // ตรวจสอบว่ารหัสผ่านมีตัวอักษร a-z อย่างน้อย 1 ตัว
            const passwordCharRegex = /[a-z]/;
            const passwordCharElement = document.getElementById('passwordChar');
            if (passwordCharRegex.test(passwordValue)) {
                passwordCharElement.textContent = '✓ รหัสผ่านต้องมีตัวอักษร a-z อย่างน้อย 1 ตัว';
                passwordCharElement.style.color = 'green';
            } else {
                passwordCharElement.textContent = '✗ รหัสผ่านต้องมีตัวอักษร a-z อย่างน้อย 1 ตัว';
                passwordCharElement.style.color = 'red';
            }

            // ตรวจสอบว่ารหัสผ่านมีตัวเลข 0-9 อย่างน้อย 1 ตัว
            const passwordDigitRegex = /\d/;
            const passwordDigitElement = document.getElementById('passwordDigit');
            if (passwordDigitRegex.test(passwordValue)) {
                passwordDigitElement.textContent = '✓ รหัสผ่านต้องมีตัวเลข 0-9 อย่างน้อย 1 ตัว';
                passwordDigitElement.style.color = 'green';
            } else {
                passwordDigitElement.textContent = '✗ รหัสผ่านต้องมีตัวเลข 0-9 อย่างน้อย 1 ตัว';
                passwordDigitElement.style.color = 'red';
            }
        });

        // ส่วนเช็คว่ารหัสผ่านที่ป้อนเข้ามาทั้งสองช่องตรงกันหรือไม่
        const submitBtn = document.getElementById('submitBtn');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        document.getElementById('confirm_password').addEventListener('keyup', function() {
            const passwordValue = document.getElementById('password').value;
            const confirmPasswordValue = this.value;
            if (passwordValue === confirmPasswordValue) {
                passwordMatchMessage.textContent = '✓ รหัสผ่านตรงกัน';
                passwordMatchMessage.style.color = 'green';
                // submitBtn.disabled = false;
            } else {
                passwordMatchMessage.textContent = '✗ รหัสผ่านไม่ตรงกัน';
                passwordMatchMessage.style.color = 'red';
                // submitBtn.disabled = true;
            }
        });

        // ตรวจสอบว่าข้อความอันไหนไม่ขึ้นสีเขียว เมื่อกดส่งแล้วให้ alert บอกว่าข้อมูลนั้นยังไม่ถูกต้อง แล้วไม่สามารถส่งได้
        function validateForm() {
            const passwordLengthElement = document.getElementById('passwordLength');
            const passwordCharElement = document.getElementById('passwordChar');
            const passwordDigitElement = document.getElementById('passwordDigit');
            const passwordMatchMessage = document.getElementById('passwordMatchMessage');
            if (passwordLengthElement.style.color !== 'green' || passwordCharElement.style.color !== 'green' || passwordDigitElement.style.color !== 'green') {
                alert('รหัสผ่านไม่ตรงตามเงื่อนไข กรุณาตรวจสอบรหัสผ่านอีกครั้ง');
                return false;
            }
            if (passwordMatchMessage.style.color !== 'green') {
                alert('รหัสผ่านไม่ตรงกัน');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>
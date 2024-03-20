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
            <?php include("main_menu.php"); ?>
            <div class="my-3 my-md-5">
                <div class="page-header">
                    <h1 class="page-title"> </h1>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col col-login mx-auto"> <!--class -->
                            <form class="card frm_login" action="ForgotPassword-send.php" method="post" id="user_for_reset" style="border-radius: 1rem;" onsubmit="return validateInput();">
                                <div class="card_body p-6">
                                    <div class="card-herder">
                                        <h4>ค้นหาบัญชีของคุณ</h4>
                                    </div>
                                    <div class="card-title">กรุณากรอก User ของคุณเพื่อค้นหาบัญชีของคุณ</div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" style="height: 50px;" name="user" id="user" placeholder="กรอก User ของคุณที่นี้">
                                    </div>
                                    <div style="text-align: end;">
                                        <button type="button" class="btn" onclick="window.location.href='login.php';">ยกเลิก</button>
                                        <button type="submit" class="btn btn-info">ตกลง</button>
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
    function validateInput() {
        var userInput = document.getElementById("user").value;
        // เช็คว่า userInput เป็นตัวเลขทั้งหมดหรือไม่
        if (!/^\d+$/.test(userInput)) {
            alert("กรุณากรอกตัวเลขเท่านั้น");
            return false;
        }
        // เช็คว่ามีจำนวนตัวเลขเท่ากับ 11 หรือไม่
        // if (userInput.length !== 11) {
        //     alert("กรุณากรอกตัวเลขให้ครบ 11 หลัก");
        //     return false;
        // }
        // return true;
    }
</script>

</body>

</html>
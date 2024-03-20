<?php
session_start();
require_once("inc/db_connect.php");
$mysqli = connect();
// คำสั่งนับจำนวนข้อมูลต้อง doc_type และแสดงออกมา
$sql_1 = "SELECT doc_type, COUNT(*) AS count
        FROM request_doc
        GROUP BY doc_type;
        ";

// // คำสั่งนับจำนวนข้อมูล
// $sql_2 = "SELECT COUNT(*) AS total_count FROM `request_doc` WHERE doc_type = 31;";
// $result_2 = $mysqli->query($sql_2);
// $row_2 = $result_2->fetch_array();

?>

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
    <title>Graduate School MSU</title>

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
        .card {
            margin-top: 20px;
            height: 150px;
        }

        .card-2 {
            height: 250px;
        }

        h4 {
            text-align: center;
        }

        .container {
            width: 100%;
            padding-right: 0.75rem;
            padding-left: 0.75rem;
            margin-right: auto;
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="page-main">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>ฟอร์มขอลาพัก</h4>
                            </div>
                            <div class="card-body" id="1">

                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>ฟอร์มขอรักษาสภาพ(กรณีพิเศษ)</h4>
                            </div>
                            <div class="card-body" id="2">

                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>ฟอร์มขอลงทะเบียน Thesis</h4>
                            </div>
                            <div class="card-body" id="3">

                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h4>ฟอร์มขอคืนสภาพ</h4>
                            </div>
                            <div class="card-body" id="31">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="card card-2">
                            <iframe title="รวม-63-65-ป.เอก-ฉบับจริง" width="100%" height="100%" src="https://app.powerbi.com/view?r=eyJrIjoiZjhlNzIzNWUtZDdhOC00MDQ4LWE0ZWItNmMwM2FiODNmOWUxIiwidCI6Ijg4NzhmNjA2LWIwZTAtNGZjYS05ZmVkLWUwNjg4NmZhNTU5MSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card card-2">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var cardBodies = document.querySelectorAll('.card-body');
            cardBodies.forEach(function(cardBody) {
                var id = cardBody.id;
                fetch('form_dashboard_count.php?id=' + id)
                    .then(response => response.text())
                    .then(data => {
                        cardBody.innerHTML = data;
                    });
            });
        });
    </script>
</body>

</html>
<?php
session_start();
/*$id = $_SESSION[ "SES_ID" ];
$SES_STDCODE = $_SESSION[ "SES_STDCODE" ];
if ( $id == "" || $SES_STDCODE == "" ) {
	echo "<script>window.location.href = 'logout.php'</script>";
}*/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradis";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// กำหนดค่า id ที่ต้องการที่จะปิด จาก tr ต้องตรงกันกับ id ใน database
$ids = ['1', '2', '3', '31'];

echo "<script>";
// Initialize JavaScript arrays to store open and close times
echo "var openDateTimes = [];\n";
echo "var closeDateTimes = [];\n";

foreach ($ids as $id) {
  // SQL query to retrieve timestamp
  // ดึงเวลามาจาก database ที่ตรงกับ id 
  $sql = "SELECT OpenTime, CloseTime FROM request_doc_type WHERE doc_type_id = $id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Convert timestamps to formatted date strings
    $opentime_timestamp = strtotime($row['OpenTime']);
    $closetime_timestamp = strtotime($row['CloseTime']);
    $opentime_formatted = date("Y-m-d H:i:s", $opentime_timestamp);
    $closetime_formatted = date("Y-m-d H:i:s", $closetime_timestamp);

    // Display the results
    echo "console.log('Opentime For ID $id: $opentime_formatted');\n";
    echo "console.log('Closetime For ID $id: $closetime_formatted');\n";

    // Store open and close times in JavaScript arrays
    echo "openDateTimes[$id] = new Date('$opentime_formatted');\n";
    echo "closeDateTimes[$id] = new Date('$closetime_formatted');\n";
  } else {
    echo "console.log('ไม่พบข้อมูลสำหรับ id $id');\n";
  }
}

echo "</script>";


// ปิดการเชื่อมต่อ
$conn->close();
?>
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

  <style>
    td {
      overflow-wrap: break-word;
      /* หรือใช้ word-wrap: break-word; */
    }

    .table th:nth-child(1),
    .table td:nth-child(1),
    .table th:nth-child(3),
    .table td:nth-child(3) {
      white-space: nowrap;
    }

    
  </style>

</head>

<body>
  <div class="page">
    <div class="page-main">
      <?php include("main_menu.php"); ?>
      <div class="my-3 my-md-5">
        <div class="container">
          <div class="page-header">
            <h1 class="page-title"> </h1>
          </div>
          <?php

          //include $src_page;

          ?>
          <div class="row row-cards row-deck">
            <div class="col-12">
              <div class="card" style=" margin: 0px 0px 0px 0px;">
                <div class="card-header">
                  <h3 class="card-title">ประเภทแบบฟอร์ม</h3>
                </div>
                <div class="table-responsive">
                  <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <strong>หมายเหตุ! ให้นิสิตดำเนินการดังต่อไปนี้</strong> <br>
                    1. การยื่นคำร้องผ่านระบบ e-Form นิสิตต้องแจ้ง/ประสานอาจารย์ที่ปรึกษาทุกครั้ง <br>
                    2. กรณีที่อาจารย์ที่ปรึกษา <strong>ยังไม่ลงนามคำร้องในระบบ บัณฑิตวิทยาลัย ถือว่าคำร้องนั้นยังไม่ได้รับเข้าระบบคำร้องออนไลน์ e-Form และหากพ้นระยะเวลา 7 วัน นับจากวันที่นิสิตยื่น ระบบจะดำเนินการตัดคำร้องออกโดยอัตโนมัติ</strong><br>
                    3. ระบบคำร้อง e-Form จะมีการแจ้งอาจารย์ที่ปรึกษา ผ่านทาง e-mail ตามที่นิสิตกรอกในระบบ
                  </div>

                  <table class="table card-table table-vcenter  ">
                    <thead>
                      <tr>
                        <th class="w-1 ">No.</th>
                        <th>เอกสาร</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- กำหนด id เพื่อใช้ในการไปตรวจสอบกับ database เพื่อกำหนดเวลาเปิดปิด -->
                      <tr id="1">
                        <td><span class="">ทบ.มมส/โท-เอก 03</span></td>
                        <td><a href="Request_Form_Taking_Leave.php" class="text-inherit">คำร้องขอลาพักการเรียน/Request Form for Taking a Leave </a></td>
                        <td class="text-right"><!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                          <div class="dropdown"> <a href="Request_Form_Taking_Leave.php" class="btn btn-secondary btn-sm">Actions</a> </div>
                        </td>
                        <td><!--     <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>--></td>
                      </tr>
                      <!-- <tr>
                          <td>ทบ.มมส/โท-เอก 13</td>
                          <td><a href="?menu=Request_Form_Status_Retention_Special" class="text-inherit">คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ) /Student Status Retention Form (Special case) </a></td>
                          <td class="text-right">
                          <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                          <div class="dropdown">
                              <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                            </div>
                          </td>
                          <td>
                            <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>
                          </td>
                        </tr>-->
                        
                      <!-- กำหนด id เพื่อใช้ในการไปตรวจสอบกับ database เพื่อกำหนดเวลาเปิดปิด -->
                      <tr id="31">
                        <td>ทบ.มมส/โท-เอก 06</td>
                        <td><a href="Request_Form_Retaining_Student_Status.php" class="text-inherit">คำร้องขอคืนสภาพการเป็นนิสิต/Request Form for Retaining Student Status</a></td>
                        <!-- <td><a href="Request_Form_Retaining_Student_Status.php" class="text-inherit">คำร้องขอคืนสภาพการเป็นนิสิต/Request Form for Retaining Student Status</a ></td> -->
                        <td class="text-right"><!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                          <div class="dropdown"> <a href="Request_Form_Retaining_Student_Status.php" class="btn btn-secondary btn-sm">Actions</a> </div>
                        </td>
                        <td><!--   <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>--></td>
                      </tr>
                      <!-- กำหนด id เพื่อใช้ในการไปตรวจสอบกับ database เพื่อกำหนดเวลาเปิดปิด -->
                      <tr id="2">
                        <td>ทบ.มมส/โท-เอก 13</td>
                        <td><a href="Request_Form_Status_Retention_Special.php" class="text-inherit">คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)/Student Status Retention Form (Special case)
                            (ใช้สำหรับกรณีสอบจบวิทยานิพนธ์แล้วอยู่ระหว่างแก้ไขเล่ม/รอผลงานตีพิมพ์)</a></td>
                        <td class="text-right"><!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                          <div class="dropdown"> <a href="Request_Form_Status_Retention_Special.php" class="btn btn-secondary btn-sm">Actions</a></div>
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                      <!-- กำหนด id เพื่อใช้ในการไปตรวจสอบกับ database เพื่อกำหนดเวลาเปิดปิด -->
                      <tr id="3">
                        <td>ทบ.มมส/โท-เอก 14</td>
                        <td><a href="Request_Form_Registration_Thesis.php" class="text-inherit">คำร้องขอลงทะเบียน Thesis/Request Form for Registration for Thesis/IS </a></td>
                        <td class="text-right"><!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                          <div class="dropdown"> <a href="Request_Form_Registration_Thesis.php" class="btn btn-secondary btn-sm">Actions</a> </div>
                        </td>
                        <td><!--   <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a>--></td>
                      </tr>
                      <!-- กำหนด id เพื่อใช้ในการไปตรวจสอบกับ database เพื่อกำหนดเวลาเปิดปิด -->
                      <tr id="">
                        <td>แบบฟอร์ม</td>
                        <td><a href="" class="text-inherit">แบบฟอร์มขออนุมัติชื่อเรื่องวิทยานิพนธ์ และแต่งตั้งอาจารย์ที่ปรึกษาวิทยานิพนธ์ </a></td>
                        <td class="text-right">
                          <div class="dropdown"> <a href="Request_Form_Appointment.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Appointment_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div>
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr id="">
                        <td>แบบฟอร์ม</td>
                        <td><a href="" class="text-inherit">แบบฟอร์มขออนุมัติสอบเค้าโครงวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ
                            และแต่งตั้งคณะกรรมการสอบเค้าโครงวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ </a></td>
                        <td class="text-right">
                          <div class="dropdown"> <a href="Request_Form_Proposal_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Proposal_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div>
                        </td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr id="">
                        <td>แบบฟอร์ม</td>
                        <td><a href="" class="text-inherit">แบบฟอร์มขออนุมัติสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระและแต่งตั้งคณะกรรมการสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ </a></td>
                        <td class="text-right">
                          <div class="dropdown"> <a href="Request_Form_Thesis_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Thesis_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div>
                        </td>
                        <td>&nbsp;</td>
                      </tr>

                      <!-- <tr>
                                 <td colspan="3"><strong><font color="BLUE">แบบฟอร์มใหม่ (ระยะเวลาทดสอบระบบ ภาคต้น ปีการศึกษา 2562)</font></strong></td>
                                 <td>&nbsp;</td>
                               </tr>
                              <tr>
                          <td>ทบ.มมส/โท-เอก 04</td>
                          <td><a href="Request_Form_Student_Status_Retention.php" class="text-inherit">คำร้องขอชำระค่าเล่าเรียน/ค่าลงทะเบียน (ระดับบัณฑิตศึกษา) Student Status Tuition Registration Form (Graduate Student) ใช้สำหรับกรณียังไม่ขึ้นสอบจบวิทยานิพนธ์</a></td>
                          <td class="text-right">                           <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
-->
                      <!--  <div class="dropdown"> <a href="Request_Form_Student_Status_Retention.php" class="btn btn-secondary btn-sm">Actions</a> </div></td>-->
                      <!-- <td> <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a></td>
                        </tr>-->
                      <!-- <tr> -->
                      <!-- <td>ทบ.มมส/โท-เอก 08</td>
                          <td><a href="Request_Form_Change_Field_Study.php" class="text-inherit">คำร้องเปลี่ยนสาขาวิชา/Request Form to Change Field of Study</a></td>
                          <td class="text-right"><                      <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a> -->

                      <!--  <div class="dropdown"> <a href="Request_Form_Change_Field_Study.php" class="btn btn-secondary btn-sm">Actions</a> </div></td>
                          <td> <a class="icon" href="javascript:void(0)"> 
                              <i class="fe fe-edit"></i>
                            </a></td>
                        </tr> 
                               <tr>
                          <td>ทบ.มมส/โท-เอก 09</td>
                          <td><a href="Request_Form_Change_Study_Program.php" class="text-inherit">คำร้องเปลี่ยนแผนการเรียน/Request Form to Change Study Program</a></td>
                          <td class="text-right">                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                            <div class="dropdown"> <a href="Request_Form_Change_Study_Program.php" class="btn btn-secondary btn-sm">Actions</a> </div></td>
                          <td>< <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a></td>
                        </tr>
                               <tr>
                          <td>ทบ.มมส/โท-เอก 10</td>
                          <td><a href="Request_Form_Changing_Student_Status.php" class="text-inherit">คำร้องขอปรับเปลี่ยนสภาพนิสิต/Request Form for Changing Student Status</a></td>
                          <td class="text-right">                           <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                            <div class="dropdown"> <a href="Request_Form_Changing_Student_Status.php" class="btn btn-secondary btn-sm">Actions</a> </div></td>
                          <td><   <a class="icon" href="javascript:void(0)">
                              <i class="fe fe-edit"></i>
                            </a></td>
                        </tr>
                              <tr>
                                 <td>ทบ.มมส/โท-เอก 11</td>
                                 <td><a href="Request_Form_Extension_Period_Study.php" class="text-inherit">คำร้องขอหนังสือรับรองการขยายเวลาศึกษาต่อ/Request Form for Extension Period of Study </a></td>
                                 <td class="text-right">                           <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                                   <div class="dropdown"> <a href="Request_Form_Extension_Period_Study.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>-->
                      <!-- <tr>
                                 <td>ทบ.มมส/โท-เอก 12</td>
                                 <td><a href="Request_Form_Return_Work.php" class="text-inherit">คำร้องขอกลับเข้ารับราชการ /Request Form for Return to Work </a></td>
                                 <td class="text-right">                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                                    <div class="dropdown"> <a href="Request_Form_Return_Work.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr> -->
                      <!-- <tr>
                                 <td>ทบ.มมส/โท-เอก 13</td>
                                 <td><a href="Request_Form_Status_Retention_Special.php" class="text-inherit">คำร้องขอลงทะเบียนรักษาสภาพ (กรณีพิเศษ)/Student Status Retention Form (Special case)  (ใช้สำหรับกรณีสอบจบวิทยานิพนธ์แล้วอยู่ระหว่างแก้ไขเล่ม/รอผลงานตีพิมพ์)</a></td>
                                 <td class="text-right">                       <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a> -->

                      <!-- <div class="dropdown"> <a href="Request_Form_Status_Retention_Special.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr> -->
                      <!-- <tr>
                                 <td>ทบ.มมส/โท-เอก 15</td>
                                 <td><a href="Request_Form_Fee_Payment.php">คำร้องชำระค่าธรรมเนียมการศึกษา / Request Form for Fee Payment     </a></td>
                                 <td class="text-right">                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                                        <div class="dropdown"> <a href="Request_Form_Fee_Payment.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>-->
                      <!-- <tr>
                                 <td>ทบ.มมส/โท-เอก 16</td>
                                 <td><a href="Request_Form_Register_Sitting_In.php" class="text-inherit">คำร้องขอลงทะเบียนเรียนร่วม / Request Form to Register for Sitting In   </a></td>
                                 <td class="text-right"><                         <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>

                                <div class="dropdown"> <a href="Request_Form_Register_Sitting_In.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td>ทบ.มมส/โท-เอก 18</td>
                                 <td><a href="Request_Form_Registration_Audit.php" class="text-inherit">คำร้องขอลงทะเบียนเรียนเป็น Audit/ Request Form for Registration as an Audit </a></td>
                                 <td class="text-right">                           <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a> -->

                      <!-- <div class="dropdown"> <a href="Request_Form_Registration_Audit.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td>ทบ.มมส/โท-เอก 20</td>
                                 <td><a href="Request_Form_Group_Study_Changes.php">คำร้องขอเปลี่ยนกลุ่มเรียน /Request form for Group Study Changes  </a></td>
                                 <td class="text-right"> -->
                      <!--                            <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a> -->

                      <!-- <div class="dropdown"> <a href="Request_Form_Group_Study_Changes.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td>ทบ.มมส/โท-เอก 22</td>
                                 <td><a href="Request_Form_Subject_Cancellation.php">คำร้องของดเรียนรายวิชา / Request Form for Subject/s Cancellation </a></td>
                                 <td class="text-right"> <div class="dropdown"> <a href="Request_Form_Subject_Cancellation.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td>บันทึกข้อความ</td>
                                 <td><a href="Request_Form_Withdraw_Registration_Taking_Leave.php">ขออนุมัติถอนการลงทะเบียนเรียนเพื่อลาพักการเรียน </a></td>
                                 <td class="text-right"> <div class="dropdown"> <a href="Request_Form_Withdraw_Registration_Taking_Leave.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                               <tr>
                                 <td>บันทึกข้อความ</td>
                                 <td><a href="Request_Form_Withdraw_Taking_Leave_Registration.php">ขออนุมัติถอนการลาพักการเรียนเพื่อลงทะเบียน </a></td>
                                 <td class="text-right"> <div class="dropdown"> <a href="Request_Form_Withdraw_Taking_Leave_Registration.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                                 <tr>
                                   <td>บันทึกข้อความ</td>
                                   <td><a href="Request_Form_Document_Student_Grad.php">บันทึกข้อความ (ไม่ผ่านคณะ)</a></td>
                                   <td class="text-right"><div class="dropdown"> <a href="Request_Form_Document_Student_Grad.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                   <td>บันทึกข้อความ</td>
                                   <td><a href="Request_Form_Document_Student.php">บันทึกข้อความ (ผ่านคณะ)</a></td>
                                   <td class="text-right"><div class="dropdown"> <a href="Request_Form_Document_Student.php" class="btn btn-secondary btn-sm">Actions</a></div></td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                 <td>บันทึกข้อความ</td>
                                 <td><a href="">แบบฟอร์มบันทึกข้อความ (การชำระเงิน/หลักฐาน/รายงานตัวช้า) /Memorandum (payment/document/late registration) </a>>><a href="Request_Form_Memorandum_Student.php" class="btn btn-secondary btn-sm">ไทย</a> |<a href="Request_Form_Memorandum_Student_En.php" class="btn btn-secondary btn-sm">ENG</a></td>
                                 <td class="text-right"> <div class="dropdown"> <a href="Request_Form_Memorandum_Student.php" class="btn btn-secondary btn-sm">ไทย</a> |<a href="Request_Form_Memorandum_Student_En.php" class="btn btn-secondary btn-sm"> ENG</a></div></td>
                                 <td>&nbsp;</td>
                               </tr>
                                 <tr>
                                   <td>แบบฟอร์ม</td>
                                   <td><a href="">แบบฟอร์มขออนุมัติชื่อเรื่องวิทยานิพนธ์ และแต่งตั้งอาจารย์ที่ปรึกษาวิทยานิพนธ์ </a>>><a href="Request_Form_Appointment.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Appointment_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></td>
                                   <td class="text-right"><div class="dropdown"> <a href="Request_Form_Appointment.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Appointment_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div></td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                   <td>แบบฟอร์ม</td>
                                   <td><a href="">แบบฟอร์มขออนุมัติสอบเค้าโครงวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ
และแต่งตั้งคณะกรรมการสอบเค้าโครงวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ </a>>><a href="Request_Form_Proposal_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Proposal_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></td>
                                   <td class="text-right"><div class="dropdown"> <a href="Request_Form_Proposal_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Proposal_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div></td>
                                   <td>&nbsp;</td>
                                 </tr>
                                 <tr>
                                   <td>แบบฟอร์ม</td>
                                   <td><a href="">แบบฟอร์มขออนุมัติสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระและแต่งตั้งคณะกรรมการสอบวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ </a>>><a href="Request_Form_Thesis_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Thesis_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></td>
                                   <td class="text-right"><div class="dropdown"> <a href="Request_Form_Thesis_Examination.php" class="btn btn-secondary btn-sm">นิสิต</a> |<a href="Request_Form_Thesis_Examination_Adv.php" class="btn btn-secondary btn-sm"> อาจารย์</a></div></td>
                                   <td>&nbsp;</td>
                                 </tr>  -->
                    </tbody>
                  </table>

                </div>
                <br>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--<div class="footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-8">
              <div class="row">
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">First link</a></li>
                    <li><a href="#">Second link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Third link</a></li>
                    <li><a href="#">Fourth link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Fifth link</a></li>
                    <li><a href="#">Sixth link</a></li>
                  </ul>
                </div>
                <div class="col-6 col-md-3">
                  <ul class="list-unstyled mb-0">
                    <li><a href="#">Other link</a></li>
                    <li><a href="#">Last link</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mt-4 mt-lg-0">
              Premium and Open Source dashboard template with responsive and high quality UI. For Free!
            </div>
          </div>
        </div>
      </div>-->
    <footer class="footer">
      <div class="container">
        <div class="row align-items-center flex-row-reverse">
          <div class="col-auto ml-lg-auto">
            <div class="row align-items-center">
              <div class="col-auto">
                <!--   <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                    <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                  </ul>-->
              </div>
              <!--   <div class="col-auto">
                  <a href="https://github.com/tabler/tabler" class="btn btn-outline-primary btn-sm">Source code</a>
                </div>-->
            </div>
          </div>
          <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center"> Copyright © 2018 บัณฑิตวิทยาลัย มหาวิทยาลัยมหาสารคาม </div>
          <!-- Global site tag (gtag.js) - Google Analytics -->
          <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125434499-1"></script>
          <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
              dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-125434499-1');
          </script>
        </div>
      </div>
    </footer>
  </div>

  <!-- ควมคุมเวลาเปิดปิด -->
  <!-- ******* 1.ทำให้ฟอร์มหายไป -->
  <!-- <script>
    function checkTime() {
      var currentTime = new Date();

      <?php foreach ($ids as $id) : ?>
        var element = document.getElementById('<?php echo $id; ?>');

        if (currentTime >= openDateTimes[<?php echo $id; ?>] && currentTime <= closeDateTimes[<?php echo $id; ?>]) {
          element.style.display = 'table-row';
        } else {
          element.style.display = 'none';
        }
      <?php endforeach; ?>
    }

    // เช็ดเวลาต่อ 1 นาที
    setInterval(checkTime, 60000);

    checkTime();
  </script> -->

  <!-- ***** 2.ฟอร์มไม่หายแต่ถ้าไม่ถึงเวลาเปิดฟอร์มจะไม่สามารถเข้าได้ -->
  <!-- <script>
  function checkTime() {
    var currentTime = new Date();

    <?php foreach ($ids as $id) : ?>
      var element = document.getElementById('<?php echo $id; ?>');
      
      if (currentTime >= openDateTimes[<?php echo $id; ?>] && currentTime <= closeDateTimes[<?php echo $id; ?>]) {
        // element อยู่ในช่วงเวลาที่กำหนด
      } else {
        // element ไม่อยู่ในช่วงเวลาที่กำหนด
        element.onclick = function() {
          alert('หมดเวลาส่งแบบฟอร์มแล้ว');
          return false; // ยกเลิกการทำงานต่อไป
          
        };
      }
    <?php endforeach; ?>
  }

  // เช็ดเวลาต่อ 1 นาที
  setInterval(checkTime, 60000);

  checkTime();
  </script> -->


</body>

</html>
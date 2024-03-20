<div class="header py-4">
  <div class="container">
    <div class="d-flex">
      <a class="header-brand" href="./index.php">        
        <img src="./demo/brand/e-from.png" class="header-brand-img" alt="tabler logo">
      </a>
      <div class="d-flex order-lg-2 ml-auto">
        <div class="nav-item d-none d-md-flex">
          <!-- <a href="https://github.com/tabler/tabler" class="btn btn-sm btn-outline-primary" target="_blank">Source code</a>-->
        </div>
        <?php
        if (isset($_SESSION["SES_USER"]) || isset($_SESSION['SES_STDCODE'])) {
          //echo "IN";
        ?>
          <div class="dropdown d-none d-md-flex">
            <a class="nav-link icon" data-toggle="dropdown">
              <i class="fe fe-bell"></i>
              <span class="nav-unread"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
              <a href="#" class="dropdown-item d-flex">
                <span class="avatar mr-3 align-self-center" style="background-image: 
              url(images/user.jpg)"></span>
                <div>

                  <div class="small text-muted">-</div>
                </div>
              </a>


              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
            </div>
          </div>
        <?php
        }
        ?>
        <div class="dropdown">
          <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
            <?php

            if (isset($_SESSION["SES_USER"]) || isset($_SESSION['SES_STDCODE'])) {
              //echo "IN";
            ?>
              <span class="avatar" style="background-image: url(images/user.jpg)"></span>
              <span class="ml-2 d-none d-lg-block">
                <?php
                if (isset($_SESSION['SES_STDCODE']) != '') {
                  echo $_SESSION['SES_STDNAME_FULL_TH'];
                ?><small class="text-muted d-block mt-1">Student</small>
                <?php
                } else if ($_SESSION['SES_LEVEL'] == 'advisor_ses') {
                ?>
                  <small class="text-muted d-block mt-1">Advisor</small>
                <?php
                } else if ($_SESSION['SES_LEVEL'] == 'staff_ses') {
                ?>
                  <small class="text-muted d-block mt-1">Staff</small>
                <?php
                } else if ($_SESSION['SES_LEVEL'] == 'admin_ses') {
                ?>
                  <small class="text-muted d-block mt-1">admin</small>
                <?php

                } else if ($_SESSION['SES_LEVEL'] == 'office') {
                ?>
                  <small class="text-muted d-block mt-1">staff</small>
              <?php
                }
              }
              ?>
              </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
            <a class="dropdown-item" href="profile.php">
              <i class="dropdown-icon fe fe-user"></i> Profile
            </a>
            <!--          <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="#">
                      <span class="float-right"><span class="badge badge-primary">6</span></span>
                      <i class="dropdown-icon fe fe-mail"></i> Inbox
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>-->
            <a class="dropdown-item" href="logout.php">
              <i class="dropdown-icon fe fe-log-out"></i> Sign out
            </a>
          </div>
        </div>
      </div>
      <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
        <span class="header-toggler-icon"></span>
      </a>
    </div>
  </div>
</div>
<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg order-lg-first">
        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
          <li class="nav-item">
            <a href="index.php" class="nav-link "><i class="fe fe-home"></i> Home</a>
          </li>
          <li class="nav-item">
            <!-- <?php
                  if (isset($_SESSION['SES_STDCODE']) != '') {
                  ?><a href="form_request_doc.php" class="nav-link"><i class="fe fe-file-text"></i> แบบฟอร์มคำร้อง</a>
            <?php
                  } else if (isset($_SESSION['SES_LEVEL']) == 'person_ses') {
            ?>
              <a href="form_request_persor.php" class="nav-link"><i class="fe fe-file-text"></i> แบบฟอร์มคำร้อง</a>
            <?php
                  } else if (isset($_SESSION['SES_LEVEL']) == 'staff_ses') {
            ?>
              <a href="staff.php" class="nav-link"><i class="fe fe-file-text"></i> แบบฟอร์มคำร้อง</a>
            <?php
                  } else { ?>
              <a href="form_request_doc.php" class="nav-link"><i class="fe fe-file-text"></i> แบบฟอร์มคำร้อง</a>
            <?php
                  }
            ?> -->
            <?php
            if (isset($_SESSION['SES_STDCODE']) && $_SESSION['SES_STDCODE'] != '') {
              $form_link = 'form_request_doc.php';
            } else if (isset($_SESSION['SES_LEVEL']) && $_SESSION['SES_LEVEL'] == 'person_ses') {
              $form_link = 'form_request_persor.php';
            } else if (isset($_SESSION['SES_LEVEL']) && $_SESSION['SES_LEVEL'] == 'staff_ses') {
              $form_link = 'staff.php';
            } else {
              $form_link = 'form_request_doc.php';
            }
            ?>

            <a href="<?php echo $form_link; ?>" class="nav-link"><i class="fe fe-file-text"></i> แบบฟอร์มคำร้อง</a>

            <!--     <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="?menu=form_request_doc" class="dropdown-item ">บริการวิชาการ</a>
                      <a href="?menu=form_request_doc" class="dropdown-item ">มาตรบทนิพนธ์</a>
                      <a href="./pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                      </div>-->
          </li>
          <li class="nav-item dropdown">

            <?php
            if (isset($_SESSION['SES_STDCODE']) != '') {
            ?><a href="student.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php
            } else if (isset($_SESSION['SES_LEVEL']) == 'advisor_ses') {
            ?>
              <a href="advisor.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php
            } else if (isset($_SESSION['SES_LEVEL']) == 'staff_ses') {
            ?>
              <a href="staff.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php
            } else if (isset($_SESSION['SES_LEVEL']) == 'admin_ses') {
            ?>
              <a href="admin.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php

            } else if (isset($_SESSION['SES_LEVEL']) == 'person_ses') {
            ?>
              <a href="person.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php

            } else if (isset($_SESSION['SES_LEVEL']) == 'office') {
            ?>
              <a href="staff_office.php" class="nav-link"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
            <?php

            } else { ?>

              <a href="#" class="nav-link" onclick="myFunction()"><i class="fe fe-check-square"></i> ตรวจสอบเอกสาร</a>
              <script>
                function myFunction() {
                  var result = confirm("กรุณาเข้าสู่ระบบ/Please Login");
                  if (result) {
                    // ถ้ากด ok ให้ไปที่หน้า login.php
                    window.location.href = "login.php";
                  } else {
                    // ถ้ากด cancel ให้อยู่หน้าเดิม
                    // หรือทำอย่างอื่นตามที่ต้องการ 
                  }
                }
              </script>
            <?php  }

            ?>
          </li>
          <li class="nav-item">
            <a href="http://gg.gg/hsuwn" class="nav-link"><i class="fe fe-bar-chart-2"></i>ประเมินความพึงพอใจ</a>
          </li>
          <!-- <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-calendar"></i> ปฏิทินต่างๆ</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./maps.html" class="dropdown-item ">Maps</a>
                      <a href="./icons.html" class="dropdown-item ">Icons</a>
                      <a href="./store.html" class="dropdown-item ">Store</a>
                      <a href="./blog.html" class="dropdown-item ">Blog</a>
                      <a href="./carousel.html" class="dropdown-item ">Carousel</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-message-square"></i> คำถามที่พบบ่อย</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./profile.html" class="dropdown-item ">Profile</a>
                      <a href="./login.html" class="dropdown-item ">Login</a>
                      <a href="./register.html" class="dropdown-item ">Register</a>
                      <a href="./forgot-password.html" class="dropdown-item ">Forgot password</a>
                      <a href="./400.html" class="dropdown-item ">400 error</a>
                      <a href="./401.html" class="dropdown-item ">401 error</a>
                      <a href="./403.html" class="dropdown-item ">403 error</a>
                      <a href="./404.html" class="dropdown-item ">404 error</a>
                      <a href="./500.html" class="dropdown-item ">500 error</a>
                      <a href="./503.html" class="dropdown-item ">503 error</a>
                      <a href="./email.html" class="dropdown-item ">Email</a>
                      <a href="./empty.html" class="dropdown-item ">Empty page</a>
                      <a href="./rtl.html" class="dropdown-item ">RTL mode</a>
                    </div>
                  </li>-->


          <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-calendar"></i> ขั้นตอนการใช้งานระบบ</a>
            <div class="dropdown-menu dropdown-menu-arrow">
              <a href="form/system_student.pdf" class="dropdown-item " target="_blank">สำหรับนิสิต</a>
              <a href="form/system_advisor.pdf" class="dropdown-item " target="_blank">สำหรับอาจารย์</a>


            </div>
          </li>
          <!-- <li class="nav-item">
                    <a href="./gallery.html" class="nav-link"><i class="fe fe-image"></i> ระเบียบข้อบังคับ</a>
                  </li>-->
          <li class="nav-item dropdown" id="setTime">
            <?php
            if (isset($_SESSION['SES_LEVEL']) == 'staff_ses') { ?>
              <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-settings"></i> ตั้งค่าเพิ่มเติม</a>
              <div class="dropdown-menu dropdown-menu-arrow">
                <a href="form_setTime.php" class="dropdown-item"><i class="fa fa-clock-o"></i> แก้ไขเวลาเปิด-ปิดฟอร์ม</a>
                <a href="form_set_SemesterAndAcademic.php" class="dropdown-item"><i class="fa fa-pencil-square-o"></i> กำหนดเทอมล่าสุดที่เปิดรับฟอร์มคืนสภาพ</a>
              </div>
            <?php
            }
            ?>
          </li>

          <li class="nav-item">
            <?php
            if (isset($_SESSION["SES_USER"]) || isset($_SESSION['SES_STDCODE'])) {
              //echo "IN";
            ?>
              <a class="nav-link" href="logout.php">
                <i class="dropdown-icon fe fe-log-out"></i> Sign out
              </a>
            <?php
            } else {
            ?>
              <a href="login.php" class="nav-link"><i class="fe fe-log-in"></i> Login</a>
            <?php
            }
            ?>
          </li>



          <!--  <li class="nav-item">
                    <a href="./docs/index.html" class="nav-link"><i class="fe fe-file-text"></i> Documentation</a>
                  </li>-->
        </ul>
      </div>
    </div>
  </div>
</div>

<script>
  <?php
  // ถ้า session `SES_LEVEL` มีค่าและเท่ากับ 'staff_ses'
  if (isset($_SESSION['SES_LEVEL']) && $_SESSION['SES_LEVEL'] == 'staff_ses') {
  ?>
    // แสดงเมนู setTime เมื่อหน้าเว็บโหลด
    document.addEventListener('DOMContentLoaded', function() {
      var setTimeMenu = document.getElementById('setTime');
      setTimeMenu.style.display = 'block';
    });
  <?php
  } else {
  ?>
    // ซ่อนเมนู setTime เมื่อหน้าเว็บโหลด
    document.addEventListener('DOMContentLoaded', function() {
      var setTimeMenu = document.getElementById('setTime');
      setTimeMenu.style.display = 'none';
    });
  <?php
  }
  ?>
</script>
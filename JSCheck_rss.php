<?php
    session_start();
    require_once("inc/db_connect.php");
    $mysqli = connect();
    
    // กรองข้อมูลที่ผู้ใช้ป้อนเข้ามา (เพื่อป้องกันการโจมตี SQL injection)
    $academic = isset($_REQUEST['academic']) ? intval($_REQUEST['academic']) : 0;
    $semester = isset($_REQUEST['semester']) ? intval($_REQUEST['semester']) : 0;

    // เตรียมและผูกคำสั่ง SQL เพื่อป้องกันการโจมตี SQL injection
    $sql = "SELECT * FROM request_rss WHERE academic = ? AND semester = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $academic, $semester);
    $stmt->execute();
    $results = $stmt->get_result();

    // วนลูปผลลัพธ์
    foreach ($results as $row) { 
        $sql_loop = "SELECT * FROM request_rss WHERE rss_id >= ? AND rss_id != (SELECT MAX(rss_id) FROM request_rss)";
        $stmt_loop = $mysqli->prepare($sql_loop);
        $stmt_loop->bind_param("i", $row['rss_id']);
        $stmt_loop->execute();
        $results_loop = $stmt_loop->get_result();

        // แสดงข้อมูลที่ดึงมา
        foreach ($results_loop as $row_loop) {
            echo '<div class="col-md-4">
                    <label class="form-label">ภาคเรียน/semester</label>
                    <input class="form-control" type="text" name="tl_semester[]" readonly rows="7" value="' . $row_loop['semester'] . '">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">ปีการศึกษา/Academic year</label>
                    <input id="group" class="form-control" type="text" name="tl_academic[]" readonly rows="7" value="' . $row_loop['academic'] . '">                
                  </div>
                  <div class="col-md-4">
                  </div>';
        }
    }
?>

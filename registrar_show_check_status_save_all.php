<?php
@session_start();
require_once("inc/db_connect.php");
$mysqli = connect();
date_default_timezone_set("Asia/Bangkok");
?>


<?php
if (isset($_POST['submit'])) {
    $doc_id = $_POST['doc_id'];
    $type_doc = $_POST['type_doc'];
    $node = $_POST['node'];
    $registration_division_status = $_POST['registration_division_status'];
    if ($type_doc == 1) { //ลาพักการเรียน
        $sql_up = "Update request_taking_leave set registration_division_status='$registration_division_status',registration_division_node='$node'  Where doc_id=" . $doc_id;
        $mysqli->query($sql_up);
?>
        <script>
            history.back();
        </script>
    <?php
    } else if ($type_doc == 3) { //ลงะทเบียน
        $sql_up = "Update request_registration_thesis_is set registration_division_status='$registration_division_status',registration_division_node='$node'   Where doc_id=" . $doc_id;
        $mysqli->query($sql_up);
    ?>
        <script>
            history.back();
        </script>
    <?php
    } else if ($type_doc == 13) { //รักษาสภาพกรณีพิเศษ
        $sql_up = "Update request_status_retention set registration_division_status='$registration_division_status',registration_division_node='$node'   Where doc_id=" . $doc_id;
        $mysqli->query($sql_up);
    ?>
        <script>
            history.back();
        </script>
    <?php
    } else if ($type_doc == 31) { //รักษาสภาพกรณีพิเศษ
        $sql_up = "Update request_retaining_student_status set registration_division_status='$registration_division_status',registration_division_node='$node'   Where doc_id=" . $doc_id;
        $mysqli->query($sql_up);
    ?>
        <script>
            history.back();
        </script>
<?php
    }
} else {
}

?>
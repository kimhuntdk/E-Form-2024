<?php
session_start();
date_default_timezone_set( "Asia/Bangkok" );
require_once( "inc/db_connect.php" );
$mysqli = connect();
 $chk_id = $_POST['chk_id'];
 $type_doc = $_POST['type_doc'];
//$user = $_SESSION['SES_EN_REG_USER'];
if($type_doc==1){//คำร้องลาพักการเรียน
      $sql = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_taking_leave.doc_id='$chk_id' ";
$result = $mysqli->query( $sql );
}else if($type_doc==3){//คำร้องลงเบียน
      $sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_registration_thesis_is.doc_id='$chk_id'  ";
$result = $mysqli->query( $sql );
}else if($type_doc==13){//รักษาสภาพกรณีพิเศษ
     $sql = "SELECT * FROM request_doc LEFT JOIN request_status_retention ON request_doc.doc_id=request_status_retention.doc_id WHERE request_status_retention.doc_id='$chk_id'";
$result = $mysqli->query( $sql );
} else if($type_doc==31){//คืนสภาพการเป็นนิสิต
      $sql = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_retaining_student_status.doc_id='$chk_id'";
 $result = $mysqli->query( $sql );
 } else{
	echo "<script> window.location ='../logout.php'; </script>"; // ไป form 5
}

        
$row = $result->fetch_array();
$registration_division_status = $row['registration_division_status'];
$registration_division_node = $row['registration_division_node'];
?>
<form class="needs-validation" name="form_gs" action="registrar_show_check_status_save.php" method="post" >
<h4 class="bg-warning">Form จัดการสถานะ : </h4>
    
<div class="col-md-8">
    <label>REGISTRATION Status :</label>
                        <select class="form-control" name="registration_division_status" id="registration_division_status" required>
                          <option value="0" <?php if($registration_division_status==0){ echo "selected"; } ?> >In progress</option>
                          <option value="1" <?php if($registration_division_status==1){ echo "selected"; } ?>>Approved</option>
                          <option value="9" <?php if($registration_division_status==9){ echo "selected"; } ?>>Disapproved</option>
                       </select>
</div>
<div class="col-md-8">
                <label>ข้อความกองทะเบียน :</label>    
                <textarea class="form-control" name="node" placeholder="ข้อความกองทะเบียน"><?php echo  $registration_division_node;?></textarea>
</div>
<hr class="mb-4">

        <input type="submit" name="submit" value="Submit"   class="btn btn-primary btn-lg btn-block">
        <input type="hidden" name="doc_id" value="<?=$chk_id;?>">
        <input type="hidden" name="type_doc" value="<?=$type_doc;?>">
</form>


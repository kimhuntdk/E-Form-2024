<?php
session_start();
$SES_LEVEL = $_SESSION["SES_LEVEL"];
$doc_id = base64_decode($_REQUEST[doc_id]);
if($$SES_LEVEL == "staff_ses" || $_SESSION["SES_USER"]==""){
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();
//=========แสดงข้อมูลนิสิตที่ยื่นเอกสาร======================
 $sql = "SELECT * FROM request_doc LEFT JOIN request_taking_leave ON request_doc.doc_id=request_taking_leave.doc_id WHERE request_doc.doc_id=".$doc_id;
 $result = $mysqli->query($sql);
 $row = $result->fetch_array();
 //=========แสดงข้อมูลนิสิต======================
  $sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
  $rs_name = $mysqli->query($sql_name);
  $row_name = $rs_name->fetch_array();
?>
<div class="row row-cards row-deck">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Request Form for Taking a Leave</h3>
      </div>
      <div class="card-body">
      <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-status bg-yellow"></div>
                  <div class="card-header">
                    <h3 class="card-title">ข้อมูลนิสิต</h3>
                    <div class="card-options">
                      <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                      <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td><b>ชื่อ</b> <?php echo $row_name['std_fname_th'];?>&nbsp;<?php echo $row_name['std_lname_th'];?>&nbsp;&nbsp;<b>รหัสประจำตัวนิสิต</b>&nbsp; <?php echo $row_name['std_id_std'];?>&nbsp;<?php echo $row_name['std_degree_th'];?> &nbsp;<?php echo $row_name['std_faculty_th'];?> &nbsp;<b>สาขา</b><?php echo $row_name['std_major_th'];?></td>
            </tr>
            <tr>
              <td></td>
            </tr>
          </tbody>
        </table>
                  </div>
                </div>
              </div>
        <form action="Javascript:void(0);" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-12">มีความประสงค์ขอลาพักการเรียน/ Would like to take a leave in <span class="form-required">*</span> </label>
            </div>
          </div>
         
           <div class="form-group col-sm-9">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" <?php if($row['semester']=="1") { echo "checked"; } ?> disabled  >
                <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2" <?php if($row['semester']=="2") { echo "checked"; } ?> disabled >
                <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="3" <?php if($row['semester']=="3") { echo "checked"; } ?> disabled >
                <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label"> ปีการศึกษา/ Academic year</label>
            <select class="custom-select" id="academic" name="academic" disabled>
              <option value="0">เลือก ปีการศึกษา/ Academic year</option>
              <option value="2561" <?php if($row['academic']=="2561") { echo "selected"; } ?>>2561</option>
              <option value="2560" <?php if($row['academic']=="2560") { echo "selected"; } ?> >2560</option>
              <option value="2559" <?php if($row['academic']=="2559") { echo "selected"; } ?>>2559</option>
              <option value="2558" <?php if($row['academic']=="2558") { echo "selected"; } ?>>2558</option>
              <option value="2557" <?php if($row['academic']=="2557") { echo "selected"; } ?>>2557</option>
              <option value="2556" <?php if($row['academic']=="2556") { echo "selected"; } ?>>2556</option>
              <option value="2555" <?php if($row['academic']=="2555") { echo "selected"; } ?>>2555</option>
              <option value="2554" <?php if($row['academic']=="2554") { echo "selected"; } ?>>2554</option>
            </select>
          </div>
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">เนื่องจาก/ because</label>
              <div class="col-sm-10"> 
                <input type="text" class="form-control" id="because" name="because" value="<?php echo $row['because'];?>" disabled>
              </div>
            </div>
          </div>

          <div class="row align-items-center">
            <label class="col-sm-12">กรณีได้อนุมัติให้ทำวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ/ Getting the approval to do thesis/independent study </label>
          </div>
          <div class="form-group">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="finished_a" class="custom-control-input" name="finished_a" value="1" >
                <span class="custom-control-label">งานที่ทำแล้วเสร็จ/ The finished assignment: </span>
                <input type="text" class="form-control" id="finished_assignment" placeholder="" disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unfinished_a" class="custom-control-input" name="unfinished_a" value="1">
                <span class="custom-control-label">งานที่กำลังทำ / The unfinished assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unfinished_assignment"  disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unstarting_a" class="custom-control-input" name="unstarting_a" value="1" >
                <span class="custom-control-label">งานที่ยังไม่ทำ/ The unstarting assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unstarting_assignment" disabled>
              </label>
            </div>
          </div>
          
                <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-3">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์
(Advisor/Chairman of Thesis) <span class="form-required">*</span></label>
              <div class="col-sm-9">
               <?php
               	
				 $sql_advisor = "Select prefixname,advisorname,advisorsurname FROM request_advisor WHERE advisorcode = '$row[advisor_chairman]' ";
                 $rs_advisor = $mysqli->query($sql_advisor);
                  $row_advisor = $rs_advisor->fetch_array();
				 	echo $row_advisor['prefixname'].$row_advisor['advisorname']." ".$row_advisor['advisorsurname'];
				  ?>
              </div>
            </div>
          </div>
            <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2 form-label">พิจารณาคำร้อง<span class="form-required">*</span></label>
              <div class="col-sm-10"> 
                   <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove"  onClick="staff_grad_approve_disapprove(1)"  id="staff_grad_approve_disapprove" value="1"  >
                <span class="custom-control-label">เสนอเรื่องเพื่อพิจารณา</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove" onClick="staff_grad_approve_disapprove(2)"  id="staff_grad_approve_disapprove" value="2" >
                <span class="custom-control-label">แบบฟอร์ไม่ถูกต้อง</span> </label>
                <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input staff_grad_approve_disapprove" name="staff_grad_approve_disapprove" onClick="staff_grad_approve_disapprove(3)"  id="staff_grad_approve_disapprove" value="3" >
                <span class="custom-control-label">ส่งคืนนิสิต</span>(มีแก้ไข) </label>
              </div>
            </div>
          </div>
           <div class="form-group">
            <label class="form-label">ส่งเรื่องให้ผู้บริหาร<span class="form-required">*</span></label>
            <select class="custom-select" id="dean_admin" name="dean_admin" disabled>
              <option value="0">เลือกผู้บริการ</option>
              <option value="2">คณบดีบัณฑิตวิทยาลัย</option>
              <option value="3">รองคณบดีบัณฑิตวิทยาลัย ฝ่ายบริหาร</option>
              <option value="4">รองคณบดีบัณฑิตวิทยาลัย ฝ่ายวิชาการ </option>
              <option value="5">รองคณบดีบัณฑิตวิทยาลัยฝ่ายประกันคุณภาพการศึกษาและกิจการพิเศษ</option>
            </select>
          </div>
            <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">เหตุผล</label>
              <div class="col-sm-10"> 
                 <textarea name="argument" id="argument" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <div class="btn-list mt-4 text-left">
          <input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>">
            <button type="submit" id="btnSaveSign"  class="btn btn-primary btn-space">Save Data</button>
            <button type="button" class="btn btn-secondary btn-space">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$( ".staff_grad_approve_disapprove" ).click(function() { //ตรวจสอบก่อนว่าส่งพิจารณาค่อยมีเลือกผู้บริหารแสดงออกมา
  var staff_grad_approve_disapprove = $( "input[type=radio][name=staff_grad_approve_disapprove]:checked" ).val();
        if (staff_grad_approve_disapprove==1) {
            $("#dean_admin").removeAttr('disabled');
        } else {
			$("#dean_admin").attr('disabled','disabled');
			$("#dean_admin").val('');
		}
});
</script> 
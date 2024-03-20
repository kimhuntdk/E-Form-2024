<?php
session_start();
$id = $_SESSION['SES_ID'];
$doc_id = base64_decode($_REQUEST[doc_id]);
if($id == "" || $_SESSION["SES_STDCODE"]==""){
	echo "<script>window.location.href = 'logout.php'</script>";
}
require_once( "inc/db_connect.php" );
$mysqli = connect();
//=========แสดงข้อมูลนิสิตที่ยื่นเอกสาร======================
 $sql = "SELECT * FROM request_doc LEFT JOIN request_registration_thesis_is ON request_doc.doc_id=request_registration_thesis_is.doc_id WHERE request_doc.doc_id=".$doc_id;
 $result = $mysqli->query($sql);
 $row = $result->fetch_array();
 $staff_grad_approve_disapprove = $row['staff_grad_approve_disapprove'];
 //=========แสดงข้อมูลนิสิต======================
  $sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
  $rs_name = $mysqli->query($sql_name);
  $row_name = $rs_name->fetch_array();
  //======== ข้อความที่มีแก้ไข========
  $sql_edit = "Select repatriate_node,repatriate_date FROM request_repatriate WHERE doc_id=".$doc_id;
  $rs_edit = $mysqli->query($sql_edit);
  $row_edit = $rs_edit->fetch_array();
?>

<div class="row row-cards row-deck">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><strong>Request Form for Registration for  Thesis/IS </strong></h3>
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
                
                      <div class="card">
                  <div class="card-status bg-green"></div>
                  <div class="card-header">
                    <h3 class="card-title">ข้อความตอบกลับจากเจ้าหน้าที่</h3>
                    <div class="card-options">
                      <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                      <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                      <?php
                      	echo $row_edit['repatriate_node']."  ";
						echo "วันที่ ".$row_edit['repatriate_date'];
					  ?>
                  </div>
                </div>
                
              </div>
        <form action="javascipt:;" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-12">มีความประสงค์ขอลงทะเบียน/ would like to register</label>
            </div>
          </div>
          <div class="form-group col-sm-9">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="type_thesis" <?php if($row['status_thesis_is']=="Thesis") { echo "checked"; } ?> id="type_thesis" value="Thesis"  <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";} ?> >
                <span class="custom-control-label">Thesis</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="type_thesis" <?php if($row['status_thesis_is']=="IS") { echo "checked"; } ?> id="type_thesis" value="IS" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>
                <span class="custom-control-label">IS</span> </label>
            </div>
          </div>
          <div class="form-group">
            <div class="row align-items-right">
              <label class="col-sm-2 align-items-right">รหัสวิชา/ subject code</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" placeholder="รหัสวิชา" id="subject_code" name="subject code" value="<?php echo $row['subject_code'];?>" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>
              </div>
              <label class="col-sm-2 align-items-right">เพิ่มอีก (more)</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" placeholder="จำนวนหน่วยกิต" id="credits" name="credits" value="<?php echo $row['credits'];?>" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>
              </div>
              <label class="col-sm-2">หน่วยกิต (credits)</label>
            </div>
          </div>
          <div class="form-group col-sm-9">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1" <?php if($row['semester']=="1") { echo "checked"; } ?> <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>  >
                <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2" <?php if($row['semester']=="2") { echo "checked"; } ?> <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?> >
                <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="3" <?php if($row['semester']=="3") { echo "checked"; } ?> <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?> >
                <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label"> ปีการศึกษา/ Academic year</label>
            <select class="custom-select" id="academic" name="academic" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>
              <option value="0">เลือก ปีการศึกษา/ Academic year</option>
              <option value="2561" <?php if($row['academic']=="2561") { echo "selected"; } ?>>2561</option>
              <option value="2560" <?php if($row['academic']=="2560") { echo "selected"; } ?>>2560</option>
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
                <input type="text" class="form-control" id="because" name="because" value="<?php echo $row['because'];?>" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>
              </div>
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
    <?php /*?>        <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">พิจารณาคำร้อง<span class="form-required">*</span></label>
              <div class="col-sm-10"> 
                  <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_status"  id="advisor_chairman_status" value="1" <?php if($row['advisor_chairman_status']=="1") { echo "checked"; } ?> <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>  >
                <span class="custom-control-label">อนุมัติ</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="advisor_chairman_status" id="advisor_chairman_status" value="2" <?php if($row['advisor_chairman_status']=="2") { echo "checked"; } ?> <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>  >
                <span class="custom-control-label">ไม่อนุมัติ</span> </label>
              </div>
            </div>
          </div>
            <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">เหตุผล<span class="form-required">*</span></label>
              <div class="col-sm-10"> 
                 <textarea name="argument" id="argument" class="form-control" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>></textarea>
              </div>
            </div>
          </div><?php */?>
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">ลงชื่อ/ signature <span class="form-required">*</span></label>
              <div class="col-sm-10">
              <img src="digital-e-signature/doc_signs/<?=$row["std_signature"];?>.png">
                <?php /*?><div id="signArea" > 
                  <!--<h2 class="tag-ingo">Put signature below,</h2>-->
                  <div class="sig sigWrapper" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="250" height="100">
                    </canvas>
                  </div>
                </div>
                <button id="btnClearSign2" class="btn btn-secondary btn-space">Clar Signature</button><?php */?>
                <!--<button id="btnSaveSign">Save Signature</button>--> 
              </div>
            </div>
          </div>
          <!-- <div class="row align-items-center">
            <label class="col-sm-12">กรณีได้อนุมัติให้ทำวิทยานิพนธ์/การศึกษาค้นคว้าอิสระ/ Getting the approval to do thesis/independent study </label>
          </div>
          <div class="form-group">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="finished_a" class="custom-control-input" name="example-checkbox1" value="option1" >
                <span class="custom-control-label">งานที่ทำแล้วเสร็จ/ The finished assignment: </span>
                <input type="text" class="form-control" id="finished_assignment" placeholder="" disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unfinished_a" class="custom-control-input" name="example-checkbox2" value="option2">
                <span class="custom-control-label">งานที่กำลังทำ / The unfinished assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unfinished_assignment"  disabled>
              </label>
              <label class="custom-control custom-checkbox">
                <input type="checkbox" id="unstarting_a" class="custom-control-input" name="example-checkbox3" value="option3" >
                <span class="custom-control-label">งานที่ยังไม่ทำ/ The unstarting assignment: </span>
                <input type="text" class="form-control" placeholder="" id="unstarting_assignment" disabled>
              </label>
            </div>
          </div>-->
          <div class="btn-list mt-4 text-left">
           	<input type="hidden" name="doc_id" id="doc_id" value="<?=$doc_id?>">
            <input type="hidden" name="edit_thesis_is" value="edit_thesis_is">
            <button type="submit" id="btnSaveSign" class="btn btn-primary btn-space" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>Save Data</button>
            <button type="reset" class="btn btn-secondary btn-space" <?php if($staff_grad_approve_disapprove !=3) { echo "disabled";}?>>Cancel</button>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Jquery Core Js --> 

<!-- Bootstrap Core Js --> 
<!--<script src="digital-e-signature/js/bootstrap.min.js"></script>--> 

<!-- Bootstrap Select Js --> 
<!--<script src="digital-e-signature/js/bootstrap-select.js"></script>
-->

<!--<script src="./js/json2.min.js"></script>--> 

<script>


	
		$("#btnSaveSign").click(function(e){
		var type_thesis = $( "input[type=radio][name=type_thesis]:checked" ).val();
			var subject_code = $("#subject_code").val();
			var credits = $("#credits").val();
			var semester = $( "input[type=radio][name=semester]:checked" ).val();
			var academic = $("#academic").val(); 
			var advisor = $("#advisor").val(); 
			var because = $("#because").val();
			if(type_thesis === undefined ){
				alert("กรุณากรอกข้อมูล มีความประสงค์ขอลงทะเบียน/ would like to register  ให้ครบด้วยนะครับ");
				$("#type_thesis").focus();
				return false;
			}
		    if(subject_code ==='' ){
				alert("กรุณากรอกข้อมูลรหัสวิชา/ subject codeให้ครบด้วยนะครับ");
				$("#subject_code").focus();
				return false;
			}
			 if(credits ===''){
				alert("กรุณากรอกข้อมูลหน่วยกิต (credits)ให้ครบด้วยนะครับ");
				$("#credits").focus();
				return false;
			}
			 if(semester === undefined){
				alert("กรุณากรอกข้อมูลเทอม/semesterให้ครบด้วยนะครับ");
				$("#semester").focus();
				return false;
			}
			if(academic == 0){
				alert("กรุณากรอกข้อมูลปีการศึกษา/ Academic year ให้ครบด้วยนะครับ");
				$("#academic").focus();
				return false;
			}
		
			 if(because === ''){
				alert("กรุณากรอกข้อมูลเนื่องจาก/ becauseให้ครบด้วยนะครับ");
				$("#because").focus();
				return false;
			}
			
		     $.post( 
                  "save.php",
                  $("#frm_add_thesis_is").serializeArray(),
                  function(data) {
					 //alert(data);
					  if(data==="1"){
						  window.location.href = 'index.php?menu=student';
					  } else if(data==="2"){
						  alert("ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง");
						   window.location.href = 'index.php?menu=student';
					  } else {
						 alert("ไม่สามารถทำรายการได้กรุณาทำรายการอีกครั้ง");
						   window.location.href = 'index.php?menu=student';
						  
					  }
                       
                  }
               );
					
			
		
		});
		//return false;
	/*	$("#btnClearSign").click(function(e){
			$("#signArea").signaturePad().clearCanvas();
		});*/
	

	
	</script> 

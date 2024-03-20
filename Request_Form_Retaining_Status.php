<?php
session_start();
$id = $_SESSION['SES_ID'];
if ($id == "" || $_SESSION["SES_STDCODE"] == "") {
  echo "<script>window.location.href = 'logout.php'</script>";
}
?>

<div class="row row-cards row-deck">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><strong>Request Form for Retaining Student Status </strong></h3>
      </div>
      <div class="card-body">
        <div id="show_loading" align="center"></div>
        <form action="javascipt:;" method="post" id="frm_add_thesis_is" class="frm_add_thesis_is">

          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-3">พ้นสภาพการเป็นนิสิต เนื่องจาก :
                Student status is canceled because :</label>
              <!--        <div class="col-sm-9">
                <input type="text" class="form-control" id="because" name="because">
              </div> -->
            </div>
          </div>
          <div class="form-group">
            <div class="row align-items-right">
              <label class="col-sm-4 align-items-right"><input type="radio" value="1" name="rdo_completely" id="rdo_completely" class="rdo_completely" data-id="1"> ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต จำนวน Did not pay for a status retention for<span class="form-required">*</span></label>
              <div class="col-sm-2">
                <select class="custom-select" id="number_semester" name="number_semester" disabled>
                  <option value="0">เลือก จำนวนภาค</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                </select>

              </div>
              <label class="col-sm-2 align-items-right">ภาคเรียน คือภาคเรียนที่ semester<span class="form-required">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" placeholder="คือภาคเรียนที่ (เช่น 1/2560,2/2560)" id="academic_more" name="academic_more" disabled>
              </div>
            </div>
          </div>
          <div class="form-group">

            <input type="radio" value="2" name="rdo_completely" id="rdo_completely" class="rdo_completely" data-id="2">
            ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลาที่มหาวิทยาลัยกำหนด (ไม่ได้ชำระเงินภายในเวลาที่มหาวิทยาลัยกำหนด)
            Did not completely enroll according to schedule (No payment within the due date.)


          </div>
          <div class="form-group">
            มีความประสงค์จะขอคืนสภาพการเป็นนิสิต ตั้งแต่ :
            Would like to retain student status from :
          </div>
          <div class="form-group col-sm-9">
            <div class="custom-controls-stacked">
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="1">
                <span class="custom-control-label">ภาคต้น/ 1<sup>st</sup> semester</span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="2">
                <span class="custom-control-label">ภาคปลาย/ 2<sup>nd</sup> semester </span> </label>
              <label class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" name="semester" id="semester" value="3">
                <span class="custom-control-label">ภาคการศึกษาพิเศษ/ 3<sup>nd</sup> semester</span> </label>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label"> ปีการศึกษา/ Academic year <span class="form-required">*</span> </label>
            <select class="custom-select" id="academic" name="academic">
              <option value="0">เลือก ปีการศึกษา/ Academic year</option>
              <option value="2563">2563</option>
              <option value="2562">2562</option>
              <option value="2561">2561</option>
              <option value="2560">2560</option>
              <option value="2559">2559</option>
              <option value="2558">2558</option>
              <option value="2557">2557</option>
              <option value="2556">2556</option>
              <option value="2555">2555</option>
              <option value="2554">2554</option>
            </select>
          </div>
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-3">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์
                (Advisor/Chairman of Thesis) <span class="form-required">*</span></label>
              <div class="col-sm-9">
                <select id="advisor" name="advisor" class="custom-select">


                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row align-items-center">
              <label class="col-sm-2">ลงชื่อ/ signature <span class="form-required">*</span></label>
              <div class="col-sm-3">
                <div id="signArea">
                  <!--<h2 class="tag-ingo">Put signature below,</h2>-->
                  <div class="sig sigWrapper" style="height:auto;">
                    <div class="typed"></div>
                    <canvas class="sign-pad" id="sign-pad" width="250" height="100">
                    </canvas>
                  </div>
                </div>
                <button id="btnClearSign2" class="btn btn-secondary btn-space">Clar Signature</button>
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
            <button type="submit" id="btnSaveSign" class="btn btn-primary btn-space">Save Data</button>
            <button type="reset" class="btn btn-secondary btn-space">Cancel</button>

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
<link rel="stylesheet" href="digital-e-signature/css/jquery-ui.css">
<link href="digital-e-signature/css/jquery.signaturepad.css" rel="stylesheet">
<script src="digital-e-signature/js/numeric-1.2.6.min.js"></script>
<script src="digital-e-signature/js/bezier.js"></script>
<script src="digital-e-signature/js/jquery.signaturepad.js"></script>
<script type='text/javascript' src="digital-e-signature/js/html2canvas.js"></script>
<!--<script src="./js/json2.min.js"></script>-->

<script>
  $(document).ready(function(e) {
    $('.rdo_completely').click(function() { //งานที่ทำแล้วเสร็จ
      //var rdo_completely = $("#rdo_completely").val();
      var rdo_completely = $(this).attr('data-id');
      if (rdo_completely == 1) {
        $("#number_semester").removeAttr('disabled');
        $("#academic_more").removeAttr('disabled');
      } else {
        $("#number_semester").attr('disabled', 'disabled');
        $("#academic_more").attr('disabled', 'disabled');
        $("#number_semester").val('0');
        $("#academic_more").val('');
      }
    });
    $("#advisor").load("JSofficergradinfo.php"); // select option อาจารย์ที่ปรึกษา
    $(document).ready(function() {
      $('#signArea').signaturePad({
        drawOnly: true,
        drawBezierCurves: true,
        lineTop: 90
      });
    });

    $("#btnSaveSign").click(function(e) {
      var rdo_completely = $("input[type=radio][name=rdo_completely]:checked").val();
      var number_semester = $("#number_semester").val();
      var academic_more = $("#academic_more").val();
      var semester = $("input[type=radio][name=semester]:checked").val();
      //var semester = $("#semester").val(); 
      var academic = $("#academic").val();
      var advisor = $("#advisor").val();
      var because = $("#because").val();
      var sig_chk = $("#signArea").signaturePad().validateForm();
      if (rdo_completely === undefined) {
        alert("กรุณาเลือก พ้นสภาพการเป็นนิสิต  เนื่องจาก : Student status is canceled because");
        $("#rdo_completely").focus();
        return false;
      }

      if (semester === undefined) {
        alert("กรุณากรอกข้อมูลเทอม/semester");
        $("#semester").focus();
        return false;
      }
      if (academic == 0) {
        alert("กรุณากรอกข้อมูลปีการศึกษา/ Academic year");
        $("#academic").focus();
        return false;
      }


      if (advisor == 0) {
        alert("กรุณาเลือกอาจารย์ที่ปรึกษา/ประธานควบคุมบทนิพนธ์");
        $("#advisor").focus();
        return false;
      }
      if (sig_chk == false) {
        alert("กรุณาลงลายชื่อ..");
        $("canvas").focus();
        return false;
      }
      html2canvas([document.getElementById('sign-pad')], {
        onrendered: function(canvas) {
          var canvas_img_data = canvas.toDataURL('image/png');
          var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");

          /*		$.ajax({
          			url: 'digital-e-signature/save_registration_thesis.php',
          			data: { img_data:img_data,type_thesis:type_thesis,
          					subject_code:subject_code,credits:credits,
          					semester:semester,academic:academic,because:because
          			 },
          			type: 'post',
          			dataType: 'json',
          			success: function (response) {
          			   //window.location.reload();
          			}
          		});*/
          $("#show_loading").html("<img src='images/loading.gif' width='100' height='100'>");
          $("#btnSaveSign").attr('disabled', 'disabled');

          $.post("digital-e-signature/save_retaining_status.php", {
            img_data: img_data,
            rdo_completely: rdo_completely,
            number_semester: number_semester,
            academic_more: academic_more,
            semester: semester,
            academic: academic,
            advisor: advisor
          }, function(data) {
            if (data == 1) {
              alert("Send Data Complete..");
              window.location.href = 'index.php?menu=student';
            } else if (data == 2) {
              alert("Send Data Error..2");
            } else if (data == 3) {
              alert("Send Data Error..3");
            } else if (data == 4) {
              alert("ไม่สามารถส่งคำร้องซ้ำได้ เนื่องจากมีการส่งคำร้องนี้อยู่ในการรออนุมัติจากอาจารย์ที่ปรึกษา/ประธานหลักสูตร");
            }
            //$("#result").html(data);
            $("#show_loading").empty();
            $("#btnSaveSign").removeAttr('disabled');

          });

        }
      });
    });
    //return false;
    /*	$("#btnClearSign").click(function(e){
    		$("#signArea").signaturePad().clearCanvas();
    	});*/

    $("#btnClearSign2").click(function(e) {
      $("#signArea").signaturePad().clearCanvas();
      return false;
    });
  });
</script>
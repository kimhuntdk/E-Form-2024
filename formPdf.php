<?php
require_once("inc/db_connect.php");
$mysqli = connect();
$doc_id = base64_decode($_GET['doc_id']);

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf([
	'fontDir' => __DIR__ . '/vendor/fonts/', // ตั้งค่าโฟลเดอร์ที่เก็บไฟล์ฟอนต์
	'fontdata' => [
		'examplefont' => [
			'R' => 'THSarabunNew.ttf',
			'I' => 'THSarabunNew Italic.ttf',
			'B' => 'THSarabunNew Bold.ttf',
			'U' => 'THSarabunNew BoldItalic.ttf'
		],
	],
	// 'default_font' => 'examplefont', // กำหนดฟอนต์เริ่มต้น
	'default_font_size' => 10, // กำหนดฟอนต์เริ่มต้น
]);

//ดึงข้อมูลตามระดับ

// ข้อมูลฟอร์มขอคืนสภาพการเป็นนิสิต
$sql = "SELECT * FROM request_doc LEFT JOIN request_retaining_student_status ON request_doc.doc_id=request_retaining_student_status.doc_id WHERE request_doc.doc_id=" . $doc_id;
$result = $mysqli->query($sql);
$row = $result->fetch_array();

// ข้อมูลนิสิต
$sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th,std_faculty_id FROM request_student WHERE std_id_std = '$row[doc_std_id]' ";
$rs_name = $mysqli->query($sql_name);
$row_name = $rs_name->fetch_array();

$fullName = $row_name['std_fname_th'] . ' ' . $row_name['std_lname_th'];

// เวลา วัน เดือน ปี
$std_dateSignature = $row['std_date_signature'];

function Std_Date($std_dateSignature)
{
	$strDay = date("d", strtotime($std_dateSignature));
	$strMonth = date("n", strtotime($std_dateSignature));
	$strYear = date("Y", strtotime($std_dateSignature)) + 543;
	$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai พ.ศ. $strYear";
}

// แสดงข้อมูล ภาคการศึกษาที่ต้องการลาพัก
$retaining_student_id = $row['retaining_student_id'];
$sql_a = "SELECT *  FROM request_retaining_student_status_academic WHERE retaining_student_id = ?";
$stmt = $mysqli->prepare($sql_a);
$stmt->bind_param('s', $retaining_student_id);
$stmt->execute();
$result_a = $stmt->get_result();

// แสดงข้อมูล ภาคเรียนปัจจุบัน
$retaining_student_id = $row['retaining_student_id'];
$sql_cs = "SELECT *  FROM request_retaining_student_status_current_semester WHERE retaining_student_id = ?";
$stmt = $mysqli->prepare($sql_cs);
$stmt->bind_param('s', $retaining_student_id);
$stmt->execute();
$result_cs = $stmt->get_result();
$row_cs = $result_cs->fetch_array();

// สร้างเนื้อหาของหน้ารายงาน
$content = '
	<style>
	.center {
		position: absolute;
		top: 2%;
		left: 5%;
		transform: translate(-50%, -50%);
	}
	img {
		display: block;
		margin: auto;
	}
	.container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        height: 100vh;
    }
	/* ถ้าตารางถูกตัดให้ย้ายตารางไปหน้าใหม่ */
	.Table {
		page-break-inside: avoid;
	  }
	p {
        line-height: 1.20; /* 1.5 เท่าของขนาดตัวอักษรปัจจุบัน */
    }
	  
	</style>
	';
// ขอคืนสภาพการเป็นนิสิต
$content .= '
	<div class="center" >
		<img src="./assets/images/ตราสัญลักษณ์ประจำมหาวิทยาลัยมหาสารคาม.svg.png" width="30%" style="margin: auto;">
	</div>
	<div>
		<p style="margin-left:10px; text-align:right">
			<span style="font-size:18px">
				<span style="font-family:&quot;Cordia New&quot;,sans-serif">
					<strong>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> </span>
					</strong>
				</span>
			</span>
			<span style="font-size:18px">
				<span style="font-family:&quot;Cordia New&quot;,sans-serif">
					<strong>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;GS-MSU_06</span>
					</strong>
				</span>
			</span>
		</p>
		<p style="margin-right:9px; text-align:center">
			<span style="font-family:TH SarabunPSK, sans-serif">
				<span style="font-size:28pt"> </span>
			</span>
			<strong style="font-family:&quot;TH SarabunPSK&quot;,sans-serif; font-size:28px; font-weight:bold">คำร้องขอคืนสภาพการเป็นนิสิต</strong>&nbsp; &nbsp;
			<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">
				<strong>
					<span style="font-size:18px">(ระดับบัณฑิตศึกษา)</span>
				</strong> <br />
				<span style="font-size:18px">Request Form for Retaining Student Status</span>
			</span>
			<span style="font-size:18px"> 
				<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Graduate Student)</span>
			</span>
		</p>
	
		<p>
			<span style="font-size:18px"><span style="font-family:AngsanaUPC,serif">
				<strong>
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; เลขประจำตัวนิสิต/ </span>
				</strong>
				<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Student ID.</span>
			</span>
			<strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; </span></strong>
		</p>
		<table align="right"  style="width:250px; float: right; margin-left: 10px; font-size: 18px;">
			<tbody>
				<tr>';
for ($i = 0; $i < strlen($row_name['std_id_std']); $i++) {
	$content .= '<td style="text-align: center; width: 20px; height: 30px; border: 1px solid #000;">' . $row_name['std_id_std'][$i] . '</td>';
}
$content .= '</tr>
			</tbody>
		</table>
	</div>
';
$content .= '
	<p>
		<span style="font-size:18px;"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp;&nbsp; &nbsp;ข้าพเจ้า </span></strong><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> นาย</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mr. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นาง</strong>/ Mrs. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นางสาว</strong>/ Miss &hellip;&hellip;....' . ' ' . $fullName . ' ' . '........</span></span></span> <br/>
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Faculty &hellip;&hellip;&hellip;' . ' ' . $row_name['std_faculty_th'] . ' ' . '.&hellip;&hellip; <strong>สาขาวิชา/ </strong>Major .....' . ' ' . $row_name['std_major_th'] . ' ' . '.......</span></span></span>
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เป็นนิสิตศึกษาอยู่ที่</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/study at</span>&nbsp;&nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขตมหาสารคาม</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mahasarakham Campus</span>&nbsp;&nbsp;<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขต/ Other Campus (Please specify) ...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span><br/>
	<p/>
	';

if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบนอกเวลา') {
	$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
} else if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบในเวลาร') {
	$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบในเวลา') {
	$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
		';
} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบนอกเวลา') {
	$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">(/)</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
		';
}
$content .= '
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;พ้นสภาพการเป็นนิสิต</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; เนื่องจาก :&nbsp; &nbsp;Student status is canceled because :</span></span><br />';
if ($row['because'] == 'ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต') {
	$content .= '
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( / ) ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต คือภาคเรียนที่ ..........' . $row['pay_semester'] . '..........</span></span><br />
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Did not pay for a status retention semester: ..........' . $row['pay_semester'] . '..........</span></span><br />
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;() ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลาที่มหาวิทยาลัยกำหนด (ไม่ได้ชำระเงินภายในเวลาที่มหาวิทยาลัยกำหนด)<br />
	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Did not completely enroll according to schedule (No payment within the due date.) </span></span><br />
 	';
} else if ($row['because' == 'ไม่ได้ลงทะะเบียนเรียนโดยสมบูรณ์ ภายในเวลามหาลัยกำหนด(ไม่ได้ชำระเงินภายในเวลาที่กำหนด)']) {
	$content .= '
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;() ไม่ชำระเงินเพื่อรักษาสภาพการเป็นนิสิต คือภาคเรียนที่ ....................</span></span><br />
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Did not pay for a status retention semester: ....................</span></span><br />
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( / ) ไม่ได้ลงทะเบียนเรียนโดยสมบูรณ์ ภายในเวลาที่มหาวิทยาลัยกำหนด (ไม่ได้ชำระเงินภายในเวลาที่มหาวิทยาลัยกำหนด)<br />
	&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Did not completely enroll according to schedule (No payment within the due date.) </span></span><br />
 	';
}
$content .= '
	<span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;มีความประสงค์จะขอคืนสภาพการเป็นนิสิต</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ตั้งแต่ /&nbsp;Would like to retain student status from :&nbsp;</span></span><br />';
if ($row['semester'] == '1') {
	$content .= '
		<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp; </span> ปีการศึกษา/ Academic Year ...' . $row['academic'] . '...<br />
		';
} else if ($row['semester'] == '2') {
	$content .= '
		<span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp; </span> ปีการศึกษา/ Academic Year ...' . $row['academic'] . '...<br />
		';
}

$content .= '	

	&nbsp;&nbsp;&nbsp;และขอลาพักการเรียนที่พ้นสภาพการเป็นนิสิต จนถึง / Would like to take a leave of absence in the :</span></span></span><br />';
foreach ($result_a as $row_a) {
	// $content.=' '.$row_a['academic_id'].'';

	$sql_a_count = "SELECT *  FROM request_retaining_student_status_academic WHERE  retaining_student_id = $row_a[retaining_student_id]";
	$result_a_count = $mysqli->query($sql_a_count);



	if ($row_a['semester_a'] == '1') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp; </span> ปีการศึกษา/ Academic Year ...' . $row_a['academic_a'] . '...</span></span></span><br />
			';
	} else if ($row_a['semester_a'] == '2') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp; </span> ปีการศึกษา/ Academic Year ...' . $row_a['academic_a'] . '...</span></span></span><br />
			';
	}
}
$content .= '

<p><span style="font-size:18pt"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:18px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>ลงชื่อ</strong>/ Signature <img src="digital-e-signature/doc_signs/' . $row['std_signature'] . '.png" width="20%"> <strong>ผู้ยื่นคำร้อง</strong>/Applicant</span></span></span></span></p>
<p><span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;' . $fullName . '&hellip;&hellip;&hellip;) ' . Std_Date($std_dateSignature) . '</span></span></span></p>
<p>&nbsp;</p>
';

$content .= '
<table cellspacing="0" class="Table" style="border-collapse:collapse; border:none; width:716px">
	<tbody>
		<tr>
			<td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; height:96px; vertical-align:top; width:347px">
			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:Wingdings">1.&nbsp;</span><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">กรรมการควบคุมวิทยานิพนธ์/อาจารย์ที่ปรึกษาการศึกษาค้นคว้าอิสระ&nbsp; </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Advisor/Chairman of the thesis)</span></span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span></span></span></p>
			';
// เวลา วัน เดือน ปี
$advisor_dateSignature = $row['advisor_chairman_date'];

function advisor_Date($advisor_dateSignature)
{
	$strDay = date("d", strtotime($advisor_dateSignature));
	$strMonth = date("n", strtotime($advisor_dateSignature));
	$strYear = date("Y", strtotime($advisor_dateSignature)) + 543;
	$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai พ.ศ. $strYear";
}

if ($row['advisor_chairman_status'] == 1) {
	$content .= ' <p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature <img src="digital-e-signature/doc_signs/' . $row['advisor_chairman_signature'] . '.png" width="20%"> (' . advisor_Date($advisor_dateSignature) . ')</span></span></span></p>
			</td>
			';
} else {
	$content .= ' <p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature ..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp; (&hellip;&hellip;/&hellip;&hellip;/&hellip;&hellip;)</span></span></span></p>
			</td>
			';
}
$content .= '
			<td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; height:96px; vertical-align:top; width:369px">
			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:Wingdings">2.</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;คณบดีบัณฑิตวิทยาลัย <strong>(Dean of Graduate School)</strong></span></span></span></p>
			<p>&nbsp;</p>
			<p><br />
			<span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..........................................................</span></span></span></p>
			';
// เวลา วัน เดือน ปี
$dean_admin_dateSignature = $row['dean_admin_date'];

function dean_admin_Date($dean_admin_dateSignature)
{
	$strDay = date("d", strtotime($dean_admin_dateSignature));
	$strMonth = date("n", strtotime($dean_admin_dateSignature));
	$strYear = date("Y", strtotime($dean_admin_dateSignature)) + 543;
	$strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$strMonthThai = $strMonthCut[$strMonth];
	return "$strDay $strMonthThai พ.ศ. $strYear";
}
if ($row['dean_admin_approve_disapprove'] == 1) {
	$content .= '
				<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp;   ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature <img src="digital-e-signature/doc_signs/' . $row['dean_admin_signature'] . '.png" width="20%"> (' . dean_admin_Date($dean_admin_dateSignature) . ').</span></span></span></p>
			</td>
			';
} else {
	$content .= '
				<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature ..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp; (&hellip;&hellip;/&hellip;&hellip;../&hellip;&hellip;..).</span></span></span></p>
			</td>
			';
}
$content .= '
		</tr>
		<tr>
			<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; height:96px; vertical-align:top; width:716px">
			<span style="font-size:24px"><span style="font-family:AngsanaUPC,serif"><span style="font-family:Wingdings">3.</span> <u><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><strong>นายทะเบียน</strong></span></u> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(The Registrar) ..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..</span></span></span>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">O</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; ตามข้อบังคับฯ ข้อ &hellip;&hellip;&hellip;.สามารถคืนสภาพได้ (The status is retained regarding the Regulation No&hellip;&hellip;&hellip;&hellip;&hellip;.)&nbsp; </span></span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">O</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; มีหนี้ค้างที่ต้องชำระเป็นเงิน &hellip;&hellip;&hellip;&hellip;&hellip;&hellip; บาท (Arrears for &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.baht)&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">O</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; ไม่มีหนี้ค้าง (No Arrears)</span></span></span></p>
			<p>&nbsp;</p>
			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;    ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature &hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp; (&hellip;&hellip;/&hellip;&hellip;../&hellip;&hellip;..)</span></span></span></p>
			</td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; height:23px; vertical-align:top; width:347px">
			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:Wingdings">4.&nbsp;</span><u><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><strong>เสนออธิการบดี</strong></span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; เพื่อโปรดสั่งการ</span></u> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;(President for Approval)</span><u> </u></span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; [&nbsp; ] <strong>&nbsp;อนุมัติ</strong>/ Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [&nbsp; ]&nbsp; <strong>ไม่อนุมัติ</strong>/Disapprove</span></span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp;ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature ..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp; (&hellip;&hellip;/&hellip;&hellip;../&hellip;&hellip;..)</span></span></span></p>
			</td>
			<td style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; height:23px; vertical-align:top; width:369px">
			<p><span style="font-size:24px"><span style="font-family:Wingdings">5.</span><span style="font-family:TH SarabunPSK,sans-serif">&nbsp;เจ้าหน้าที่ทะเบียน (Staff Registration Officer)</span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;   ลงชื่อ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature ..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&nbsp; <strong>ผู้บันทึกข้อมูล (Recorder)</strong> </span></span></span></p>

			<p><span style="font-size:24px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 	 (&hellip;&hellip;/&hellip;&hellip;../&hellip;&hellip;..).</span></span></span></p>
			</td>
		</tr>
	</tbody>
</table>
';
$content .= '
<div style="page-break-before: always;"></div>
';


// ขอลาพักการเรียน
while ($row_count = $result_a_count->fetch_assoc()) {

	$content .= '
	<div class="center" >
		<img src="./assets/images/ตราสัญลักษณ์ประจำมหาวิทยาลัยมหาสารคาม.svg.png" width="30%" style="margin: auto;">
	</div>
	<div>
	<p style="margin-left:10px; text-align:right">
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> </span></strong></span></span>
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;GS-MSU_03</span></strong></span></span>
	</p>
	<p style="margin-right:9px; text-align:center">
		<span style="font-family:TH SarabunPSK, sans-serif"><span style="font-size:28pt"> </span></span>
		<strong style="font-family:&quot;TH SarabunPSK&quot;,sans-serif; font-size:28px; font-weight:bold">คำร้องขอลาพักการเรียน</strong>&nbsp; &nbsp;
		<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><strong><span style="font-size:18px">(ระดับบัณฑิตศึกษา)</span></strong><br />
		<span style="font-size:18px">Request Form for Taking a Leave</span></span>
		<span style="font-size:18px"> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Graduate Student)</span></span>
	</p>

	<p>
		<span style="font-size:18px"><span style="font-family:AngsanaUPC,serif">
			<strong>
				<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; เลขประจำตัวนิสิต/ </span>
			</strong>
			<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Student ID.</span>
		</span>
		<strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; </span></strong>
	</p>
	<table align="right"  style="width:250px; float: right; margin-left: 10px; font-size: 18px;">
		<tbody>
			<tr>';
	for ($j = 0; $j < strlen($row_name['std_id_std']); $j++) {
		$content .= '<td style="text-align: center; width: 20px; height: 30px; border: 1px solid #000;">' . $row_name['std_id_std'][$j] . '</td>';
	}
	$content .= '
			</tr>
		</tbody>
	</table>
	</div>
';

	$content .= '
	<p>
		<span style="font-size:18px;"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp;&nbsp; &nbsp;ข้าพเจ้า </span></strong><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> นาย</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mr. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นาง</strong>/ Mrs. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นางสาว</strong>/ Miss &hellip;&hellip;....' . ' ' . $fullName . ' ' . '........</span></span></span> <br/>
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Faculty &hellip;&hellip;&hellip;' . ' ' . $row_name['std_faculty_th'] . ' ' . '.&hellip;&hellip; <strong>สาขาวิชา/ </strong>Major .....' . ' ' . $row_name['std_major_th'] . ' ' . '.......</span></span></span>
		<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เป็นนิสิตศึกษาอยู่ที่</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/study at</span>&nbsp;&nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขตมหาสารคาม</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mahasarakham Campus</span>&nbsp;&nbsp;<br />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขต/ Other Campus (Please specify) ...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span><br/>
	<p/>
		';
	if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบในเวลาร') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบในเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
		';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
		<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">(/)</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
		';
	}
	$content .= '
	<p>&nbsp;</p>
	<p style="margin-left:55px"><span style="font-size:18px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">มีความประสงค์ขอลาพักการเรียน/</span></strong><strong> </strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Would</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">like</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">to</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">take</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">a</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">leave</span> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">in:</span></span></span></p>	
	';
	// ลูป

	if ($row_count['semester_a'] == '1') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ Academic Year ...' . $row_count['academic_a'] . '...</span></span></span><br />
					';
	} else if ($row_count['semester_a'] == '2') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ Academic Year ...' . $row_count['academic_a'] . '...</span></span></span><br />
					';
	}

	$content .= '
		<p style="margin-left:7px">
			<span style="font-size:18px">
				<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
					<strong>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เนื่องจาก</span>
					</strong>
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span>&nbsp;
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">because &hellip;&hellip;&hellip;' . $row['because'] . '&hellip;&hellip;&hellip;</span>
				</span>
			</span>
		</p>
	';
	$content .= '
		<p>
			<span style="font-size:18pt">
				<span style="font-family:&quot;Cordia New&quot;,sans-serif">
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span style="font-size:18px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<strong>ลงชื่อ</strong>/ Signature <img src="digital-e-signature/doc_signs/' . $row['std_signature'] . '.png" width="20%"> <strong>ผู้ยื่นคำร้อง</strong>/Applicant
						</span>
					</span>
				</span>
			</span>
		</p>
		<p>
			<span style="font-size:18px">
				<span style="font-family:&quot;Cordia New&quot;,sans-serif">
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;' . $fullName . '&hellip;&hellip;&hellip;) ' . Std_Date($std_dateSignature) . '</span>
				</span>
			</span>
		</p>
		<p>&nbsp;</p>
	';
	$content .= '

	<p style="margin-left:206px">
		<span style="font-size:20px">
			<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
				<strong>
					<u>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ขั้นตอนการลงความเห็น/การอนุมัติ</span>
					</u>
				</strong>
				<strong>
					<u> </u>
				</strong>
				<u>
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Comment/Approval</span>
				</u>
			</span>
		</span>
	</p>

	<table cellspacing="0" class="TableNormal" style="border-collapse:collapse; border:none; margin-left:22px">
		<tbody>
			<tr>
				<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:336px">
				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<u>&nbsp;
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">1. </span>
							</u>
							<u> </u>
							<strong>
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมวิทยานิพนธ</span>
								</u>
							</strong>
							<strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">์</span>
							</strong>
						</span>
					</span>
				</p>

				<p style="margin-left:11px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;(Advisor/Chairman</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">thesis)</span>
						</span>
					</span>
				</p>

				<p style="margin-left:7px">
					<span style="font-size:22px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;</span>
						</span>
					</span>
				</p>

				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span>
						</span>
					</span>
				</p>
		';
	$content .= '
				<p style="margin-left:px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
							</strong>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['advisor_chairman_signature'] . '.png" width="20%"></span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . advisor_Date($advisor_dateSignature) . ')</span>
						</span>
					</span>
				</p>

				<p style="margin-left:96px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</span>
						</span>
					</span>
				</p>
				</td>

				<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:354px">
				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<u>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;2. </span>
							</u>
							<u> </u>
							<strong>
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นคณบดีบัณฑิตวิทยาลัย</span>
								</u>
							</strong>
							<strong> </strong>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Dean of Graduate school)</span> 
							
						</span>
					</span>
				</p>

				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</span>
						</span>
					</span>
				</p>
				';
	if ($row['dean_admin_approve_disapprove'] == '1') {
		$content .= ' <p style="margin-right:24px; text-align:center">
								<span style="font-size:22px">
									<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ /</span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
										</strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
											<strong>[ ] ไม่อนุมัติ</strong>/ Disapprove
										</span>
									</span>
								</span>
							</p>
				';
	} else {
		$content .= ' <p style="margin-right:24px; text-align:center">
							<span style="font-size:22px">
								<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ </span>
									</strong>
									<strong> </strong>
									<strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
									</strong>
									<strong> </strong>
									<strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
									</strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>[ / ] ไม่อนุมัติ</strong>/ Disapprove
									</span>
								</span>
							</span>
						</p>
				';
	}

	$content .= '
				<p style="margin-right:13px; text-align:center">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
							</strong>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['dean_admin_signature'] . '.png" width="20%"></span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . dean_admin_Date($dean_admin_dateSignature) . ')</span>
						</span>
					</span>
				</p>

				<p style="margin-left:100px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
						</span>
					</span>
				</p>
				</td>
			</tr>
			<tr>
				<td style="border-bottom:none; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:158px">
				<p>&nbsp;</p>
				</td>
				<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:338px">
				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<u>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;3. </span>
							</u>
							<u> </u>
							<strong>
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เจ้าหน้าที่กองทะเบียนและประมวลผล</span>
								</u>
							</strong>
						</span>
					</span>
				</p>

				<p style="margin-left:7px">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(The</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Officer</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Division</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Registrar)</span>
						</span>
					</span>
				</p>

				<p style="margin-right:9px; text-align:center">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
							</strong>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span> 
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;)</span>
						</span>
					</span>
				</p>

				<p style="margin-right:5px; text-align:center">
					<span style="font-size:22px">
						<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
						</span>
					</span>
				</p>
				</td>
				<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; height:92px; vertical-align:top; width:194px">
				<p>&nbsp;</p>
				</td>
			</tr>
			<tr>
				<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:200px">&nbsp;</td>
				<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
				<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
				<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:130px">&nbsp;</td>
			</tr>
		</tbody>
	</table>
';
	$content .= '
		 <div style="page-break-before: always;"></div>
	';
}
// ส่วนแสดงเทอมปัจจุบันว่าต้องการลาพักหรือลงทะเบียน Thesis
// แสดงเมื่อขอลาพักเทอมปัจจุบัน
if ($row_cs['doc_type_id'] == 1) {
	$content .= '
		<div class="center" >
			<img src="./assets/images/ตราสัญลักษณ์ประจำมหาวิทยาลัยมหาสารคาม.svg.png" width="30%" style="margin: auto;">
		</div>
		<div>
		<p style="margin-left:10px; text-align:right">
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> </span></strong></span></span>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;GS-MSU_03</span></strong></span></span>
		</p>
		<p style="margin-right:9px; text-align:center">
			<span style="font-family:TH SarabunPSK, sans-serif"><span style="font-size:28pt"> </span></span>
			<strong style="font-family:&quot;TH SarabunPSK&quot;,sans-serif; font-size:28px; font-weight:bold">คำร้องขอลาพักการเรียน</strong>&nbsp; &nbsp;
			<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><strong><span style="font-size:18px">(ระดับบัณฑิตศึกษา)</span></strong><br />
			<span style="font-size:18px">Request Form for Taking a Leave</span></span>
			<span style="font-size:18px"> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Graduate Student)</span></span>
		</p>

		<p>
			<span style="font-size:18px"><span style="font-family:AngsanaUPC,serif">
				<strong>
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; เลขประจำตัวนิสิต/ </span>
				</strong>
				<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Student ID.</span>
			</span>
			<strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; </span></strong>
		</p>
		<table align="right"  style="width:250px; float: right; margin-left: 10px; font-size: 18px;">
			<tbody>
				<tr>';
	for ($j = 0; $j < strlen($row_name['std_id_std']); $j++) {
		$content .= '<td style="text-align: center; width: 20px; height: 30px; border: 1px solid #000;">' . $row_name['std_id_std'][$j] . '</td>';
	}
	$content .= '
				</tr>
			</tbody>
		</table>
		</div>
	';

	$content .= '
		<p>
			<span style="font-size:18px;"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp;&nbsp; &nbsp;ข้าพเจ้า </span></strong><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> นาย</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mr. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นาง</strong>/ Mrs. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นางสาว</strong>/ Miss &hellip;&hellip;....' . ' ' . $fullName . ' ' . '........</span></span></span> <br/>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Faculty &hellip;&hellip;&hellip;' . ' ' . $row_name['std_faculty_th'] . ' ' . '.&hellip;&hellip; <strong>สาขาวิชา/ </strong>Major .....' . ' ' . $row_name['std_major_th'] . ' ' . '.......</span></span></span>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เป็นนิสิตศึกษาอยู่ที่</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/study at</span>&nbsp;&nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขตมหาสารคาม</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mahasarakham Campus</span>&nbsp;&nbsp;<br />
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขต/ Other Campus (Please specify) ...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span><br/>
		<p/>
			';
	if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบในเวลาร') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบในเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
			';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">(/)</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
			';
	}
	$content .= '
		<p>&nbsp;</p>
		<p style="margin-left:55px"><span style="font-size:18px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">มีความประสงค์ขอลาพักการเรียน/</span></strong><strong> </strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Would lick to take a leave in:</span> </span></span></p>	
		';

	if ($row_cs['semester'] == '1') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ Academic Year ...' . $row_cs['academic'] . '...</span></span></span><br />
						';
	} else if ($row_cs['semester'] == '2') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ Academic Year ...' . $row_cs['academic'] . '...</span></span></span><br />
						';
	}

	$content .= '
			<p style="margin-left:7px">
				<span style="font-size:18px">
					<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
						<strong>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เนื่องจาก</span>
						</strong>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span>&nbsp;
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">because &hellip;&hellip;&hellip;' . $row['because'] . '&hellip;&hellip;&hellip;</span>
					</span>
				</span>
			</p>
		';
	$content .= '
			<p>
				<span style="font-size:18pt">
					<span style="font-family:&quot;Cordia New&quot;,sans-serif">
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-size:18px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>ลงชื่อ</strong>/ Signature <img src="digital-e-signature/doc_signs/' . $row['std_signature'] . '.png" width="20%"> <strong>ผู้ยื่นคำร้อง</strong>/Applicant
							</span>
						</span>
					</span>
				</span>
			</p>
			<p>
				<span style="font-size:18px">
					<span style="font-family:&quot;Cordia New&quot;,sans-serif">
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;' . $fullName . '&hellip;&hellip;&hellip;) ' . Std_Date($std_dateSignature) . '</span>
					</span>
				</span>
			</p>
			<p>&nbsp;</p>
		';
	$content .= '

		<p style="margin-left:206px">
			<span style="font-size:20px">
				<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
					<strong>
						<u>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ขั้นตอนการลงความเห็น/การอนุมัติ</span>
						</u>
					</strong>
					<strong>
						<u> </u>
					</strong>
					<u>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Comment/Approval</span>
					</u>
				</span>
			</span>
		</p>

		<table cellspacing="0" class="TableNormal" style="border-collapse:collapse; border:none; margin-left:22px">
			<tbody>
				<tr>
					<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:336px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>&nbsp;
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">1. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมวิทยานิพนธ</span>
									</u>
								</strong>
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">์</span>
								</strong>
							</span>
						</span>
					</p>

					<p style="margin-left:11px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;(Advisor/Chairman</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">thesis)</span>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;</span>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span>
							</span>
						</span>
					</p>
			';
	$content .= '
					<p style="margin-left:px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['advisor_chairman_signature'] . '.png" width="20%"></span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . advisor_Date($advisor_dateSignature) . ')</span>
							</span>
						</span>
					</p>

					<p style="margin-left:96px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>

					<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:354px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;2. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นคณบดีบัณฑิตวิทยาลัย</span>
									</u>
								</strong>
								<strong> </strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Dean of Graduate school)</span> 
								
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</span>
							</span>
						</span>
					</p>
					';
	if ($row['dean_admin_approve_disapprove'] == '1') {
		$content .= ' <p style="margin-right:24px; text-align:center">
									<span style="font-size:22px">
										<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ /</span>
											</strong>
											<strong> </strong>
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
											</strong>
											<strong> </strong>
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
											</strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
												<strong>[ ] ไม่อนุมัติ</strong>/ Disapprove
											</span>
										</span>
									</span>
								</p>
					';
	} else {
		$content .= ' <p style="margin-right:24px; text-align:center">
								<span style="font-size:22px">
									<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ </span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
										</strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>[ / ] ไม่อนุมัติ</strong>/ Disapprove
										</span>
									</span>
								</span>
							</p>
					';
	}

	$content .= '
					<p style="margin-right:13px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['dean_admin_signature'] . '.png" width="20%"></span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . dean_admin_Date($dean_admin_dateSignature) . ')</span>
							</span>
						</span>
					</p>

					<p style="margin-left:100px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>
				</tr>
				<tr>
					<td style="border-bottom:none; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:158px">
					<p>&nbsp;</p>
					</td>
					<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:338px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;3. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เจ้าหน้าที่กองทะเบียนและประมวลผล</span>
									</u>
								</strong>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(The</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Officer</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Division</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Registrar)</span>
							</span>
						</span>
					</p>

					<p style="margin-right:9px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>

					<p style="margin-right:5px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; height:92px; vertical-align:top; width:194px">
					<p>&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:200px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:130px">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	';
}
// แสดงเมื่อขอลงทะเบียนในเทอมปัจจุบัน
else {
	$content .= '
		<div class="center" >
			<img src="./assets/images/ตราสัญลักษณ์ประจำมหาวิทยาลัยมหาสารคาม.svg.png" width="30%" style="margin: auto;">
		</div>
		<div>
		<p style="margin-left:10px; text-align:right">
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> </span></strong></span></span>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp;GS-MSU_14</span></strong></span></span>
		</p>
		<p style="margin-right:9px; text-align:center">
			<span style="font-family:TH SarabunPSK, sans-serif"><span style="font-size:28pt"> </span></span>
			<strong style="font-family:&quot;TH SarabunPSK&quot;,sans-serif; font-size:28px; font-weight:bold">คำร้องขอลงทะเบียน Thesis/IS</strong>&nbsp; &nbsp;
			<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><strong><span style="font-size:18px">(ระดับบัณฑิตศึกษา)</span></strong><br />
			<span style="font-size:18px">Request Form for Registration for for Thesis/IS</span></span>
			<span style="font-size:18px"> <span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Graduate Student)</span></span>
		</p>

		<p>
			<span style="font-size:18px"><span style="font-family:AngsanaUPC,serif">
				<strong>
					<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; เลขประจำตัวนิสิต/ </span>
				</strong>
				<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Student ID.</span>
			</span>
			<strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; </span></strong>
		</p>
		<table align="right"  style="width:250px; float: right; margin-left: 10px; font-size: 18px;">
			<tbody>
				<tr>';
	for ($j = 0; $j < strlen($row_name['std_id_std']); $j++) {
		$content .= '<td style="text-align: center; width: 20px; height: 30px; border: 1px solid #000;">' . $row_name['std_id_std'][$j] . '</td>';
	}
	$content .= '
				</tr>
			</tbody>
		</table>
		</div>
	';

	$content .= '
		<p>
			<span style="font-size:18px;"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp; &nbsp;&nbsp; &nbsp;ข้าพเจ้า </span></strong><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> นาย</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mr. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นาง</strong>/ Mrs. </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นางสาว</strong>/ Miss &hellip;&hellip;....' . ' ' . $fullName . ' ' . '........</span></span></span> <br/>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">คณะ</span></strong><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ </span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Faculty &hellip;&hellip;&hellip;' . ' ' . $row_name['std_faculty_th'] . ' ' . '.&hellip;&hellip; <strong>สาขาวิชา/ </strong>Major .....' . ' ' . $row_name['std_major_th'] . ' ' . '.......</span></span></span>
			<span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เป็นนิสิตศึกษาอยู่ที่</span></strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/study at</span>&nbsp;&nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขตมหาสารคาม</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/ Mahasarakham Campus</span>&nbsp;&nbsp;<br />
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> วิทยาเขต/ Other Campus (Please specify) ...&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span><br/>
		<p/>
			';
	if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาโท ระบบในเวลาร') {
		$content .= '<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบในเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
			';
	} else if ($row_name['std_degree_th'] == 'ปริญญาเอก ระบบนอกเวลา') {
		$content .= '<span style="font-family:Wingdings">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาโท</strong>/Master Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes&nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes </span><br />
			<span style="font-family:Wingdings">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> <strong>นิสิตระดับปริญญาเอก</strong>/Ph. D. Student&nbsp; &nbsp;&nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบในเวลาราชการ/Weekday classes &nbsp;</span><span style="font-family:&quot;Symbol \(AS\)&quot;">(/)</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ระบบนอกเวลาราชการ/Weekend classes</span></span><br />
			';
	}
	$content .= '
		<p >
			<span style="font-size:18px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;มีความประสงค์ขอลงทะเบียน/</span></strong><strong> </strong><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Would like to register</span> </></span></span>	
		';
	if ($row_cs['status_thesis_is'] == 'Thesis') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> Thesis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> IS &nbsp;</span></span></span><br />
					';
	} else if ($row_cs['status_thesis_is'] == 'IS') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> Thesis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> IS &nbsp;</span></span></span><br/>
					';
	}
	$content .= '
		<span style="font-size:18px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">รหัสวิชา/ subject code</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span>&nbsp;.....' . $row_cs['subject_code'] . '.....&nbsp;</span><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เพิ่มอีก (more)</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span>&nbsp;.....' . $row_cs['credits'] . '.....หน่วยกิต(credits)&nbsp;</span> </span><br/>
		';
	if ($row_cs['semester'] == '1') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">ประจำ/ for&nbsp;&nbsp;&nbsp;( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ in academic year ...' . $row_cs['academic'] . '...</span></span></span><br/>
						';
	} else if ($row_cs['semester'] == '2') {
		$content .= ' <span style="font-size:18px"><span style="font-family:&quot;Cordia New&quot;,sans-serif"><span style="font-family:&quot;Symbol \(AS\)&quot;">ประจำ/ for&nbsp;&nbsp;&nbsp;()</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคต้น/ 1<sup>st</sup> semester&nbsp; </span><span style="font-family:&quot;Symbol \(AS\)&quot;">( / )</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"> ภาคปลาย/ 2<sup>nd</sup> semester&nbsp;  ปีการศึกษา/ in academic year ...' . $row_cs['academic'] . '...</span></span></span><br/>
						';
	}
	$content .= '
		<span style="font-size:18px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif"><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เนื่องจาก/ because</span><span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"></span>&nbsp;....................' . $row_cs['because'] . '....................&nbsp;</span> </span>
		</p>
		';
	
	$content .= '
			<p>
				<span style="font-size:18pt">
					<span style="font-family:&quot;Cordia New&quot;,sans-serif">
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style="font-size:18px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<strong>ลงชื่อ</strong>/ Signature <img src="digital-e-signature/doc_signs/' . $row['std_signature'] . '.png" width="20%"> <strong>ผู้ยื่นคำร้อง</strong>/Applicant
							</span>
						</span>
					</span>
				</span>
			</p>
			<p>
				<span style="font-size:18px">
					<span style="font-family:&quot;Cordia New&quot;,sans-serif">
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;' . $fullName . '&hellip;&hellip;&hellip;) ' . Std_Date($std_dateSignature) . '</span>
					</span>
				</span>
			</p>
			<p>&nbsp;</p>
		';
	$content .= '

		<p style="margin-left:206px">
			<span style="font-size:20px">
				<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
					<strong>
						<u>
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ขั้นตอนการลงความเห็น/การอนุมัติ</span>
						</u>
					</strong>
					<strong>
						<u> </u>
					</strong>
					<u>
						<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Comment/Approval</span>
					</u>
				</span>
			</span>
		</p>

		<table cellspacing="0" class="TableNormal" style="border-collapse:collapse; border:none; margin-left:22px">
			<tbody>
				<tr>
					<td colspan="2" style="border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:336px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>&nbsp;
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">1. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นอาจารย์ที่ปรึกษา/ประธานควบคุมวิทยานิพนธ</span>
									</u>
								</strong>
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">์</span>
								</strong>
							</span>
						</span>
					</p>

					<p style="margin-left:11px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;(Advisor/Chairman</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">thesis)</span>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px"><span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
							<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;</span>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span>
							</span>
						</span>
					</p>
			';
	$content .= '
					<p style="margin-left:px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['advisor_chairman_signature'] . '.png" width="20%"></span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . advisor_Date($advisor_dateSignature) . ')</span>
							</span>
						</span>
					</p>

					<p style="margin-left:96px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>

					<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; height:127px; vertical-align:top; width:354px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;2. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">ความเห็นคณบดีบัณฑิตวิทยาลัย</span>
									</u>
								</strong>
								<strong> </strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(Dean of Graduate school)</span> 
								
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.</span>
							</span>
						</span>
					</p>
					';
	if ($row['dean_admin_approve_disapprove'] == '1') {
		$content .= ' <p style="margin-right:24px; text-align:center">
									<span style="font-size:22px">
										<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ /</span>
											</strong>
											<strong> </strong>
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
											</strong>
											<strong> </strong>
											<strong>
												<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
											</strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
												<strong>[ ] ไม่อนุมัติ</strong>/ Disapprove
											</span>
										</span>
									</span>
								</p>
					';
	} else {
		$content .= ' <p style="margin-right:24px; text-align:center">
								<span style="font-size:22px">
									<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">[ </span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">]</span>
										</strong>
										<strong> </strong>
										<strong>
											<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">อนุมัติ</span>
										</strong>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Approve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<strong>[ / ] ไม่อนุมัติ</strong>/ Disapprove
										</span>
									</span>
								</span>
							</p>
					';
	}

	$content .= '
					<p style="margin-right:13px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif"><img src="digital-e-signature/doc_signs/' . $row['dean_admin_signature'] . '.png" width="20%"></span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(' . dean_admin_Date($dean_admin_dateSignature) . ')</span>
							</span>
						</span>
					</p>

					<p style="margin-left:100px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>
				</tr>
				<tr>
					<td style="border-bottom:none; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:158px">
					<p>&nbsp;</p>
					</td>
					<td colspan="2" style="border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; height:92px; vertical-align:top; width:338px">
					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<u>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;3. </span>
								</u>
								<u> </u>
								<strong>
									<u>
										<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">เจ้าหน้าที่กองทะเบียนและประมวลผล</span>
									</u>
								</strong>
							</span>
						</span>
					</p>

					<p style="margin-left:7px">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(The</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Officer</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">the</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Division</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">of</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Registrar)</span>
							</span>
						</span>
					</p>

					<p style="margin-right:9px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<strong>
									<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;ลงชื่อ</span>
								</strong>
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">/</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">Signature</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;</span> 
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">(&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;/&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>

					<p style="margin-right:5px; text-align:center">
						<span style="font-size:22px">
							<span style="font-family:&quot;Microsoft Sans Serif&quot;,sans-serif">
								<span style="font-family:&quot;TH SarabunPSK&quot;,sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;)</span>
							</span>
						</span>
					</p>
					</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; height:92px; vertical-align:top; width:194px">
					<p>&nbsp;</p>
					</td>
				</tr>
				<tr>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:200px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:220px">&nbsp;</td>
					<td style="border-bottom:none; border-left:none; border-right:none; border-top:none; width:130px">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	';
}


$mpdf->WriteHTML($content);
$mpdf->Output();

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
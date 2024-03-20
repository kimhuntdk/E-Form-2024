<?php
 if(isset($_GET['menu'])) {
    $menu = $_GET['menu'];
} else {
    $menu = '';
}
switch ($menu) {
	//---------------------------------------method--------------------
	case "home":
			$src_page = 'home.php';
			break;	
	case "login":
			$src_page = 'login.php';
			break;
	case "profile":
			$src_page = 'profile.php';
			break;
	case "form_request_doc":
			$src_page = 'form_request_doc2.php';
			break;
	case "Request_Form_Taking_Leave":
			$src_page = 'Request_Form_Taking_Leave.php'; //ลาพักการเรียน
			break;
	case "Request_Form_Registration_Thesis":
			$src_page = 'Request_Form_Registration_Thesis.php'; //ลงทะเบียน Thesis/IS เพิ่ม
			break;
	case "student":
			$src_page = 'student.php'; //สถานะคำร้องนิสิต
			break;
	case "Student_Registration_Thesis":
			$src_page = 'Student_Registration_Thesis.php';
			break;
	case "Student_Taking_Leave":
			$src_page = 'Student_Taking_Leave.php';
			break;
	case "profile":
			$src_page = 'profile.php';
			break;
	//-------------------------------------advisor-----------------------------
	
	case "advisor":
			$src_page = 'advisor.php'; //รักษาสภาพกรณีพิเศษ
			break;
	case "Advisor_Registration_Thesis":
			$src_page = 'Advisor_Registration_Thesis.php';
			break;
	case "Advisor_Taking_Leave":
			$src_page = 'Advisor_Taking_Leave.php';
			break;
	//-------------------------------------staff-----------------------------
	case "staff":
			$src_page = 'staff.php'; 
			break;
	case "Staff_Registration_Thesis":
			$src_page = 'Staff_Registration_Thesis.php';
			break;
	case "Staff_Taking_Leave":
			$src_page = 'Staff_Taking_Leave.php';
			break;
	//------------------------------Admin------------------------------------
	case "admin":
			$src_page = 'admin.php'; 
			break;
	case "Admin_Registration_Thesis":
			$src_page = 'Admin_Registration_Thesis.php';
			break;
	case "Admin_Taking_Leave":
			$src_page = 'Admin_Taking_Leave.php';
			break;
	//-------------------------------------Home-----------------------
	case "home":
			$src_page = '.php';
			break;	
	
	//------------------------------------------------------------------			
				
	default:
			$src_page = 'home.php';
			}
		
		
?>
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
	case "form_request_doc":
			$src_page = 'form_request_doc.php';
			break;
	case "Request_Form_Taking_Leave":
			$src_page = 'Request_Form_Taking_Leave.php'; //ลาพักการเรียน
			break;
	case "Request_Form_Registration_Thesis":
			$src_page = 'Request_Form_Registration_Thesis.php'; //ลงทะเบียน Thesis/IS เพิ่ม
			break;
	case "Request_Form_Status_Retention_Special":
			$src_page = 'Request_Form_Status_Retention_Special.php'; //รักษาสภาพกรณีพิเศษ
			break;
	//------------------------------------------------------------------
	
	//-------------------------------------Home-----------------------
	case "home":
			$src_page = '.php';
			break;	
	
	//------------------------------------------------------------------			
				
	default:
			$src_page = 'home.php';
			}
		
		
?>
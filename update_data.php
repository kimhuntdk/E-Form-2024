<?php
    session_start();
    include ("inc/db_connect.php");
	$mysqli = connect();
    date_default_timezone_set("Asia/Bangkok");
	if($_FILES['file']['name'] != "")
			{
			    $Filenames = $_FILES['file']['name'];
			    $type = $_FILES['file']['type'];
				$Filesize = $_FILES['file']['size'];	
			    $Filetem = $_FILES["file"]["tmp_name"];	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         $Filetem = $_FILES["file"]["tmp_name"][$i];		
				//เก็บชื่อไฟล์เป็นเวลาขณะที่ upload แล้วตามด้วยนามสกุลไฟล์ ถ้าไฟล์มีชื่อเหมือนกันจะได้ไม่มีปัญหา
				//สามารถ upload ไฟล์นามสกุล .gif, .png, .jpg, .zip, .docx, .pdf, .doc, .swf, .rar ได้
				$time = time() * microtime(); 
			if ( $type == "image/gif" ) {$Filenames = $time.".gif"; $pic_type = 'GIF'; }
				else if ( $type == "image/png" ) {$Filenames = $time.".png"; $pic_type = 'PNG'; }
				else if (( $type == "image/jpg") or ($type=="image/jpeg") or ($type == "image/pjpeg")) {$Filenames = $time.".jpg"; $pic_type = 'JPG'; }
				else if ($type == "application/octet-stream" ) {$Filenames = $time.".zip"; $pic_type = false;}
				else if ($type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" ) {$Filenames = $time.".docx"; $pic_type = false;}
				else if ($type == "application/pdf" ) {$Filenames = $time.".pdf"; $pic_type = false;}
				else if ($type == "application/msword" ) {$Filenames = $time.".doc"; $pic_type = false;}
				else if ($type == "application/x-shockwave-flash" ) {$Filenames = $time.".swf"; $pic_type = false;}
				else if($type == "application/octet-stream" ) {$Filenames = $time.".rar"; $pic_type = false;}
				//move ไฟล์ไปยังโฟลเดอร์ที่สร้างไว้ในที่นี้คือ fileupload
				if(move_uploaded_file($_FILES['file']['tmp_name'], "images/users/$Filenames")){
					 $sql_chk = " Update  request_student set  std_img='$Filenames' WHERE  std_id_std=".$_SESSION['SES_STDCODE'] ;
		            $rs_chk = $mysqli->query( $sql_chk );
					if($rs_chk){
						echo 1;
					}else {
						echo 2;
					}
				}
			}
?>
<?php
    session_start();
    $std_id= $_SESSION['SES_STDCODE'];
	$vacadyear = $_REQUEST['academic']; //acardemic
	$vsemester = $_REQUEST['semester'];  // sester
    $std_id = substr($std_id,6, 1); // returns "8"
	$vlevelid = $std_id ; // split จากรหัสประจำตัวนิสิต
	//$vcoursecode = '2007102' ;
    $vcoursecode = $_REQUEST['txt'];
	$url = "http://regpr.msu.ac.th/webservice/JsoncourseClass.php?acadyear=" . $vacadyear . "&semester=".$vsemester."&levelid=".$vlevelid."&coursecode=".$vcoursecode;
	echo $url;
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$results = json_decode($contents); 
	foreach ($results as $key => $value) { 
    //echo "<h2>$key</h2>";
    foreach ($value as $k => $v) { 
        //echo $k." | ".$v; 
        //echo $key;
        //echo "<br>";
        if($k=="CLASSID"){
/*            echo $v; 
            echo "|";*/
            $selion = $v;
            echo "<option value='$selion'>";
        }
        if($k=="SECTION"){ 
           // echo $v; 
            $classid = $v;
            echo $classid."</option>";
        }
    }
	}


?>

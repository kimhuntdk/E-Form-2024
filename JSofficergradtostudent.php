<?php

	$vofficercode = 5510;
    
	$url = "http://202.28.34.2/webservice/JsonOfficergardtostudent.php?officercode=" . $vofficercode;
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$results = json_decode($contents); 
	foreach ($results as $key => $value) { 
    foreach ($value as $k => $v) { 
        echo "$k | $v <br />"; 
    }
}


?>

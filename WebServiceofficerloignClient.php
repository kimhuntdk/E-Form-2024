<html>
<head>
<title>REG MSU</title>
</head>
<body>
<?php
		date_default_timezone_set("Asia/Bangkok");

	
		require_once("lib/nusoap.php");
        $client = new nusoap_client("http://regpr.msu.ac.th/webservice/WsOfficerlogin.php?wsdl",true); 
        $params = array(
                   'officercode' => '6750' , 'out_password' => 'ko23'
        );
       $data = $client->call("Officerlogin",$params); 
       //echo $data;

		$mydata = json_decode($data,true); // json decode from web service


					if(count($mydata) == 0)
					{
							echo "Not found data!";
					}
					else
					{
						?>
								<table width="100%" border="1">
								  <tr>
									<td>ตรวจสอบ</td>
								  </tr>
								<?php
								foreach ($mydata as $result) {
								?>
									  <tr>
										<td><?php echo $result["xpass"];?></td>
									  </tr>
								<?php
								}
					}


?>
</body>
</html>
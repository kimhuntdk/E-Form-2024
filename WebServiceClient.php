<html>
<head>
<title>REG MSU</title>
</head>
<body>
<?php
		date_default_timezone_set("Asia/Bangkok");

	
		require_once("lib/nusoap.php");
        $client = new nusoap_client("http://regpr.msu.ac.th/webservice/WsStudentinformation.php?wsdl",true); 
        $params = array(
                   'studentcode' => '57011282004' //$_GET['stdcode']
        );
       $data = $client->call("Studentinformation",$params); 
       // echo $data;

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
									<td>รหัสนิสิต</td>
									<td>ชื่อ</td>
									<td>สกุล</td>
									<td>วิทยาเขต</td>
									<td>ระดับ</td>
									<td>สาขา</td>
									<td>ชื่ออังกฤษ</td>
									<td>สกุลอังกฤษ</td>
									<td>วิทยาเขตอังกฤษ</td>
									<td>ระดับอังกฤษ</td>
									<td>สาขาอังกฤษ</td>
									<td>เลขบัตร</td>
								  </tr>
								<?php
								foreach ($mydata as $result) {
								?>
									  <tr>
										<td><?php echo $result["STUDENTCODE"];?></td>
										<td><?php echo $result["STUDENTNAME"];?></td>
										<td><?php echo $result["STUDENTSURNAME"];?></td>
										<td><?php echo $result["CAMPUSNAME"];?></td>
										<td><?php echo $result["LEVELNAME"];?></td>
										<td><?php echo $result["PROGRAMNAME"];?></td>
										<td><?php echo $result["STUDENTNAMEENG"];?></td>
										<td><?php echo $result["STUDENTSURNAMEENG"];?></td>
										<td><?php echo $result["CAMPUSNAMEENG"];?></td>
										<td><?php echo $result["LEVELNAMEENG"];?></td>
										<td><?php echo $result["PROGRAMNAMEENG"];?></td>
										<td><?php echo $result["CITIZENID"];?></td>
									  </tr>
								<?php
								}
					}


?>
</body>
</html>
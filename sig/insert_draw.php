<?PHP

	include ("connect.inc.php");
	
	$Name=$_POST['txtName'];
	$Draw=$_POST['Draw'];
	
	$StrInsert="INSERT INTO signature (Name,Draw) VALUES ('".$Name."','".$Draw."')";
	$Query=mysqli_query($Con,$StrInsert) or die (mysql_error());
	
	if($Query){
		$arr['Status']="Success";
		$arr['Msg']="System Insert Complete";
	}
	
	echo json_encode($arr);

?>
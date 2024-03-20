<?PHP
	$Host="localhost";
	$UserDB="root";
	$PassDB="";
	$DB="electronic";
	
	$Con=mysqli_connect($Host,$UserDB,$PassDB,$DB);
	if(!$Con){
		echo mysqli_connect_error();	
	}	   
?>
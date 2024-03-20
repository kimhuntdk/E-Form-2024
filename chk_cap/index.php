<?php
session_start();
/*if($_POST['button2']){
    if(isset($_POST['i_verify']) && $_POST['i_verify']==@array_sum($_SESSION['num_to_check']) && $_POST['i_verify']>0 && trim($_POST['i_verify'])!=""){
        echo "<span style="color:green;">Right</span>";
        $_SESSION['num_to_check'][0]=rand(1,9);
        $_SESSION['num_to_check'][1]=rand(1,9);
        exit;
    }else{
        echo "<span style="color:red;">Wrong</span>";
        $_SESSION['num_to_check'][0]=rand(1,9);
        $_SESSION['num_to_check'][1]=rand(1,9);     
        exit;   
    }
}*/
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>php question verify</title>
	<style type="text/css">
#verify_math{
    display:block;
    height:21px;    
}
#verify_math span{
    display:block;
    height:21px;    
    width:30px;
    position:relative;
    float:left;
    text-align:center;
    line-height:20px;
    color:#000;
}
#verify_math span.digital{
    background:url(images/digi_img.jpg) left top no-repeat; 
}
#i_verify{
    position:relative;
    height:15px;    
    width:35px; 
    text-align:center;
    padding:0;
    margin:0;
    font-size:15px;
    font-weight:bold;
    font-family:Tahoma, Geneva, sans-serif;
}
</style>
</head>
  
<body>
<?php
$_SESSION['num_to_check'][0]=rand(1,9);
$_SESSION['num_to_check'][1]=rand(1,9);
?>
<form id="form1" name="form1" method="post" action="check.php">
  <div id="verify_math">
  <span class="digital" style="background-position:<?php echo ($_SESSION['num_to_check'][0]*-30);?>px 0px;"></span>
  <span>+</span>
  <span class="digital" style="background-position:<?php echo ($_SESSION['num_to_check'][1]*-30);?>px 0px;"></span>
  <span>=</span>
  <span>
  <input name="i_verify" type="text" id="i_verify" maxlength="2" />
</span>
</div>
<br />
<br />
<input type="submit" name="button2" id="button2" value="Submit" />
</form>
  
</body>
</html>
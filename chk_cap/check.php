<?php
session_start();
if($_POST['button2']){
    if(isset($_POST['i_verify']) && $_POST['i_verify']==array_sum($_SESSION['num_to_check']) && $_POST['i_verify']>0 && trim($_POST['i_verify'])!=""){
        echo "<span style='color:green;'>Right</span>";
        $_SESSION['num_to_check'][0]=rand(1,9);
        $_SESSION['num_to_check'][1]=rand(1,9);
        exit;
    }else{
        echo "<span style='color:red;'>Wrong</span>";
        $_SESSION['num_to_check'][0]=rand(1,9);
        $_SESSION['num_to_check'][1]=rand(1,9);     
        exit;   
    }
}
?>
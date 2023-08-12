<?php
session_start();
include "../data/functions.php";
	$email=$_SESSION['email'];
	$otp=$_POST['otp'];
	if(empty($otp)){
		echo 404;
	}else{
	$user=new User();
	$select=$user->login_user();
    $execute=$select->execute([$email]);
    $rowCount=$select->rowCount();;
    if($rowCount>=1){
        $row=$select->fetch();
        $oldotp=$row['otp'];
        if(password_verify($otp,$oldotp)){
            $hash=Null;
            $send=$user->update_code($hash,$email);
            if($send){
               echo 200;
               $_SESSION['code']=$otp;
               $_SESSION['email1']=$email;
            }else{
                // Server error;
                404;
            }
        }else{
            echo 400;
        }
    }else{
        echo 402;
    }
    }
?>
<?php
// Remember using sha1 here dont forget 
session_start();
include "../data/functions.php";
	$firstName=$_POST['fname'];
	$lastName=$_POST['lname'];
	$shop_no=$_POST['shopNo'];
	$business_name=$_POST['bName'];
	$phone_number=$_POST['phoneNo'];
	$email=$_POST['email'];
	$password=$_POST['pword'];
	if(empty($firstName)||empty($lastName)||empty($shop_no)||empty($business_name)||empty($phone_number)||empty($email)||empty($password)){
		echo 404;
	}else{
	$user=new User();
	$select2=$user->login_user();
    $execute1=$select2->execute([$email]);
    $rowCountEmail=$select2->rowCount();
		if($rowCountEmail>=1){
			// Email Already exist
			echo 401;
		}else{
	$hashing=$user->hash($password);
	$insert=$user->insert_user($firstName,$lastName,$shop_no,$business_name,$phone_number,$email,$hashing);
	if($insert){
		echo 200;
	}else{
		echo 500;
	}
	}
}
	?>

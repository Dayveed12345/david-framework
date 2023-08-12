<?php
session_start();
include "../data/functions.php";
	$email=$_POST['email'];
	$password=$_POST['pword'];
	if(empty($email)||empty($password)){
		echo 404;
	}else{
	$user=new User();
	$select=$user->login_user();
    $execute=$select->execute([$email]);
    $rowCount=$select->rowCount();;
    if($rowCount>=1){
        $row=$select->fetch();
        $pword=$row['pword'];
        if(password_verify($password,$pword)){
            $_SESSION['email']=$email;
            echo 200;
            if(isset($_POST['remember'])){
                setcookie('email',$email,time()+(60*60*24*30));
                setcookie('pword',$password,time()+(60*60*24*30));
            }else{
                setcookie('email',"",time()-(60*60*24*30));
                setcookie('pword',"",time()-(60*60*24*30));
            }
     
        }else{
            echo 400;
        }
    }else{
        echo 402;
    }
    }
	
?>
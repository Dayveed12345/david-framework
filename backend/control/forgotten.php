<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;

require "../phpmailer/src/Exception.php";
require "../phpmailer/src/PHPMailer.php";
require "../phpmailer/src/SMTP.php";
include "../data/functions.php";
$email = $_POST['email'];
if (empty($email)) {
    echo 404;
} else {
    $user = new User();
    $select = $user->login_user();
    $execute = $select->execute([$email]);
    $rowCount = $select->rowCount();;
    if ($rowCount >= 1) {
        $_SESSION['email'] = $email;
        $md5=rand(10000,99999);
        // var_dump($md5);
        // try{
        // $mail = new PHPMailer(true);
		// $mail->isSMTP();
		// $mail->Host = 'smtp.gmail.com';
		// $mail->SMTPAuth = true;
        // // REmember to use codeweb email here
		// $mail->Username = 'dayveed070@gmail.com';
		// $mail->Password = 'ozzivmueqkvfunlm';
		// $mail->SMTPSecure = 'ssl';
		// $mail->Port = 465;
		// $mail->setFrom('nwinyinyadavid123@gmail.com');
		// $mail->addAddress($_SESSION['email']);
		// $mail->isHTML(true);
		// $mail->Subject = 'Your Verification Code';
		// $mail->Body = $md5;
		// $email=$mail->send();
        // }catch(Exception $ex){
        //     echo $ex->getMessage();
        // }
        // if(!$email){
        //     // Check your internet connection;
        //     echo 500;
        // }else{
            $hash=$user->hash($md5);
            $send=$user->update_code($hash,$email);
            if($send){
              echo json_encode( ["STATUS"=>200,"OTP"=>$md5]);
            }else{
                // Server error;
                404;
            }
        }
     
   else {
        // Email does not exist;
        echo 400;
    }
}

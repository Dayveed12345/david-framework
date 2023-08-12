<?php
session_start();
include '../data/functions.php';
$user=new User();
$image=$_FILES['image'];
$email = $_POST['email'];
$password=$_POST['pword'];
if(empty($image)||empty($password)||empty(($email))){
    echo   json_encode(["STATUS"=>600,"MESSAGE"=>"INPUT FIELD CANNOT BE EMPTY"]);
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo   json_encode(["STATUS"=>407,"MESSAGE"=>"ENTER A VALID EMAIL "]);
}else{
$select = $user->login_user();
$execute = $select->execute( [ $email ] );
$rowCount = $select->rowCount();
if($rowCount>=1){
    $row = $select->fetch();
    $pword = $row[ 'pword' ];
    if ( password_verify( $password, $pword ) ) {
        if ( $user->upload($image,$email)==400 ) {
            echo   json_encode(["STATUS"=>400,"MESSAGE"=>"THIS IS A WRONG IMAGE FORMAT "]);
        } else if ($user->upload($image,$email)==402) {
            echo   json_encode(["STATUS"=>402,"MESSAGE"=>"FiLE IS TOO LARGE"]);
        } else if($user->upload($image,$email)==200) {
            echo   json_encode(["STATUS"=>200,"MESSAGE"=>"IMAGE UPLDADED SUCCESSFULLY"]);
        }else{
         echo   json_encode(["STATUS"=>500,"MESSAGE"=>"AN ERROR OCCURED"]);
        }
        }
    else{
        echo   json_encode(["STATUS"=>505,"MESSAGE"=>"INCORRECT PASSWORD"]);
    }
}else{
    // Invalid Email
    echo json_encode(["STATUS"=>404,"MESSAGE"=>"INVALID EMAIL"]);
}
}

?>
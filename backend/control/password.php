<?php
session_start();
include '../data/functions.php';
$oldpassword = $_POST[ 'oldpword' ];
$newpassword = $_POST[ 'newpword' ];
$email = $_POST[ 'email' ];
if ( empty( $oldpassword ) || empty( $newpassword ) || empty( $email ) ) {
    echo 404;
} else {
    $user = new User();
    $select = $user->login_user();
    $execute = $select->execute( [ $email ] );
    $rowCount = $select->rowCount();
    if ( $rowCount >= 1 ) {
        $row = $select->fetch();
        $pword = $row[ 'pword' ];
        if ( password_verify( $oldpassword, $pword ) ) {
            $npword = $user->hash( $newpassword );
            $checking_pass = $user->edit_password( $npword, $email );
            if ( $checking_pass ) {
                echo 200;
                session_unset();
                session_destroy();
          
            } else {
                echo 500;
            }
        } else {
            echo 400;
        }
    } else {
        echo 402;
    }
}
;

<?php
session_start();
include '../data/functions.php';
$input_password = $_POST[ 'pword' ];
$email = $_POST[ 'email' ];
$oldemail = $_SESSION[ 'email' ];
if ( empty( $input_password ) || empty( $email ) ) {
    echo 404;
} else {
    $user = new User();
    $select = $user->login_user();
    $execute = $select->execute( [ $oldemail ] );
    $rowCount = $select->rowCount();
    if ( $rowCount >= 1 ) {
        $select2 = $user->login_user();
        $execute1 = $select2->execute( [ $email ] );
        $rowCountEmail = $select2->rowCount();
        if ( $rowCountEmail >= 1 ) {
            // Email Already exist
            echo 401;
        } else {
            $row = $select->fetch();
            $pword = $row[ 'pword' ];
            if ( password_verify( $input_password, $pword ) ) {
                $checking_email = $user->edit_email( $email, $oldemail );
                if ( $checking_email ) {
                    // Successful
                    echo 200;
                
                    session_unset();
                    session_destroy();
                 
                } else {
                    // email update not successful
                    echo 500;
                }
            } else {
                // password is not correct
                echo 400;
            }
        }
    } else {
        // Not in Session
        echo 402;
    }
}
;
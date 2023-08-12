<?php
include 'process.php';

class User
 {
    public $sql;
    public $sql1;
    public $processQuery;
    public $execute;
    public $query;
    public $prepare;


// CODEWEB CODING ACADEMY

    public function insert_user( $a, $b, $c, $d, $e, $f, $g ) {
        $this->processQuery = new processQuery();
        $this->query = 'INSERT INTO lavatb (firstname,lastname,shop_no,business_name,phone_number,email,pword)VALUES(?,?,?,?,?,?,?)';
        $this->prepare = $this->processQuery->query( $this->query );
        $this->prepare->execute( [ $a, $b, $c, $d, $e, $f, $g ] );
        return $this->prepare;
    }

    public function login_user()
 {
        $this->processQuery = new processQuery();
        $this->query = 'SELECT * FROM lavatb WHERE email=?';
        $this->execute = $this->processQuery->query( $this->query );
        return $this->execute;

    }

    public function hash( $password ) {
        $hash = password_hash( $password, PASSWORD_DEFAULT );
        return $hash;
    }

    public function select_user()
 {
        $this->processQuery = new processQuery();
        $this->query = 'SELECT * FROM lavatb WHERE email=?';
        $this->execute = $this->processQuery->query( $this->query );
        return $this->execute;

    }

    public function edit_password( $newpass, $email ) {
        $this->processQuery = new processQuery();
        $this->query = 'UPDATE lavatb SET pword=? where email=?';
        $this->prepare = $this->processQuery->query( $this->query );
        $this->prepare->execute( [ $newpass, $email ] );
        return $this->prepare;
    }

    public function edit_email( $newemail, $oldemail ) {
        $this->processQuery = new processQuery();
        $this->query = 'UPDATE lavatb SET email=? where email=?';
        $this->prepare = $this->processQuery->query( $this->query );
        $this->prepare->execute( [ $newemail, $oldemail ] );
        return $this->prepare;
    }

    public function send_code()
 {
        $this->processQuery = new processQuery();
        $this->query = 'SELECT * FROM lavatb WHERE email=? and otp=?';
        $this->execute = $this->processQuery->query( $this->query );
        return $this->execute;

    }

    public function update_code( $otp, $email ) {
        $this->processQuery = new processQuery();
        $this->query = 'UPDATE lavatb SET otp=? where email=?';
        $this->prepare = $this->processQuery->query( $this->query );
        $this->prepare->execute( [ $otp, $email ] );
        return $this->prepare;
    }

    public function update_pass( $pword, $email ) {
        $this->processQuery = new processQuery();
        $this->query = 'UPDATE lavatb SET pword=? where email=?';
        $this->prepare = $this->processQuery->query( $this->query );
        $this->prepare->execute( [ $pword, $email ] );
        return $this->prepare;
    }
    public function upload($files,$email ) {
        $fileName = $files[ 'name' ];
        $tmpName = $files[ 'tmp_name' ];
        $fileSize = $files[ 'size' ];
        $validImageExtension = [ 'jpeg', 'jpg', 'png' ];
        $imageExtension = explode( '.', $fileName );
        $imageExtension1 = strtolower( end( $imageExtension ) );
        $this->processQuery  = new processQuery();
        if ( !in_array( $imageExtension1, $validImageExtension ) ) {
            return 400;
        } else if ( $fileSize > 1000000 ) {
            return 402;
        } else {
            $this->query = 'UPDATE lavatb SET image=? where email=?';
            $newImageExtension = md5($fileName) . '.' . $imageExtension1;
            $this->prepare = $this->processQuery->query( $this->query );
            $checking=$this->prepare->execute([$newImageExtension, $email ] );
            move_uploaded_file( $tmpName, '../../profile/'. $newImageExtension );
            if($checking){
                return 200;
            }else{
                return 500;
            }
        }
    }
}
?>
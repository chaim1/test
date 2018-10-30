<?php

if (isset($_POST['submit'])) {

    include_once 'dbh-inc.php';

    $first = mysqli_real_escape_string($coon, $_POST['first']);
    $last = mysqli_real_escape_string($coon, $_POST['last']);
    $email = mysqli_real_escape_string($coon, $_POST['email']);
    $uid = mysqli_real_escape_string($coon, $_POST['uid']);
    $pwd = mysqli_real_escape_string($coon, $_POST['pwd']);

    if(empty($first)||empty($last)||empty($email)||empty($uid)||empty($pwd)){
        // echo $first.$last.$email.$uid.$pwd;
        // echo "jdksl";
        header("Location: ../signup.php?signup=empty");
        exit();
    }
    else{
        if(!preg_match("/^[a-zA-Z]*$/", $first)||!preg_match("/^[a-zA-Z]*$/", $last)){
            header("Location: ../signup.php?signup=invalid");
            exit();
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                header("Location: ../signup.php?signup=email");
                exit();
            }else{
                $sql = "SELECT * FROM users WHERE user_uid='$uid'";
                $result =  mysqli_query($coon, $sql);
                $resultChack = mysqli_num_rows($result);

                if($resultChack > 0){
                    header("Location: ../signup.php?signup=usertaken");
                     exit();
                }else{
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO users (user_first, user_last, user_email, user_uid, user_psw)
                     VALUES ('$first', '$last', '$email', '$uid', '$hashedPwd')";
                     mysqli_query($coon,  $sql);
                     header("Location: ../signup.php?signup=success");
                     exit();
                }
            }
        }
    }
}else{
    header("Location: ../signup.php");
    exit();
}
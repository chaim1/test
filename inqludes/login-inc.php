<?php

session_start();

if (isset($_POST['submit'])) {

    include 'dbh-inc.php';

    $uid = mysqli_real_escape_string($coon, $_POST['uid']);
    $pwd = mysqli_real_escape_string($coon, $_POST['pwd']);

    if(empty($uid)||empty($pwd)){
        header("location: ../index.php?login=empty");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE user_uid='$uid' OR user_email='$uid'";
        $result = mysqli_query($coon, $sql);
        $resultCeck = mysqli_num_rows($result);
        if($resultCeck < 1){
            header("location: ../index.php?login=error1");
            exit();
        }else{
            if($row = mysqli_fetch_assoc($result)){
                $hashedPwdCeck = password_verify($pwd,$row['user_psw']);
                if($hashedPwdCeck == false){
                    // echo $row['user_psw'];
                    header("location: ../index.php?login=error2");
                    exit();
                }elseif($hashedPwdCeck == true){
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    header("location: ../index.php?login=succes");
                    exit();
                }
            }
        }
    }
}else{
        header("location: ../index.php?login=error3");
        exit();

}
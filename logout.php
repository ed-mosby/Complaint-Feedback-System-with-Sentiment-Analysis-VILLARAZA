<?php 

    session_start();

    $_SESSION['userId'] = "";
    $_SESSION['IdUser']= "";
    $_SESSION['FullName']= "";
    $_SESSION['UserStatus']= "";

    if($_SESSION['userId'] == ""){
        header('location:login');
    }

?>
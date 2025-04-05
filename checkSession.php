<?php
    session_start();

        if($_SESSION['userId'] == ""){
            header('location:login');
        }else{
            if($_SESSION['isNew'] == 1){
                header('location:changePassword'); 
            }
        }
    

?>
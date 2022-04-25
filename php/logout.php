<?php
    session_start();
    if(isset($_SESSION['unique_id'])){ //if user is logged in then come to this page otherwise go to the login page
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){ //if logout id is set
            $status = "Offline now";
            //once user logsout,update this status to offline and in login form
            //again update status to active now if user logged in succesfully
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{
        header("location: ../login.php");
    }

?>
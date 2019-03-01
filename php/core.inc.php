<?php
    session_start();
    require 'connection/connection.php';
    $currentFile = $_SERVER["SCRIPT_NAME"];

    if (isset($_SERVER['HTTP_SERVER'])) {
        $httpReferer = $_SERVER['HTTP_REFERER'];
    }

    function loggedIn() {
        if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
            return true;
        } else {
            return false;
        }
    }

    function getuserfield($field) {
        global $conn;
        $query = "SELECT `$field` FROM `users` WHERE `id` = '".$_SESSION['user_id']."'";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $query_num_rows = mysqli_num_rows($query_run);
            if ($query_num_rows == NULL) {
                echo mysqli_error($conn);
            } else {
                $array = mysqli_fetch_assoc($query_run);
                return $array[$field];
            }
        } else {
            echo mysqli_error($conn);
        }

    } 
?>
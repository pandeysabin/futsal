<?php
    require '../core.inc.php';

    session_destroy();
    echo 'You\'re loggedout';
    // header('location:'. $http_referer);
?>
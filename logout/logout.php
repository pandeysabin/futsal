<?php
    require '../core.inc.php';

    session_destroy();
    header('location:'. $http_referer);
?>
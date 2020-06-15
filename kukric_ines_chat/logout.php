<?php
include('connection.php');

session_start();


update_user_status(0, $_SESSION['user_id'], $connect);

session_destroy();


header('location:login.php');

?>
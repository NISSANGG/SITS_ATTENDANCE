<?php
session_start();

// Unset the user_id session variable
if(isset($_SESSION['user_id'])) {
	unset($_SESSION['user_id']);
}

// Redirect to the login page
header("Location: login.php");
die;
?>

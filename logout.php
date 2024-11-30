<?php
session_start();

// Get the user's email from the session
$user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to the index page after logout with a logout message and user email
header("Location: index.php?logout=1&email=" . urlencode($user_email));
exit;
?>


<?php
// Controller/authcontroller.php

session_start();

function loginUser($username, $password) {
    // 1. SIMPLE ADMIN CHECK
    // You can change these to whatever you want
    $valid_user = "admin";
    $valid_pass = "admin123";

    if ($username === $valid_user && $password === $valid_pass) {
        // Success! Save user info to session
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = "Administrator";
        return true;
    }
    
    return false;
}

function logoutUser() {
    session_unset();
    session_destroy();
}

// Security Check Function
// Include this at the top of every restricted page
function checkLogin() {
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        // Check where we are to redirect correctly
        $in_view_folder = (basename(dirname($_SERVER['PHP_SELF'])) == 'View');
        $redirect_path = $in_view_folder ? '../login.php' : 'login.php';
        
        header("Location: " . $redirect_path);
        exit();
    }
}


?>
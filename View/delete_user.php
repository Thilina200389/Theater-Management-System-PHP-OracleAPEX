<?php
// View/delete_user.php
include_once '../Controller/usercontroller.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Call Delete
    deleteUser($id);
    
    // Redirect back to list
    header("Location: users.php");
    exit();
} else {
    // If no ID provided, just go back
    header("Location: users.php");
    exit();
}
?>
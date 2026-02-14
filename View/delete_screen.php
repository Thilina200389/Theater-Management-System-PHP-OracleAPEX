<?php
// View/delete_screen.php
include_once '../Controller/screencontroller.php';

if (isset($_GET['id'])) {
    $result = deleteScreen($_GET['id']);
    
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Screen deleted successfully'); window.location.href='screens.php';</script>";
    } else {
        echo "<script>alert('Failed to delete screen'); window.location.href='screens.php';</script>";
    }
} else {
    header("Location: screens.php");
}
?>
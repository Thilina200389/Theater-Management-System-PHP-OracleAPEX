<?php
// View/delete_show.php
include_once '../Controller/showcontroller.php';

if (isset($_GET['id'])) {
    $result = deleteShow($_GET['id']);
    
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Show deleted successfully'); window.location.href='shows.php';</script>";
    } else {
        echo "<script>alert('Failed to delete show'); window.location.href='shows.php';</script>";
    }
} else {
    header("Location: shows.php");
}
?>
<?php
// View/delete_theatre.php
include_once '../Controller/theatrecontroller.php';

if (isset($_GET['id'])) {
    $result = deleteTheatre($_GET['id']);
    
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Theatre deleted successfully'); window.location.href='theatres.php';</script>";
    } else {
        echo "<script>alert('Failed to delete theatre'); window.location.href='theatres.php';</script>";
    }
} else {
    header("Location: theatres.php");
}
?>
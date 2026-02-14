<?php
// View/delete_movie.php
include_once '../Controller/moviecontroller.php';

if (isset($_GET['id'])) {
    $result = deleteMovie($_GET['id']);
    
    // Check Success (200 OK or 204 No Content)
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Movie deleted successfully'); window.location.href='movies.php';</script>";
    } else {
        echo "<script>alert('Failed to delete movie'); window.location.href='movies.php';</script>";
    }
} else {
    header("Location: movies.php");
}
?>
<?php
// View/add_movie.php

// 1. Include the Controller
include_once '../Controller/moviecontroller.php';

// --- LOGIC: Handle the Form Submit ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Call the Controller function
    $result = addMovie(
        $_POST['title'],
        $_POST['language'],
        $_POST['duration'],
        $_POST['genre'],
        $_POST['rating'],
        $_POST['description']
    );

    // 3. Success Check (using the standard http_code from our connector)
    if ($result['http_code'] == 200 || $result['http_code'] == 201) {
        echo "<script>alert('Movie added successfully!'); window.location.href='movies.php';</script>";
    } else {
        // Display Error
        $error_msg = $result['message'] ?? 'Unknown Error';
        $raw_response = json_encode($result); // For debugging
        
        echo "<div style='color:red; padding:10px; border:1px solid red; margin-bottom:10px;'>";
        echo "<strong>Error:</strong> Failed to add movie. (HTTP Code: {$result['http_code']})<br>";
        echo "<strong>APEX Response:</strong> $error_msg";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Movie</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        .form-container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 15px; font-weight: bold; color: #333; }
        input[type="text"], input[type="number"], textarea, select { 
            width: 100%; padding: 10px; margin-top: 5px; 
            border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; 
        }
        button { 
            width: 100%; margin-top: 25px; padding: 12px; 
            background-color: #007bff; color: white; 
            border: none; border-radius: 4px; font-size: 16px; cursor: pointer; 
        }
        button:hover { background-color: #0056b3; }
        .back-btn { text-decoration: none; color: #666; font-size: 14px; }
    </style>
</head>
<body>

<div class="form-container">
    <a href="movies.php" class="back-btn">← Back to Movie List</a>
    <h2 style="text-align: center;">Add New Movie</h2>
    <p style="text-align:center; font-size:12px; color:#888;">Adding to Database via Controller</p>

    <form method="POST" action="">
        
        <label>Title</label>
        <input type="text" name="title" required placeholder="Movie Title">

        <label>Language</label>
        <input type="text" name="language" required placeholder="English, Hindi, etc.">

        <label>Duration (minutes)</label>
        <input type="number" name="duration" required placeholder="e.g. 120">

        <label>Genre</label>
        <input type="text" name="genre" required placeholder="Action, Drama, etc.">

        <label>Rating</label>
        <select name="rating">
            <option value="">-- Select Rating --</option>
            <option value="G">G</option>
            <option value="PG">PG</option>
            <option value="PG-13">PG-13</option>
            <option value="R">R</option>
        </select>

        <label>Description</label>
        <textarea name="description" rows="4" placeholder="Short plot summary..."></textarea>

        <button type="submit">Save Movie</button>
    </form>
</div>

</body>
</html>
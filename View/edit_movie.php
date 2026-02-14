<?php
// View/edit_movie.php

// 1. Include the Controller
include_once '../Controller/moviecontroller.php';

// 2. Validate ID
if (!isset($_GET['id'])) {
    die("Error: No movie ID provided.");
}
$movie_id = $_GET['id'];

// 3. FETCH DATA (Using Controller)
$movie = getMovieById($movie_id);

// Pre-fill variables
if ($movie) {
    $title = $movie['title'];
    $lang  = $movie['language'];
    $dur   = $movie['duration'];
    $genre = $movie['genre'];
    $rate  = $movie['rating'];
    $desc  = $movie['description'];
} else {
    // If not found in the list
    die("<p style='color:red'>Error: Movie ID $movie_id not found in the database.</p>");
}

// 4. HANDLE UPDATE (Using Controller)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = updateMovie(
        $movie_id,
        $_POST['title'],
        $_POST['language'],
        $_POST['duration'],
        $_POST['genre'],
        $_POST['rating'],
        $_POST['description']
    );

    // Check Success (200 OK or 204 No Content are both standard for PUT)
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Movie updated successfully!'); window.location.href='movies.php';</script>";
    } else {
        $error_msg = $result['message'] ?? 'Unknown Error';
        echo "<div style='color:red; padding:10px; border:1px solid red; margin:10px 0;'>";
        echo "<strong>Update Failed.</strong> HTTP Code: {$result['http_code']}<br>";
        echo "APEX Response: $error_msg";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie</title>
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
            background-color: #ffc107; color: black; /* Yellow for Edit */
            border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold;
        }
        button:hover { background-color: #e0a800; }
        .back-btn { text-decoration: none; color: #666; font-size: 14px; }
    </style>
</head>
<body>

<div class="form-container">
    <a href="movies.php" class="back-btn">← Back to Movie List</a>
    
    <h2 style="text-align: center;">Edit Movie (ID: <?php echo $movie_id; ?>)</h2>
    <p style="text-align:center; font-size:12px; color:#888;">Editing via MVC Controller</p>

    <form method="POST" action="">
        
        <label>Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label>Language</label>
        <input type="text" name="language" value="<?php echo htmlspecialchars($lang); ?>">

        <label>Duration (minutes)</label>
        <input type="number" name="duration" value="<?php echo htmlspecialchars($dur); ?>">

        <label>Genre</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($genre); ?>">

        <label>Rating</label>
        <select name="rating">
            <option value="G" <?php if($rate=='G') echo 'selected'; ?>>G</option>
            <option value="PG" <?php if($rate=='PG') echo 'selected'; ?>>PG</option>
            <option value="PG-13" <?php if($rate=='PG-13') echo 'selected'; ?>>PG-13</option>
            <option value="R" <?php if($rate=='R') echo 'selected'; ?>>R</option>
        </select>

        <label>Description</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($desc); ?></textarea>

        <button type="submit">Update Movie</button>
    </form>
</div>

</body>
</html>
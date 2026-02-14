<?php
// View/add_show.php

// 1. INCLUDE CONTROLLERS
include_once '../Controller/showcontroller.php';
include_once '../Controller/moviecontroller.php';
include_once '../Controller/screencontroller.php';

// 2. FETCH DATA FOR DROPDOWNS
$movie_list = getAllMovies();
$screen_list = getAllScreens();

// 3. HANDLE FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // We pass the separate Date and Time to the controller.
    // The controller handles mixing them into "YYYY-MM-DD HH:MM:SS"
    $result = addShow(
        $_POST['movie_id'],
        $_POST['screen_id'],
        $_POST['show_date'],
        $_POST['show_time'],
        $_POST['base_price']
    );

    // 4. CHECK RESPONSE
    // We check for HTTP 200/201 OR if the API returned a specific "status": "success" JSON
    $is_success = ($result['http_code'] == 200 || $result['http_code'] == 201);
    
    // Fallback: Sometimes ORDS returns 200 even on error, so check JSON body if available
    if (isset($result['status']) && $result['status'] == 'error') {
        $is_success = false;
    }

    if ($is_success) {
        echo "<script>alert('Show scheduled successfully!'); window.location.href='shows.php';</script>";
    } else {
        $error_msg = $result['message'] ?? "Unknown Error";
        $debug_info = json_encode($result);
        
        echo "<div style='color:red; padding:15px; background:white; border-bottom:2px solid red;'>";
        echo "<strong>Scheduling Failed!</strong><br>";
        echo "Message: " . htmlspecialchars($error_msg) . "<br>";
        echo "<small>Debug: $debug_info</small>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Show</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        h2 { margin-top: 0; color: #2c3e50; text-align: center; margin-bottom: 30px; }
        
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; margin-bottom: 5px; }
        
        /* Input Styling */
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 15px; background: white; }
        
        /* Flexbox for Side-by-Side Date/Time */
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }

        .btn-submit { 
            width: 100%; margin-top: 30px; padding: 14px; 
            background-color: #0066cc; color: white; border: none; 
            border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; 
        }
        .btn-submit:hover { background-color: #0052a3; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="shows.php" class="back-link">← Back to Schedule</a>
        <h2>Schedule New Show</h2>

        <form method="POST" action="">
            
            <label>Select Movie</label>
            <select name="movie_id" required>
                <option value="">-- Choose a Movie --</option>
                <?php foreach ($movie_list as $m): ?>
                    <option value="<?php echo $m['movie_id']; ?>">
                        <?php echo $m['title']; ?> (<?php echo $m['duration']; ?> min)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Select Screen</label>
            <select name="screen_id" required>
                <option value="">-- Choose a Screen --</option>
                <?php foreach ($screen_list as $s): ?>
                    <option value="<?php echo $s['screen_id']; ?>">
                        <?php echo $s['name']; ?> (Cap: <?php echo $s['capacity']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="row">
                <div class="col">
                    <label>Date</label>
                    <input type="date" name="show_date" required>
                </div>
                <div class="col">
                    <label>Start Time</label>
                    <input type="time" name="show_time" required>
                </div>
            </div>

            <label>Ticket Price ($)</label>
            <input type="number" step="0.01" name="base_price" placeholder="e.g. 12.50" required>

            <button type="submit" class="btn-submit">Confirm Schedule</button>
        </form>
    </div>
</div>

</body>
</html>
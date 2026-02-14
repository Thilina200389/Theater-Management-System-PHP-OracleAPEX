<?php
// View/edit_show.php

// 1. INCLUDE CONTROLLERS
include_once '../Controller/showcontroller.php';
include_once '../Controller/moviecontroller.php';
include_once '../Controller/screencontroller.php';

// 2. VALIDATE ID
if (!isset($_GET['id'])) { die("Error: No Show ID provided."); }
$show_id = $_GET['id'];

// 3. FETCH DATA
$show = getShowById($show_id);
if (!$show) { die("Error: Show not found."); }

// Fetch Dropdowns
$movie_list = getAllMovies();
$screen_list = getAllScreens();

// 4. PARSE EXISTING DATA
$current_movie  = $show['movie_id'] ?? '';
$current_screen = $show['screen_id'] ?? '';
$price          = $show['base_price'] ?? '';
$status         = $show['status'] ?? 'Scheduled';

// Smart Date Parsing (Your Logic Preserved)
$full_dt   = $show['start_datetime'] ?? '';
$date_val  = "";
$time_val  = "";

if (!empty($full_dt)) {
    // strtotime is smart enough to handle both formats
    $ts = strtotime($full_dt);
    $date_val = date('Y-m-d', $ts); // 2025-12-20
    $time_val = date('H:i', $ts);   // 10:00
}

// 5. HANDLE UPDATE (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = updateShow(
        $show_id,
        $_POST['movie_id'],
        $_POST['screen_id'],
        $_POST['show_date'],
        $_POST['show_time'],
        $_POST['base_price'],
        $_POST['status']
    );

    // Check Success (200 or 204 are standard for PUT)
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Show updated successfully!'); window.location.href='shows.php';</script>";
    } else {
        $error_msg = $result['message'] ?? 'Unknown Error';
        echo "<div style='color:red; padding:10px; border:1px solid red; margin:10px;'>";
        echo "<strong>Update Failed.</strong> HTTP Code: {$result['http_code']}<br>Response: $error_msg";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Show</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        
        label { display: block; margin-top: 15px; font-weight: 600; color: #555; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; margin-top: 5px; box-sizing: border-box; }
        
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }

        button { width: 100%; margin-top: 25px; padding: 12px; background-color: #ffc107; color: #000; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #e0a800; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="shows.php" class="back-link">← Back to Schedule</a>
        <h2 style="text-align: center;">Edit Show #<?php echo $show_id; ?></h2>

        <form method="POST" action="">
            
            <label>Movie</label>
            <select name="movie_id" required>
                <?php foreach ($movie_list as $m): ?>
                    <option value="<?php echo $m['movie_id']; ?>" <?php if($m['movie_id'] == $current_movie) echo 'selected'; ?>>
                        <?php echo $m['title']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Screen</label>
            <select name="screen_id" required>
                <?php foreach ($screen_list as $s): ?>
                    <option value="<?php echo $s['screen_id']; ?>" <?php if($s['screen_id'] == $current_screen) echo 'selected'; ?>>
                        <?php echo $s['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="row">
                <div class="col">
                    <label>Date</label>
                    <input type="date" name="show_date" value="<?php echo $date_val; ?>" required>
                </div>
                <div class="col">
                    <label>Time</label>
                    <input type="time" name="show_time" value="<?php echo $time_val; ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Price ($)</label>
                    <input type="number" step="0.01" name="base_price" value="<?php echo $price; ?>" required>
                </div>
                <div class="col">
                    <label>Status</label>
                    <select name="status">
                        <option value="Scheduled" <?php if($status=='Scheduled') echo 'selected'; ?>>Scheduled</option>
                        <option value="Selling Fast" <?php if($status=='Selling Fast') echo 'selected'; ?>>Selling Fast</option>
                        <option value="Sold Out" <?php if($status=='Sold Out') echo 'selected'; ?>>Sold Out</option>
                        <option value="Cancelled" <?php if($status=='Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>
            </div>

            <button type="submit">Update Show</button>
        </form>
    </div>
</div>

</body>
</html>
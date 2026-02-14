<?php
// View/add_booking.php

// 1. INCLUDE CONTROLLERS
include_once '../Controller/bookingcontroller.php';
include_once '../Controller/usercontroller.php';
include_once '../Controller/moviecontroller.php';
include_once '../Controller/showcontroller.php';

// 2. FETCH DATA FOR DROPDOWNS
$user_list = getAllUsers();
$show_list = getAllShows();
$movie_list = getAllMovies();

// 3. BUILD MOVIE MAP (Movie ID -> Title)
// We need this so the Show dropdown can say "Avengers" instead of "Movie #5"
$movies_map = [];
foreach ($movie_list as $m) {
    $mid = $m['movie_id'] ?? $m['MOVIE_ID'];
    $ttl = $m['title'] ?? $m['TITLE'] ?? "Movie #$mid";
    $movies_map[$mid] = $ttl; 
}

// 4. HANDLE FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = addBooking(
        $_POST['user_id'],
        $_POST['show_id'],
        $_POST['total_amount']
    );

    // Check Success (Either HTTP 200/201 OR specific 'success' status)
    if (($result['http_code'] == 200 || $result['http_code'] == 201) || ($result['status'] ?? '') == 'success') {
        
        // Grab the code if returned
        $code = $result['booking']['booking_code'] ?? 'Confirmed';
        echo "<script>alert('Booking successfully created! Code: $code'); window.location.href='bookings.php';</script>";
        
    } else {
        $err = $result['message'] ?? 'Unknown Error';
        $debug = json_encode($result);
        
        echo "<div style='color:red; padding:15px; border:1px solid red; margin:20px; background:white;'>";
        echo "<strong>Booking Failed:</strong> $err <br>";
        echo "<small>Debug: $debug</small>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Booking</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; margin-top: 5px; background: white; }
        
        button { width: 100%; margin-top: 30px; padding: 14px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
        button:hover { background-color: #218838; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="bookings.php" class="back-link">← Back to Bookings</a>
        <h2>Create Manual Booking</h2>

        <form method="POST" action="">
            
            <label>Customer</label>
            <select name="user_id" required>
                <option value="">-- Select Customer --</option>
                <?php foreach ($user_list as $u): ?>
                    <?php 
                        // Safe extraction (UPPER/lower case)
                        $uid   = $u['user_id'] ?? $u['USER_ID'];
                        $uname = $u['username'] ?? $u['USERNAME'] ?? $u['name'] ?? $u['NAME'] ?? "User #$uid";
                    ?>
                    <option value="<?php echo $uid; ?>">
                        <?php echo $uname; ?> (ID: <?php echo $uid; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Show</label>
            <select name="show_id" required>
                <option value="">-- Select Show --</option>
                <?php foreach ($show_list as $s): ?>
                    <?php 
                        // Safe extraction
                        $sid   = $s['show_id'] ?? $s['SHOW_ID'];
                        $mid   = $s['movie_id'] ?? $s['MOVIE_ID'];
                        $price = $s['base_price'] ?? $s['BASE_PRICE'] ?? 0;
                        $dt    = $s['start_datetime'] ?? $s['START_DATETIME'];
                        
                        // Lookup Movie Name
                        $m_name = $movies_map[$mid] ?? "Movie #$mid";
                        
                        // Clean Date Display
                        $time_disp = date("M d, H:i", strtotime($dt));
                    ?>
                    <option value="<?php echo $sid; ?>">
                        <?php echo $m_name; ?> | <?php echo $time_disp; ?> | $<?php echo $price; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Total Amount ($)</label>
            <input type="number" step="0.01" name="total_amount" placeholder="e.g. 1500.00" required>

            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</div>

</body>
</html>
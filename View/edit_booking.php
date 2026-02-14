<?php
// View/edit_booking.php

include_once '../Controller/bookingcontroller.php';
include_once '../Controller/usercontroller.php';
include_once '../Controller/showcontroller.php';
include_once '../Controller/moviecontroller.php';

if (!isset($_GET['id'])) { die("Error: No Booking ID."); }
$b_id = $_GET['id'];

// 1. FETCH DATA
$booking = getBookingById($b_id);
if (!$booking) { die("Error: Booking not found."); }

$user_list = getAllUsers();
$show_list = getAllShows();
$movie_list = getAllMovies();

// 2. MAP MOVIES (ID -> Title)
$movies_map = [];
foreach ($movie_list as $m) {
    $mid = $m['movie_id'] ?? $m['MOVIE_ID'];
    $movies_map[$mid] = $m['title'] ?? $m['TITLE']; 
}

// 3. PRE-FILL FORM DATA
$current_user   = $booking['user_id'] ?? $booking['USER_ID'];
$current_show   = $booking['show_id'] ?? $booking['SHOW_ID'];
$current_amount = $booking['total_amount'] ?? $booking['TOTAL_AMOUNT'];
$current_status = $booking['status'] ?? $booking['STATUS'];
$booking_code   = $booking['booking_code'] ?? $booking['BOOKING_CODE'];

// 4. HANDLE UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = updateBooking(
        $b_id,
        $_POST['user_id'],
        $_POST['show_id'],
        $_POST['total_amount'],
        $_POST['status']
    );

    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Booking updated!'); window.location.href='bookings.php';</script>";
    } else {
        $err = $result['message'] ?? 'Unknown Error';
        echo "<script>alert('Update Failed: $err');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; }
        select, input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; margin-top: 5px; background: white; box-sizing: border-box;}
        button { width: 100%; margin-top: 30px; padding: 14px; background-color: #ffc107; color: black; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; }
        button:hover { background-color: #e0a800; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="bookings.php" class="back-link">← Back to Bookings</a>
        <h2 style="text-align: center;">Edit Booking (<?php echo $booking_code; ?>)</h2>

        <form method="POST" action="">
            
            <label>Customer</label>
            <select name="user_id" required>
                <?php foreach ($user_list as $u): ?>
                    <?php 
                        $uid = $u['user_id'] ?? $u['USER_ID'];
                        $uname = $u['username'] ?? $u['USERNAME'] ?? $u['name'] ?? "User #$uid";
                    ?>
                    <option value="<?php echo $uid; ?>" <?php if($uid == $current_user) echo 'selected'; ?>>
                        <?php echo $uname; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Show</label>
            <select name="show_id" required>
                <?php foreach ($show_list as $s): ?>
                    <?php 
                        $sid = $s['show_id'] ?? $s['SHOW_ID'];
                        $mid = $s['movie_id'] ?? $s['MOVIE_ID'];
                        $m_name = $movies_map[$mid] ?? "Movie #$mid";
                        $dt = date("M d, H:i", strtotime($s['start_datetime'] ?? $s['START_DATETIME']));
                    ?>
                    <option value="<?php echo $sid; ?>" <?php if($sid == $current_show) echo 'selected'; ?>>
                        <?php echo $m_name; ?> | <?php echo $dt; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Total Amount ($)</label>
            <input type="number" step="0.01" name="total_amount" value="<?php echo $current_amount; ?>" required>

            <label>Status</label>
            <select name="status">
                <option value="Confirmed" <?php if($current_status=='Confirmed') echo 'selected'; ?>>Confirmed</option>
                <option value="Pending" <?php if($current_status=='Pending') echo 'selected'; ?>>Pending</option>
                <option value="Cancelled" <?php if($current_status=='Cancelled') echo 'selected'; ?>>Cancelled</option>
            </select>

            <button type="submit">Update Booking</button>
        </form>
    </div>
</div>

</body>
</html>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// View/bookings.php

// 1. INCLUDE CONTROLLERS
include_once '../Controller/bookingcontroller.php';
include_once '../Controller/moviecontroller.php';
include_once '../Controller/showcontroller.php';
include_once '../Controller/usercontroller.php';

// 2. FETCH ALL DATA
$booking_list = getAllBookings();
$movies       = getAllMovies();
$shows        = getAllShows();
$users        = getAllUsers();

// 3. BUILD SMART MAPS (Logic preserved from your code)

// A. Movies Map (ID -> Title)
$movies_map = [];
foreach ($movies as $m) { 
    $movies_map[$m['movie_id']] = $m['title']; 
}

// B. Shows Map (Show ID -> Movie Title)
$shows_movie_map = [];
foreach ($shows as $s) {
    $mid = $s['movie_id'];
    $movie_name = $movies_map[$mid] ?? "Movie #$mid";
    $shows_movie_map[$s['show_id']] = $movie_name;
}

// C. Users Map (User ID -> Name)
$users_map = [];
foreach ($users as $u) {
    $u_id   = $u['user_id'] ?? $u['USER_ID'];
    // Handle various name fields
    $u_name = $u['username'] ?? $u['USERNAME'] ?? $u['name'] ?? $u['NAME'] ?? "User #$u_id";
    $users_map[$u_id] = $u_name; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Management</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 25px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .api-info { font-size: 12px; color: #888; display: block; margin-top: 5px; }
        
        .styled-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .styled-table th { background: #f8f9fa; padding: 15px; text-align: left; color: #6c757d; border-bottom: 2px solid #e9ecef; }
        .styled-table td { padding: 15px; border-bottom: 1px solid #e9ecef; vertical-align: middle; }
        
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge-Confirmed { background: #d4edda; color: #155724; }
        .badge-Pending { background: #fff3cd; color: #856404; }
        .badge-Cancelled { background: #f8d7da; color: #721c24; }

        .btn-cancel { padding: 6px 12px; background: #fee2e2; color: #b91c1c; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: 600; }
        .btn-cancel:hover { background: #fecaca; }
        
        .booking-code { font-family: 'Courier New', monospace; font-weight: bold; color: #555; background: #eee; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <div class="page-header">
            <div>
                <h1>📑 Customer Bookings</h1>
                <span class="api-info">Connected to: <?php echo API_BASE_URL; ?>bookings</span>
            </div>
            <a href="add_booking.php" class="btn" style="background:#28a745; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;">+ New Booking</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Customer</th>
                    <th>Movie / Show</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($booking_list)): ?>
                    <?php foreach ($booking_list as $b): ?>
                    
                    <?php 
                        // Handle Uppercase Keys (Oracle compatibility)
                        $b_id     = $b['BOOKING_ID'] ?? $b['booking_id'];
                        $u_id     = $b['USER_ID']    ?? $b['user_id'];
                        $s_id     = $b['SHOW_ID']    ?? $b['show_id'];
                        $b_code   = $b['BOOKING_CODE'] ?? $b['booking_code'];
                        $amount   = $b['TOTAL_AMOUNT'] ?? $b['total_amount'];
                        $status   = $b['STATUS']       ?? $b['status'];
                        $b_date   = $b['BOOKING_DATETIME'] ?? $b['booking_datetime'];
                    ?>

                    <tr>
                        <td style="color: #888;">#<?php echo $b_id; ?></td>
                        
                        <td><span class="booking-code"><?php echo $b_code; ?></span></td>
                        
                        <td style="font-weight: 600;">
                            <?php echo $users_map[$u_id] ?? "User ID: $u_id"; ?>
                        </td>
                        
                        <td>
                            🎬 <?php echo $shows_movie_map[$s_id] ?? "Show ID: $s_id"; ?>
                        </td>

                        <td style="font-weight: bold; color: #2c3e50;">
                            $<?php echo number_format((float)$amount, 2); ?>
                        </td>

                        <td style="font-size: 13px; color: #666;">
                            <?php echo date("M d, H:i", strtotime($b_date)); ?>
                        </td>

                        <td>
                            <span class="badge badge-<?php echo $status; ?>">
                                <?php echo $status; ?>
                            </span>
                        </td>

                        <td>
                            <a href="edit_booking.php?id=<?php echo $b_id; ?>"
                            class="btn-edit"
                            style="margin-right:5px; text-decoration:none; padding:6px 12px; background:#e9ecef; color:#333; border-radius:4px; font-weight:600; font-size:12px;">
                            Edit
                            </a>
                            <a href="delete_booking.php?id=<?php echo $b_id; ?>" 
                               class="btn-cancel"
                               onclick="return confirm('Delete booking <?php echo $b_code; ?>?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" style="text-align: center; padding: 40px;">No bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
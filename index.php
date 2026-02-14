<?php
// index.php - ADMIN DASHBOARD

// 1. SECURITY CHECK (Include the Auth Controller)
include_once 'Controller/authcontroller.php';
checkLogin(); // This function kicks you out if not logged in

// 1. SESSION START (Prepared for future Login)
session_start();
// if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// 2. INCLUDE CONTROLLERS
// We need these to fetch the live counts
include_once 'Controller/moviecontroller.php';
include_once 'Controller/bookingcontroller.php';
include_once 'Controller/theatrecontroller.php';
include_once 'Controller/showcontroller.php';
include_once 'Controller/usercontroller.php';

// 3. FETCH LIVE STATS
$movies     = getAllMovies();
$theatres   = getAllTheatres();
$bookings   = getAllBookings();
$shows      = getAllShows();

$movies_count   = count($movies);
$theatres_count = count($theatres);
$bookings_count = count($bookings);
$shows_count    = count($shows);

// Calculate Total Revenue
$total_revenue = 0;
foreach ($bookings as $b) {
    // Handle upper/lower case keys just to be safe
    $amt = $b['total_amount'] ?? $b['TOTAL_AMOUNT'] ?? 0;
    $total_revenue += (float)$amt;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; color: #333; }
        
        /* Top Bar */
        .top-bar { background: #2c3e50; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 24px; font-weight: bold; }
        .user-info { font-size: 14px; opacity: 0.8; }

        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px; }
        
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        
        .stat-info h3 { margin: 0; font-size: 32px; color: #2c3e50; }
        .stat-info p { margin: 5px 0 0; color: #888; font-weight: 600; font-size: 14px; text-transform: uppercase; }
        
        .icon-box { width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        
        /* Colors */
        .c-green { background: #e8f5e9; color: #2e7d32; }
        .c-blue  { background: #e3f2fd; color: #0d47a1; }
        .c-purple{ background: #f3e5f5; color: #7b1fa2; }
        .c-orange{ background: #fff3e0; color: #e65100; }

        /* Quick Actions */
        h2 { color: #444; margin-bottom: 20px; font-size: 20px; }
        .actions-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        
        .action-btn { 
            background: white; padding: 30px 20px; border-radius: 12px; text-decoration: none; 
            color: #555; font-weight: 600; text-align: center; border: 1px solid #eee; transition: all 0.2s; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); display: flex; flex-direction: column; align-items: center; gap: 10px;
        }
        .action-btn:hover { border-color: #007bff; color: #007bff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .btn-icon { font-size: 30px; margin-bottom: 5px; }

    </style>
</head>
<body>

    <div class="top-bar">
        <div class="logo">Admin Dashboard</div>
        <div class="user-info">Logged in as Admin</div>
    </div>

    <div class="container">
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>$<?php echo number_format($total_revenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon-box c-green">💰</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $bookings_count; ?></h3>
                    <p>Tickets Sold</p>
                </div>
                <div class="icon-box c-blue">🎟</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $movies_count; ?></h3>
                    <p>Movies</p>
                </div>
                <div class="icon-box c-purple">🎬</div>
            </div>

            <div class="stat-card">
                <div class="stat-info">
                    <h3><?php echo $theatres_count; ?></h3>
                    <p>Theatres</p>
                </div>
                <div class="icon-box c-orange">🏛</div>
            </div>
        </div>

        <h2>Management Modules</h2>
        <div class="actions-grid">
            <a href="View/bookings.php" class="action-btn">
                <span class="btn-icon">📑</span>
                Manage Bookings
            </a>
            <a href="View/movies.php" class="action-btn">
                <span class="btn-icon">🎥</span>
                Manage Movies
            </a>
            <a href="View/shows.php" class="action-btn">
                <span class="btn-icon">📅</span>
                Manage Schedule
            </a>
            <a href="View/theatres.php" class="action-btn">
                <span class="btn-icon">🏢</span>
                Manage Theatres
            </a>
            <a href="View/screens.php" class="action-btn">
                <span class="btn-icon">📺</span>
                Manage Screens
            </a>
            <a href="View/users.php" class="action-btn">
                <span class="btn-icon">👥</span>
                Manage Users
            </a>
            <a href="View/add_booking.php" class="action-btn" style="border-color: #28a745; color: #28a745; background: #f0fff4;">
                <span class="btn-icon">➕</span>
                New Booking
            </a>
        </div>

    </div>

</body>
</html>
<?php
// View/shows.php

// 1. INCLUDE CONTROLLERS
include_once '../Controller/showcontroller.php';
include_once '../Controller/moviecontroller.php';   // To get Movie Names
include_once '../Controller/screencontroller.php';  // To get Screen Names

// 2. FETCH DATA
$show_list = getAllShows();
$movies    = getAllMovies();
$screens   = getAllScreens();

// 3. BUILD SMART MAPS (ID -> Name)
// This replaces the "Smart Loading" block from your old code
$movies_map = [];
foreach ($movies as $m) { 
    $movies_map[$m['movie_id']] = $m['title']; 
}

$screens_map = [];
foreach ($screens as $s) { 
    $screens_map[$s['screen_id']] = $s['name']; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Management</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 25px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .api-info { font-size: 12px; color: #888; display: block; margin-top: 5px; }
        .btn { padding: 10px 18px; border-radius: 6px; text-decoration: none; color: white; background: #0066cc; display: inline-block; border: none; cursor: pointer; }
        .btn-edit { background: #e9ecef; color: #333; padding: 5px 10px; font-size: 12px; }
        .btn-delete { background: #fee2e2; color: #b91c1c; padding: 5px 10px; font-size: 12px; margin-left: 5px; }
        
        .styled-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .styled-table th { background: #f8f9fa; padding: 15px; text-align: left; color: #6c757d; border-bottom: 2px solid #e9ecef; }
        .styled-table td { padding: 15px; border-bottom: 1px solid #e9ecef; }
        
        /* Status Badges */
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .status-Scheduled { background-color: #e3f2fd; color: #0d47a1; } /* Blue */
        .status-Cancelled { background-color: #ffebee; color: #c62828; } /* Red */
        .status-Completed { background-color: #e8f5e9; color: #2e7d32; } /* Green */
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        
        <div class="page-header">
            <div>
                <h1>🎟 Show Schedule</h1>
                <span class="api-info">Connected to: <?php echo API_BASE_URL; ?>shows</span>
            </div>
            <a href="add_show.php" class="btn">+ Add Show</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Movie</th>
                    <th>Screen</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($show_list)): ?>
                    <?php foreach ($show_list as $show): ?>
                    <tr>
                        <td style="font-weight: bold; color: #888;">#<?php echo $show['show_id']; ?></td>
                        
                        <?php 
                            $dt_str = $show['start_datetime']; // e.g., "2025-12-25T18:00:00Z"
                            $timestamp = strtotime($dt_str);
                            $date_display = date("M d, Y", $timestamp); // Dec 25, 2025
                            $time_display = date("h:i A", $timestamp);  // 06:00 PM
                        ?>
                        <td><?php echo $date_display; ?></td>
                        <td style="font-weight: bold; color: #007bff;"><?php echo $time_display; ?></td>
                        
                        <td style="font-weight: 600;">
                            <?php echo $movies_map[$show['movie_id']] ?? $show['movie_id']; ?>
                        </td>
                        
                        <td>
                            <?php echo $screens_map[$show['screen_id']] ?? $show['screen_id']; ?>
                        </td>
                        
                        <td>$<?php echo number_format($show['base_price'], 2); ?></td>

                        <td>
                            <span class="status-badge status-<?php echo $show['status']; ?>">
                                <?php echo $show['status']; ?>
                            </span>
                        </td>

                        <td style="text-align: right;">
                            <a href="edit_show.php?id=<?php echo $show['show_id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_show.php?id=<?php echo $show['show_id']; ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Delete this show?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="8" style="text-align: center; padding: 40px; color: #888;">No shows found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
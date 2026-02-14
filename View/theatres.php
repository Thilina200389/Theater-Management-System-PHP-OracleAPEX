<?php
// View/theatres.php

// 1. INCLUDE CONTROLLER
include_once '../Controller/theatrecontroller.php';

// 2. FETCH DATA
$theater_list = getAllTheatres();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Management</title>
    <style>
        /* Keeping your existing styles */
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 25px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-header h1 { margin: 0; font-size: 24px; color: #2c3e50; }
        .api-info { font-size: 12px; color: #888; display: block; margin-top: 5px; }
        .btn { padding: 10px 18px; border-radius: 6px; text-decoration: none; color: white; background: #0066cc; display: inline-block; border: none; cursor: pointer; }
        .btn-edit { background: #e9ecef; color: #333; padding: 5px 10px; font-size: 12px; }
        .btn-delete { background: #fee2e2; color: #b91c1c; padding: 5px 10px; font-size: 12px; margin-left: 5px; }
        
        /* Table Styles */
        .styled-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .styled-table th { background: #f8f9fa; padding: 15px; text-align: left; color: #6c757d; border-bottom: 2px solid #e9ecef; }
        .styled-table td { padding: 15px; border-bottom: 1px solid #e9ecef; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        
        <div class="page-header">
            <div>
                <h1>🏛 Theater Locations</h1>
                <span class="api-info">Connected to: <?php echo API_BASE_URL; ?>theatres</span>
            </div>
            <a href="add_theatre.php" class="btn">+ Add Theater</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Theater Name</th>
                    <th>Location</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($theater_list)): ?>
                    <?php foreach ($theater_list as $theater): ?>
                    <tr>
                        <td style="font-weight: bold; color: #888;">
                            #<?php echo $theater['cinema_id']; ?>
                        </td>
                        
                        <td style="font-weight: 600; color: #333;">
                            <?php echo $theater['name']; ?>
                        </td>
                        
                        <td>
                            📍 <?php echo $theater['location']; ?>
                        </td>

                        <td style="text-align: right;">
                            <a href="edit_theatre.php?id=<?php echo $theater['cinema_id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_theatre.php?id=<?php echo $theater['cinema_id']; ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Delete <?php echo $theater['name']; ?>?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center; padding: 40px; color: #888;">
                        No theaters found. <br>
                        <small>Debug: Check if your APEX GET Handler query matches: <code>SELECT * FROM THEATRES</code></small>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
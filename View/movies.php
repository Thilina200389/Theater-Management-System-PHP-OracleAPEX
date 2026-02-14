<?php
// View/movies.php

// 1. Include the Controller (The Brain)
include_once '../Controller/moviecontroller.php';

// 2. Fetch Data using the Controller
$movie_list = getAllMovies();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Management</title>
    <style>
        /* 1. Global Styles & Reset */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9; /* Soft grey background for contrast */
            margin: 0;
            padding-top: 80px; /* Space for the fixed navbar */
            color: #333;
        }

        /* 2. The Container - Stops the table from touching the edges */
        .container {
            max-width: 1200px;
            margin: 0 auto; /* Centers the container */
            padding: 0 20px;
        }

        /* 3. The Card - The white box holding the content */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Subtle shadow */
            padding: 25px;
            overflow: hidden; /* Keeps rounded corners clean */
        }

        /* 4. Header Section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
        }

        .api-info {
            font-size: 12px;
            color: #888;
            margin-bottom: 15px;
            display: block;
        }

        /* 5. Modern Button Styles */
        .btn {
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add {
            background-color: #0066cc; /* Deep Blue */
            color: white;
            box-shadow: 0 2px 5px rgba(0, 102, 204, 0.3);
        }
        .btn-add:hover { background-color: #0052a3; transform: translateY(-1px); }

        .btn-edit { background-color: #e9ecef; color: #495057; padding: 6px 12px; }
        .btn-edit:hover { background-color: #dde2e6; color: #000; }

        .btn-delete { background-color: #fee2e2; color: #b91c1c; padding: 6px 12px; margin-left: 5px; }
        .btn-delete:hover { background-color: #fecaca; }

        /* 6. Advanced Table Styles */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .styled-table thead tr {
            background-color: #f8f9fa;
            text-align: left;
        }

        .styled-table th {
            padding: 15px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }

        .styled-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        /* Hover Effect for Rows */
        .styled-table tbody tr:hover {
            background-color: #f8f9ff;
        }

        /* Badge for Ratings */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            background-color: #e2e6ea;
            color: #444;
        }
        
        .description-cell {
            color: #666;
            max-width: 250px; /* Limits width so table doesn't break */
        }

        /* Responsive tweak */
        @media (max-width: 768px) {
            .styled-table thead { display: none; }
            .styled-table, .styled-table tbody, .styled-table tr, .styled-table td { display: block; width: 100%; }
            .styled-table tr { margin-bottom: 15px; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    
    <div class="card">
        
        <div class="page-header">
            <div>
                <h1>🎬 Movies Database</h1>
                <span class="api-info">Connected to: <?php echo API_BASE_URL; ?></span>
            </div>
            <a href="add_movie.php" class="btn btn-add">+ New Movie</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="15%">Title</th>
                    <th width="10%">Language</th>
                    <th width="10%">Duration</th>
                    <th width="10%">Genre</th>
                    <th width="10%">Rating</th>
                    <th width="25%">Description</th>
                    <th width="15%" style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($movie_list)): ?>
                    <?php foreach ($movie_list as $movie): ?>
                    <tr>
                        <td style="font-weight: bold; color: #888;">#<?php echo $movie['movie_id']; ?></td>
                        
                        <td style="font-weight: 600; color: #333;">
                            <?php echo $movie['title']; ?>
                        </td>
                        
                        <td><?php echo $movie['language']; ?></td>
                        
                        <td><?php echo $movie['duration']; ?> <span style="color:#999; font-size:11px;">min</span></td>
                        
                        <td><?php echo $movie['genre']; ?></td>
                        
                        <td><span class="badge"><?php echo $movie['rating']; ?></span></td>
                        
                        <td class="description-cell" title="<?php echo htmlspecialchars($movie['description']); ?>" style="cursor: help;">
                            <?php 
                                $desc = $movie['description'];
                                echo (strlen($desc) > 40) ? substr($desc, 0, 40) . "..." : $desc;
                            ?>
                        </td>

                        <td style="text-align: right;">
                            <a href="edit_movie.php?id=<?php echo $movie['movie_id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_movie.php?id=<?php echo $movie['movie_id']; ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Are you sure you want to delete <?php echo addslashes($movie['title']); ?>?');">
                               Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr><td colspan="8" style="text-align: center; padding: 40px; color: #888;">No movies found in the database.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div> 
</div> 

</body>
</html>
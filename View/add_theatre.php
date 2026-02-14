<?php
// View/add_theatre.php

// 1. INCLUDE CONTROLLER
include_once '../Controller/theatrecontroller.php';

// 2. HANDLE FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = addTheatre($_POST['name'], $_POST['location']);

    // Check Success (200 or 201)
    if ($result['http_code'] == 200 || $result['http_code'] == 201) {
        echo "<script>alert('Theater added successfully!'); window.location.href='theatres.php';</script>";
    } else {
        $error_msg = $result['message'] ?? 'Unknown Error';
        echo "<div style='color:red; padding:15px; background:white; border-bottom:2px solid red;'>";
        echo "<strong>Error:</strong> HTTP {$result['http_code']} <br> <strong>Response:</strong> $error_msg";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Theater</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        
        .card { 
            background-color: white; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); 
            padding: 40px; 
        }

        h2 { margin-top: 0; color: #2c3e50; text-align: center; margin-bottom: 30px; }

        label { display: block; margin-top: 20px; font-weight: 600; color: #555; margin-bottom: 8px; }
        
        input[type="text"] { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 15px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus { border-color: #007bff; outline: none; }

        .btn-submit { 
            width: 100%; margin-top: 30px; padding: 14px; 
            background-color: #0066cc; color: white; 
            border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; 
            transition: background 0.2s;
        }
        .btn-submit:hover { background-color: #0052a3; }

        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: #333; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="theatres.php" class="back-link">← Back to Theaters</a>
        <h2>Add New Theater</h2>

        <form method="POST" action="">
            
            <label>Theater Name</label>
            <input type="text" name="name" required placeholder="e.g. Savoy Cinema">

            <label>Location</label>
            <input type="text" name="location" required placeholder="e.g. Wellawatte, Colombo">

            <button type="submit" class="btn-submit">Save Theater</button>
        </form>
    </div>
</div>

</body>
</html>
<?php
// View/add_screen.php

// 1. Include the Controller
include_once '../Controller/screencontroller.php';

// 2. Fetch Theatres for the Dropdown
$theatre_list = getTheatresForDropdown();

// 3. HANDLE FORM SUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = addScreen(
        $_POST['name'],
        $_POST['capacity'],
        $_POST['cinema_id']
    );

    // Check Success
    if ($result['http_code'] == 200 || $result['http_code'] == 201) {
        echo "<script>alert('Screen added successfully!'); window.location.href='screens.php';</script>";
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
    <title>Add Screen</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        h2 { margin-top: 0; color: #2c3e50; text-align: center; margin-bottom: 30px; }
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; margin-bottom: 8px; }
        
        input[type="text"], input[type="number"], select { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; 
            box-sizing: border-box; font-size: 15px; background-color: white;
        }
        
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
        <a href="screens.php" class="back-link">← Back to Screens</a>
        <h2>Add New Screen</h2>

        <form method="POST" action="">
            
            <label>Select Theater</label>
            <select name="cinema_id" required>
                <option value="">-- Choose a Theater --</option>
                <?php foreach ($theatre_list as $theatre): ?>
                    <option value="<?php echo $theatre['cinema_id']; ?>">
                        <?php echo $theatre['name']; ?> (<?php echo $theatre['location']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Screen Name</label>
            <input type="text" name="name" required placeholder="e.g. Screen 1 (Dolby Atmos)">

            <label>Capacity (Seats)</label>
            <input type="number" name="capacity" required placeholder="e.g. 150">

            <button type="submit" class="btn-submit">Save Screen</button>
        </form>
    </div>
</div>

</body>
</html>
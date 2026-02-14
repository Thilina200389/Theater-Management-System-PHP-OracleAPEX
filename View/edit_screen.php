<?php
// View/edit_screen.php

// 1. Include the Controller
include_once '../Controller/screencontroller.php';

// 2. Validate ID
if (!isset($_GET['id'])) { die("Error: No Screen ID provided."); }
$screen_id = $_GET['id'];

// 3. FETCH DATA (Using Controller)
$screen = getScreenById($screen_id);
$theatre_list = getTheatresForDropdown();

// Pre-fill variables
if ($screen) {
    $name = $screen['name'];
    $capacity = $screen['capacity'];
    $current_cinema_id = $screen['cinema_id'];
} else {
    die("Error: Screen not found.");
}

// 4. HANDLE UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = updateScreen(
        $screen_id,
        $_POST['name'],
        $_POST['capacity'],
        $_POST['cinema_id']
    );

    // Check Success
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Screen updated successfully!'); window.location.href='screens.php';</script>";
    } else {
        $error_msg = $result['message'] ?? 'Unknown Error';
        echo "<script>alert('Error: $error_msg');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Screen</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; }
        input, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; margin-top: 8px; }
        
        button { width: 100%; margin-top: 30px; padding: 14px; background-color: #ffc107; color: #000; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
        button:hover { background-color: #e0a800; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="screens.php" class="back-link">← Back to Screens</a>
        <h2 style="text-align: center;">Edit Screen (ID: <?php echo $screen_id; ?>)</h2>

        <form method="POST" action="">
            
            <label>Select Theater</label>
            <select name="cinema_id" required>
                <option value="">-- Choose Theater --</option>
                <?php foreach ($theatre_list as $theatre): ?>
                    <option value="<?php echo $theatre['cinema_id']; ?>" 
                        <?php if($theatre['cinema_id'] == $current_cinema_id) echo 'selected'; ?>>
                        <?php echo $theatre['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Screen Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label>Capacity</label>
            <input type="number" name="capacity" value="<?php echo htmlspecialchars($capacity); ?>" required>

            <button type="submit">Update Screen</button>
        </form>
    </div>
</div>

</body>
</html>
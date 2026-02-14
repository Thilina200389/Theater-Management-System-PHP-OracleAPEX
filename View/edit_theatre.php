<?php
// View/edit_theatre.php

// 1. INCLUDE CONTROLLER
include_once '../Controller/theatrecontroller.php';

// 2. VALIDATE ID
if (!isset($_GET['id'])) {
    die("Error: No cinema ID provided.");
}
$cinema_id = $_GET['id'];

// 3. FETCH DATA (Using Controller)
$theatre = getTheatreById($cinema_id);

if ($theatre) {
    // Handle Case Sensitivity from Oracle (NAME vs name)
    $name = $theatre['name'] ?? $theatre['NAME'] ?? '';
    $location = $theatre['location'] ?? $theatre['LOCATION'] ?? '';
} else {
    die("Error: Theatre not found.");
}

// 4. HANDLE UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $result = updateTheatre(
        $cinema_id,
        $_POST['name'],
        $_POST['location']
    );

    // Check Success (200 or 204)
    if ($result['http_code'] == 200 || $result['http_code'] == 204) {
        echo "<script>alert('Theatre updated successfully!'); window.location.href='theatres.php';</script>";
    } else {
        $error_msg = $result['message'] ?? 'Unknown Error';
        echo "<div style='color:red; padding:10px; border:1px solid red; margin:10px;'>";
        echo "<strong>Update Failed.</strong> HTTP Code: {$result['http_code']}<br>Response: $error_msg";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Theatre</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding-top: 80px; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 0 20px; }
        .card { background-color: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); padding: 40px; }
        label { display: block; margin-top: 20px; font-weight: 600; color: #555; }
        input[type="text"] { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; margin-top: 8px; }
        button { width: 100%; margin-top: 30px; padding: 14px; background-color: #ffc107; color: #000; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
        button:hover { background-color: #e0a800; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card">
        <a href="theatres.php" class="back-link">← Back to List</a>
        <h2 style="text-align: center;">Edit Theatre (ID: <?php echo $cinema_id; ?>)</h2>

        <form method="POST" action="">
            <label>Theatre Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label>Location</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
            
            <button type="submit">Update Theatre</button>
        </form>
    </div>
</div>

</body>
</html>
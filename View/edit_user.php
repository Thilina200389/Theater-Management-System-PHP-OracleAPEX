<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// View/edit_user.php
include_once '../Controller/usercontroller.php';

if (!isset($_GET['id'])) { header("Location: users.php"); exit(); }

$id = $_GET['id'];
$user = getUserById($id); // Fetch existing data

// Check if API returned items array (common in APEX) or direct object
if (isset($user['items'][0])) {
    $user = $user['items'][0];
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];
    
    // Call the Update function we added to the controller
    updateUser($id, $username, $role, $email);
    
    header("Location: users.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; padding-top: 80px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-weight: 500; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn { padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-size: 16px; margin-right: 10px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-secondary { background: #e2e6ea; color: #333; text-decoration: none; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="card">
            <h2>Edit User #<?php echo $id; ?></h2>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="Customer" <?php if(($user['role']??'') == 'Customer') echo 'selected'; ?>>Customer</option>
                        <option value="Cashier" <?php if(($user['role']??'') == 'Cashier') echo 'selected'; ?>>Cashier</option>
                        <option value="Admin" <?php if(($user['role']??'') == 'Admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="users.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
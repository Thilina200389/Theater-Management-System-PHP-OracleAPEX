<?php
// View/add_user.php
include_once '../Controller/usercontroller.php';

$error = "";

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // In real app, hash this!
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    if (!empty($username) && !empty($password)) {
        $result = addUser($username, $password, $role, $email);
        
        // APEX usually returns 'status' => 'success' or an error message
        header("Location: users.php"); 
        exit();
    } else {
        $error = "Username and Password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f6f9; padding-top: 80px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { margin-top: 0; color: #333; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; font-weight: 500; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        
        .btn { padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-size: 16px; margin-right: 10px; }
        .btn-primary { background: #28a745; color: white; }
        .btn-secondary { background: #e2e6ea; color: #333; text-decoration: none; }
        .btn-primary:hover { background: #218838; }
        
        .error { color: red; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <div class="card">
            <h2>Add New User</h2>
            <?php if($error): ?><div class="error"><?php echo $error; ?></div><?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role">
                        <option value="Customer">Customer</option>
                        <option value="Cashier">Cashier</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Save User</button>
                <a href="users.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>
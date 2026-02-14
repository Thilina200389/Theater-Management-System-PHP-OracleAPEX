<?php
// login.php

// 1. INCLUDE CONTROLLER
include_once 'Controller/authcontroller.php';

// 2. CHECK IF ALREADY LOGGED IN
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php");
    exit();
}

// 3. HANDLE LOGIN FORM
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (loginUser($user, $pass)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | TMS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #2c3e50; /* Dark background */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        .login-card h2 { margin: 0 0 20px; color: #333; }
        .login-card p { color: #666; font-size: 14px; margin-bottom: 30px; }
        
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background-color: #0056b3; }
        
        .error-msg {
            color: #d9534f;
            background: #f9dede;
            padding: 10px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>🎭 TMS Admin</h2>
        <p>Please sign in to continue</p>

        <div class="error-msg"><?php echo $error; ?></div>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>

</body>
</html>
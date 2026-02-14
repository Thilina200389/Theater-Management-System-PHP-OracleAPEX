<?php
// View/users.php

// 1. Include the Controller (The Brain)
include_once '../Controller/usercontroller.php';
// Include Auth if you want to protect the page
// include_once '../Controller/authcontroller.php'; 

// 2. Fetch Data using the Controller
$userList = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        /* 1. Global Styles & Reset */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9; /* Soft grey background */
            margin: 0;
            padding-top: 80px; /* Space for navbar */
            color: #333;
        }

        /* 2. The Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* 3. The Card */
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            overflow: hidden;
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
            background-color: #28a745; /* Green for Users */
            color: white;
            box-shadow: 0 2px 5px rgba(40, 167, 69, 0.3);
        }
        .btn-add:hover { background-color: #218838; transform: translateY(-1px); }

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

        .styled-table tbody tr:hover {
            background-color: #f8f9ff;
        }

        /* 7. Role Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-admin { background-color: #e3f2fd; color: #1565c0; }   /* Blue */
        .badge-cashier { background-color: #fff3e0; color: #ef6c00; } /* Orange */
        .badge-customer { background-color: #e8f5e9; color: #2e7d32; } /* Green */

        /* Responsive */
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
                <h1>👥 User Management</h1>
                <span class="api-info">Managing users from APEX Database</span>
            </div>
            <a href="add_user.php" class="btn btn-add">+ Add User</a>
        </div>

        <table class="styled-table">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">Username</th>
                    <th width="30%">Email</th>
                    <th width="15%">Role</th>
                    <th width="20%">Created At</th>
                    <th width="10%" style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($userList)): ?>
                    <?php foreach ($userList as $user): ?>
                    <tr>
                        <td style="font-weight: bold; color: #888;">#<?php echo $user['user_id'] ?? $user['id']; ?></td>
                        
                        <td style="font-weight: 600; color: #333;">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </td>
                        
                        <td style="color: #555;">
                            <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?>
                        </td>
                        
                        <td>
                            <?php 
                                // Determine Badge Color
                                $role = $user['role'] ?? 'Customer';
                                $roleClass = 'badge-customer';
                                if(stripos($role, 'admin') !== false) $roleClass = 'badge-admin';
                                if(stripos($role, 'cashier') !== false) $roleClass = 'badge-cashier';
                            ?>
                            <span class="badge <?php echo $roleClass; ?>">
                                <?php echo htmlspecialchars($role); ?>
                            </span>
                        </td>
                        
                        <td style="font-size: 13px; color: #777;">
                           <?php echo isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : '-'; ?>
                        </td>

<td style="text-align: right; white-space: nowrap;">
    <a href="edit_user.php?id=<?php echo $user['user_id'] ?? $user['id']; ?>" class="btn btn-edit">Edit</a>
    
    <a href="delete_user.php?id=<?php echo $user['user_id'] ?? $user['id']; ?>" 
       class="btn btn-delete" 
       onclick="return confirm('Are you sure you want to delete this user?');">
       Delete
    </a>
</td>
                    </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #888;">
                            No users found. (Check your API connection)
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div> 
</div> 

</body>
</html>
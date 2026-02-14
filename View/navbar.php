<?php
// View/navbar.php

// 1. Get current filename (movies.php, index.php, etc.)
$current_page = basename($_SERVER['PHP_SELF']);

// 2. DETECT FOLDER LOCATION
// Check if the script is running inside the "View" folder
$in_view_folder = (basename(dirname($_SERVER['PHP_SELF'])) == 'View');

// 3. SET PATHS BASED ON LOCATION
if ($in_view_folder) {
    // We are inside View/, so go UP for home, stay here for modules
    $home_link = "../index.php"; 
    $module_path = ""; // e.g., "movies.php"
} else {
    // We are at Root (index.php), so stay here for home, go DOWN for modules
    $home_link = "index.php";
    $module_path = "View/"; // e.g., "View/movies.php"
}
?>

<style>
    /* NAVBAR STYLES (Unchanged) */
    body { padding-top: 70px; }
    .navbar {
        background-color: #2c3e50; height: 60px; width: 100%; position: fixed; top: 0; left: 0;
        z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1); display: flex; align-items: center;
        justify-content: space-between; padding: 0 20px; box-sizing: border-box;
    }
    .navbar-brand { color: white; font-size: 20px; font-weight: bold; text-decoration: none; letter-spacing: 1px; display: flex; align-items: center; }
    .navbar-links { display: flex; gap: 5px; }
    .navbar a.nav-link { color: #b0bccf; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 15px; transition: all 0.3s ease; }
    .navbar a.nav-link:hover { background-color: #34495e; color: white; }
    .navbar a.nav-link.active { background-color: #007bff; color: white; font-weight: 500; }
    .navbar-user { color: white; font-size: 14px; font-weight: 500; display: flex; align-items: center; }
    .user-avatar { width: 30px; height: 30px; background-color: #007bff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 14px; }
</style>

<nav class="navbar">
    <a href="<?php echo $home_link; ?>" class="navbar-brand">
        TMS
    </a>

    <div class="navbar-links">
        <a href="<?php echo $home_link; ?>" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
            Dashboard
        </a>

        <a href="<?php echo $module_path; ?>movies.php" class="nav-link <?php echo ($current_page == 'movies.php') ? 'active' : ''; ?>">
            Movies
        </a>
        
        <a href="<?php echo $module_path; ?>theatres.php" class="nav-link <?php echo ($current_page == 'theatres.php') ? 'active' : ''; ?>">
            Theaters
        </a>
        
        <a href="<?php echo $module_path; ?>screens.php" class="nav-link <?php echo ($current_page == 'screens.php') ? 'active' : ''; ?>">
            Screens
        </a>
        
        <a href="<?php echo $module_path; ?>shows.php" class="nav-link <?php echo ($current_page == 'shows.php') ? 'active' : ''; ?>">
            Shows
        </a>

        <a href="<?php echo $module_path; ?>bookings.php" class="nav-link <?php echo ($current_page == 'bookings.php') ? 'active' : ''; ?>">
            Bookings
        </a>
    </div>

    <div class="navbar-user">
    <div class="user-avatar">AD</div>
    <span style="margin-right: 15px;">Admin</span>
    
    <a href="<?php echo $in_view_folder ? '../logout.php' : 'logout.php'; ?>" 
       style="color: #ff6b6b; text-decoration: none; font-size: 13px; border: 1px solid #ff6b6b; padding: 5px 10px; border-radius: 4px;">
       Logout
    </a>
    </div>
</nav>
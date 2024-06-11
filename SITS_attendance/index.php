<?php

session_start();

	include("conn.php");
	include("function.php");
    include ('functions.php');

$user_data = check_login($conn);

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
    <title>Attendance System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Bodoni MT', serif;
        }
        .sidebar {
            position: fixed;
            height: 100%;
            width: 240px;
            background: #1A4D2E;
            transition: all 0.5s ease;
        }
        .sidebar.active {
            width: 60px;
        }
        .sidebar .logo-details {
            height: 80px;
            display: flex;
            align-items: center;
        }
        .sidebar .logo-details i {
            font-size: 28px;
            font-weight: 500;
            color: #fff;
            min-width: 60px;
            text-align: center;
        }
        .sidebar .logo-details .logo_name {
            color: #fff;
            font-size: 24px;
            font-weight: 500;
        }
        .sidebar .nav-links {
            margin-top: 200px;
        }
        .sidebar .nav-links li {
            position: relative;
            list-style: none;
            height: 50px;
            padding: 10px;
        }
        .sidebar .nav-links li a {
            height: 100%;
            /* padding:10px; */
            width: 100%;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.4s ease;
        }
        .sidebar .nav-links li a.active {
            background: #4F6F52;
        }
        .sidebar .nav-links li a:hover {
            background: #15a02e;
        }
        .sidebar .nav-links li i {
            min-width: 60px;
            text-align: center;
            font-size: 25px;
            color: white;
            /* padding-top: 10px; */
        }
        .sidebar .nav-links li a .links_name {
            color: #f8f8ff;
            font-size: 17px;
            font-weight: 400;
            white-space: nowrap;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .sidebar .nav-links .log_out {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .home-section {
            position: relative;
            background: #f5f5f5;
            min-height: 100vh;
            width: calc(100% - 240px);
            left: 240px;
            transition: all 0.5s ease;
        }
        .sidebar.active ~ .home-section {
            width: calc(100% - 60px);
            left: 60px;
        }
        .home-section nav {
            display: flex;
            justify-content: space-between;
            height: 90px;
            background: #1A4D2E;
            align-items: center;
            position: fixed;
            width: calc(100% - 240px);
            left: 240px;
            z-index: 100;
            padding: 0 40px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }
        .sidebar.active ~ .home-section nav {
            left: 60px;
            width: calc(100% - 60px);
        }
        .home-section nav .sidebar-button {
            display: flex;
            align-items: center;
            font-size: 40px;
            font-weight: 500;
        }
        nav .sidebar-button i {
            font-size: 40px;
            margin-right: 10px;
            color: #fff; /* Change the color of the dashboard icon to white */
        }
        nav .sidebar-button .dashboard {
            color: #fff; /* Change the color of the dashboard text to white */
        }
        .home-section nav .search-box {
            position: relative;
            height: 50px;
            max-width: 550px;
            width: 100%;
            margin: 0 20px;
        }
        nav .search-box input {
            height: 95%;
            width: 100%;
            outline: none;
            margin-top: 10px;
            background: #F5F6FA;
            border: 2px solid hsl(260, 10%, 94%);
            border-radius: 6px;
            font-size: 18px;
            /* padding: 0 10px; */
        }
        nav .search-box .bx-search {
            position: absolute;
            margin-top: 10px;
            height: 40px;
            width: 40px;
            background: green;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 4px;
            line-height: 40px;
            text-align: center;
            color: #fff;
            font-size: 22px;
            transition: all 0.4s ease;
        }
        .home-section nav .profile-details {
            display: flex;
            align-items: center;
            background: #F5F6FA;
            border: 2px solid #EFEEF1;
            border-radius: 6px;
            height: 50px;
            min-width: 190px;
            padding: 0 15px 0 2px;
        }
        nav .profile-details img {
            height: 40px;
            width: 40px;
            border-radius: 6px;
            object-fit: cover;
        }
        nav .profile-details .admin_name {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin: 0 10px;
            white-space: nowrap;
        }
        nav .profile-details i {
            font-size: 25px;
            color: #333;
        }
        .home-section .home-content {
            position: relative;
            padding-top: 104px;
        }
        .home-content .overview-boxes {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 0 20px;
            margin-bottom: 26px;
        }
        .overview-boxes .box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: calc(100% / 4 - 15px);
            background: #fff;
            padding: 15px 14px;
            border-radius: 12px;
            box-shadow: 0 5px 10px #15a02e;
        }
        .overview-boxes .box-topic {
            font-size: 20px;
            font-weight: 500;
        }
        .home-content .box .number {
            display: inline-block;
            font-size: 35px;
            margin-top: -6px;
            font-weight: 500;
        }
        .home-content .box .indicator {
            display: flex;
            align-items: center;
        }
        .home-content .box .indicator i {
            height: 20px;
            width: 20px;
            background: #8FDACB;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            color: #fff;
            font-size: 20px;
            margin-right: 5px;
        }
        .box .indicator i.down {
            background: #e87d88;
        }
        .home-content .box .indicator .text {
            font-size: 12px;
        }
        @media (max-width: 1240px) {
            .sidebar {
                width: 60px;
            }
            .sidebar.active {
                width: 220px;
            }
            .home-section {
                width: calc(100% - 60px);
                left: 60px;
            }
            .sidebar.active ~ .home-section {
                left: 220px;
                width: calc(100% - 220px);
                overflow: hidden;
            }
            .home-section nav {
                width: calc(100% - 60px);
                left: 60px;
            }
            .sidebar.active ~ .home-section nav {
                width: calc(100% - 220px);
                left: 220px;
            }
        }
        @media (max-width: 1000px) {
            .overview-boxes .box {
                width: calc(100% / 2 - 15px);
                margin-bottom: 15px;
            }
        }
        @media (max-width: 700px) {
            nav .sidebar-button .dashboard,
            nav .profile-details .admin_name,
            nav .profile-details i {
                display: none;
            }
            .home-section nav .profile-details {
                height: 50px;
                min-width: 40px;
            }
        }
        @media (max-width: 550px) {
            .overview-boxes .box {
                width: 100%;
                margin-bottom: 15px;
            }
            .sidebar.active ~ .home-section nav .profile-details {
                display: none;
            }
        }
        @media (max-width: 400px) {
            .sidebar {
                width: 0;
            }
            .sidebar.active {
                width: 60px;
            }
            .home-section {
                width: 100%;
                left: 0;
            }
            .sidebar.active ~ .home-section {
                left: 60px;
                width: calc(100% - 60px);
            }
            .home-section nav {
                width: 100%;
                left: 0;
            }
            .sidebar.active ~ .home-section nav {
                left: 60px;
                width: calc(100% - 60px);
            }
        }
        img {
            width: 50px;
            margin-left: 10px;
            margin-right: 5px;
        }
        .logos {
            width: 250px;
            height: 120px;
            margin-top: 50px;
            margin-right: 1px;
        }
        
      
    </style>
</head>
<body>
<div class="sidebar">

    <ul class="nav-links">
        <li>
            <a href="?page=dashboard" class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                <i class="bx bx-grid-alt"></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=students" class="<?php echo ($page == 'students') ? 'active' : ''; ?>">
                <i class="bx bx-user"></i>
                <span class="links_name">Students</span>
            </a>
        </li>
        <li>
            <a href="?page=attendance" class="<?php echo ($page == 'attendance') ? 'active' : ''; ?>">
                <i class="bx bx-calendar-check"></i>
                <span class="links_name">Take Attendance</span>
            </a>
        </li>
        <br>
        <div class="logo-details">
            <img class="logos" src="SITS.PNG" alt="Logo">
            <!-- <span class="logo_name">SIT'S</span> -->
        </div>

        <br>
        <br>
        <br>
        <li>
            <a href="?page=reports" class="<?php echo ($page == 'reports') ? 'active' : ''; ?>">
                <i class="bx bx-bar-chart-alt-2"></i>
                <span class="links_name">Reports</span>
            </a>
        </li>
        <li>
            <a href="logout.php" class="<?php echo ($page == 'logout') ? 'active' : ''; ?>">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Logout</span>
            </a>
        </li>

    </ul>
</div>
<div class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class="bx bx-menu"></i>
            <span class="dashboard">
                <?php
                switch($page){
                    case 'dashboard':
                        echo 'Dashboard';
                        break;
                    case 'students':
                        echo 'Students';
                        break;
                    case 'attendance':
                        echo 'Attendance';
                        break;
                    case 'reports':
                        echo 'Reports';
                        break;
                    default:
                        echo 'Dashboard';
                        break;
                }
                ?>
            </span>
        </div>
        <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
            <button class="bx bx-search"></button>
        </div>
        <div class="profile-details">
            <?php
            $username = $user_data['user_name'];
            $profile_picture = ($username === 'nisa') ? 'nisa.jpg' : 'avatar.jpg';
            ?>
            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture">
            <span class="admin_name"><?php echo $username; ?></span>
            <i class="bx bx-chevron-down"></i>
        </div>

    </nav>
    
    <div class="home-content"></div>
    <div class="contentToSearch">
        <?php
        switch($page){
            case 'dashboard':
                echo "<h2><center>Welcome to the SIT's Attendance</center></h2>";
                break;
            case 'students':
                include 'students.php';
                break;
            case 'attendance':
                include 'attendance.php';
                break;
            case 'reports':
                echo "<h2><center>Attendance Report</center></h2>";
                echo "<div class='report-container'>";
                generateReport(); 
                echo "</div>";
                break;
            default:
                echo "<h2><center>Welcome to the SIT's Attendance</center></h2>";
                break;
        }
        ?>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.querySelector(".sidebar");
        const sidebarBtn = document.querySelector(".sidebar-button");
        const homeSection = document.querySelector(".home-section");

        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            homeSection.classList.toggle("active");
        });
    });
    // Function to filter content based on user input
    function searchTable() {
    // Declare variables
    var input, filter, contentToSearch, divs, spans, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    contentToSearch = document.querySelector(".contentToSearch");
    divs = contentToSearch.getElementsByTagName('div');

    // Loop through all divs, and hide those that don't match the search query
    for (i = 0; i < divs.length; i++) {
        spans = divs[i].getElementsByTagName("span"); // Get all <span> elements within each div
        txtValue = ""; // Reset txtValue for each div

        // Concatenate text content of all <span> elements within the div
        for (var j = 0; j < spans.length; j++) {
            txtValue += spans[j].textContent || spans[j].innerText;
        }

        // Check if the concatenated text content matches the search query
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            divs[i].style.display = ""; // Show the div if there's a match
        } else {
            divs[i].style.display = "none"; // Hide the div if there's no match
        }
    }
}

</script>
</body>
</html>

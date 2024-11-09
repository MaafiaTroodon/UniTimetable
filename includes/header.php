<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (header.php)
*/

// Start the session only if it’s not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dalhousie Timetable</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/styles.css">
</head>

<body class="bg-light-grey">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Logo with alt text for accessibility -->
                <a class="navbar-brand" href="index.php">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHV0yTI5pWCUHLmQNLX3KdArcOxWUPBArzfg&s"
                        alt="Dalhousie University Logo" height="40">
                </a>
                
                <!-- Navbar toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Links visible when the user is logged in -->
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="index.php">Course Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="logout.php">Logout</a>
                            </li>
                        <?php else: ?>
                            <!-- Link visible when the user is not logged in -->
                            <li class="nav-item">
                                <a class="nav-link text-dark btn btn-brand" href="login.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
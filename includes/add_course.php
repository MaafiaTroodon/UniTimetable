<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (add_course.php)
*/

require_once 'db.php';
session_start();

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in to add a course to your schedule.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize course code
    $course_code = filter_var($_POST['course_code'] ?? '', FILTER_SANITIZE_STRING);

    if (empty($course_code)) {
        echo json_encode(['success' => false, 'error' => 'Course code is required.']);
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Ensure the database connection is active
    if ($mysqli->connect_error) {
        error_log("Database connection error: " . $mysqli->connect_error);
        echo json_encode(['success' => false, 'error' => 'Database connection error. Please try again later.']);
        exit();
    }

    // Check if the course exists
    $stmt = $mysqli->prepare("SELECT id FROM courses WHERE course_code = ?");
    if (!$stmt) {
        error_log("Database error: " . $mysqli->error); // Log error for debugging
        echo json_encode(['success' => false, 'error' => 'An unexpected error occurred.']);
        exit();
    }
    $stmt->bind_param("s", $course_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Course does not exist.']);
        $stmt->close();
        exit();
    }
    $stmt->bind_result($course_id);
    $stmt->fetch();
    $stmt->close();

    // Check if the course is already in the user's schedule
    $stmt = $mysqli->prepare("SELECT id FROM schedule WHERE user_id = ? AND course_id = ?");
    if (!$stmt) {
        error_log("Database error: " . $mysqli->error);
        echo json_encode(['success' => false, 'error' => 'An unexpected error occurred.']);
        exit();
    }
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'Course is already in your schedule.']);
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Add course to user's schedule
    $stmt = $mysqli->prepare("INSERT INTO schedule (user_id, course_id) VALUES (?, ?)");
    if (!$stmt) {
        error_log("Database error: " . $mysqli->error);
        echo json_encode(['success' => false, 'error' => 'An unexpected error occurred.']);
        exit();
    }
    $stmt->bind_param("ii", $user_id, $course_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Course successfully added to your schedule.']);
    } else {
        error_log("Failed to add course to schedule for user_id {$user_id} and course_id {$course_id}");
        echo json_encode(['success' => false, 'error' => 'Failed to add course to schedule. Please try again later.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
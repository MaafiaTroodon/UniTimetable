<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (drop_course.php)
*/

require_once 'db.php';
session_start();

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You must be logged in to drop a course.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$schedule_id = filter_var($_POST['schedule_id'] ?? '', FILTER_VALIDATE_INT);

// Validate the schedule ID
if ($schedule_id === false) {
    echo json_encode(['success' => false, 'error' => 'Invalid or missing Schedule ID.']);
    exit();
}

// Ensure the database connection is active
if ($mysqli->connect_error) {
    error_log("Database connection error: " . $mysqli->connect_error);
    echo json_encode(['success' => false, 'error' => 'Database connection error. Please try again later.']);
    exit();
}

// Prepare the SQL statement to delete the course from the user's schedule
$stmt = $mysqli->prepare("DELETE FROM schedule WHERE id = ? AND user_id = ?");
if (!$stmt) {
    error_log("Database error: " . $mysqli->error); // Log database error for debugging
    echo json_encode(['success' => false, 'error' => 'Database error. Please try again later.']);
    exit();
}

$stmt->bind_param("ii", $schedule_id, $user_id);

// Execute the deletion and return a response to the user
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Course successfully dropped from your schedule.']);
} else {
    error_log("Error dropping course for user {$user_id} with schedule_id {$schedule_id}: " . $stmt->error);
    echo json_encode(['success' => false, 'error' => 'Failed to drop course from schedule. Please try again.']);
}

$stmt->close();
?>
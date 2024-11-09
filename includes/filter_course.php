<?php
header('Content-Type: application/json');
require_once 'db.php'; // Database connection

// Retrieve and decode JSON input data
$data = json_decode(file_get_contents("php://input"), true);
$searchTerm = isset($data['searchTerm']) ? $data['searchTerm'] : '';
$days = isset($data['days']) ? $data['days'] : [];

// Base SQL query to fetch courses with optional filters
$sql = "SELECT DISTINCT course_code, course_name, instructor, schedule FROM courses WHERE 1=1";

// Append search term condition to SQL if provided
if (!empty($searchTerm)) {
    $sql .= " AND course_code LIKE ?";
    $searchTerm = "%{$searchTerm}%"; // Wildcard search for course_code
}

// Append day filtering to SQL if specific days are selected
if (!empty($days)) {
    $dayConditions = [];
    foreach ($days as $day) {
        $dayConditions[] = "schedule LIKE ?";
    }
    $sql .= " AND (" . implode(" OR ", $dayConditions) . ")";
}

// Prepare the SQL statement
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "SQL Error: " . $mysqli->error]);
    exit;
}

// Set up dynamic binding of parameters
$types = "";
$params = [];

if (!empty($searchTerm)) {
    $types .= "s";
    $params[] = $searchTerm;
}

foreach ($days as $day) {
    $types .= "s";
    $params[] = "%$day%"; // Wildcard search for each selected day
}

// Bind parameters if necessary
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}

// Execute the query and handle any errors
if (!$stmt->execute()) {
    echo json_encode(["error" => "Execution Error: " . $stmt->error]);
    exit;
}

// Fetch results
$result = $stmt->get_result();
if (!$result) {
    echo json_encode(["error" => "Result Error: " . $stmt->error]);
    exit;
}

// Convert results to associative array
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Return courses in JSON format, or a message if no results found
if (empty($courses)) {
    echo json_encode(["message" => "No courses found matching the criteria."]);
} else {
    echo json_encode($courses);
}
?>
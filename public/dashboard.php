<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (dashboard.php)
*/

session_start();
require_once '../includes/db.php'; // Ensure db.php is included to connect to the database

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header
include('../includes/header.php');

// Retrieve last login time from cookie
$last_login_time = isset($_COOKIE['last_login_time']) ? $_COOKIE['last_login_time'] : 'First time login';
$user_id = $_SESSION['user_id'];


// Fetch the user's schedule from the `schedule` table
$schedule = [];
$stmt = $mysqli->prepare("
    SELECT s.id AS schedule_id, c.course_code, c.course_name, c.instructor, c.schedule 
    FROM schedule s 
    JOIN courses c ON s.course_id = c.id 
    WHERE s.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $schedule[] = $row;
}

$stmt->close();
?>

<div id="threejs-background"></div> <!-- Three.js background container -->
<main class="container">
    <h2 class="text-center text-primary">Welcome to Your Dashboard</h2>
    <div class="text-center mt-3">
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        <p>Last Login Time: <strong><?php echo htmlspecialchars($last_login_time); ?></strong></p>
        <p>You can manage your course schedule here.</p>
    </div>

    <h3 class="mt-5">My Schedule</h3>
    <?php if (count($schedule) > 0): ?>
        <div class="translucent-container"> <!-- New wrapper div with translucent background -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Instructor</th>
                            <th>Schedule</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schedule as $course): ?>
                            <tr id="course-row-<?php echo $course['schedule_id']; ?>">
                                <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                                <td><?php echo htmlspecialchars($course['instructor']); ?></td>
                                <td><?php echo htmlspecialchars($course['schedule']); ?></td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="dropCourse(<?php echo $course['schedule_id']; ?>)">Drop</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <p>You have not added any courses to your schedule yet.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</main>

<div id="notification" class="notification"></div>

<script>
function showNotification(message, type = 'success') {
    const notification = document.getElementById('notification');
    notification.innerText = message;
    notification.className = 'notification show ' + (type === 'error' ? 'error' : 'success');

    // Show the notification
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000); // Hide after 3 seconds
}

function dropCourse(scheduleId) {
    fetch('../includes/drop_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'schedule_id=' + encodeURIComponent(scheduleId)
    })
    .then(response => response.text())
    .then(text => {
        try {
            const data = JSON.parse(text);
            if (data.success) {
                showNotification(data.message, 'success'); // Show success notification
                document.getElementById(`course-row-${scheduleId}`).remove(); // Remove the course row if needed
            } else {
                showNotification(data.error, 'error'); // Show error notification
            }
        } catch (error) {
            console.error('JSON parsing error:', error);
            showNotification('Unexpected response format. Check the console for details.', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showNotification('An error occurred. Please check the console for details.', 'error');
    });
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Three.js scene
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('threejs-background').appendChild(renderer.domElement);

    // Create a Torus Geometry
    const geometry = new THREE.TorusGeometry(10, 3, 16, 100);
    const material = new THREE.MeshBasicMaterial({ color: 0xffcb00, wireframe: true });
    const torus = new THREE.Mesh(geometry, material);
    scene.add(torus);

    camera.position.z = 50;

    // Position the torus to appear behind the table
    torus.position.z = -20;

    // Animation loop
    function animate() {
        requestAnimationFrame(animate);
        torus.rotation.x += 0.01;
        torus.rotation.y += 0.01;
        renderer.render(scene, camera);
    }
    animate();

    // Handle window resize
    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });
});
</script>

<?php
// Include footer
include('../includes/footer.php');
?>

<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (dashboard.php)
*/

session_start();
require_once '../includes/db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include header
include('../includes/header.php');

// Last login time from cookie
$last_login_time = $_COOKIE['last_login_time'] ?? 'First time login';
$user_id = $_SESSION['user_id'];

// Fetch user's schedule
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
        <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></strong>!</p>
        <p>Last Login Time: <strong><?php echo htmlspecialchars($last_login_time); ?></strong></p>
        <p>Manage your course schedule below.</p>
    </div>
    <?php if (count($schedule) > 0 && isset($_SESSION['user_id'])): ?>
    <div class="filter-container mb-4">
        <button id="filter-toggle" class="btn btn-brand">Toggle Filter</button>
        <div id="filter-options" class="d-none mt-3">
            <input type="text" id="search-bar" placeholder="Search by course code..." class="form-control mb-2">
            <div class="form-check">
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-sun" value="Sun"> Sun</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-mon" value="Mon"> Mon</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-tue" value="Tue"> Tue</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-wed" value="Wed"> Wed</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-thu" value="Thu"> Thu</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-fri" value="Fri"> Fri</label><br>
                <label class="form-check-label"><input class="form-check-input day-checkbox" type="checkbox" id="filter-sat" value="Sat"> Sat</label>
            </div>
        </div>
    </div>
<?php endif; ?>
    <h3 class="mt-5">My Schedule</h3>
    <?php if (count($schedule) > 0): ?>
        <div class="translucent-container">
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
                                <button class="button-animate" onclick="dropCourse(<?php echo $course['schedule_id']; ?>)">Drop</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <p id="no-results-message" style="display: none; color: red; text-align: center;">
    No courses found matching your criteria. Try removing some filters or search terms.
</p>
    <?php else: ?>
        <p>No courses in your schedule yet.</p>
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

    // Auto-hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

function dropCourse(scheduleId) {
    fetch('../includes/drop_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'schedule_id=' + encodeURIComponent(scheduleId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            document.getElementById(`course-row-${scheduleId}`).remove();

            // Check if there are remaining rows
            const rows = document.querySelectorAll("tbody tr");
            if (rows.length === 0) {
                // Hide the filter container
                document.querySelector('.filter-container').style.display = 'none';

                // Display the "No courses in your schedule yet." message
                document.querySelector('.translucent-container').style.display = 'none';
                document.getElementById('no-results-message').style.display = 'none';

                const noCoursesMessage = document.createElement('p');
                noCoursesMessage.textContent = 'No courses in your schedule yet.';
                noCoursesMessage.className = 'text-warning';
                document.querySelector('main.container').appendChild(noCoursesMessage);
            }
        } else {
            showNotification(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred, please try again.', 'error');
    });
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('threejs-background').appendChild(renderer.domElement);

    const geometry = new THREE.TorusGeometry(10, 3, 16, 100);
    const material = new THREE.MeshBasicMaterial({ color: 0xffcb00, wireframe: true });
    const torus = new THREE.Mesh(geometry, material);
    scene.add(torus);
    camera.position.z = 50;
    torus.position.z = -20;

    function animate() {
        requestAnimationFrame(animate);
        torus.rotation.x += 0.01;
        torus.rotation.y += 0.01;
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const filterToggle = document.getElementById("filter-toggle");
    const filterOptions = document.getElementById("filter-options");

    // Toggle filter options visibility on button click
    filterToggle.addEventListener("click", function () {
        filterOptions.classList.toggle("d-none");
    });
});



document.addEventListener("DOMContentLoaded", function () {
    applyFilters(); // Apply filters once on page load
    document.getElementById("search-bar").addEventListener("input", applyFilters);
    document.querySelectorAll(".day-checkbox").forEach(checkbox => {
        checkbox.addEventListener("change", applyFilters);
    });
});

function applyFilters() {
    const searchTerm = document.getElementById("search-bar").value.toLowerCase();
    const days = Array.from(document.querySelectorAll(".day-checkbox:checked")).map(checkbox => checkbox.value);

    // Pass the filter criteria to the updateTable function
    updateTable(searchTerm, days);
}

function updateTable(searchTerm, days) {
    const rows = document.querySelectorAll("tbody tr");
    let anyMatch = false; // Track if there's any match
    const noResultsMessage = document.getElementById("no-results-message"); // Reference to the message paragraph

    rows.forEach(row => {
        const courseCode = row.querySelector("td:nth-child(1)").textContent.toLowerCase();
        const schedule = row.querySelector("td:nth-child(4)").textContent;
        const matchesSearch = courseCode.includes(searchTerm);
        const matchesDay = days.length === 0 || days.some(day => schedule.includes(day));

        // Show or hide the row based on filters
        if (matchesSearch && matchesDay) {
            row.style.display = "";
            anyMatch = true; // Found at least one match
        } else {
            row.style.display = "none";
        }
    });

    // Show or hide the "No courses found" message
    noResultsMessage.style.display = anyMatch ? "none" : "block";
}
</script>

<?php include('../includes/footer.php'); ?>
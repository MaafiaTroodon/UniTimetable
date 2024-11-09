<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (index.php)
*/

session_start();
$loggedIn = isset($_SESSION['user_id']);
include('../includes/header.php');
?>
<div id="notification" class="notification"></div>
<div id="threejs-background"></div> <!-- Background for Three.js Knot -->
<main class="container">
    <h1 class="mb-4 text-warning">Available Courses</h1>
    
    <!-- Filter Button and Options Container -->
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

    <!-- Course Table -->
    <div class="table-responsive">
        <table class="table custom-table table-hover">
            <thead class="bg-dark">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                    <th>Schedule</th>
                    <th>Add to Schedule</th>
                </tr>
            </thead>
            <tbody id="course-table">
                <?php
                $json_data = file_get_contents('../files/timetable.json');
                if ($json_data === false) {
                    echo "<tr><td colspan='5'>Error: Unable to load timetable data. Please try again later.</td></tr>";
                } else {
                    $courses = json_decode($json_data, true);
                    if (is_array($courses)) {
                        foreach ($courses as $course) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($course['course_code'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['name'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['instructor'] ?? 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($course['schedule'] ?? 'N/A') . "</td>";
                            echo "<td>";
                            echo '<button class="button-animate" onclick="handleAddToSchedule(\'' . htmlspecialchars($course['course_code']) . '\')">Add to Schedule</button>';
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Error: Timetable data is not in a valid format. Contact support.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Link to response.js and other necessary scripts -->
<script src="../assets/responsive.js"></script> <!-- Assuming response.js is in ../assets/ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
// Three.js knot setup
document.addEventListener("DOMContentLoaded", function () {
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.getElementById('threejs-background').appendChild(renderer.domElement);

    const geometry = new THREE.TorusKnotGeometry(10, 3, 100, 16);
    const material = new THREE.MeshBasicMaterial({ color: 0xffcb00, wireframe: true });
    const torusKnot = new THREE.Mesh(geometry, material);
    scene.add(torusKnot);

    camera.position.z = 50;

    function animate() {
        requestAnimationFrame(animate);
        torusKnot.rotation.x += 0.01;
        torusKnot.rotation.y += 0.01;
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('scroll', () => {
        const scrollY = window.scrollY;
        const scaleFactor = 1 + scrollY / 500;
        torusKnot.scale.set(scaleFactor, scaleFactor, scaleFactor);
    });

    window.addEventListener('resize', () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
    });
});

// JavaScript function for the toggle button
document.addEventListener("DOMContentLoaded", function () {
    const filterToggle = document.getElementById("filter-toggle");
    const filterOptions = document.getElementById("filter-options");

    // Toggle filter options visibility on button click
    filterToggle.addEventListener("click", function () {
        filterOptions.classList.toggle("d-none");
    });
});
function handleAddToSchedule(courseCode) {
    const isLoggedIn = <?php echo json_encode($loggedIn); ?>;
    
    if (isLoggedIn) {
        addToSchedule(courseCode);
    } else {
        showNotification('Please log in to add courses to your schedule.', 'error');
    }
}

function addToSchedule(courseCode) {
    const button = document.querySelector(`button[onclick="handleAddToSchedule('${courseCode}')"]`);

    fetch('../includes/add_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'course_code=' + encodeURIComponent(courseCode)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            button.classList.add("animate"); // Trigger animation

            // Remove the 'animate' class after 600ms to reset the animation
            setTimeout(() => {
                button.classList.remove("animate");
            }, 600);
        } else {
            showNotification(data.error, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding the course. Please try again.', 'error');
    });
}

function applyFilters() {
    const searchTerm = document.getElementById("search-bar").value;
    const days = Array.from(document.querySelectorAll(".day-checkbox:checked")).map(checkbox => checkbox.value);

    fetch('../includes/filter_course.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ searchTerm, days })
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
    })
    .then(courses => {
        updateCourseTable(courses);
    })
    .catch(error => {
        console.error('Error:', error);
        updateCourseTable([], 'Error fetching filtered courses. Please try again later.');
    });
}

function updateCourseTable(courses, errorMessage = "") {
    const courseTable = document.getElementById("course-table");
    courseTable.innerHTML = ""; // Clear existing courses

    if (errorMessage) {
        courseTable.innerHTML = `<tr><td colspan='5'>${errorMessage}</td></tr>`;
        return;
    }

    if (courses.length > 0) {
        courses.forEach(course => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${course.course_code}</td>
                <td>${course.course_name}</td>
                <td>${course.instructor}</td>
                <td>${course.schedule}</td>
                <td><button class="btn btn-primary" onclick="addToSchedule('${course.course_code}')">Add to Schedule</button></td>
            `;
            courseTable.appendChild(row);
        });
    } else {
        courseTable.innerHTML = "<tr><td colspan='5'>No courses found matching your criteria.</td></tr>";
    }
}

// Trigger filtering in real-time when user types or changes filter options
document.getElementById("search-bar").addEventListener("input", applyFilters);
document.querySelectorAll(".day-checkbox").forEach(checkbox => {
    checkbox.addEventListener("change", applyFilters);
});

function fetchAndRefreshTimetable() {
    fetch('../files/timetable.json')
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.json();
        })
        .then(courses => {
            updateCourseTable(courses); // Call the existing update function to refresh table data
        })
        .catch(error => {
            console.error('Error fetching timetable data:', error);
        });
}

// Set up a 30-second interval to refresh the timetable
setInterval(fetchAndRefreshTimetable, 30000);
</script>

<?php
include('../includes/footer.php');
?>
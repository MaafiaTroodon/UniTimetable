# Assignment 4 - Dalhousie University Timetable Rebuild

## Student Information

- **Name**: Malhar Datta Mahajan
- **Student ID**: B00934337
- **Date Created**: 1 November 2024

## Overview

This assignment involved building a web application to manage the Dalhousie University academic timetable. Using PHP, MySQL, JSON, and JavaScript, users can view available courses, log in, and manage their personal schedules by adding or dropping courses. Key features include user authentication, session handling, asynchronous data loading with the Fetch API, and a dynamic, responsive interface powered by Bootstrap and enhanced with Three.js for a 3D background element.

dalhousie_timetable:

- courses: Contains course details (course_code, course_name, instructor, schedule).
- schedule: Links users to courses (user_id, course_id) for managing enrolled schedules.
- users: Stores user information (username, password, created_at) for schedule management.

## Features Implemented Beyond Requirements

	1.	Three.js 3D Background: A rotating Torus Knot element adds visual depth to the background, making the user experience more engaging.
	2.	Show/Hide Password: Provides users with an option to toggle password visibility, enhancing usability during login and registration.
	3.	Course Search and Filter: Users can search and filter courses by day, allowing for a streamlined view of classes that fit their schedule.

## Citations

- [Bootstrap](https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css)

- "PHP how to connect to MySQL database." YouTube, uploaded by Bro Code, 19 May 2024, www.youtube.com/watch?v=-1DTYAQ25bY&t=95s. Accessed 31 Oct. 2024.
    This video was used to guide PHP-MySQL connection setup for secure data handling and user authentication in the timetable project.

- Mozilla Developer Network. (n.d.). JavaScript Fetch API. Mozilla. https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API. Accessed on 2024-10-31.
    This documentation provided instructions for using the Fetch API to handle asynchronous requests, allowing real-time updates to the user’s schedule without page reloads, which enhanced the project’s interactivity.

- PHP Manual. “session_start() - Manual.” PHP Documentation. https://www.php.net/manual/en/function.session-start.php. Accessed 1 Nov. 2024.
Used session_start() to manage user sessions and authentication securely throughout the application.

- PHP Manual. “filter_var() - Manual.” PHP Documentation. https://www.php.net/manual/en/function.filter-var.php. Accessed 1 Nov. 2024.
Employed filter_var() to sanitize user inputs and ensure data integrity when processing form submissions.

- PHP Manual. “password_verify() - Manual.” PHP Documentation. https://www.php.net/manual/en/function.password-verify.php. Accessed 1 Nov. 2024.
Utilized password_verify() for verifying hashed passwords during login, providing secure authentication.

- “TorusKnotGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusKnotGeometry. Accessed 7 Nov. 2024.
This documentation was used to implement and customize a Torus Knot geometry for the background effect in the timetable project, enabling a visually dynamic 3D element that scales and rotates with user interaction in the index.php.

- “TorusGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusGeometry. Accessed 7 Nov. 2024.
This documentation was referenced to understand and utilize the properties of the Torus geometry in the project, enabling the creation of circular 3D shapes that could serve as alternative visual effects within the timetable interface in the dashboard.php.

- “Learn the Basics of Three.js - 3D Scrolling Animation.” YouTube, uploaded by Fireship, 21 May. 2021, www.youtube.com/watch?v=Q7AOvWpIVHU. Accessed 7 Nov. 2024.
This video tutorial was instrumental in learning the fundamentals of Three.js, particularly for setting up 3D scenes, animations, and creating a scroll-based animation effect, which contributed to the interactive 3D elements in the timetable project.

- “Bootstrap 5 Toggle Visibility | Hide/Show Password with JavaScript.” YouTube, uploaded by Southbridge, 23 May 2024, www.youtube.com/watch?v=OkS5XWPka8s. Accessed 7 Nov. 2024.

- CodingLabWeb YouTube Channel. “Button Click Animation in HTML CSS & JavaScript.” YouTube, 28 Dec. 2022, https://www.youtube.com/watch?v=F7iFnhSZe7o. Accessed 7 Nov. 2024.
This tutorial was referenced to implement the animated button effect in the timetable project. It provided instructions on creating bubble animations that appear on button clicks, enhancing the interactivity and visual appeal of action buttons in the interface.
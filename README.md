# Assignment 4 - Dalhousie University Timetable Rebuild

## Student Information

- **Name**: Malhar Datta Mahajan
- **Student ID**: B00934337
- **Date Created**: 1 November 2024

## Overview

In this assignment, we are rebuilding the Dalhousie University academic timetable using PHP, MySQL, and JSON. The application allows users to view available courses, log in, and manage their personal course schedules by adding or dropping courses asynchronously using Fetch API. This assignment focuses on key topics such as user authentication, session handling, asynchronous communication, and dynamic data retrieval.

dalhousie_timetable:

- courses: Contains course details (course_code, course_name, instructor, schedule).
- schedule: Links users to courses (user_id, course_id) for managing enrolled schedules.
- users: Stores user information (username, password, created_at) for schedule management.



## Citations

- [Bootstrap](https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css)

- "PHP how to connect to MySQL database." YouTube, uploaded by Bro Code, 19 May 2024, www.youtube.com/watch?v=-1DTYAQ25bY&t=95s. Accessed 31 Oct. 2024.
    This video was used to guide PHP-MySQL connection setup for secure data handling and user authentication in the timetable project.

- Mozilla Developer Network. (n.d.). JavaScript Fetch API. Mozilla. https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API. Accessed on 2024-10-31.
    This documentation provided instructions for using the Fetch API to handle asynchronous requests, allowing real-time updates to the user’s schedule without page reloads, which enhanced the project’s interactivity.

- “TorusKnotGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusKnotGeometry. Accessed 7 Nov. 2024.
This documentation was used to implement and customize a Torus Knot geometry for the background effect in the timetable project, enabling a visually dynamic 3D element that scales and rotates with user interaction in the index.php.

- “TorusGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusGeometry. Accessed 7 Nov. 2024.
This documentation was referenced to understand and utilize the properties of the Torus geometry in the project, enabling the creation of circular 3D shapes that could serve as alternative visual effects within the timetable interface in the dashboard.php.

- “Learn the Basics of Three.js - 3D Scrolling Animation.” YouTube, uploaded by Fireship, 21 May. 2021, www.youtube.com/watch?v=Q7AOvWpIVHU. Accessed 7 Nov. 2024.
This video tutorial was instrumental in learning the fundamentals of Three.js, particularly for setting up 3D scenes, animations, and creating a scroll-based animation effect, which contributed to the interactive 3D elements in the timetable project.
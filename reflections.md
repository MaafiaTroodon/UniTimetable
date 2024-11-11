# CSCI 2170: Assignment Creative Curiosity Corner

## 1. Student Details

* Full Name: Malhar Datta Mahajan
* Dal Email: ml575444@dal.ca
* B00 ID: 934337

## 2. Introducing the Creative Curiosity Corner

In addition to completing the main requirements for each assignment, here’s an invitation to explore beyond the task at hand through the Creative Curiosity Corner. This is an opportunity for you to demonstrate creative thinking and curiosity about the topics we are learning. Creative Curiosity Corner a space for you to experiment, explore, and challenge yourself with concepts related to the assignment, but not directly part of the main requirements. This could involve:

* Expanding on a specific idea that caught your attention
* Testing out a new technique you haven’t had the chance to explore
* Applying the material in a creative way that goes beyond the instructions

We learn best by trying new things, making mistakes, and pushing beyond what feels comfortable. This is how we grow as learners, and it’s also how we build resilience. The Creative Curiosity Corner gives you the freedom to experiment without the pressure of perfection. It’s a chance to take risks, learn from them, and bounce back when things don’t work out as planned. The goal isn’t just to get things right—it’s about developing your problem-solving skills, embracing the unknown, and becoming more confident when facing challenges.

### 2.1. Grading: The focus is on learning and experimentation: not correctness

* Grading for `creative-curiosity-corner` is not based on something working or being correct. It is about encouraging you to learn beyond boundaries!
* The code and reflections will be graded as a bonus component of the assignment, making you eligible to receive a grade of __*exceeds expectations*__ in case all other assignment components are complete.
* In case other assignment components are not complete, you are eligible to get the next level of the grade.
  * For example, if your grade was “Incomplete, does not meet expectations yet”, you could receive a grade of “Incomplete, has scope for improvements”.

## 3. Reflections

### 3.1. What did you do in this creative curiosity corner activity? (at least 250 words)

In the Creative Curiosity Corner, I expanded beyond the core assignment requirements by adding several interactive and user-focused features to enhance the overall user experience. Specifically, I explored the following:

	1.	3D Background with Three.js: To add visual appeal, I integrated a dynamic 3D object in the background using the Three.js library. This animated 3D shape provides a modern look and enhances user engagement, making the web interface more dynamic and visually engaging.
	2.	Advanced Course Search and Filter: I added a robust search and filter system that allows users to search for courses by code and filter them by specific days of the week. This is especially useful for students who have specific scheduling needs and want to quickly view courses offered on particular days. Implementing this required JavaScript and PHP, as well as advanced filtering logic to handle multiple days simultaneously.
	3.	Show and Hide Password Feature: For a more user-friendly login experience, I added a “show/hide password” toggle on the login page. This small but valuable feature lets users confirm their password entries, reducing potential login errors.

### 3.2. Why did you choose to do this? (at least 100 words)

I chose to implement these features to explore ways to make web applications more engaging and user-friendly. Using Three.js allowed me to experiment with interactive 3D graphics, an area that is increasingly popular in modern web design. The search and filter functionality is a highly practical feature, as it enhances the usability of the course schedule for students. Additionally, the “show/hide password” feature is a small but significant improvement for accessibility and user convenience, aligning with best practices in UI/UX design.


### 3.3. How it connects to this assignment? (no word limit; bullet points encouraged)

	•	3D Background (Three.js): Enhances the visual interface and ties into the assignment’s focus on creating a more engaging UI.
	•	Course Search and Filter by Days: Directly relates to course data handling, allowing users to interact with the schedule in a flexible way.
	•	Show and Hide Password Feature: Improves login functionality and provides a more user-friendly experience, building on session and security concepts covered in the course.

### 3.4. What worked and what didn’t? (no word limit; bullet points encouraged)

	•	Worked:
	•	Three.js integration was smooth and brought a polished look to the page.
	•	The filter and search system performed well, allowing quick, responsive filtering based on day selection and search terms.
	•	The “show/hide password” feature worked effectively across browsers and made logging in more user-friendly.
	•	Didn’t Work:
	•	Initially, the Three.js background animation caused slight performance issues on lower-powered devices, which I mitigated by optimizing render settings.
	•	Managing multiple day filters required refining my JavaScript and PHP code to handle combined filtering logic, which took some debugging.

### 3.5. What did you tried to fix? (no word limit; bullet points encouraged)

	•	Optimized Three.js settings to improve performance, especially on mobile.
	•	Refined filtering code to ensure multiple day selections worked as intended without conflicts.
	•	Ensured “show/hide password” compatibility across different browsers and devices.

### 3.6. References/Citations: What additional resources did you use, and why? (no word limit; bullet points encouraged)

- “TorusKnotGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusKnotGeometry. Accessed 7 Nov. 2024.
This documentation was used to implement and customize a Torus Knot geometry for the background effect in the timetable project, enabling a visually dynamic 3D element that scales and rotates with user interaction in the index.php.

- “TorusGeometry.” three.js Documentation, 2024, threejs.org/docs/index.html#api/en/geometries/TorusGeometry. Accessed 7 Nov. 2024.
This documentation was referenced to understand and utilize the properties of the Torus geometry in the project, enabling the creation of circular 3D shapes that could serve as alternative visual effects within the timetable interface in the dashboard.php.

- “Learn the Basics of Three.js - 3D Scrolling Animation.” YouTube, uploaded by Fireship, 21 May. 2021, www.youtube.com/watch?v=Q7AOvWpIVHU. Accessed 7 Nov. 2024.
This video tutorial was instrumental in learning the fundamentals of Three.js, particularly for setting up 3D scenes, animations, and creating a scroll-based animation effect, which contributed to the interactive 3D elements in the timetable project.

- “Bootstrap 5 Toggle Visibility | Hide/Show Password with JavaScript.” YouTube, uploaded by Southbridge, 23 May 2024, www.youtube.com/watch?v=OkS5XWPka8s. Accessed 7 Nov. 2024.

### 3.7 What did you learn from this experience? (at least 150 words)

This experience taught me valuable skills in implementing user-centered features and optimizing performance for web applications. The Three.js background added a creative element to the project, making it visually engaging, while the course search and filter feature provided practical functionality that adds real value to users. These enhancements gave me hands-on experience in balancing aesthetics with usability and taught me more about effective client-side scripting. Implementing the “show/hide password” toggle also reinforced my understanding of accessibility features and the importance of small details in improving user experience. This experience has shown me that small interactive elements and thoughtful design choices can greatly enhance user engagement and satisfaction in web development.

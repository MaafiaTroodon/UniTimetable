<?php
/*
    CSCI 2170: Introduction to Server-Side Scripting
    (Fall Semester 2024)
    Assignment 3 (footer.php)
*/

// Set the timezone 
date_default_timezone_set('America/Halifax');
?>
</div> <!-- Closing main container div from header -->

<!-- Footer -->
<footer class="bg-white text-center text-lg-start shadow-sm mt-5" aria-label="Footer">
    <div class="text-center p-3">
        <!-- Dynamic year display -->
        <span class="text-muted">&copy; <?php echo date("Y"); ?> Dalhousie University - Server Side Scripting Assignment</span>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
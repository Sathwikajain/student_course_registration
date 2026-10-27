<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect('localhost', 'root', '', 'student_registration');

    if (!$conn) {
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    if (isset($_POST['user'], $_POST['email'], $_POST['pass'], $_POST['course'])) {
        $user = trim($_POST['user']);
        $pass = trim($_POST['pass']);
        $email = trim($_POST['email']);
        $course = trim($_POST['course']);

        // Check if student is already registered
        $checkQuery = "SELECT * FROM `student1` WHERE `s_email` = ? AND `s_course` = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "ss", $email, $course);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('You have already registered for $course.'); window.history.back();</script>";
        } else {
            // Check available seats
            $seatQuery = "SELECT seats_allotted FROM course_seats WHERE course_name = ?";
            $stmt = mysqli_prepare($conn, $seatQuery);
            mysqli_stmt_bind_param($stmt, "s", $course);
            mysqli_stmt_execute($stmt);
            $seatResult = mysqli_stmt_get_result($stmt);
            $seatData = mysqli_fetch_assoc($seatResult);
            $seatsLeft = $seatData['seats_allotted'];

            if ($seatsLeft > 0) {
                // Generate a unique 5-digit Student ID
                do {
                    $sid = rand(10000, 99999);
                    $sidCheckQuery = "SELECT * FROM `student1` WHERE `s_id` = ?";
                    $stmt = mysqli_prepare($conn, $sidCheckQuery);
                    mysqli_stmt_bind_param($stmt, "i", $sid);
                    mysqli_stmt_execute($stmt);
                    $sidResult = mysqli_stmt_get_result($stmt);
                } while (mysqli_num_rows($sidResult) > 0);

                // Insert new student record
                $sql = "INSERT INTO `student1` (`s_id`, `s_name`, `s_password`, `s_course`, `s_email`) 
                        VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "issss", $sid, $user, $pass, $course, $email);
                
                if (mysqli_stmt_execute($stmt)) {
                    // Reduce the seat count by 1
                    $updateSeats = "UPDATE course_seats SET seats_allotted = seats_allotted - 1 WHERE course_name = ?";
                    $stmt = mysqli_prepare($conn, $updateSeats);
                    mysqli_stmt_bind_param($stmt, "s", $course);
                    mysqli_stmt_execute($stmt);

                    echo "<script>alert('Registered successfully! Your Registration Number: $sid | Selected Course: $course'); window.location.href='index.php';</script>";
                } else {
                    echo "<p>An error occurred: " . mysqli_error($conn) . "</p>";
                }
            } else {
                echo "<script>alert('Seats are full for $course.'); window.history.back();</script>";
            }
        }
    }
}
?>

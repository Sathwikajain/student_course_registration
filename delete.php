<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'student_registration') or die("Connection failed: " . mysqli_connect_error());

// Check if s_id is set in URL
if (isset($_GET['s_id'])) {
    $sid = $_GET['s_id'];

    // Check if the student exists
    $checkQuery = "SELECT * FROM `student1` WHERE `s_id` = '$sid'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Delete the student record
        $deleteQuery = "DELETE FROM `student1` WHERE `s_id` = '$sid'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<script>alert('Student record deleted successfully!'); window.location.href='search.php';</script>";
        } else {
            echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No student found with this Registration ID.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}

// Close the connection
mysqli_close($conn);
?>

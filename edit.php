<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "student_registration");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if student ID is set and get the details
if (isset($_GET['s_id'])) {
    $s_id = $_GET['s_id'];

    // Fetch student record based on the ID
    $query = "SELECT * FROM student1 WHERE s_id = '$s_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('No record found!'); window.location.href='search.php';</script>";
        exit();
    }
}

// Handle form submission to update the record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    // Check if the new email already exists in another record
    $emailCheckQuery = "SELECT * FROM student1 WHERE s_email = '$email' AND s_id != '$s_id'";
    $emailCheckResult = mysqli_query($con, $emailCheckQuery);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        // Email already in use by another student
        echo "<script>alert('Email already exists! Please use a different email.'); window.history.back();</script>";
    } else {
        // Update student record
        $update_query = "UPDATE student1 SET s_name = '$user', s_password = '$pass', s_email = '$email', s_course = '$course' WHERE s_id = '$s_id'";

        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Record updated successfully!'); window.location.href='search.php';</script>";
        } else {
            echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-group-custom {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Edit Student Record</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="user" class="form-label">Student Name:</label>
            <input type="text" class="form-control" name="user" value="<?= htmlspecialchars($student['s_name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="pass" class="form-label">Password:</label>
            <input type="password" class="form-control" name="pass" value="<?= htmlspecialchars($student['s_password']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($student['s_email']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="course" class="form-label">Course:</label>
            <select name="course" id="course" class="form-control" required>
                <option value="BCA" <?= $student['s_course'] == 'BCA' ? 'selected' : ''; ?>>BCA</option>
                <option value="BBA" <?= $student['s_course'] == 'BBA' ? 'selected' : ''; ?>>BBA</option>
                <option value="BCom" <?= $student['s_course'] == 'BCom' ? 'selected' : ''; ?>>BCom</option>
                <option value="BSc" <?= $student['s_course'] == 'BSc' ? 'selected' : ''; ?>>BSc</option>
                <option value="BVoc" <?= $student['s_course'] == 'BVoc' ? 'selected' : ''; ?>>BVoc</option>
            </select>
        </div>

        <!-- Buttons aligned neatly -->
        <div class="btn-group-custom">
            <button type="submit" class="btn btn-primary">Update Record</button>
            <a href="search.php" class="btn btn-secondary">Back to Search</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js">
// Prevent form submission when Enter key is pressed
document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

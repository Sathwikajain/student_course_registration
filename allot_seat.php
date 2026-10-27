<?php
session_start();

if (!isset($_SESSION['admin1'])) {
    header("Location: admin.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "student_registration");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$success_message = "";

// Update seats when admin submits the form
if (isset($_POST['update_seats'])) {
    $course = $_POST['course'];
    $seats = $_POST['seats'];

    if (mysqli_query($con, "UPDATE course_seats SET seats_allotted = '$seats' WHERE course_name = '$course'")) {
        $success_message = "Seats successfully updated for $course!";
    } else {
        $success_message = "Error updating seats: " . mysqli_error($con);
    }
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
        }
        .card {
            padding: 25px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h4 {
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
        }
        .success-message {
            font-weight: 500;
            text-align: center;
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .btn-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-success, .btn-danger, .btn-secondary {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h4>Allot the Seat</h4>

        <?php if (!empty($success_message)): ?>
            <div class="success-message">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <!-- Form for updating seats -->
        <form action="" method="POST">
            <div class="mb-3">
                <label for="course" class="form-label">Select Course:</label>
                <select name="course" class="form-select" required>
                    <option value="BCA">BCA</option>
                    <option value="BBA">BBA</option>
                    <option value="BCom">BCom</option>
                    <option value="BSc">BSc</option>
                    <option value="BVoc">BVoc</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="seats" class="form-label">Number of Seats:</label>
                <input type="number" name="seats" class="form-control" min="0" required />
            </div>

            <button type="submit" name="update_seats" class="btn btn-success">Update Seats</button>
        </form>

        <div class="btn-container">
            <a href="search.php" class="btn btn-secondary">Back to Search</a>

            <!-- Separate Logout Form -->
            <form action="" method="POST">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

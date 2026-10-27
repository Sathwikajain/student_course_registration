<?php
$con = mysqli_connect("localhost", "root", "", "student_registration");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($con, "SELECT * FROM course_seats");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* General Styles */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #EAEAEA;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Admin Button Styling */
        .admin-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #FDCB58;
            color: #1E1E1E;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .admin-btn:hover {
            background: #E3B354;
            transform: translateY(-3px);
        }

        /* Glassmorphism Effect */
        .card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            padding: 30px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 800px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }
        h2 {
            font-weight: 600;
            color: #FDCB58;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Table Styling */
        .table {
            overflow: hidden;
            text-align: center;
            margin-top: 20px;
            border-radius: 10px;
        }
        .table th {
            background: #FDCB58;
            color: #1E1E1E;
            padding: 15px;
            font-weight: 600;
        }
        .table td {
            background: rgba(255, 255, 255, 0.15);
            color: #EAEAEA;
            font-weight: 400;
            transition: all 0.3s ease-in-out;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(253, 203, 88, 0.2);
            transform: scale(1.02);
        }

        /* Buttons */
        .btn-custom {
            background: #FDCB58;
            color: #1E1E1E;
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            display: inline-block;
            width: 100%;
            text-align: center;
            text-decoration: none;
            margin-top: 15px;
        }
        .btn-custom:hover {
            background: #E3B354;
            transform: translateY(-3px);
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<!-- Admin Button (Top Right) with Icon -->
<a href="admin.php" class="admin-btn">
    👤 Admin
</a>

<!-- Main Content -->
<div class="card">
    <h2>Available Courses</h2>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Seats Available</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['course_name']); ?></td>
                        <td><?= htmlspecialchars($row['seats_allotted']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="index.php" class="btn-custom">Register Now</a>
</div>

<!-- Bootstrap Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

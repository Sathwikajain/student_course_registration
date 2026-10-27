<?php
// Start session to check if admin is logged in
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin1'])) {
    header("Location: admin.php"); // Redirect to admin login if not logged in
    exit();
}

// Logout functionality
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: admin.php"); // Redirect to admin login page
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Student Records</title>
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn-group-custom {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
        .btn-primary {
            background: #28a745; /* Green */
            border: none;
        }
        .btn-primary:hover {
            background: #218838;
        }
        .btn-danger {
            background: #dc3545; /* Red */
            border: none;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .no-records {
            text-align: center;
            color: red;
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Search, Edit, and Delete Student Records</h4>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search student data" oninput="filterTable()">
                    </div>

                    <!-- Buttons (Allot Seats & Logout) aligned properly -->
                    <div class="btn-group-custom">
                        <a href="allot_seat.php" class="btn btn-primary">Allot Seats</a>
                        <form action="" method="POST">
                            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="studentTable">
                        <thead class="table-dark">
                            <tr>
                                <th>Registration Number</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $con = mysqli_connect("localhost","root","","student_registration");

                                if(!$con) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                $query = "SELECT s_id, s_name, s_email, s_course FROM student1";
                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0) {
                                    foreach($query_run as $items) {
                                        ?>
                                        <tr class="studentRow">
                                            <td><?= htmlspecialchars($items['s_id']); ?></td>
                                            <td><?= htmlspecialchars($items['s_name']); ?></td>
                                            <td><?= htmlspecialchars($items['s_email']); ?></td>
                                            <td><?= htmlspecialchars($items['s_course']); ?></td>
                                            <td>
                                                <a href="edit.php?s_id=<?= $items['s_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete.php?s_id=<?= $items['s_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirmDelete('<?= $items['s_id']; ?>');">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr id="noRecordsRow" class="no-records" style="display:none;">
                                        <td colspan="5">Data does not exist</td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Prevent form submission when Enter key is pressed
    document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    // Function to confirm deletion
    function confirmDelete(sid) {
        return confirm("Are you sure you want to delete student record with Registration ID: " + sid + "?");
    }

    // Function to filter table rows based on search input
    function filterTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#studentTable tbody tr');
        let found = false;

        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            let match = false;

            columns.forEach(column => {
                if (column.textContent.toLowerCase().includes(searchInput)) {
                    match = true;
                }
            });

            if (match) {
                row.style.display = '';
                found = true;
            } else {
                row.style.display = 'none';
            }
        });

        // If no rows found, show the 'Data does not exist' row
        const noRecordsRow = document.getElementById('noRecordsRow');
        if (!found) {
            noRecordsRow.style.display = '';  // Show the "Data does not exist" row
        } else {
            noRecordsRow.style.display = 'none';  // Hide it if there are results
        }
    }
</script>

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

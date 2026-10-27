<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Student Registration Form</title>

    <!-- Prevent form caching -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }
        .form-label {
            font-weight: 600;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .btn-custom {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            font-weight: bold;
            transition: 0.3s;
            text-align: center;
        }
        .btn-primary {
            background: #28a745; /* Green */
            border: none;
        }
        .btn-primary:hover {
            background: #218838;
        }
        .btn-secondary {
            background: #007bff; /* Blue */
            border: none;
        }
        .btn-secondary:hover {
            background: #0056b3;
        }
        .btn-danger {
            background: #dc3545; /* Red */
            border: none;
        }
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

	<div class="container">
        <h2>Student Registration</h2>
        
        <!-- Form to submit data -->
		<form action="save_reg.php" method="POST" id="myForm" autocomplete="off" onsubmit="return validateForm()">
            <input type="hidden" name="sentForm" value="1"> <!-- Hidden field -->

            <div class="mb-3">
                <label for="user" class="form-label">Username:</label>
                <input type="text" name="user" id="user" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Password:</label>
                <input type="password" name="pass" id="pass" class="form-control" required minlength="6" />
            </div>

            <div class="mb-3">
                <label for="course" class="form-label">Select Course:</label>
                <select name="course" id="course" class="form-control" required>
                    <option value="BCA">BCA</option>
                    <option value="BBA">BBA</option>
                    <option value="BCom">BCom</option>
                    <option value="BSc">BSc</option>
                    <option value="BVoc">BVoc</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required />
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary btn-custom">Submit</button>
                <a href="home.php" class="btn btn-secondary btn-custom">Home</a>
                <button type="reset" class="btn btn-danger btn-custom">Reset</button>
            </div>
        </form>
	</div>

	<!-- JavaScript -->
	<script>
        // Prevent form submission when Enter key is pressed
        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });

        // Function to validate form before submission
        function validateForm() {
            let password = document.getElementById("pass").value;

            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false;
            }
            return confirm("Do you want to proceed with submitting the form?");
        }

        // Reset form when page is fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("myForm").reset();
        });

        // Ensure form resets even when navigating back
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                document.getElementById("myForm").reset();
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

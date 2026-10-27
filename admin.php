<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = mysqli_connect("localhost", "root", "", "student_registration");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM admin1 WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin1'] = $username;
        header("Location: search.php");
        exit();
    } else {
        $error = "Invalid credentials. Please try again.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* General Page Styling */
        body {
            background: linear-gradient(135deg, #1e1e2e, #252542);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Home Button (Fixed at Top Right Corner) */
        .home-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #FDCB58;
            color: #1E1E1E;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }
        .home-button:hover {
            background: #e3b354;
            transform: scale(1.05);
        }

        /* Login Card */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            color: #ffffff;
        }

        /* Heading */
        .login-container h2 {
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Input Fields */
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
            box-shadow: none;
        }

        /* Buttons */
        .btn-primary, .btn-reset {
            padding: 10px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
        }

        .btn-primary {
            background: #FDCB58;
            color: #1E1E1E;
            border: none;
        }
        .btn-primary:hover {
            background: #e3b354;
            transform: translateY(-3px);
        }

        .btn-reset {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: none;
        }
        .btn-reset:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Error Message */
        .alert {
            font-size: 14px;
            padding: 10px;
            border-radius: 5px;
            background: rgba(255, 0, 0, 0.2);
            color: #ff4d4d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <!-- Home Button (Top Right Corner) -->
    <a href="home.php" class="home-button">🏠 Home</a>

    <!-- Login Container -->
    <div class="login-container">
        <h2>Admin Login</h2>
        
        <?php if (isset($error)) { ?>
            <div class="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST" action="">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <input type="password" class="form-control" name="password" placeholder="Password" required>

            <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
            <button type="reset" class="btn btn-reset w-100 mt-2">Reset</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

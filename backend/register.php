<?php

session_start();
include 'db.php';

$success = "";
$error   = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name = trim(mysqli_real_escape_string($conn, $_POST['full_name']));
    $email     = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password  = trim($_POST['password']);
    $role      = mysqli_real_escape_string($conn, $_POST['role']);
    $hospital  = trim(mysqli_real_escape_string($conn, $_POST['hospital']));

    if (empty($full_name) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";

    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";

    } else {

        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");

        if (mysqli_num_rows($check) > 0) {
            $error = "This email is already registered.";

        } else {

            $hashed_pass = MD5($password); 

            $sql = "INSERT INTO users (full_name, email, password, role, hospital)
                    VALUES ('$full_name', '$email', '$hashed_pass', '$role', '$hospital')";

            if (mysqli_query($conn, $sql)) {
                $success = "Account created! <a href='login.php'>Login here</a>.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Register – Parkinson's AI</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f7f8fc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 44px;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        }

        h2 {
            font-size: 24px;
            color: #0f2147;
            margin-bottom: 6px;
        }

        .sub {
            font-size: 13px;
            color: #718096;
            margin-bottom: 28px;
        }
        .alert-success {
            background: #f0fff4;
            border: 1px solid #9ae6b4;
            color: #38a169;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .alert-error {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #e53e3e;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-group {
            margin-bottom: 16px;
        }

        .field-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 5px;
        }

        .field-group input,
        .field-group select {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
            transition: border 0.2s;
        }

        .field-group input:focus,
        .field-group select:focus {
            border-color: #1a56db;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: #1a56db;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #1446bc;
        }

        .login-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #718096;
        }

        .login-link a {
            color: #1a56db;
            font-weight: 600;
            text-decoration: none;
        }

        .req {
            color: #e53e3e;
        }

    </style>
</head>
<body>

<div class="card">

    <h2>Register Account</h2>
    <p class="sub">Create a new account — Parkinson's AI System</p>

    <?php if (!empty($success)): ?>
        <div class="alert-success"><?= $success ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">

        <div class="row">
            <div class="field-group">
                <label>Full Name <span class="req">*</span></label>
                <input type="text" name="full_name" placeholder="Your full name" required
                       value="<?= isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : '' ?>"/>
            </div>

            <div class="field-group">
                <label>Role <span class="req">*</span></label>
                <select name="role">
                    <option value="doctor">Doctor</option>
                    <option value="researcher">Researcher</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>

        <div class="field-group">
            <label>Email <span class="req">*</span></label>
            <input type="email" name="email" placeholder="yourname@hospital.com" required
                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"/>
        </div>

        <div class="row">
            <div class="field-group">
                <label>Password <span class="req">*</span></label>
                <input type="password" name="password" placeholder="Min 6 characters" required/>
            </div>

            <div class="field-group">
                <label>Hospital</label>
                <input type="text" name="hospital" placeholder="Hospital name"
                       value="<?= isset($_POST['hospital']) ? htmlspecialchars($_POST['hospital']) : '' ?>"/>
            </div>
        </div>

        <button type="submit" class="btn">Register Account</button>

    </form>

    <p class="login-link">Already registered? <a href="login.php">Login here</a></p>

</div>

</body>
</html>

<?php
session_start();
include 'db.php';
$error = "";
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email    = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and Password are both required.";

    } else {

        $sql    = "SELECT * FROM users WHERE email = '$email' AND password = MD5('$password')";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {

            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect Email or Password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login  Parkinson's AI System</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet"/>

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
        }

        .login-wrap {
            display: flex;
            width: 860px;
            min-height: 520px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #0f2147 0%, #1a3a6b 100%);
            color: #ffffff;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-ico {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .login-left h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 14px;
            opacity: 0.75;
            line-height: 1.6;
            margin-bottom: 36px;
        }

        .feat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
            font-size: 14px;
            opacity: 0.9;
        }

        .feat-ico {
            width: 8px;
            height: 8px;
            background: #63b3ed;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .login-right {
            flex: 1;
            background: #ffffff;
            padding: 50px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 26px;
            color: #1a202c;
            margin-bottom: 6px;
        }

        .login-right .sub {
            font-size: 14px;
            color: #718096;
            margin-bottom: 30px;
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

        .field-group {
            margin-bottom: 18px;
        }

        .field-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 6px;
        }

        .field-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            font-family: inherit;
            transition: border 0.2s;
        }

        .field-group input:focus {
            border-color: #1a56db;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-wrap input {
            padding-right: 44px;
        }

        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .login-foot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .forgot {
            color: #1a56db;
            text-decoration: none;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #1a56db;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-login:hover {
            background: #1446bc;
        }

        .register-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
            color: #718096;
        }

        .register-link a {
            color: #1a56db;
            font-weight: 600;
            text-decoration: none;
        }

    </style>
</head>
<body>

<div class="login-wrap">

    <div class="login-left">
        <div class="brand-ico"></div>
        <h1>Parkinson's AI System</h1>
        <p>Federated Learning &amp; Explainable AI for Better Healthcare</p>

        <div class="feat-item">
            <span class="feat-ico"></span> Secure &amp; Privacy-Preserving
        </div>
        <div class="feat-item">
            <span class="feat-ico"></span> 94.2% Prediction Accuracy
        </div>
        <div class="feat-item">
            <span class="feat-ico"></span> 12 Hospitals Connected
        </div>
    </div>

  
    <div class="login-right">
        <h2>Welcome Back</h2>
        <p class="sub">Sign in to your account</p>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

   
        <form method="POST" action="login.php">

            <div class="field-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required
                       value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"/>
            </div>

            <div class="field-group">
                <label>Password</label>
                <div class="pw-wrap">
                    <input type="password" id="l-pass" name="password" placeholder="Enter your password" required/>
                    <button type="button" class="toggle-pw" onclick="togglePw()"></button>
                </div>
            </div>

            <div class="login-foot">
                <label><input type="checkbox" name="remember"/> &nbsp;Remember me</label>
                <a href="#" class="forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-login">Login</button>

        </form>

        <p class="register-link">No account? <a href="register.php">Register Here</a></p>
    </div>

</div>

<script>
function togglePw() {
    var p = document.getElementById('l-pass');
    p.type = p.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>

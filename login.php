<?php
require 'config.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST['Username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("select ID, Username, Password from users where Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['Password']))
    {
        $_SESSION['Username'] = $user['Username'];
        $_SESSION['User_id'] = $user["ID"];
        header("Location: index.php");
        exit;
    }
    else
        $error = "Invalid Username or Password!";
}
$registered = isset($_GET['registered']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            min-height: 100vh;
            background-image: url("images/BG2.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-color: #1215dd;
            display: flex;
            font-family: Tahoma;
        }
        .container{
            margin: auto;
            width: 500px;
            max-width: 90%
        }
        .container form{
            width: 100%;
            height: 100%;
            padding: 20px;
            background: lightblue;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0,0,0,.3);
        }
        .container form h1{
            text-align: center;
            margin-bottom: 24px;
            color: #222;
        }
        .container form .form-control{
            width: 100%;
            height: 40px;
            background: cyan;
            border-radius: 4px;
            border: 1px solid black;
            margin: 10px 0 18px 0;
            padding: 0 10px;
        }
        .container form .btn{
            margin-left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height:34px;
            border: none;
            outline: none;
            background: #27a327;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            color: white;
            border-radius: 4px;
            transition: .3s;
        }
        .container form .btn:hover{
            opacity: .7;
        }
        .container form .alert
        {
            color: darkred;
        }
        .container .link{
            text-decoration: none;
            color: rgba(24, 137, 250, 0.93)
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <h1>Login</h1>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" class="form-control" name="Username" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary" type="submit">Login</button>
            <nav><a class="link" href="register.php">Don't have an account? Create one!</a></nav>
            <?php if ($registered): ?><div class="alert">Registration Successful! Please Login.</div><?php endif; ?>
        </form>
    </div>
</body>
</html>
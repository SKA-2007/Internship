<?php
require 'config.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST['Username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '')
        $error = "All fields are required!";
    else
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("insert into users (Username, Password) values (?, ?)");
        $stmt->bind_param("ss", $username, $hash);
        if ($stmt->execute())
        {
            header("Location: login.php?registered=1");
            exit;
        }
        else
            $error = "Username may already exist.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>

<body>
    <header>
        <h1>Register</h1>
        <nav><a href="login.php">Login</a></nav>
    </header>
    <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="Username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button class ="btn btn-primary" type="submit">Create Account</button>
    </form>
</body>

</html>
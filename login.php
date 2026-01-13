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
    <title>Login</title>
</head>

<body>
    <header>
        <h1>Login</h1>
        <nav><a href="register.php">Register</a></nav>
    </header>
    <?php if ($registered): ?><div class="alert">Registration Successful! Please Login.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Username</label>
        <input type="text" name="Username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button class="btn btn-primary" type="submit">Login</button>
    </form>
</body>

</html>
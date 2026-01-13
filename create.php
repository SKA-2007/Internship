<?php
require 'config.php';
require_login();
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = trim($_POST['Title'] ?? '');
    $content = trim($_POST['Content'] ?? '');
    if ($title === "" || $content === "")
        $error = "Title and Content are required!";
    else
    {
        $stmt = $conn->prepare("insert into posts (title,content) values (?,?)");
        $stmt->bind_param("ss", $title,$content);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Create Post</title>
</head>

<body>
    <header>
        <h1>Create Post</h1>
        <nav>
            <a class="btn" href="index.php">Back</a>
            <a class="btn" href="logout.php">Log Out</a>
        </nav>
    </header>
    <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Title</label>
        <input type="text" name="Title" required>
        <label>Content</label>
        <textarea name="Content" rows="8" required></textarea>
        <button class="btn btn-primary" type="submit">Save</button>
    </form>
</body>

</html>
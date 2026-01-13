<?php
require 'config.php';
require_login();
$id = intval($_GET['ID'] ?? 0);
if ($id <= 0)
{
    header("Location: index.php");
    exit;
}
$stmt = $conn->prepare("select ID, Title, Content from posts where ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
if (!$post)
{
    header("Location: index.php");
    exit;
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $title = trim($_POST['Title'] ?? '');
    $content = trim($_POST['Content'] ?? '');
    if ($title === "" || $content === "")
        $error = "Title and content are required.";
    else
    {
        $up = $conn->prepare("update posts set Title = ?, Content = ? where ID = ?");
        $up->bind_param("ssi",$title, $content, $id);
        $up->execute();
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Post</title>
</head>

<body>
    <header>
        <h1>Edit Post</h1>
        <nav>
            <a class="btn" href="index.php">Back</a>
            <a class="btn" href="logout.php">Log Out</a>
        </nav>
    </header>
    <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Title</label>
        <input type="text" name="Title" value="<?= htmlspecialchars($post['Title']) ?>" required>
        <label>Content</label>
        <textarea name="Content" rows="8" required><?= htmlspecialchars($post['Content']) ?></textarea>
        <button class="btn btn-primary" type="submit">Update</button>
    </form>
</body>

    </html>
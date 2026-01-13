<?php
require 'config.php';
require_login();
$stmt = $conn->prepare("select ID, Title, Content, Created_at from posts order by Created_at desc");
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Posts</title>
</head>

<body>
    <header>
        <h1>Posts</h1>
        <nav>
            <a class="btn btn-primary" href="create.php">New Post</a>
            <a class="btn" href="logout.php">Log Out</a>
        </nav>
    </header>
    <?php if (empty($posts)): ?>
        <p>No posts yet. Create yout first one.</p>
    <?php else: ?>
        <?php foreach ($posts as $p): ?>
            <div class="card">
                <h3><?= htmlspecialchars($p['Title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($p['Content'])) ?></p>
                <div class="small"><?= $p['Created_at'] ?></div>
                <div style="margin-top:8px;">
                    <a class="btn" href="edit.php?ID=<?= $p["ID"] ?>">Edit</a>
                    <form action="delete.php" method="POST" style="display:inline;">
                        <input type="hidden" name="ID" value="<?= $p['ID'] ?>">
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this Post?');">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

<html>
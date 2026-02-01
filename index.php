<?php
require 'config.php';
require_login();
$search = trim($_GET['search'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;
$like = "%$search%";
if ($search)
{
    $stmt = $conn->prepare("select SQL_CALC_FOUND_ROWS * from posts
        where Title like ? or content like ?
        order by created_at desc limit ?, ?");
    $stmt->bind_param("ssii", $like, $like, $offset, $limit);
}
else
{
    $stmt = $conn->prepare("select SQL_CALC_FOUND_ROWS * from posts
        order by created_at desc limit ?, ?");
    $stmt->bind_param("ii",$offset, $limit);
}
$stmt->execute();
$res = $stmt->get_result();
$posts = $res->fetch_all(MYSQLI_ASSOC);
$totalRes = $conn->query("select FOUND_ROWS() as total");
$totalRows = $totalRes->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Posts</title>
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
        h1{
            color: rgba(163, 87, 250, 0.94);
            font-size: 40px;
            position: relative;
            left: 100px;
        }
        .input-group{
            width: 100%;
            max-width: 700px;
            background: white;
            display: flex;
            align-items: center;
            border-radius: 60px;
            padding: 10px 20px;
            backdrop-filter: blur(4px) saturate(180%);
            transform: translate(150%,70%);
        }
        .input-group input{
            background: transparent;
            flex: 1;
            border: 0;
            outline: none;
            padding: 24px 20px;
            font-size: 20px;
            color: #423da1;
        }
        ::placeholder{
            color: #423da1;
        }
        .input-group button img{
            width: 25px;
        }
        .input-group button{
            border: 0;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            background: #58629b;
            cursor: pointer;
        }
        .input-group button:hover{
            opacity: .7;
        }
        .alert-warning{
            color: red;
            font-size: 20px;
            padding: 16px;
            transform: translate(130%,40%);
            font-size: 30px;
        }
        .card .card-body{
            width: 1200px;
            background: lightgrey;
            border: 4px solid purple;
            border-radius: 12px;
            padding: 16px;
            margin:12px 0;
            font-size: 26px;
            transform: translate(-20%,90%);
        }
        .card .card-body .btn{
            width: 120px;
            height:34px;
            border: none;
            outline: none;
            background: #b83030;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            color: white;
            border-radius: 4px;
            transition: .3s;
        }
        .card .card-body .btn:hover{
            opacity: .7;
        }
        .btn1{
            text-decoration: none;
            color: lightblue;
            font-size: 25px;
            background: blue;
            border-radius: 4px;
            padding: 10px;
            position: relative;
            left: 1500px;
            top: 2px;
        }
        .btn1:hover{
            opacity: .7;
        }
        .btn2{
            text-decoration: none;
            color: white;
            font-size: 23px;
            background: Red;
            border-radius: 4px;
            padding: 10px;
            position: relative;
            left: 1525px;
        }
        .btn2:hover{
            opacity: .7;
        }
        .btn3{
            text-decoration: none;
            color: white;
            font-size: 23px;
            background: darkgrey;
            border-radius: 4px;
            padding: 10px;
        }
        .btn3:hover{
            opacity: .7;
        }
    </style>
</head>

<body>
    <header>
        <h1>Posts</h1>
        <nav>
            <a class="btn1 btn-primary" href="create.php">Create Post</a>
            <a class="btn2 btn-danger" type="submit" onclick="return confirm('Do you really want to Logout?');" href="logout.php">Log Out</a>
        </nav>
    </header>
    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search posts...">
            <button class="btn btn-primary"><img src="images/search.png"></button>
        </div>
    </form>
    <?php if (empty($posts)): ?>
        <div class = "alert-warning">No posts found!</div>
    <?php else: ?>
        <?php foreach ($posts as $p): ?>
            <div class="card mb-3">
                <div class="card-body">
                <h3><?= htmlspecialchars($p['Title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($p['content'])) ?></p>
                <small class="text-muted"><?= $p['created_at'] ?></small><br>
                <div style="margin-top:8px;">
                    <a class="btn3" href="edit.php?ID=<?= $p["ID"] ?>">Edit</a>
                    <form action="delete.php" method="POST" style="display:inline;">
                        <input type="hidden" name="ID" value="<?= $p['ID'] ?>">
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this Post?');">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        <nav>
            <ul class = "pagination">
                <?php for ($i = 1; $i <$totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</body>

</html>
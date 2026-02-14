<?php
require_once 'config.php';
require_login();
$search = trim($_GET['search'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;
$like = "%$search%";
$sql = "select  * from users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->get_result();
$users = $res->fetch_all(MYSQLI_ASSOC);
if ($search)
{
    $stmt = $conn->prepare("select SQL_CALC_FOUND_ROWS * from posts
        where Title like ? or Content like ?
        order by Created_at desc limit ?, ?");
    $stmt->bind_param("ssii", $like, $like, $offset, $limit);
}
else
{
    $stmt = $conn->prepare("select SQL_CALC_FOUND_ROWS * from posts
        order by Created_at desc limit ?, ?");
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
            width: 100%;
            min-height: 100vh;
            background-image: url("images/BG.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-color: #25279b;
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
            max-width: 100%;
            width: 700px;
            background: white;
            display: flex;
            align-items: center;
            border-radius: 60px;
            padding: 10px 20px;
            backdrop-filter: blur(4px) saturate(180%);
            margin: 2% 0 0 70%;
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
            max-width: 100%;
        }
        .input-group button{
            border: 0;
            border-radius: 50%;
            width: 60px;
            max-width: 100%;
            height: 60px;
            max-height: 100%;
            background: #58629b;
            cursor: pointer;
        }
        .input-group button:hover{
            opacity: .7;
        }
        .alert-warning{
            color: red;
            padding: 16px;
            font-size: 30px;
            transform: translate(-50%,20%);
        }
        .card .card-body{
            width: 1111px;
            max-width: 100%;
            background: lightgrey;
            border: 4px solid purple;
            border-radius: 12px;
            padding: 16px;
            font-size: 150%;
            margin-top: 50px;
            transform: translate(-40%,50%);
        }
        .card .card-body .btn{
            width: 120px;
            max-width: 100%;
            height:34px;
            max-height: 100%;
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
            color: white;
            background: purple;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 16px;
            position: relative;
            left: 1400px;
        }
        .btn1:hover{
            opacity: .7;
        }
        .btn2{
            text-decoration: none;
            color: white;
            background: red;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 15px;
            position: relative;
            left: 1530px;
            bottom: 20px;
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
            padding: 8px 12px;
        }
        .btn3:hover{
            opacity: .7;
        }
        .my-pigmentation-container{
            contain: style layout;
        }
        .my-pagination-container .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .my-pagination-container .page-item .page-link {
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
            margin: 0 2px;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
        }

        .my-pagination-container .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .my-pagination-container .page-item:not(.active) .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #adb5bd;
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
            <?php foreach($users as $u): ?>
                    <?php if ($u['ID'] == $p['User_ID']): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                            <?php echo "Posted By: ".$u['Username']. "<br>\n" ."Role: ".$u['Role']; ?>
                            <h3><?= htmlspecialchars($p['Title']) ?></h3>
                            <p><?= nl2br(htmlspecialchars($p['Content'])) ?></p>
                            <small class="text-muted"><?= $p['Created_at'] ?></small><br>
                            <div style="margin-top:8px;">
                                <form action="delete.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="ID" value="<?= $p['ID'] ?>">
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this Post?');">Delete</button>
                                </form>
                                <a class="btn3" href="edit.php?ID=<?= $p["ID"] ?>">Edit</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
        <?php endforeach; ?>
        <div class="my-pigmentation-container">
            <nav aria-label="Page navigation">
                <ul class = "pagination">
                    <div style="padding: 20px; margin: 50px; position: relative; top: 50px;">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" style="display: inline-block; padding: 10px; margin: 5px; background: violet; color: black; text-decoration: none; font-size: 20px; font-weight: bold; border: none;">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</body>

</html>
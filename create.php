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
        $stmt = $conn->prepare("insert into posts (Title,Content) values (?,?)");
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
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            min-height: 100vh;
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
        .container{
            margin: auto;
            width: 1000px;
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
        .container form .form-control1{
            width: 100%;
            height: 500px;
            background: cyan;
            border-radius: 4px;
            border: 1px solid black;
            margin: 10px 0 18px 0;
            padding: 0 10px;
            font-size: 20px;
        }
        .btn{
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
        .btn:hover{
            opacity: .7;
        }
        .btn1{
            text-decoration: none;
            color: white;
            background: purple;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 17px;
            position: relative;
            left: 1520px;
            bottom: 20px;
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
    </style>
</head>

<body>
    <header>
        <h1>Create Post</h1>
        <nav>
            <a class="btn1" href="index.php">Back</a>
            <a class="btn2" href="logout.php">Log Out</a>
        </nav>
    </header>
    <div class="container">
        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Title</label>
                <input class="form-control" type="text" name="Title" required>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea class="form-control1" name="Content" rows="8" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
    </div>
</body>

</html>
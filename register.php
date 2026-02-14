<?php
require 'config.php';
$error = "";
$v_error = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST['Username'] ?? '');
    $name = trim($_POST['Name'] ?? '');
    $mobile = $_POST['mobile'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    if (empty($username)){
        $n_error = "Please Enter the Username.";
        $v_error = 1;
    }
    if (empty($password)){
        $p_error = "Please Enter the Password.";
        $v_error = 1;
    }
    if(empty($role)) $role = 'user';
    if ($v_error === 0){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("insert into users (Username, Password, Role) values (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hash, $role);
        if ($stmt->execute())
        {
            header("Location: login.php?registered=1");
            exit;
        }
        else $error = "Username may already exist.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .container .link{
            text-decoration: none;
            color: rgba(24, 137, 250, 0.93)
        }       
        .text-danger{
            color: darkred;
            position: relative;
            bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if ($error): ?><div class="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST" onsubmit="return validateForm()">
            <h1>Register</h1>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" class="form-control" name="Username" minlength="3" id="username" onblur="checkUser()">
                <span class="text-danger"><?php if(!empty($n_error)) echo $n_error?></span>
                <span class="text-danger" id="n_error"></span>
            </div>        
            <div class="form-group">
                <label>Password:</label>
                <input type="password" class="form-control" name="password" minlength="8" id="pass" onblur="checkPass()">
                <span class="text-danger"><?php if(!empty($p_error)) echo $p_error?></span>
                <span class="text-danger" id="p_error"></span>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <input type="text" class="form-control" name="role">        
            </div>
            <button class ="btn btn-primary" type="submit" name="submit">Create Account</button>
            <nav><a class="link" href="login.php">Already have an account? Login.</a></nav>
        </form>
        <script>
            function checkUser() {
                var user = document.getElementById("username").value;
                var error = document.getElementById("n_error");
                if (user.length < 3) {
                    error.textContent = "The Username Must be Atleast 3 Characters.";
                    return false;
                }
                error.textContent = "";
                return true;
            }
            function checkPass() {
                var user = document.getElementById("pass").value;
                var error = document.getElementById("p_error");
                if (user.length < 8) {
                    error.textContent = "The Password Must be Atleast 8 Chracters.";
                    return false;
                }
                error.textContent = "";
                return true;
            }
        </script>
    </div>
</body>

</html>
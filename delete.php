<?php
require 'config.php';
require_login();
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $id = intval($_POST['ID'] ?? 0);
    if ($id > 0)
    {
        $stmt = $conn->prepare("delete from posts where ID = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
    }
}
header("Location: index.php");
exit;
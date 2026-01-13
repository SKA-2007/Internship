<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "blog";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error)
    die("Connect failed : " . $conn->connect_error);
if (session_status() === PHP_SESSION_NONE)
    session_start();
function require_login()
{
    if (!isset($_SESSION['Username']))
    {
        header("location: login.php");
        exit;
    }
}
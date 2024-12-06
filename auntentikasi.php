<?php
include "config.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sqlStatement = "SELECT * FROM user WHERE username='$username'";
$query = mysqli_query($conn, $sqlStatement);
$row = mysqli_fetch_assoc($query);
// print_r($row);

if ($row == "") { //username tidak ditemukan
    $errMsg = "Username tidak terdaftar!";
    header("location:login.php?errorMsg=$errMsg");
} else { //username ditemukan
    if (md5($password) == $row['password']) { //username dan password match
        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("location:index.php");
    } else {
        $errMsg = "Password salah!";
        header("location:login.php?errorMsg=$errMsg");
    }
}



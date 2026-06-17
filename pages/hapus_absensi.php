<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM absensi
WHERE id_absensi='$id'
");

header("Location: absensi.php");
exit;
?>
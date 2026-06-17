<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn,"SELECT * FROM kelas");
$total_kelas = mysqli_num_rows($data);

mysqli_data_seek($data,0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Kelas TPA</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5efff;
    font-family:'Segoe UI',sans-serif;
    overflow-x:hidden;
}

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#7b2ff7,#9d4edd);
    padding:25px;
    overflow-y:auto;
    z-index:999;
}

.sidebar h3{
    color:white;
    font-weight:bold;
    margin-bottom:30px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    margin-bottom:8px;
    border-radius:12px;
    transition:.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,.2);
}

.main{
    margin-left:250px;
    padding:25px;
    overflow-x:hidden;
}

.banner{
    background:white;
    border-radius:35px;
    overflow:hidden;
    box-shadow:0 15px 35px rgba(0,0,0,.08);
}

.banner img{
    width:100%;
    height:350px;
    object-fit:cover;
}

.banner-content{
    padding:25px 35px;
}

.banner-content h1{
    font-size:42px;
    font-weight:800;
    color:#6f2cff;
}

.banner-content p{
    color:#666;
    font-size:17px;
}

.info-card{
    background:white;
    border-radius:25px;
    padding:25px;
    text-align:center;
    box-shadow:0 10px 25px rgba(123,47,247,.10);
    transition:.3s;
}

.info-card:hover{
    transform:translateY(-6px);
}

.info-number{
    font-size:34px;
    font-weight:bold;
    color:#7b2ff7;
}

.section-title{
    margin-top:35px;
    margin-bottom:20px;
    font-size:28px;
    font-weight:700;
}

.class-card{
    background:white;
    border-radius:30px;
    padding:30px;
    height:100%;
    box-shadow:0 10px 25px rgba(123,47,247,.08);
    transition:.3s;
}

.class-card:hover{
    transform:translateY(-8px);
}

.class-title{
    color:#7b2ff7;
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
}

.class-item{
    margin-bottom:14px;
    color:#555;
    font-size:16px;
}

.badge-purple{
    background:#7b2ff7;
    color:white;
    padding:8px 15px;
    border-radius:30px;
}

.btn-purple{
    background:#7b2ff7;
    color:white;
    border:none;
    border-radius:15px;
    padding:10px 18px;
}

.btn-purple:hover{
    background:#6520dd;
    color:white;
}

</style>

</head>

<body>

<div class="sidebar">

<h3>💜 TPA Admin</h3>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="santri.php">👦 Data Santri</a>
<a href="kelas.php">📚 Data Kelas</a>
<a href="hafalan.php">📖 Hafalan</a>
<a href="absensi.php">📝 Absensi</a>
<a href="logout.php">🚪 Logout</a>

</div>

<div class="main">
    <!-- BANNER -->

<div class="banner">

<img src="../assets/kelas-banner.png">

<div class="banner-content">

<h1>📚 Data Kelas TPA</h1>

<p>
Kelola kelas, jadwal pembelajaran dan ruangan TPA
dalam satu sistem yang modern dan mudah digunakan.
</p>

</div>

</div>

<!-- INFO CARD -->

<div class="row mt-4">

<div class="col-lg-4 col-md-6 mb-4">

<div class="info-card">

<h5>Total Kelas</h5>

<div class="info-number">
<?= $total_kelas ?>
</div>

</div>

</div>

<div class="col-lg-4 col-md-6 mb-4">

<div class="info-card">

<h5>Status Sistem</h5>

<div class="info-number">
Aktif
</div>

</div>

</div>

<div class="col-lg-4 col-md-12 mb-4">

<div class="info-card">

<h5>Program</h5>

<div class="info-number">
TPA
</div>

</div>

</div>

</div>

<!-- DAFTAR KELAS -->

<h2 class="section-title">
✨ Daftar Kelas
</h2>

<div class="row">

<?php while($row=mysqli_fetch_assoc($data)) : ?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="class-card">

<div class="text-center mb-4">

<?php

$gambar = "class.png";

if($row['nama_kelas'] == "Iqro Dasar"){
    $gambar = "iqro-dasar.png";
}
elseif($row['nama_kelas'] == "Iqro Lanjutan"){
    $gambar = "iqro-lanjutan.png";
}
elseif($row['nama_kelas'] == "Tahfidz"){
    $gambar = "tahfidz.png";
}

?>

<img
src="../assets/<?= $gambar; ?>"
style="
width:110px;
height:110px;
object-fit:contain;
">

</div>

<div class="class-title">
<?= htmlspecialchars($row['nama_kelas']); ?>
</div>

<div class="class-item">
🕒 Jadwal :
<strong><?= htmlspecialchars($row['jadwal']); ?></strong>
</div>

<div class="class-item">
🏫 Ruangan :
<strong><?= htmlspecialchars($row['ruangan']); ?></strong>
</div>

<div class="class-item">
👨‍🎓 Status :
<strong>Aktif</strong>
</div>

<div class="mt-3">

<span class="badge-purple">
Kelas Aktif
</span>

</div>

</div>

</div>

<?php endwhile; ?>

</div>
<!-- PANEL INFORMASI -->

<div class="row mt-4">

<div class="col-lg-6 mb-4">

<div class="class-card">

<h4 class="mb-3">
📅 Jadwal Hari Ini
</h4>

<hr>

<p>
🕒 Iqro Dasar - Sabtu 08:00
</p>

<p>
🕒 Iqro Lanjutan - Sabtu 09:00
</p>

<p>
🕒 Tahfidz - Minggu 08:00
</p>

<div class="progress mt-4" style="height:12px;">

<div
class="progress-bar"
style="
width:85%;
background:linear-gradient(90deg,#7b2ff7,#c77dff);
">
</div>

</div>

<small class="text-muted">
85% Jadwal Pembelajaran Berjalan
</small>

</div>

</div>

<div class="col-lg-6 mb-4">

<div class="class-card">

<h4 class="mb-3">
📊 Ringkasan Kelas
</h4>

<hr>

<p>
📚 Total Kelas :
<strong><?= $total_kelas ?></strong>
</p>

<p>
👦 Santri Aktif :
<strong>6</strong>
</p>

<p>
✅ Semua kelas berjalan normal
</p>

<p>
🎯 Target Pembelajaran tercapai
</p>

<div class="progress mt-4" style="height:12px;">

<div
class="progress-bar bg-success"
style="width:92%;">
</div>

</div>

<small class="text-muted">
92% Target Pembelajaran
</small>

</div>

</div>

</div>

<!-- PROGRAM PEMBELAJARAN -->

<div class="banner mt-4">

<div class="banner-content">

<h3 style="
color:#7b2ff7;
font-weight:bold;
margin-bottom:20px;
">
🎓 Program Pembelajaran TPA
</h3>

<p style="
font-size:18px;
line-height:1.9;
color:#555;
margin-bottom:0;
">

Program pembelajaran TPA dirancang untuk membantu santri
mempelajari Al-Qur'an secara bertahap mulai dari pengenalan
huruf hijaiyah, membaca dengan tajwid yang benar, hingga
menghafal surat-surat Al-Qur'an.

Setiap kelas memiliki target pembelajaran yang berbeda sesuai
tingkat kemampuan santri sehingga proses belajar menjadi lebih
terarah, terukur, dan efektif dalam mencapai tujuan pendidikan
Islam yang berkualitas.

</p>


</div>

</div>

<!-- TOMBOL -->

<div class="mt-4 mb-4">

<a href="dashboard.php" class="btn btn-purple">
⬅ Kembali ke Dashboard
</a>

</div>

</div>

</body>
</html>
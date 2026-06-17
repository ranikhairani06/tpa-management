<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$santri = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM santri"));
$kelas = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM kelas"));
$hafalan = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM hafalan"));
$absensi = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM absensi"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Dashboard TPA</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4efff;
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
    margin-bottom:30px;
    font-weight:bold;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:12px;
    margin-bottom:8px;
    transition:.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,.2);
}

.main{
    margin-left:250px;
    padding:25px;
}

.hero{
    background:linear-gradient(135deg,#7b2ff7,#c77dff);
    border-radius:30px;
    padding:35px;
    color:white;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(123,47,247,.25);
}

.hero img{
    max-height:220px;
    object-fit:contain;
}

.hero h2{
    font-weight:bold;
}

.stat-card{
    border:none;
    border-radius:25px;
    overflow:hidden;
    background:white;
    box-shadow:0 10px 25px rgba(123,47,247,.12);
    transition:.3s;
    height:100%;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.stat-card img{
    width:100%;
    height:95px;
    object-fit:cover;
}

.stat-number{
    font-size:28px;
    font-weight:bold;
    color:#7b2ff7;
}

.table-box{
    background:white;
    border-radius:25px;
    padding:25px;
    margin-top:30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.quick-btn{
    border:none;
    border-radius:15px;
    padding:12px 20px;
    color:white;
    text-decoration:none;
    display:inline-block;
    margin:5px;
}

.btn-purple{
    background:#7b2ff7;
}

.btn-pink{
    background:#c77dff;
}

</style>
</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

<h3>💜 TPA Admin</h3>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="santri.php">👦 Data Santri</a>
<a href="kelas.php">📚 Data Kelas</a>
<a href="hafalan.php">📖 Hafalan</a>
<a href="absensi.php">📝 Absensi</a>
<a href="logout.php">🚪 Logout</a>

</div>

<!-- CONTENT -->

<div class="main">

<!-- HERO -->

<div class="hero">

<div class="row align-items-center">

<div class="col-md-7">

<h2>Assalamu'alaikum 👋</h2>

<h4><?= $_SESSION['username']; ?></h4>

<p>
Selamat datang di Sistem Manajemen TPA.
Kelola data santri, kelas, hafalan dan absensi dengan mudah.
</p>

<a href="santri.php" class="btn btn-light">
Kelola Data
</a>

</div>

<div class="col-md-5 text-center">

<img src="../assets/student.png" class="img-fluid">

</div>

</div>

</div>
<!-- CARD STATISTIK -->

<div class="row mt-4">

<div class="col-lg-3 col-md-6 mb-4">

<div class="card stat-card">

<img src="../assets/teacher.png">

<div class="card-body p-3">

<h5 class="fw-bold">👧 Data Santri</h5>

<p class="text-muted mb-2">
Total santri aktif
</p>

<div class="stat-number">
<?= $santri ?>
</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6 mb-4">

<div class="card stat-card">

<img src="../assets/class.png">

<div class="card-body p-3">

<h5 class="fw-bold">📚 Data Kelas</h5>

<p class="text-muted mb-2">
Jumlah kelas TPA
</p>

<div class="stat-number">
<?= $kelas ?>
</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6 mb-4">

<div class="card stat-card">

<img src="../assets/quran.png">

<div class="card-body p-3">

<h5 class="fw-bold">📖 Hafalan</h5>

<p class="text-muted mb-2">
Progress hafalan
</p>

<div class="stat-number">
<?= $hafalan ?>
</div>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6 mb-4">

<div class="card stat-card">

<img src="../assets/attendance.png">

<div class="card-body p-3">

<h5 class="fw-bold">📝 Absensi</h5>

<p class="text-muted mb-2">
Kehadiran santri
</p>

<div class="stat-number">
<?= $absensi ?>
</div>

</div>

</div>

</div>

</div>

<!-- QUICK ACCESS -->

<div class="table-box">

<h4 class="mb-3">⚡ Quick Access</h4>

<a href="santri.php" class="quick-btn btn-purple">
👦 Data Santri
</a>

<a href="kelas.php" class="quick-btn btn-pink">
📚 Data Kelas
</a>

<a href="hafalan.php" class="quick-btn btn-purple">
📖 Hafalan
</a>

<a href="absensi.php" class="quick-btn btn-pink">
📝 Absensi
</a>

</div>

<!-- DATA SANTRI TERBARU -->

<div class="table-box">

<div class="d-flex justify-content-between align-items-center mb-3">

<h4>📋 Data Santri Terbaru</h4>

<span class="badge bg-primary">
<?= $santri ?> Santri
</span>

</div>

<table class="table table-hover align-middle">

<thead class="table-light">

<tr>
<th>ID</th>
<th>Nama</th>
<th>JK</th>
<th>Alamat</th>
</tr>

</thead>

<tbody>

<?php

$data = mysqli_query($conn,"
SELECT * FROM santri
ORDER BY id_santri DESC
LIMIT 5
");

while($row=mysqli_fetch_assoc($data)){

?>

<tr>

<td>
<?= $row['id_santri']; ?>
</td>

<td>
<?= htmlspecialchars($row['nama_santri']); ?>
</td>

<td>

<?php if($row['jk']=='L'){ ?>

<span class="badge bg-primary">
Laki-Laki
</span>

<?php } else { ?>

<span class="badge bg-danger">
Perempuan
</span>

<?php } ?>

</td>

<td>
<?= htmlspecialchars($row['alamat']); ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- INFORMASI -->

<div class="table-box">

<h4 class="mb-3">📊 Ringkasan Sistem</h4>

<div class="row text-center">

<div class="col-md-3">
<h5 class="text-primary"><?= $santri ?></h5>
<small>Total Santri</small>
</div>

<div class="col-md-3">
<h5 class="text-success"><?= $kelas ?></h5>
<small>Total Kelas</small>
</div>

<div class="col-md-3">
<h5 class="text-warning"><?= $hafalan ?></h5>
<small>Data Hafalan</small>
</div>

<div class="col-md-3">
<h5 class="text-danger"><?= $absensi ?></h5>
<small>Data Absensi</small>
</div>

</div>

</div>

</div>

</body>
</html>
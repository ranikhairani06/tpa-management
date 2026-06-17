<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn,"
SELECT
h.id_hafalan,
s.nama_santri,
h.nama_surat,
h.ayat,
h.status
FROM hafalan h
JOIN santri s
ON h.id_santri = s.id_santri
");

$totalHafalan = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM hafalan
"));

$selesai = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM hafalan
WHERE status='Selesai'
"));

$proses = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM hafalan
WHERE status='Proses'
"));

$belum = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM hafalan
WHERE status='Belum'
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Hafalan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    background:#f5efff;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#7b2ff7,#9d4edd);
    padding:25px;
    overflow-y:auto;
    z-index:1000;
}

.sidebar h3{
    color:white;
    font-weight:700;
    margin-bottom:35px;
    white-space:nowrap;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:14px 18px;
    margin-bottom:10px;
    border-radius:14px;
    transition:.3s;
    font-size:18px;
}

.sidebar a:hover{
    background:rgba(255,255,255,.18);
}

.sidebar .active{
    background:rgba(255,255,255,.20);
}

/* CONTENT */

.main{
    margin-left:250px;
    padding:35px;
}

/* HEADER */

.top-header{
    background:white;
    border-radius:30px;
    padding:28px 35px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    margin-bottom:30px;
}

.top-header h1{
    margin:0;
    font-size:30px;
    font-weight:700;
    color:#222;
}

.top-header p{
    margin:5px 0 0;
    color:#777;
}

.admin-box{
    display:flex;
    align-items:center;
    gap:15px;
}

.admin-avatar{
    width:55px;
    height:55px;
    border-radius:50%;
    background:#7b2ff7;
    color:white;
    font-weight:bold;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:25px;
}

.admin-name{
    font-weight:700;
    font-size:18px;
}

/* HERO */

.hero{
    background:white;
    border-radius:35px;
    padding:45px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    margin-bottom:30px;
}

.hero h2{
    font-size:60px;
    font-weight:800;
    color:#222;
}

.hero p{
    font-size:20px;
    color:#666;
    margin-top:15px;
    margin-bottom:30px;
}

.hero-img{
    max-width:100%;
    height:280px;
    object-fit:contain;
}

.btn-purple{
    background:linear-gradient(135deg,#7b2ff7,#b86bff);
    border:none;
    color:white;
    padding:16px 28px;
    border-radius:18px;
    font-weight:600;
}

.btn-purple:hover{
    color:white;
}

/* STAT CARD */

.stat-card{
    background:white;
    border-radius:28px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    height:100%;
}

.stat-icon{
    width:70px;
    height:70px;
    border-radius:20px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:30px;
    margin-bottom:20px;
}

.icon-purple{
    background:#efe3ff;
}

.icon-green{
    background:#d8ffe7;
}

.icon-yellow{
    background:#fff7d6;
}

.icon-red{
    background:#ffdede;
}

.stat-title{
    color:#666;
    font-size:18px;
}

.stat-number{
    font-size:42px;
    font-weight:800;
    color:#222;
}
.stat-number{
    font-size:42px;
    font-weight:800;
    color:#222;
}



.summary-card{
    background:white;
    border-radius:28px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    height:100%;
}

.summary-card h3{
    font-weight:700;
    color:#222;
}

.progress{
    height:12px;
    border-radius:20px;
}

.progress-item span{
    font-weight:600;
}

.target-item{
    background:#f6f0ff;
    padding:12px 15px;
    border-radius:14px;
    margin-bottom:12px;
    font-weight:500;
}

.progress-box{
    margin-top:10px;
}
</style>
</head>
<body>

<div class="sidebar">

<h3>💜 TPA Admin</h3>

<a href="dashboard.php">🏠 Dashboard</a>
<a href="santri.php">👦 Data Santri</a>
<a href="kelas.php">📚 Data Kelas</a>
<a href="hafalan.php" class="active">📖 Hafalan</a>
<a href="absensi.php">📝 Absensi</a>
<a href="logout.php">🚪 Logout</a>

</div>

<div class="main">

<div class="top-header">

<div>

<h1>📖 Data Hafalan</h1>

<p>
Kelola dan pantau perkembangan hafalan santri
</p>

</div>

<div class="admin-box">

<div class="admin-avatar">
A
</div>

<div>

<div class="admin-name">
<?= $_SESSION['username']; ?>
</div>

<small class="text-muted">
Administrator
</small>

</div>

</div>

</div>

<div class="hero">

<div class="row align-items-center">

<div class="col-md-7">

<h2>
📖 Hafalan Santri
</h2>

<p>
Kelola progres hafalan, target surat,
dan perkembangan hafalan santri dengan mudah.
</p>

<a href="tambah_hafalan.php" class="btn btn-purple">
+ Tambah Hafalan
</a>

</div>

<div class="col-md-5 text-center">

<img
src="../assets/hafalan-banner.png"
class="hero-img">

</div>

</div>

</div>
<!-- STATISTIK -->

<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="stat-card">

<div class="stat-icon icon-purple">
📖
</div>

<div class="stat-title">
Total Hafalan
</div>

<div class="stat-number">
<?= $totalHafalan ?>
</div>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<div class="stat-icon icon-green">
✅
</div>

<div class="stat-title">
Selesai
</div>

<div class="stat-number">
<?= $selesai ?>
</div>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<div class="stat-icon icon-yellow">
🟡
</div>

<div class="stat-title">
Proses
</div>

<div class="stat-number">
<?= $proses ?>
</div>

</div>

</div>

<div class="col-md-3">

<div class="stat-card">

<div class="stat-icon icon-red">
🔴
</div>

<div class="stat-title">
Belum
</div>

<div class="stat-number">
<?= $belum ?>
</div>

</div>

</div>

</div>

<!-- RINGKASAN -->

<div class="row g-4 mb-4">

<div class="col-md-8">

<div class="summary-card">

<h3 class="mb-4">
📈 Progress Hafalan Santri
</h3>

<div class="progress-box">

<div class="progress-item">

<div class="d-flex justify-content-between">

<span>Al Fatihah</span>

<span>100%</span>

</div>

<div class="progress mt-2">

<div
class="progress-bar bg-success"
style="width:100%">
</div>

</div>

</div>

<div class="progress-item mt-4">

<div class="d-flex justify-content-between">

<span>An Nas</span>

<span>80%</span>

</div>

<div class="progress mt-2">

<div
class="progress-bar bg-warning"
style="width:80%">
</div>

</div>

</div>

<div class="progress-item mt-4">

<div class="d-flex justify-content-between">

<span>Al Ikhlas</span>

<span>55%</span>

</div>

<div class="progress mt-2">

<div
class="progress-bar"
style="
width:55%;
background:#7b2ff7;
">
</div>

</div>

</div>

<div class="progress-item mt-4">

<div class="d-flex justify-content-between">

<span>Al Falaq</span>

<span>35%</span>

</div>

<div class="progress mt-2">

<div
class="progress-bar bg-danger"
style="width:35%">
</div>

</div>

</div>

</div>

</div>

</div>

<div class="col-md-4">

<div class="summary-card">

<h3 class="mb-4">
🎯 Target Hafalan
</h3>

<div class="target-box">

<div class="target-item">
📖 Al Fatihah
</div>

<div class="target-item">
📖 An Nas
</div>

<div class="target-item">
📖 Al Ikhlas
</div>

<div class="target-item">
📖 Al Falaq
</div>

<div class="target-item">
📖 Al Kautsar
</div>

</div>



</div>

</div>

</div>
<!-- TABEL HAFALAN -->

<div class="summary-card mb-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<h3>
📋 Daftar Hafalan Santri
</h3>

<a href="tambah_hafalan.php" class="btn btn-purple">
+ Tambah Hafalan
</a>

</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>ID</th>
<th>Nama Santri</th>
<th>Surat</th>
<th>Ayat</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<tr>

<td>
<?= $row['id_hafalan']; ?>
</td>

<td>
<?= htmlspecialchars($row['nama_santri']); ?>
</td>

<td>
<?= htmlspecialchars($row['nama_surat']); ?>
</td>

<td>
<?= htmlspecialchars($row['ayat']); ?>
</td>

<td>

<?php if($row['status']=="Selesai"){ ?>

<span class="badge bg-success">
Selesai
</span>

<?php } elseif($row['status']=="Proses"){ ?>

<span class="badge bg-warning text-dark">
Proses
</span>

<?php } else { ?>

<span class="badge bg-danger">
Belum
</span>

<?php } ?>

</td>

<td>

<a
href="edit_hafalan.php?id=<?= $row['id_hafalan']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="hapus_hafalan.php?id=<?= $row['id_hafalan']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus data?')">
Hapus
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<!-- PANEL INFORMASI -->

<div class="summary-card mb-4">

<h3 class="mb-4">
📚 Informasi Hafalan
</h3>

<div class="row">

<div class="col-md-4">

<h5 style="color:#7b2ff7;">
🎯 Target Bulanan
</h5>

<p>
Menambah hafalan minimal
1 surat setiap bulan.
</p>

</div>

<div class="col-md-4">

<h5 style="color:#7b2ff7;">
📖 Program Tahfidz
</h5>

<p>
Membantu santri meningkatkan
hafalan Al-Qur'an secara bertahap.
</p>

</div>

<div class="col-md-4">

<h5 style="color:#7b2ff7;">
🏆 Evaluasi
</h5>

<p>
Monitoring hafalan dilakukan
secara berkala oleh ustadz/ustadzah.
</p>

</div>

</div>

</div>

<!-- TOMBOL KEMBALI -->

<div class="mb-4">

<a href="dashboard.php" class="btn btn-purple">
⬅ Kembali ke Dashboard
</a>

</div>

</div>

</body>
</html>
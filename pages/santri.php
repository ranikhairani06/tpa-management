<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn,"
SELECT
s.id_santri,
s.nama_santri,
s.jk,
s.alamat,
k.nama_kelas
FROM santri s
JOIN kelas k
ON s.id_kelas = k.id_kelas
");

$totalSantri = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM santri
"));

$laki = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM santri
WHERE jk='L'
"));

$perempuan = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM santri
WHERE jk='P'
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Santri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f6f2ff;
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
z-index:999;
}

.sidebar h3{
    color:white;
    margin-bottom:30px;
    font-weight:bold;
    font-size:26px;
    white-space:nowrap;
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

.sidebar a.active{
background:rgba(255,255,255,.25);
color:white;
}

.main{
margin-left:250px;
padding:30px;
}

.topbar{
background:white;
border-radius:25px;
padding:20px 30px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 10px 25px rgba(0,0,0,.05);
margin-bottom:25px;
}

.topbar h4{
margin:0;
font-weight:700;
}

.profile-box{
display:flex;
align-items:center;
gap:15px;
}
.page-title{
font-size:36px;
font-weight:800;
margin:0;
color:#222;
}

.page-subtitle{
margin-top:8px;
margin-bottom:0;
color:#777;
font-size:15px;
}

.profile-name{
font-size:22px;
font-weight:700;
}

.profile-role{
font-size:14px;
color:#888;
}
.profile-circle{
width:45px;
height:45px;
background:linear-gradient(135deg,#7b2ff7,#b56cff);
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-weight:bold;
}

.hero-card{
background:white;
border-radius:35px;
padding:35px;
box-shadow:0 15px 40px rgba(0,0,0,.06);
margin-bottom:25px;
}

.hero-card .row{
align-items:center;
}

.hero-title{
font-size:42px;
font-weight:700;
color:#222;
margin-bottom:10px;
}

.hero-subtitle{
color:#777;
font-size:16px;
margin-bottom:25px;
}

.hero-btn{
background:linear-gradient(135deg,#7b2ff7,#b56cff);
border:none;
padding:14px 25px;
border-radius:15px;
color:white;
font-weight:600;
text-decoration:none;
display:inline-block;
}

.hero-image{
text-align:center;
}

.hero-image img{
max-height:280px;
object-fit:contain;
}
.stats-row{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:25px;
}

.stat-card{
background:white;
border-radius:25px;
padding:25px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
transition:.3s;
}

.stat-card:hover{
transform:translateY(-6px);
}

.stat-icon{
width:55px;
height:55px;
border-radius:18px;
display:flex;
align-items:center;
justify-content:center;
font-size:24px;
margin-bottom:15px;
}

.icon-purple{
background:#efe6ff;
}

.icon-pink{
background:#ffe8f7;
}

.icon-blue{
background:#e8f4ff;
}

.icon-green{
background:#e7fff0;
}

.stat-label{
color:#777;
font-size:14px;
}

.stat-number{
font-size:34px;
font-weight:700;
color:#222;
}

.content-row{
display:grid;
grid-template-columns:1.2fr 1fr;
gap:25px;
margin-bottom:25px;
}

.panel{
background:white;
border-radius:30px;
padding:30px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.panel-title{
font-size:22px;
font-weight:700;
margin-bottom:20px;
color:#222;
}

.info-item{
display:flex;
justify-content:space-between;
padding:12px 0;
border-bottom:1px solid #eee;
}

.info-item:last-child{
border-bottom:none;
}

.progress{
height:10px;
border-radius:20px;
margin-top:8px;
}

.achievement-card{
background:linear-gradient(135deg,#7b2ff7,#b56cff);
color:white;
border-radius:25px;
padding:25px;
margin-bottom:15px;
}

.achievement-card h5{
font-weight:700;
margin-bottom:10px;
}

.achievement-card p{
margin:0;
opacity:.9;
}

.table-box{
background:white;
border-radius:30px;
padding:30px;
box-shadow:0 10px 25px rgba(0,0,0,.05);
}

.table-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
}

.table-title{
font-size:24px;
font-weight:700;
}

.btn-purple{
background:linear-gradient(135deg,#7b2ff7,#b56cff);
border:none;
color:white;
padding:12px 22px;
border-radius:15px;
font-weight:600;
}

.btn-purple:hover{
color:white;
}

.table{
vertical-align:middle;
}

.table thead{
background:#f3ecff;
}

.badge-l{
background:#7b2ff7;
padding:8px 12px;
}

.badge-p{
background:#ff4fd8;
padding:8px 12px;
}

@media(max-width:992px){

.main{
margin-left:0;
}

.sidebar{
display:none;
}

.stats-row{
grid-template-columns:repeat(2,1fr);
}

.content-row{
grid-template-columns:1fr;
}

}

@media(max-width:768px){

.stats-row{
grid-template-columns:1fr;
}

.hero-title{
font-size:30px;
}

}
</style>
</head>

<body>

<div class="sidebar">

<h3>💜 TPA Admin</h3>

<a href="dashboard.php">
🏠 Dashboard
</a>

<a href="santri.php" class="active">
👧 Data Santri
</a>

<a href="kelas.php">
📚 Data Kelas
</a>

<a href="hafalan.php">
📖 Hafalan
</a>

<a href="absensi.php">
📝 Absensi
</a>

<a href="logout.php">
🚪 Logout
</a>

</div>

<div class="main">

<div class="topbar">

<div>

<h2 class="page-title">
👧 Manajemen Data Santri
</h2>

<p class="page-subtitle">
Monitoring data santri, kelas, dan aktivitas pembelajaran TPA
</p>

</div>

<div class="profile-box">

<div class="profile-circle">
<?= strtoupper(substr($_SESSION['username'],0,1)); ?>
</div>

<div>

<div class="profile-name">
<?= $_SESSION['username']; ?>
</div>

<div class="profile-role">
Administrator
</div>

</div>

</div>

</div>

<div class="hero-card">

<div class="row">

<div class="col-md-7">

<div class="hero-title">
👧 Data Santri
</div>

<div class="hero-subtitle">
Kelola seluruh data santri dengan tampilan modern,
rapi dan mudah digunakan.
</div>

<a href="tambah_santri.php" class="hero-btn">
+ Tambah Santri
</a>

</div>

<div class="col-md-5 hero-image">

<img src="../assets/santri-banner.png">

</div>

</div>

</div>

<div class="stats-row">

<div class="stat-card">

<div class="stat-icon icon-purple">
👦
</div>

<div class="stat-label">
Total Santri
</div>

<div class="stat-number">
<?= $totalSantri ?>
</div>

</div>

<div class="stat-card">

<div class="stat-icon icon-blue">
👨
</div>

<div class="stat-label">
Laki-Laki
</div>

<div class="stat-number">
<?= $laki ?>
</div>

</div>

<div class="stat-card">

<div class="stat-icon icon-pink">
👧
</div>

<div class="stat-label">
Perempuan
</div>

<div class="stat-number">
<?= $perempuan ?>
</div>

</div>

<div class="stat-card">

<div class="stat-icon icon-green">
📚
</div>

<div class="stat-label">
Total Kelas
</div>

<div class="stat-number">
3
</div>

</div>

</div>
<div class="content-row">

<!-- PANEL STATISTIK -->

<div class="panel">

<div class="panel-title">
📊 Statistik Santri
</div>

<div class="info-item">
<span>Santri Aktif</span>
<strong><?= $totalSantri ?></strong>
</div>

<div class="progress">
<div class="progress-bar bg-success" style="width:100%"></div>
</div>

<div class="info-item">
<span>Kehadiran</span>
<strong>95%</strong>
</div>

<div class="progress">
<div class="progress-bar bg-primary" style="width:95%"></div>
</div>

<div class="info-item">
<span>Progress Hafalan</span>
<strong>82%</strong>
</div>

<div class="progress">
<div class="progress-bar bg-warning" style="width:82%"></div>
</div>

<div class="info-item">
<span>Kelulusan Target</span>
<strong>88%</strong>
</div>

<div class="progress">
<div class="progress-bar bg-info" style="width:88%"></div>
</div>

</div>

<!-- PANEL PRESTASI -->

<div class="panel">

<div class="panel-title">
🏆 Prestasi Santri
</div>

<div class="achievement-card">

<h5>
⭐ Santri Teraktif
</h5>

<p>
Kehadiran terbaik bulan ini
</p>

</div>

<div class="achievement-card">

<h5>
📖 Hafalan Terbaik
</h5>

<p>
Progress hafalan tercepat
</p>

</div>

<div class="achievement-card">

<h5>
🎯 Kelas Terfavorit
</h5>

<p>
Partisipasi santri tertinggi
</p>

</div>

</div>

</div>

<!-- TABEL -->

<div class="table-box">

<div class="table-header">

<div class="table-title">
📋 Daftar Santri
</div>

<a href="tambah_santri.php" class="btn btn-purple">
+ Tambah Santri
</a>

</div>

<table class="table table-hover">

<thead>

<tr>
<th>ID</th>
<th>Nama Santri</th>
<th>JK</th>
<th>Kelas</th>
<th>Alamat</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<tr>

<td>
<?= $row['id_santri']; ?>
</td>

<td>
<?= htmlspecialchars($row['nama_santri']); ?>
</td>

<td>

<?php if($row['jk']=='L'){ ?>

<span class="badge badge-l">
Laki-Laki
</span>

<?php } else { ?>

<span class="badge badge-p">
Perempuan
</span>

<?php } ?>

</td>

<td>
<?= htmlspecialchars($row['nama_kelas']); ?>
</td>

<td>
<?= htmlspecialchars($row['alamat']); ?>
</td>

<td>

<a
href="edit_santri.php?id=<?= $row['id_santri']; ?>"
class="btn btn-warning btn-sm">
Edit
</a>

<a
href="hapus_santri.php?id=<?= $row['id_santri']; ?>"
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

</body>
</html>
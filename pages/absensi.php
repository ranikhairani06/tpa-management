<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn,"
SELECT
a.id_absensi,
s.nama_santri,
a.tanggal,
a.status
FROM absensi a
JOIN santri s
ON a.id_santri = s.id_santri
ORDER BY a.id_absensi DESC
");

$totalAbsensi = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM absensi
"));

$hadir = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM absensi
WHERE status='Hadir'
"));

$izin = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM absensi
WHERE status='Izin'
"));

$sakit = mysqli_num_rows(mysqli_query($conn,"
SELECT * FROM absensi
WHERE status='Sakit'
"));

$persenHadir = 0;

if($totalAbsensi > 0){
    $persenHadir = round(($hadir/$totalAbsensi)*100);
}
$aktivitas = mysqli_query($conn,"
SELECT
a.status,
a.tanggal,
s.nama_santri
FROM absensi a
JOIN santri s
ON a.id_santri = s.id_santri
ORDER BY a.id_absensi DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Absensi Santri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    background:#f6f0ff;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
}

/* SIDEBAR */

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#7b2ff7,#9d4edd);
    padding:25px;
    overflow-y:auto;
    z-index:999;
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
    border-radius:14px;
    margin-bottom:10px;
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

.page-header{
    background:white;
    border-radius:30px;
    padding:30px;
    margin-bottom:30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.page-title{
    font-size:42px;
    font-weight:800;
    color:#222;
}

.page-subtitle{
    color:#777;
    font-size:17px;
}

.date-box{
    text-align:right;
}

.date-box h4{
    margin:0;
    color:#7b2ff7;
    font-weight:700;
}

.date-box p{
    margin:0;
    color:#777;
}

/* DASHBOARD CARD */

.dashboard-card{
    background:white;
    border-radius:30px;
    padding:30px;
    height:100%;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}
.row-equal{
    display:flex;
    align-items:stretch;
}
/* ATTENDANCE */

.attendance-percent{
    font-size:85px;
    font-weight:800;
    color:#7b2ff7;
    line-height:1;
}

.attendance-title{
    font-size:30px;
    font-weight:700;
}

.attendance-desc{
    color:#666;
}

/* CALENDAR */

.calendar-box{
    text-align:center;
}

.calendar-month{
    font-size:30px;
    font-weight:700;
    color:#7b2ff7;
}

.calendar-date{
    font-size:80px;
    font-weight:800;
    color:#222;
    line-height:1;
}

.calendar-day{
    color:#777;
    margin-top:10px;
}

/* STATUS CARD */

.status-card{
    background:white;
    border-radius:25px;
    padding:25px;
    text-align:center;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    transition:.3s;
}

.status-card:hover{
    transform:translateY(-5px);
}

.status-icon{
    font-size:38px;
}

.status-number{
    font-size:42px;
    font-weight:800;
    margin-top:10px;
}

.status-label{
    color:#777;
}

.green{
    color:#22c55e;
}

.yellow{
    color:#f59e0b;
}

.red{
    color:#ef4444;
}

/* TABLE */

.table-card{
    background:white;
    border-radius:30px;
    padding:30px;
    margin-top:30px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}
table th{
    border:none !important;
    color:#555;
    font-weight:700;
}

table td{
    vertical-align:middle;
}
.btn-purple{
    background:linear-gradient(135deg,#7b2ff7,#a855f7);
    border:none;
    color:white;
    padding:12px 24px;
    border-radius:15px;
    font-weight:600;
}

.btn-purple:hover{
    color:white;
}
.activity-item{
    transition:.3s;
}

.activity-item:hover{
    transform:translateX(5px);
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
<a href="absensi.php" class="active">📝 Absensi</a>
<a href="logout.php">🚪 Logout</a>

</div>

<!-- MAIN -->

<div class="main">

<!-- HEADER -->

<div class="page-header">

<div>

<div class="page-title">
📝 Absensi Santri
</div>

<div class="page-subtitle">
Monitoring kehadiran santri secara modern dan realtime
</div>

</div>

<div class="date-box">

<h4>
<?= date('d F Y'); ?>
</h4>

<p>
Hari Ini
</p>

</div>

</div>

<!-- OVERVIEW -->

<div class="row g-4">

<div class="col-lg-8">

<div class="dashboard-card">

<div class="attendance-title">
📊 Kehadiran Hari Ini
</div>

<p class="attendance-desc">
Persentase kehadiran santri berdasarkan data absensi yang tersedia.
</p>

<div class="attendance-percent">
<?= $persenHadir ?>%
</div>

<div class="progress mt-4" style="height:16px;border-radius:20px;">

<div
class="progress-bar"
style="
width:<?= $persenHadir ?>%;
background:linear-gradient(90deg,#7b2ff7,#c77dff);
">
</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="dashboard-card">

<div class="calendar-box">

<div class="calendar-month">
<?= date('F'); ?>
</div>

<div class="calendar-date">
<?= date('d'); ?>
</div>

<div class="calendar-day">
<?= date('l'); ?>
</div>

<hr>

<p class="text-muted mb-0">
📅 Jadwal Pembelajaran Aktif
</p>

</div>

</div>

</div>

</div>
<!-- STATUS CARD -->

<div class="row g-4 mt-1">

<div class="col-md-4">

<div class="status-card">

<div class="status-icon green">
🟢
</div>

<div class="status-number green">
<?= $hadir ?>
</div>

<div class="status-label">
Santri Hadir
</div>

</div>

</div>

<div class="col-md-4">

<div class="status-card">

<div class="status-icon yellow">
🟡
</div>

<div class="status-number yellow">
<?= $izin ?>
</div>

<div class="status-label">
Santri Izin
</div>

</div>

</div>

<div class="col-md-4">

<div class="status-card">

<div class="status-icon red">
🔴
</div>

<div class="status-number red">
<?= $sakit ?>
</div>

<div class="status-label">
Santri Sakit
</div>

</div>

</div>

</div>

<!-- AKTIVITAS TERBARU -->

<div class="row g-4 mt-2 row-equal">

<div class="col-lg-8">

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
📌 Aktivitas Absensi Terbaru
</h2>

<span class="badge bg-success">
Realtime
</span>

</div>

<?php while($a=mysqli_fetch_assoc($aktivitas)) : ?>

<div
class="activity-item d-flex justify-content-between align-items-center mb-3 p-3 rounded"
style="background:#f7f2ff;">

<div>

<h6 class="mb-1">

<?php
if($a['status']=="Hadir"){
    echo "🟢 ";
}
elseif($a['status']=="Izin"){
    echo "🟡 ";
}
else{
    echo "🔴 ";
}
?>

<?= htmlspecialchars($a['nama_santri']); ?>

</h6>

<small class="text-muted">
<?= date('d M Y',strtotime($a['tanggal'])); ?>
</small>

</div>

<div>

<?php if($a['status']=="Hadir"){ ?>

<span class="badge bg-success">
Hadir
</span>

<?php } elseif($a['status']=="Izin"){ ?>

<span class="badge bg-warning text-dark">
Izin
</span>

<?php } else { ?>

<span class="badge bg-danger">
Sakit
</span>

<?php } ?>

</div>

</div>

<?php endwhile; ?>
</div>

</div>
<div class="col-lg-4">

<div class="dashboard-card h-100">


<h3 class="mb-4">
🏆 Ringkasan Kehadiran
</h3>

<div class="mb-4">

<h1 style="
font-size:60px;
font-weight:800;
color:#7b2ff7;">
<?= $persenHadir ?>%
</h1>

<p class="text-muted">
Tingkat kehadiran santri
</p>

</div>

<hr>

<div class="d-flex justify-content-between mb-3">

<span>👦 Total Santri</span>

<strong>
<?= $totalAbsensi ?>
</strong>

</div>

<div class="d-flex justify-content-between mb-3">

<span>✅ Kehadiran</span>

<strong>
<?= $hadir ?>
</strong>

</div>

<div class="d-flex justify-content-between mb-3">

<span>📌 Izin</span>

<strong>
<?= $izin ?>
</strong>

</div>

<div class="d-flex justify-content-between">

<span>🤒 Sakit</span>

<strong>
<?= $sakit ?>
</strong>

</div>

</div>

</div>

</div>
<!-- TABEL ABSENSI -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>
📋 Data Absensi Santri
</h2>

<a href="tambah_absensi.php" class="btn btn-purple">
+ Tambah Absensi
</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>ID</th>
<th>Nama Santri</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php mysqli_data_seek($data,0); ?>

<?php while($row=mysqli_fetch_assoc($data)) : ?>

<tr>

<td>
<?= $row['id_absensi']; ?>
</td>

<td>
<?= htmlspecialchars($row['nama_santri']); ?>
</td>

<td>
<?= date('d M Y', strtotime($row['tanggal'])); ?>
</td>

<td>

<?php if($row['status']=="Hadir"){ ?>

<span class="badge bg-success">
Hadir
</span>

<?php } elseif($row['status']=="Izin"){ ?>

<span class="badge bg-warning text-dark">
Izin
</span>

<?php } else { ?>

<span class="badge bg-danger">
Sakit
</span>

<?php } ?>

</td>

<td>

<a
href="edit_absensi.php?id=<?= $row['id_absensi']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="hapus_absensi.php?id=<?= $row['id_absensi']; ?>"
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

<!-- INFORMASI ABSENSI -->

<div class="table-card mt-4">

<h2 class="mb-4">
📚 Informasi Absensi
</h2>

<div class="row">

<div class="col-md-4">

<div class="p-4 rounded"
style="background:#f7f2ff;">

<h4 style="color:#7b2ff7;">
🎯 Kehadiran
</h4>

<p class="mb-0">

Data kehadiran digunakan untuk
memantau kedisiplinan santri
setiap pertemuan pembelajaran.

</p>

</div>

</div>

<div class="col-md-4">

<div class="p-4 rounded"
style="background:#f7f2ff;">

<h4 style="color:#7b2ff7;">
📅 Monitoring
</h4>

<p class="mb-0">

Monitoring absensi dilakukan
oleh pengajar untuk memastikan
keaktifan santri.

</p>

</div>

</div>

<div class="col-md-4">

<div class="p-4 rounded"
style="background:#f7f2ff;">

<h4 style="color:#7b2ff7;">
🏆 Evaluasi
</h4>

<p class="mb-0">

Data absensi dapat digunakan
sebagai bahan evaluasi
pembelajaran santri.

</p>

</div>

</div>

</div>

</div>

<!-- QUICK ACTION -->

<div class="table-card mt-4">

<div class="row align-items-center">

<div class="col-md-8">

<h3>
⚡ Akses Cepat
</h3>

<p class="text-muted mb-0">

Kelola data absensi santri dengan cepat
melalui menu berikut.

</p>

</div>

<div class="col-md-4 text-end">

<a
href="dashboard.php"
class="btn btn-secondary">

Dashboard

</a>

<a
href="tambah_absensi.php"
class="btn btn-purple">

Tambah Data

</a>

</div>

</div>

</div>

</div>
<!-- END MAIN -->

</body>
</html>
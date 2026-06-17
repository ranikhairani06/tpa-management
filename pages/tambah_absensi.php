<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$santri = mysqli_query($conn,"
SELECT *
FROM santri
ORDER BY nama_santri ASC
");

if(isset($_POST['simpan'])){

    $id_santri = $_POST['id_santri'];
    $tanggal   = $_POST['tanggal'];
    $status    = $_POST['status'];

    mysqli_query($conn,"
    INSERT INTO absensi
    (
        id_santri,
        tanggal,
        status
    )
    VALUES
    (
        '$id_santri',
        '$tanggal',
        '$status'
    )
    ");

    header("Location: absensi.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Tambah Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header">

<h3>Tambah Absensi</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Nama Santri</label>

<select
name="id_santri"
class="form-control"
required>

<option value="">
-- Pilih Santri --
</option>

<?php while($s=mysqli_fetch_assoc($santri)) : ?>

<option value="<?= $s['id_santri']; ?>">

<?= $s['nama_santri']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="mb-3">

<label>Tanggal</label>

<input
type="date"
name="tanggal"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control"
required>

<option value="Hadir">Hadir</option>
<option value="Izin">Izin</option>
<option value="Sakit">Sakit</option>

</select>

</div>

<button
type="submit"
name="simpan"
class="btn btn-primary">

Simpan

</button>

<a
href="absensi.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>
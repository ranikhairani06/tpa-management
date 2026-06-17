<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT *
FROM absensi
WHERE id_absensi='$id'
");

$row = mysqli_fetch_assoc($data);

$santri = mysqli_query($conn,"
SELECT *
FROM santri
ORDER BY nama_santri ASC
");

if(isset($_POST['update'])){

    $id_santri = $_POST['id_santri'];
    $tanggal   = $_POST['tanggal'];
    $status    = $_POST['status'];

    mysqli_query($conn,"
    UPDATE absensi
    SET
        id_santri='$id_santri',
        tanggal='$tanggal',
        status='$status'
    WHERE id_absensi='$id'
    ");

    header("Location: absensi.php");
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Edit Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header">

<h3>Edit Absensi</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Nama Santri</label>

<select
name="id_santri"
class="form-control"
required>

<?php while($s=mysqli_fetch_assoc($santri)) : ?>

<option
value="<?= $s['id_santri']; ?>"
<?= ($s['id_santri']==$row['id_santri']) ? 'selected' : ''; ?>>

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
value="<?= $row['tanggal']; ?>"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control"
required>

<option
value="Hadir"
<?= ($row['status']=="Hadir") ? "selected" : ""; ?>>
Hadir
</option>

<option
value="Izin"
<?= ($row['status']=="Izin") ? "selected" : ""; ?>>
Izin
</option>

<option
value="Sakit"
<?= ($row['status']=="Sakit") ? "selected" : ""; ?>>
Sakit
</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn btn-success">

Update

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
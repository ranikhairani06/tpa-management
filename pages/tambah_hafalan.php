<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])){

    $id_santri = $_POST['id_santri'];
    $nama_surat = $_POST['nama_surat'];
    $ayat = $_POST['ayat'];
    $status = $_POST['status'];

    mysqli_query($conn,"
    INSERT INTO hafalan
    VALUES(
    NULL,
    '$id_santri',
    '$nama_surat',
    '$ayat',
    '$status'
    )
    ");

    echo "
    <script>
    alert('Data hafalan berhasil ditambahkan');
    document.location='hafalan.php';
    </script>
    ";
}

$santri = mysqli_query($conn,"
SELECT * FROM santri
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Tambah Hafalan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
Tambah Data Hafalan
</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Santri</label>

<select name="id_santri" class="form-control" required>

<option value="">
Pilih Santri
</option>

<?php while($s=mysqli_fetch_assoc($santri)){ ?>

<option value="<?= $s['id_santri']; ?>">
<?= $s['nama_santri']; ?>
</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label>Nama Surat</label>

<input
type="text"
name="nama_surat"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Ayat</label>

<input
type="text"
name="ayat"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="Belum">
Belum
</option>

<option value="Proses">
Proses
</option>

<option value="Selesai">
Selesai
</option>

</select>

</div>

<button
type="submit"
name="simpan"
class="btn btn-success">

Simpan

</button>

<a
href="hafalan.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>
</html>
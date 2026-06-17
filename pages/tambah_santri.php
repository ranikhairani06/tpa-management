<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];

    mysqli_query($conn,"
    INSERT INTO santri
    (nama_santri,jk,alamat,id_kelas)
    VALUES
    ('$nama','$jk','$alamat','$kelas')
    ");

    header("Location: santri.php");
    exit;
}

$kelas = mysqli_query($conn,"SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Santri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Tambah Santri</h2>

<form method="POST">

<div class="mb-3">
<label>Nama Santri</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Jenis Kelamin</label>

<select name="jk" class="form-control">

<option value="L">Laki-laki</option>
<option value="P">Perempuan</option>

</select>

</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Kelas</label>

<select name="kelas" class="form-control">

<?php while($k = mysqli_fetch_assoc($kelas)) : ?>

<option value="<?= $k['id_kelas']; ?>">
<?= $k['nama_kelas']; ?>
</option>

<?php endwhile; ?>

</select>

</div>

<button type="submit" name="simpan" class="btn btn-success">
Simpan
</button>

<a href="santri.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</body>
</html>
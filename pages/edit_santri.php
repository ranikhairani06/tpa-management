<?php
session_start();
include '../includes/config.php';

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT * FROM santri
WHERE id_santri='$id'
");

$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

$nama = $_POST['nama'];
$jk = $_POST['jk'];
$alamat = $_POST['alamat'];

mysqli_query($conn,"
UPDATE santri
SET
nama_santri='$nama',
jk='$jk',
alamat='$alamat'
WHERE id_santri='$id'
");

header("Location: santri.php");
exit;

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Santri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>Edit Santri</h2>

<form method="POST">

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= $row['nama_santri']; ?>"
>

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

<textarea
name="alamat"
class="form-control"
><?= $row['alamat']; ?></textarea>

</div>

<button
type="submit"
name="update"
class="btn btn-warning"
>
Update
</button>

<a href="santri.php" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</body>
</html>
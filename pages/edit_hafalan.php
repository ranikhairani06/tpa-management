<?php
session_start();
include '../includes/config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($conn,"
SELECT * FROM hafalan
WHERE id_hafalan='$id'
");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $nama_surat = $_POST['nama_surat'];
    $ayat       = $_POST['ayat'];
    $status     = $_POST['status'];

    mysqli_query($conn,"
    UPDATE hafalan
    SET
    nama_surat='$nama_surat',
    ayat='$ayat',
    status='$status'
    WHERE id_hafalan='$id'
    ");

    echo "
    <script>
    alert('Data berhasil diupdate');
    window.location='hafalan.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Edit Hafalan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5efff;
    font-family:'Poppins',sans-serif;
}

.container-box{
    max-width:700px;
    margin:50px auto;
}

.card-form{
    background:white;
    border-radius:25px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.title{
    font-size:32px;
    font-weight:700;
    color:#7b2ff7;
    margin-bottom:25px;
}

.form-control,
.form-select{
    border-radius:12px;
    padding:12px;
}

.btn-purple{
    background:linear-gradient(135deg,#7b2ff7,#b86bff);
    border:none;
    color:white;
    padding:12px 25px;
    border-radius:12px;
}

.btn-purple:hover{
    color:white;
}

</style>

</head>
<body>

<div class="container-box">

<div class="card-form">

<h2 class="title">
✏ Edit Hafalan
</h2>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Nama Surat
</label>

<input
type="text"
name="nama_surat"
class="form-control"
value="<?= $data['nama_surat']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Jumlah Ayat
</label>

<input
type="number"
name="ayat"
class="form-control"
value="<?= $data['ayat']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-select">

<option value="Belum"
<?= $data['status']=='Belum'?'selected':'' ?>>
Belum
</option>

<option value="Proses"
<?= $data['status']=='Proses'?'selected':'' ?>>
Proses
</option>

<option value="Selesai"
<?= $data['status']=='Selesai'?'selected':'' ?>>
Selesai
</option>

</select>

</div>

<button
type="submit"
name="update"
class="btn btn-purple">

💾 Simpan Perubahan

</button>

<a
href="hafalan.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</body>
</html>
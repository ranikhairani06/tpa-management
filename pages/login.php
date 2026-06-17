<?php
session_start();
include '../includes/config.php';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM users
    WHERE username='$username'
    AND password='$password'");

    $data = mysqli_fetch_assoc($query);

    if($data){

        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];

        header("Location: dashboard.php");
        exit;

    }else{

        echo "<script>
        alert('Username atau Password salah!');
        </script>";

    }

}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login Admin TPA</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#7b2ff7,#c77dff);
    font-family:'Segoe UI',sans-serif;
    overflow:hidden;
}

/* dekorasi background */

.circle1{
    position:absolute;
    width:250px;
    height:250px;
    background:rgba(255,255,255,.15);
    border-radius:50%;
    top:-80px;
    left:-80px;
}

.circle2{
    position:absolute;
    width:300px;
    height:300px;
    background:rgba(255,255,255,.1);
    border-radius:50%;
    bottom:-120px;
    right:-120px;
}

.login-card{

    width:950px;
    max-width:95%;

    background:rgba(255,255,255,.15);

    backdrop-filter:blur(15px);

    border-radius:35px;

    overflow:hidden;

    box-shadow:0 20px 50px rgba(0,0,0,.15);

}

.left-side{

    background:white;
    padding:40px;
    text-align:center;

}

.left-side img{

    width:260px;
    max-width:100%;
    margin-bottom:15px;

}

.left-side h2{

    color:#7b2ff7;
    font-weight:bold;

}

.left-side p{

    color:#777;

}

.right-side{

    padding:50px;
    color:white;

}

.right-side h1{

    font-weight:bold;
    margin-bottom:10px;

}

.right-side p{

    opacity:.9;
    margin-bottom:30px;

}

.form-control{

    border:none;
    border-radius:15px;
    padding:14px;

}

.input-group-text{

    border:none;
    border-radius:15px 0 0 15px;
    background:white;

}

.btn-login{

    background:white;
    color:#7b2ff7;
    border:none;
    border-radius:15px;
    padding:12px;
    font-weight:bold;
    transition:.3s;

}

.btn-login:hover{

    transform:translateY(-3px);

}

.footer-text{

    margin-top:20px;
    font-size:14px;
    opacity:.8;

}

@media(max-width:768px){

    .left-side{
        display:none;
    }

    .right-side{
        padding:30px;
    }

}

</style>

</head>

<body>

<div class="circle1"></div>
<div class="circle2"></div>

<div class="login-card">

<div class="row g-0">

<!-- GAMBAR -->

<div class="col-md-5 left-side">

<img src="../assets/login.png" alt="Login">

<h2>Sistem Manajemen TPA</h2>

<p>
Kelola data santri, kelas,
hafalan dan absensi dengan mudah.
</p>

</div>

<!-- FORM LOGIN -->

<div class="col-md-7 right-side">

<h1>💜 Login Admin</h1>

<p>
Selamat datang kembali.
Silakan masuk untuk melanjutkan.
</p>

<form method="POST">

<div class="mb-3">

<label class="mb-2">
Username
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa-solid fa-user"></i>
</span>

<input
type="text"
name="username"
class="form-control"
placeholder="Masukkan username"
required>

</div>

</div>

<div class="mb-4">

<label class="mb-2">
Password
</label>

<div class="input-group">

<span class="input-group-text">
<i class="fa-solid fa-lock"></i>
</span>

<input
type="password"
name="password"
class="form-control"
placeholder="Masukkan password"
required>

</div>

</div>

<button
type="submit"
name="login"
class="btn btn-login w-100">

Masuk ke Dashboard

</button>

</form>

<div class="footer-text text-center">

© 2026 Sistem Manajemen TPA

</div>

</div>

</div>

</div>

</body>
</html>
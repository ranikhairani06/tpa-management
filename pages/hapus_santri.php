<?php

include '../includes/config.php';

$id = $_GET['id'];

mysqli_query($conn,"
DELETE FROM santri
WHERE id_santri='$id'
");

header("Location: santri.php");
exit;

?>
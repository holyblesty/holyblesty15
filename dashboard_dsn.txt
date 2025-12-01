<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_dosen'])) {
    header("Location: home.html");
    exit;
}

$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen</title>
</head>
<body>

<!-- NAVBAR -->
<div style="margin-bottom: 15px;">
    <a href="dashboard_dsn.php">🏠 Dashboard</a> |
    <a href="portofolio_dsn.php">📁 Portofolio Mahasiswa</a> |
    <a href="logout.php">🚪 Logout</a>
</div>

<h2>Selamat datang, <?= $nama ?> (Dosen)</h2>
<p>Silakan pilih menu di atas.</p>

</body>
</html>

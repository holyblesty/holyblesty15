<?php
// simpan_nilai.php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_dosen'])) {
    header("Location: login_dsn.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard_dsn.php");
    exit;
}

$id = isset($_POST['id_portofolio']) ? (int)$_POST['id_portofolio'] : 0;
$nilai = isset($_POST['nilai']) ? (int)$_POST['nilai'] : null;

if ($id <= 0 || $nilai === null || $nilai < 0 || $nilai > 100) {
    echo "<script>alert('Data nilai tidak valid'); window.history.back();</script>";
    exit;
}

// update nilai
$sql = "UPDATE portofolio SET nilai = ? WHERE id_portofolio = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $nilai, $id);
$ok = $stmt->execute();

if ($ok) {
    echo "<script>alert('Nilai berhasil disimpan'); window.location='portofolio_detail.php?id={$id}';</script>";
} else {
    echo "<script>alert('Gagal menyimpan nilai'); window.history.back();</script>";
}
?>

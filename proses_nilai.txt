<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_dosen'])) {
    header("Location: home.html");
    exit;
}

$id_portofolio = $_POST['id_portofolio'];
$nilai         = $_POST['nilai'];
$catatan       = $_POST['catatan'];
$id_dosen      = $_SESSION['id_dosen'];

// cek apakah sudah ada nilai sebelumnya
$cek = $conn->prepare("SELECT id_nilai FROM nilai WHERE id_portofolio = ?");
$cek->bind_param("i", $id_portofolio);
$cek->execute();
$hasil = $cek->get_result();

if ($hasil->num_rows > 0) {
    // UPDATE nilai
    $sql = "UPDATE nilai 
            SET nilai = ?, catatan = ?, tanggal_penilaian = NOW() 
            WHERE id_portofolio = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $nilai, $catatan, $id_portofolio);
    $stmt->execute();

} else {
    // INSERT nilai baru
    $sql = "INSERT INTO nilai (id_portofolio, id_dosen, nilai, catatan, tanggal_penilaian)
            VALUES (?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $id_portofolio, $id_dosen, $nilai, $catatan);
    $stmt->execute();
}

header("Location: portofolio_dsn.php");
exit;
?>

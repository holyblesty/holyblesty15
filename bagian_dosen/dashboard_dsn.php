<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_dosen'])) {
    header("Location: home.html");
    exit;
}

if (!isset($_GET['id_portofolio'])) {
    echo "ID Portofolio tidak ditemukan!";
    exit;
}

$id_portofolio = $_GET['id_portofolio'];

$sql = "SELECT p.*, m.nama 
        FROM portofolio p
        JOIN login_mhs m ON m.id_mahasiswa = p.id_mahasiswa
        WHERE p.id_portofolio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_portofolio);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<h2>Beri Nilai</h2>

<form action="proses_nilai.php" method="POST">
    <input type="hidden" name="id_portofolio" value="<?= $data['id_portofolio'] ?>">

    Nama Mahasiswa:<br>
    <input type="text" value="<?= $data['nama'] ?>" readonly><br><br>

    Judul Proyek:<br>
    <input type="text" value="<?= $data['judul'] ?>" readonly><br><br>

    Nilai:<br>
    <input type="number" name="nilai" min="0" max="100" required><br><br>

    Catatan:<br>
    <textarea name="catatan" rows="4"></textarea><br><br>

    <button type="submit">Simpan Nilai</button>
</form>

<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: home.html");
    exit;
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

// Ambil semua portofolio milik mahasiswa beserta nilai
$sql = "SELECT portofolio.judul, nilai.nilai, nilai.catatan, nilai.tanggal_penilaian
        FROM portofolio
        LEFT JOIN nilai ON portofolio.id_portofolio = nilai.id_portofolio
        WHERE portofolio.id_mahasiswa = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mahasiswa);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Nilai Proyek Anda</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Judul Proyek</th>
        <th>Nilai</th>
        <th>Catatan</th>
        <th>Tanggal Penilaian</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['nilai'] ?: '-' ?></td>
            <td><?= $row['catatan'] ?: '-' ?></td>
            <td><?= $row['tanggal_penilaian'] ?: '-' ?></td>
        </tr>
    <?php } ?>
</table>

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
    <title>Portofolio Mahasiswa</title>
</head>
<body>

<!-- NAVBAR -->
<div style="margin-bottom: 15px;">
    <a href="dashboard_dsn.php">🏠 Dashboard</a> |
    <a href="portofolio_dsn.php">📁 Portofolio Mahasiswa</a> |
    <a href="logout.php">🚪 Logout</a>
</div>

<h3>Daftar Portofolio Mahasiswa</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama Mahasiswa</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Repo</th>
        <th>Nilai</th>
        <th>Aksi</th>
    </tr>

<?php
$sql = "SELECT 
            p.*, 
            m.nama AS nama_mahasiswa,
            n.nilai
        FROM portofolio p
        INNER JOIN login_mhs m ON m.id_mahasiswa = p.id_mahasiswa
        LEFT JOIN nilai n ON n.id_portofolio = p.id_portofolio
        ORDER BY p.judul ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

while ($p = $result->fetch_assoc()) {
?>
    <tr>
        <td><?= $p['nama_mahasiswa'] ?></td>
        <td><?= $p['judul'] ?></td>
        <td><?= $p['deskripsi'] ?></td>
        <td><a href="<?= $p['repo_link'] ?>" target="_blank">Buka Repo</a></td>
        <td><?= $p['nilai'] !== null ? $p['nilai'] : "Belum Dinilai" ?></td>

        <td>
            <?php if ($p['nilai'] === null): ?>
                <a href="beri_nilai.php?id=<?= $p['id_portofolio'] ?>">📝 Beri Nilai</a>
            <?php else: ?>
                <a href="edit_nilai.php?id=<?= $p['id_portofolio'] ?>">✏ Edit Nilai</a>
            <?php endif; ?>
        </td>
    </tr>
<?php } ?>

</table>

</body>
</html>

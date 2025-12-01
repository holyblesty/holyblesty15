<?php
session_start();
include "koneksi.php";

// Cek login mahasiswa
if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: home.html");
    exit;
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];
$nama = $_SESSION['nama'];
// ============= AKSES OTOMATIS HANYA KE PORTOFOLIO MILIKNYA =============

// menggunakan daftar user portofolio dari file "users.php" tadi
include "users.php";  // <-- file berisi array users NIM → proyek

$nim = $_SESSION['username']; // username yang digunakan login = NIM mahasiswa

// Cek apakah NIM ada dalam daftar user
if(isset($users[$nim])){

    // ambil halaman portofolio milik mahasiswa tersebut
    $halaman_portofolio = $users[$nim]['projek'];

    // Redirect otomatis ke halaman portofolio mereka
    header("Location: " . $halaman_portofolio);
    exit;
} else {
    echo "<h3>⚠ Portofolio belum terdaftar untuk akun ini</h3>";
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
</head>
<body>

<h2>Selamat datang, <?= $nama ?> (Mahasiswa)</h2>
<a href="logout.php">Logout</a>

<hr>

<h3>Proyek Portofolio Anda</h3>
<a href="tambah_portofolio.php">➕ Tambah Proyek Baru</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Repo</th>
        <th>Nilai</th>
        <th>Aksi</th>
    </tr>

<?php
$sql = "SELECT portofolio.*, nilai.nilai
        FROM portofolio
        LEFT JOIN nilai ON nilai.id_portofolio = portofolio.id_portofolio
        WHERE portofolio.id_mahasiswa = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_mahasiswa);
$stmt->execute();
$result = $stmt->get_result();

while ($p = $result->fetch_assoc()) {
?>
    <tr>
        <td><?= $p['judul'] ?></td>
        <td><?= $p['deskripsi'] ?></td>
        <td><img src="uploads/<?= $p['gambar'] ?>" width="120"></td>
        <td><a href="<?= $p['repo_link'] ?>" target="_blank">Buka Repo</a></td>
        <td><?= $p['nilai'] !== null ? $p['nilai'] : "Belum Dinilai" ?></td>

        <td>
            <a href="edit_portofolio.php?id=<?= $p['id_portofolio'] ?>">✏ Edit</a> |
            <a href="hapus_portofolio.php?id=<?= $p['id_portofolio'] ?>"
               onclick="return confirm('Hapus proyek ini?')">🗑 Hapus</a>
        </td>
    </tr>
<?php } ?>

</table>

<br>
<a href="lihat_nilai.php">📊 Lihat Detail Nilai</a>

</body>
</html>

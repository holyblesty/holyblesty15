<?php
session_start();
include "koneksi.php";

// ======================
// Daftar user dan projek
// ======================
$users = [
    "3312511001" => [
        "nama"=>"Muhammad Kevin Fadillah",
        "projek"=>"buku-tamu-tata-usaha.html",
        "id_portofolio"=>1
    ],
    "3312511002" => [
        "nama"=>"aliya putri ramadhani",
        "projek"=>"buku-tamu-tata-usaha.html",
        "id_portofolio"=>2
    ],
    "3312511004" => [
        "nama"=>"muhammad subhan fajriansyah",
        "projek"=>"pengelolaan-rapat.html",
        "id_portofolio"=>3
    ],
      "3312511005" => [
        "nama"=>"muhammad farhan",
        "projek"=>"pengelolaan-rapat.html",
        "id_portofolio"=>4
    ],
      "3312511006"	=> [
        "nama"=>"firnanda habib nur afian",
        "proyek"=>"pengelolaan-rapat.html",
        "id_portofolio"=>5
    ],
      "3312511007"  => [
        "nama"=>"muhammad yasir",
        "proyek"=>"pengelolaan-rapat.html",
        "id_portofolio"=>6
    ],
      "3312512008" => [
        "nama"=>"Andi Lumbangaol",
        "projek"=>"pencatatan-notulen.html",
        "id_portofolio"=>7
    ],
      "3312512009" => [
        "nama"=>"Nalita Nurul",
        "projek"=>"pencatatan-notulen.html",
        "id_portofolio"=>8
    ],
      "3312511010" => [
        "nama"=>"dody sinaga",
        "proyek"=>"pencatatan-notulen.html",
        "id_portofolio"=>9
    ],
      "3312511011" => [
        "nama"=>"muhammad mu'as",
        "proyek"=>"pencatatan-notulen.html",
        "id_portofolio"=>10
    ],
    "3312511012" => [
        "nama"=>"divani putri olivia hutagaol",
        "proyek"=>"pengelolaan-surat-peringatan-sp.html",
        "id_portofolio"=>11
    ],
    "3312511013" => [
        "nama"=>"yoga putra agusetiawan",
        "proyek"=>"pengelolaan-surat-peringatan-sp.html",
        "id_portofolio"=>12
    ],
    "3312511014" => [
        "nama"=>"m.khairil candra",
        "proyek"=>"pengelolaan-surat-peringatan-sp.html",
        "id_portofolio"=>13
    ],
    "3312511015" => [
        "nama"=>"qoonitah novia damayanti",
        "proyek"=>"pengelolaan-surat-peringatan-sp.html",
        "id_portofolio"=>14
    ],
    "3312511019" => [
        "nama"=>"afdal rahman hakim",
        "proyek"=>"jadwal-perkuliahan-mahasiswa-(pribadi).html",
        "id_portofolio"=>15
    ],
    "3312511020" => [
        "nama"=>"muhammad fachri sulthani",
        "proyek"=>"jadwal-perkuliahan-mahasiswa-(pribadi).html",
        "id_portofolio"=>16
    ],
    "3312511022" => [
        "nama"=>"intan rahmadani putri",
        "proyek"=>"jadwal-perkuliahan-mahasiswa-(pribadi).html",
        "id_portofolio"=>17
    ],
    "3312511023" => [
        "nama"=>"adetyas fauzia",
        "proyek"=>"web-informasi-event-kampus.html",
        "id_portofolio"=>18
    ],
    "3312511024" => [
        "nama"=>"lusiana hotmauli panggabean",
        "proyek"=>"web-informasi-event-kampus.html",
        "id_portofolio"=>19
    ],
    "3312511025" => [
        "nama"=>"maria putri agustina tamba",
        "proyek"=>"web-informasi-event-kampus.html",
        "id_portofolio"=>20
    ],
    "3312511026" => [
        "nama"=>"aldi ernando firmansyah",
        "proyek"=>"web-informasi-event-kampus.html",
        "id_portofolio"=>21
    ],
    "3312511027" => [
        "nama"=>"muhammad rafif akmal",
        "proyek"=>"aplikasi-pengumuman-akademik-online.html",
        "id_portofolio"=>22
    ],
    "3312511028" => [
        "nama"=>"juni friskenny sinaga",
        "proyek"=>"aplikasi-pengumuman-akademik-online.html",
        "id_portofolio"=>23
    ],
    "3312511029" => [
        "nama"=>"muhamad restu putra",
        "proyek"=>"aplikasi-pengumuman-akademik-online.html",
        "id_portofolio"=>24
    ],
    "3312511030" => [
        "nama"=>"dita indriyan",
        "proyek"=>"aplikasi-pengumuman-akademik-online.html",
        "id_portofolio"=>25
    ],
];
// ======================
// Pengecekan Hak Akses (TANPA MENGUBAH KODEMU YANG ADA)
// ======================

// memastikan user login sebagai mahasiswa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    die("❌ Anda tidak memiliki akses. Login sebagai mahasiswa terlebih dahulu.");
}

// memastikan NIM terdaftar di daftar users
if (!isset($users[$_SESSION['username']])) {
    die("❌ Portofolio untuk akun ini tidak ditemukan!");
}

// memastikan mahasiswa hanya bisa membuka portofolionya sendiri
if (isset($_GET['id']) && $_GET['id'] != $users[$_SESSION['username']]['id_portofolio']) {
    die("❌ Anda tidak boleh membuka portofolio milik mahasiswa lain!");
}

// ======================
// Cek login mahasiswa
// ======================
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: dashboard_mhs.php");
    exit;
}

// ======================
// Ambil ID portofolio dari GET
// ======================
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("ID portofolio tidak valid.");
}

// ======================
// Proteksi mahasiswa hanya bisa edit portofolio sendiri
// ======================
$username = $_SESSION['username'];
if (!isset($users[$username])) {
    die("Akses ditolak!");
}

$userPortofolio = $users[$username]['id_portofolio'];
if ($id !== $userPortofolio) {
    die("Anda tidak memiliki akses ke portofolio ini!");
}

// ======================
// Ambil data portofolio dari DB
// ======================
$sql = "SELECT * FROM portofolio WHERE id_portofolio = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows !== 1) {
    die("Data portofolio tidak ditemukan.");
}
$data = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Edit Portofolio #<?= $data['id_portofolio'] ?></title>
  <style>body{font-family:Arial;margin:20px} img.full{max-width:100%;height:auto}</style>
</head>
<body>
  <a href="dashboard_mhs.php">← Kembali</a> | <a href="logout.php">Logout</a>

  <h2>Edit Portofolio</h2>
  <form action="simpan_portofolio.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_portofolio" value="<?= $data['id_portofolio'] ?>">

    <label>Judul:</label><br>
    <input type="text" name="judul" required value="<?= htmlspecialchars($data['judul']) ?>"><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea><br><br>

    <label>Gambar Saat Ini:</label><br>
    <?php if (!empty($data['gambar'])): ?>
      <img src="<?= htmlspecialchars($data['gambar']) ?>" class="full" alt="gambar"><br>
    <?php else: ?>
      Tidak ada gambar.<br>
    <?php endif; ?>
    <label>Ganti Gambar:</label><br>
    <input type="file" name="gambar"><br><br>

    <label>Link Repository:</label><br>
    <input type="text" name="repo_link" value="<?= htmlspecialchars($data['repo_link']) ?>"><br><br>

    <button type="submit">Simpan Perubahan</button>
  </form>
</body>
</html>

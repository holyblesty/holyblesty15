<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id_mahasiswa'])){
    header("Location: login_mhs.php");
    exit();
}

$id_mhs = $_SESSION['id_mahasiswa'];

if(isset($_POST['tambah'])){
    $judul     = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar    = $_POST['gambar'];
    $repo      = $_POST['repo'];

    mysqli_query($koneksi, 
        "INSERT INTO portofolio(id_mahasiswa, judul, deskripsi, gambar, repo_link)
         VALUES('$id_mhs','$judul','$deskripsi','$gambar','$repo')");

    header("Location: dashboard_mhs.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Tambah Proyek</title></head>
<body>

<h2>Tambah Proyek</h2>

<form method="POST">
    Judul:<br>
    <input type="text" name="judul" required><br><br>

    Deskripsi:<br>
    <textarea name="deskripsi" required></textarea><br><br>

    Link Gambar:<br>
    <input type="text" name="gambar"><br><br>

    Repo Link:<br>
    <input type="text" name="repo"><br><br>

    <button type="submit" name="tambah">Simpan</button>
</form>

</body>
</html>

<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id_mahasiswa'])){
    header("Location: login_mhs.php");
    exit();
}

$id_mhs = $_SESSION['id_mahasiswa'];
$id     = $_GET['id'];

$q = mysqli_query($koneksi,
    "SELECT * FROM portofolio 
     WHERE id_portofolio='$id' AND id_mahasiswa='$id_mhs'");

$data = mysqli_fetch_assoc($q);

if(!$data){
    die("Akses ditolak!");
}

if(isset($_POST['edit'])){
    mysqli_query($koneksi,
        "UPDATE portofolio SET
            judul='$_POST[judul]',
            deskripsi='$_POST[deskripsi]',
            gambar='$_POST[gambar]',
            repo_link='$_POST[repo]'
         WHERE id_portofolio='$id'");

    header("Location: dashboard_mhs.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Edit Proyek</title></head>
<body>

<h2>Edit Proyek</h2>

<form method="POST">
    Judul:<br>
    <input type="text" name="judul" value="<?= $data['judul']; ?>"><br><br>

    Deskripsi:<br>
    <textarea name="deskripsi"><?= $data['deskripsi']; ?></textarea><br><br>

    Link Gambar:<br>
    <input type="text" name="gambar" value="<?= $data['gambar']; ?>"><br><br>

    Repo Link:<br>
    <input type="text" name="repo" value="<?= $data['repo_link']; ?>"><br><br>

    <button type="submit" name="edit">Update</button>
</form>

</body>
</html>

<?php
session_start();
include "koneksi.php";

// Pastikan data dikirim dari form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: home.html");
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';   // ← dari hidden input

// Cek role kosong?
if ($role === "") {
    echo "<script>alert('Role login tidak ditemukan!'); window.location='home.html';</script>";
    exit;
}

/* ==============================================
   LOGIN DOSEN
   Tabel: login_dsn
   Kolom: id_dosen, nama, username, password
================================================= */
if ($role === "dosen") {

    $sql = "SELECT * FROM login_dsn 
            WHERE username = ? AND password = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {

        $row = $res->fetch_assoc();

        $_SESSION['id_dosen'] = $row['id_dosen'];
        $_SESSION['nama']     = $row['nama'];
        $_SESSION['username'] = $row['username'];

        header("Location: dashboard_dsn.php");
        exit;

    } else {
        echo "<script>alert('Login dosen gagal! Cek username/password.'); window.location='home.html';</script>";
        exit;
    }
}


/* ==============================================
   LOGIN MAHASISWA
   Tabel: login_mhs
   Kolom: id_mahasiswa, nama, username, password
================================================= */
if ($role === "mahasiswa") {

    $sql = "SELECT * FROM login_mhs 
            WHERE username = ? AND password = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {

        $row = $res->fetch_assoc();

        $_SESSION['id_mahasiswa'] = $row['id_mahasiswa'];
        $_SESSION['nama']         = $row['nama'];
        $_SESSION['username']     = $row['username'];

        header("Location: dashboard_mhs.php");
        exit;

    } else {
        echo "<script>alert('Login mahasiswa gagal! Cek username/password.'); window.location='home.html';</script>";
        exit;
    }
}


// Jika role tidak valid
echo "<script>alert('Role login tidak dikenali!'); window.location='home.html';</script>";
exit;

?>

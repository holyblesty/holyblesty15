<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: home.html");
    exit;
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];
$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <style>
        /* —— seluruh css asli kamu tetap —— */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body { background-color: #f5f5f5; color: #333; line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #FD5DA8, #e11584); color: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header h2 { margin-bottom: 10px; font-size: 28px; }
        .nav-bar { background: white; padding: 15px 20px; border-radius: 10px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

        .nav-links a {
            color: #e11584;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: 600;
        }

        .nav-links a:hover { background-color: #ffe4f3; }
        .nav-links .logout { background-color: #e11584; color: white; }
        .nav-links .logout:hover { background-color: #c91073; }
        .content { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .content h3 { color: #e11584; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #ffe4f3; }

        .btn-primary {
            background-color: #e11584; color: white; padding: 10px 20px;
            border: none; border-radius: 5px; text-decoration: none;
            display: inline-block; margin-bottom: 20px; transition: 0.3s;
            cursor: pointer;
        }

        .btn-primary:hover { background-color: #c91073; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #FD5DA8; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        tr:hover { background-color: #f9f9f9; }
        .aksi-link { color: #e11584; text-decoration: none; margin-right: 10px; padding: 5px 10px; border-radius: 3px; transition: 0.3s; }
        .aksi-link:hover { background-color: #ffe4f3; }
        .no-data { text-align: center; padding: 40px; color: #666; font-style: italic; }
        .img-preview { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 2px solid #ffe4f3; }
        .btn-secondary { background-color: #6c757d; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; display: inline-block; margin-top: 20px; }
        .btn-secondary:hover { background-color: #5a6268; }

        .alert {
            padding: 15px;
            background-color: #ffe4f3;
            border-left: 4px solid #e11584;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>Selamat datang, <?= htmlspecialchars($nama) ?> 👋</h2>
            <p>Mahasiswa - Sistem Portofolio PBL</p>
        </div>
        
        <div class="nav-bar">
            <div><strong>Dashboard Mahasiswa</strong></div>
            <div class="nav-links">
                <a href="dashboard_mhs.php">🏠 Dashboard</a>
                <a href="lihat_nilai.php">📊 Nilai</a>
                <a href="logout.php" class="logout">🚪 Logout</a>
            </div>
        </div>
        
        <div class="content">
            <h3>📁 Proyek Portofolio Anda</h3>
            
            <a href="portofolio_detail.php" class="btn-primary">➕ Tambah Proyek Baru</a>
            
            <?php
            $sql = "SELECT p.*, n.nilai, n.catatan 
                    FROM portofolio p
                    LEFT JOIN nilai n ON n.id_portofolio = p.id_portofolio
                    WHERE p.id_mahasiswa = ?
                    ORDER BY p.id_portofolio DESC";
            
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $id_mahasiswa);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                echo '<div class="alert">';
                echo '<p>Belum ada proyek portofolio. Mulailah dengan menambahkan proyek pertama Anda!</p>';
                echo '</div>';
            } else {
            ?>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Proyek</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Repository</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($p = $result->fetch_assoc()) {
                        $nilai_display = ($p['nilai'] !== null) ? $p['nilai'] : '<span style="color:#888;">Belum Dinilai</span>';
                        $gambar_src = (!empty($p['gambar']) && file_exists("uploads/" . $p['gambar'])) ? 
                                      "uploads/" . $p['gambar'] : "assets/no-image.jpg";
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= htmlspecialchars($p['judul']) ?></strong></td>
                        <td><?= htmlspecialchars(substr($p['deskripsi'], 0, 100)) ?>...</td>
                        <td>
                            <?php if (file_exists($gambar_src)): ?>
                                <img src="<?= $gambar_src ?>" alt="Gambar proyek" class="img-preview">
                            <?php else: ?>
                                <span style="color:#888;">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($p['repo_link'])): ?>
                                <a href="<?= htmlspecialchars($p['repo_link']) ?>" target="_blank" style="color:#e11584;">🔗 Buka</a>
                            <?php else: ?>
                                <span style="color:#888;">-</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= $nilai_display ?></strong></td>
                        <td>
                            <a href="portofolio_detail.php?id=<?= $p['id_portofolio'] ?>" class="aksi-link">✏ Edit</a>
                            <a href="portofolio_detail.php?id=<?= $p['id_portofolio'] ?>" 
                               onclick="return confirm('Yakin menghapus proyek ini?')" 
                               class="aksi-link" style="color:#dc3545;">🗑 Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php } ?>
            
            <br>
            <a href="lihat_nilai.php" class="btn-secondary">📊 Lihat Detail Nilai & Catatan Dosen</a>
        </div>
    </div>

</body>
</html>

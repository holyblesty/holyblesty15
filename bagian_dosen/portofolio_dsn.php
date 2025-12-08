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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Mahasiswa - Dosen</title>
    
    <!-- BOOTSTRAP CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Nunito:wght@500;600&display=swap" rel="stylesheet">
    
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f9f0f5;
            font-family: 'Poppins', sans-serif;
            color: #333;
            padding-top: 80px;
        }
        
        /* NAVBAR DOSEN */
        .navbar-dosen {
            background: linear-gradient(135deg, #e11584, #d10b73) !important;
            box-shadow: 0 2px 10px rgba(225, 21, 132, 0.2);
        }
        
        .navbar-dosen .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .navbar-dosen .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .navbar-dosen .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .navbar-dosen .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
        }
        
        /* HEADER */
        .header-dosen {
            background: linear-gradient(135deg, #e11584, #d10b73);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(225, 21, 132, 0.2);
        }
        
        /* STATS CARDS */
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(225, 21, 132, 0.1);
            text-align: center;
            transition: transform 0.3s;
            border: 1px solid #ffe4f3;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(225, 21, 132, 0.2);
        }
        
        .stat-icon {
            font-size: 40px;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #e11584, #ff69b4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #e11584;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        
        /* TABLE */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(225, 21, 132, 0.1);
            border: 1px solid #ffe4f3;
        }
        
        .table thead {
            background: linear-gradient(135deg, #e11584, #d10b73);
        }
        
        .table thead th {
            color: white;
            border: none;
            padding: 18px 15px;
            font-weight: 600;
        }
        
        .table tbody tr {
            border-bottom: 1px solid #ffe4f3;
            transition: all 0.3s;
        }
        
        .table tbody tr:hover {
            background-color: #fff5fa;
        }
        
        .table tbody td {
            padding: 16px 15px;
            vertical-align: middle;
        }
        
        /* BADGE NILAI */
        .badge-nilai {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            min-width: 70px;
            display: inline-block;
        }
        
        .badge-belum {
            background-color: #ffe4f3;
            color: #e11584;
        }
        
        .badge-tinggi {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-sedang {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-rendah {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* BUTTONS */
        .btn-nilai {
            padding: 6px 15px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
        }
        
        .btn-nilai-primary {
            background: linear-gradient(135deg, #e11584, #ff69b4);
            color: white;
        }
        
        .btn-nilai-primary:hover {
            background: linear-gradient(135deg, #d10b73, #e11584);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 4px 8px rgba(225, 21, 132, 0.4);
        }
        
        .btn-nilai-warning {
            background: linear-gradient(135deg, #ffb347, #ffcc33);
            color: #212529;
        }
        
        .btn-nilai-warning:hover {
            background: linear-gradient(135deg, #ffa033, #ffc107);
            transform: translateY(-2px);
            color: #212529;
            box-shadow: 0 4px 8px rgba(255, 193, 7, 0.4);
        }
        
        /* BUTTON REPOSITORY PINK */
        .btn-repo-pink {
            background: linear-gradient(135deg, #ffe4f3, #ffd1e6) !important;
            color: #e11584 !important;
            border: 1px solid #ffb6d9 !important;
            border-radius: 6px !important;
            padding: 5px 12px !important;
            font-size: 14px !important;
            transition: all 0.3s !important;
            font-weight: 600;
        }
        
        .btn-repo-pink:hover {
            background: linear-gradient(135deg, #e11584, #ff69b4) !important;
            color: white !important;
            border-color: #e11584 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(225, 21, 132, 0.4);
        }
        
        /* DESKRIPSI SINGKAT */
        .deskripsi-singkat {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #666;
        }
        
        /* ALERTS */
        .alert-custom {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 10px rgba(225, 21, 132, 0.1);
        }
        
        .alert-success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        
        /* FOOTER INFO */
        .footer-info {
            background: linear-gradient(135deg, #fff5fa, #ffe4f3);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: center;
            color: #e11584;
            border: 1px solid #ffb6d9;
        }
        
        .footer-info .badge {
            background: linear-gradient(135deg, #e11584, #ff69b4);
            color: white;
        }
        
        /* RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            
            .stat-card {
                margin-bottom: 20px;
            }
            
            .table-responsive {
                border-radius: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dosen fixed-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard_dsn.php">
                <i class="fas fa-chart-line me-2"></i>Sistem Penilaian PBL
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDosen">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarDosen">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard_dsn.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="portofolio_dsn.php">
                            <i class="fas fa-folder me-1"></i>Portofolio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- MAIN CONTENT -->
    <div class="container">
        <!-- HEADER -->
        <div class="header-dosen mt-4">
            <h1 class="mb-2"><i class="fas fa-folder-open me-2"></i>Portofolio Mahasiswa</h1>
            <p class="mb-0">
                <i class="fas fa-user-tie me-1"></i> Dosen: <?= htmlspecialchars($nama) ?> | 
                <i class="fas fa-graduation-cap me-1 ms-2"></i> Sistem Penilaian Projek PBL
            </p>
        </div>
        
        <!-- ALERT MESSAGES -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <!-- STATISTICS -->
        <?php
        // Hitung statistik
        $sql_total = "SELECT COUNT(*) as total FROM portofolio";
        $result_total = $koneksi->query($sql_total);
        $total_proyek = $result_total->fetch_assoc()['total'];
        
        $sql_dinilai = "SELECT COUNT(DISTINCT id_portofolio) as dinilai FROM nilai";
        $result_dinilai = $koneksi->query($sql_dinilai);
        $dinilai = $result_dinilai->fetch_assoc()['dinilai'];
        
        $sql_rata = "SELECT AVG(nilai) as rata FROM nilai";
        $result_rata = $koneksi->query($sql_rata);
        $rata_row = $result_rata->fetch_assoc();
        $rata_nilai = $rata_row['rata'] ? number_format($rata_row['rata'], 2) : '0.00';
        ?>
        
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="stat-value"><?= $total_proyek ?></div>
                    <div class="stat-label">Total Proyek</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?= $dinilai ?></div>
                    <div class="stat-label">Sudah Dinilai</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-value"><?= $rata_nilai ?></div>
                    <div class="stat-label">Rata-rata Nilai</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value"><?= $total_proyek - $dinilai ?></div>
                    <div class="stat-label">Belum Dinilai</div>
                </div>
            </div>
        </div>
        <!-- SEARCH FORM -->
<form method="GET" class="mb-4">
    <div style="
        display:flex;
        gap:10px;
        align-items:center;
        background:white;
        padding:15px;
        border-radius:10px;
        border:1px solid #ffe4f3;
        box-shadow:0 2px 6px rgba(0,0,0,0.05);
    ">
        <input 
            type="text" 
            name="cari_nim" 
            value="<?= isset($_GET['cari_nim']) ? htmlspecialchars($_GET['cari_nim']) : '' ?>" 
            placeholder="Cari berdasarkan NIM mahasiswa..." 
            style="
                flex:1;
                padding:10px 15px;
                border-radius:8px;
                border:1px solid #e11584;
                outline:none;
            "
        >

        <button type="submit"
            style="
                background:linear-gradient(135deg, #e11584, #ff69b4);
                color:white;
                padding:10px 20px;
                border:none;
                border-radius:8px;
                cursor:pointer;
                font-weight:600;
                transition:0.3s;
            ">
            🔍 Cari
        </button>
    </div>
</form>

        <!-- TABLE PORTFOLIO -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%">Mahasiswa (NIM)</th>
                            <th width="25%">Judul Proyek</th>
                            <th width="20%">Deskripsi</th>
                            <th width="10%" class="text-center">Repository</th>
                            <th width="10%" class="text-center">Nilai</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      $where = "";
    if (isset($_GET['cari_nim']) && $_GET['cari_nim'] !== "") {
        $cari = bersihkan_input($_GET['cari_nim']);
        $where = "WHERE m.username LIKE '%$cari%'"; // diasumsikan NIM = username mhs
    }
    
    $sql = "SELECT p.*, m.nama AS nama_mahasiswa, n.nilai, n.catatan, m.username AS nim
        FROM portofolio p
        INNER JOIN login_mhs m ON m.id_mahasiswa = p.id_mahasiswa
        LEFT JOIN nilai n ON n.id_portofolio = p.id_portofolio
        $where
        ORDER BY p.id_portofolio ASC";


                        $stmt = $koneksi->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 0): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x mb-3" style="color: #e11584;"></i>
                                    <h5 style="color: #e11584;">📭 Belum ada portofolio mahasiswa</h5>
                                    <p style="color: #ff69b4;">Mahasiswa belum mengumpulkan proyek portofolio</p>
                                </td>
                            </tr>
                        <?php else: 
                            $no = 1;
                            while ($p = $result->fetch_assoc()):
                                $nilai = $p['nilai'];
                                
                                // Tentukan badge berdasarkan nilai
                                if ($nilai === null) {
                                    $badge_class = 'badge-belum';
                                    $badge_text = 'Belum';
                                } elseif ($nilai >= 80) {
                                    $badge_class = 'badge-tinggi';
                                    $badge_text = $nilai;
                                } elseif ($nilai >= 60) {
                                    $badge_class = 'badge-sedang';
                                    $badge_text = $nilai;
                                } else {
                                    $badge_class = 'badge-rendah';
                                    $badge_text = $nilai;
                                }
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td>
                               <td>
                        <strong><?= htmlspecialchars($p['nama_mahasiswa']) ?></strong><br>
                        <small style="color:#666;">NIM: <?= htmlspecialchars($p['nim']) ?></small>
                            </td>

                            </td>
                            <td><?= htmlspecialchars($p['judul']) ?></td>
                            <td>
                                <span class="deskripsi-singkat" title="<?= htmlspecialchars($p['deskripsi']) ?>">
                                    <?= htmlspecialchars(substr($p['deskripsi'], 0, 60)) ?>...
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($p['repo_link'])): ?>
                                    <a href="<?= htmlspecialchars($p['repo_link']) ?>" target="_blank" 
                                       class="btn btn-sm btn-repo-pink">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge-nilai <?= $badge_class ?>">
                                    <?= $badge_text ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($nilai === null): ?>
                                    <a href="beri_nilai.php?id_portofolio=<?= $p['id_portofolio'] ?>" 
                                       class="btn-nilai btn-nilai-primary">
                                        <i class="fas fa-edit"></i> Nilai
                                    </a>
                                <?php else: ?>
                                    <a href="edit_nilai.php?id_portofolio=<?= $p['id_portofolio'] ?>" 
                                       class="btn-nilai btn-nilai-warning">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        endif; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- FOOTER INFO -->
        <div class="footer-info">
            <p class="mb-2">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Petunjuk:</strong> Klik tombol <span class="badge">Nilai</span> untuk memberikan nilai pada portofolio mahasiswa
            </p>
            <p class="mb-0">
                Klik tombol <span class="badge">Edit</span> untuk memperbarui nilai yang sudah diberikan
            </p>
        </div>
    </div>
    
    <!-- BOOTSTRAP JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>ASRI</title>
  <link rel="stylesheet" href="../../admin.css">
</head>
<body>

  <header>
    <div class="logo">
      <img src="../../Image/lgo.png" alt="Logo">
      <h1>ASRI</h1>
    </div>
    <a href="../../index.php" class="logout">Log Out</a>
  </header>

  <div class="navbar">
    <button class="menu-toggle" onclick="toggleSidebar()">☰ Menu</button>
    <a href ="../../Data/data.php" class="btn-secondary">Home</a>
    <a href="../../Data/absen/absen.php" class="btn-secondary">Absen</a>
    <a href="../../Data/jurnal/jurnal.php" class="btn-secondary">Jurnal</a>
    <a href="../../Data/bayar/pembayaran.php" class="btn-secondary">Bayar</a>
  </div>

  <div class="sidebar" id="sidebar">
    <a href="siswa.php">Siswa</a>
    <a href="../../Data/kelas/kelas.php">Kelas</a>
    <a href="../../Data/jurusan/jurusan.php">Jurusan</a>
    <a href="../../Data/MPK/mpk.php">MPK</a>
    <a href="../../Data/guru/guru.php">Guru</a>
    <a href="../../Data/pegawe/Pegawai.php">Pegawai</a>
  </div>
  <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("overlay");
      sidebar.classList.toggle("show");
      overlay.classList.toggle("show");
    }
  </script>

<?php
include "../../koneksi.php";

// --- Cek apakah ada pencarian ---
$cari = "";
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $cari = $_GET['cari'];

    $result = mysqli_query($koneksi, "SELECT * FROM siswa 
                                        JOIN kelas ON siswa.id_kelas = kelas.id_kelas 
                                        JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan 
                                        WHERE (nama_siswa LIKE '%$cari%'
                                        OR nis LIKE '%$cari%' 
                                        OR nisn LIKE '%$cari%'
                                        OR nama_kelas LIKE '%$cari%'
                                        OR nama_jurusan LIKE '%$cari%') 
                                        ORDER BY id_siswa DESC"); 
} else { 
    $result = mysqli_query($koneksi, "SELECT * FROM siswa,kelas,jurusan 
                                        WHERE siswa.id_kelas=kelas.id_kelas 
                                        AND kelas.id_jurusan=jurusan.id_jurusan 
                                        ORDER BY id_siswa DESC"); }
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-3">
    <h2 class="mb-3 text-center">👨‍🎓 Data Siswa</h2>

    <!-- Notifikasi -->
    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php 
            if ($_GET['pesan'] == 'tambah') echo "✅ Data siswa berhasil ditambahkan!";
            if ($_GET['pesan'] == 'edit') echo "✅ Data siswa berhasil diperbaharui!";
            if ($_GET['pesan'] == 'hapus') echo "✅ Data siswa berhasil dihapus!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Pencarian + Tombol Tambah -->
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="get" action="">
            <input type="hidden" name="page" value="siswa">
            <input class="form-control me-2" type="search" name="cari" placeholder="Cari siswa...." value="<?= htmlspecialchars($cari) ?>">
            <button class="btn btn-outline-primary" type="submit">Cari</button>
        </form>
        <a href="siswa_tambah.php" class="btn btn-primary">+ Tambah Siswa</a>
    </div>

    <!-- Tabel Data Ringkas -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>No Absen</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1; 
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['no_absen']) ?></td>
                        <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($row['nama_kelas']) ?></td>
                        <td><?= htmlspecialchars($row['nama_jurusan']) ?></td>
                        <td>
                            <button 
                                class="btn btn-info btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#detailModal<?= $row['id_siswa'] ?>">
                                🔍 Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="detailModal<?= $row['id_siswa'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Detail Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama_siswa']) ?></p>
                                    <p><strong>No Absen:</strong> <?= htmlspecialchars($row['no_absen']) ?></p>
                                    <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($row['tgl_lahir']) ?></p>
                                    <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']) ?></p>
                                    <p><strong>Telepon:</strong> <?= htmlspecialchars($row['telp']) ?></p>
                                    <p><strong>NIS:</strong> <?= htmlspecialchars($row['nis']) ?></p>
                                    <p><strong>NISN:</strong> <?= htmlspecialchars($row['nisn']) ?></p>
                                    <p><strong>Kelas:</strong> <?= htmlspecialchars($row['nama_kelas']) ?></p>
                                    <p><strong>Jurusan:</strong> <?= htmlspecialchars($row['nama_jurusan']) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <a href="siswa_edit.php?id=<?= $row['id_siswa'] ?>" class="btn btn-warning">✏️ Edit</a>
                                    <a href="siswa_hapus.php?id=<?= $row['id_siswa'] ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Yakin ingin menghapus siswa ini?')">🗑️ Hapus</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } 
            } else { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">⚠️ Data tidak ditemukan</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

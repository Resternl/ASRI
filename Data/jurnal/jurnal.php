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
    <a href="jurnal.php" class="btn-secondary">Jurnal</a>
    <a href="../../Data/bayar/pembayaran.php" class="btn-secondary">Bayar</a>
  </div>

  <div class="sidebar" id="sidebar">
    <a href="../../Data/siswa/siswa.php">Siswa</a>
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
// Cek apakah ada pencarian
include "../../koneksi.php";
$cari = "";
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $cari = $_GET['cari'];
    $result = mysqli_query($koneksi, "SELECT * FROM jurnal, guru, kelas 
                                      WHERE jurnal.id_guru = guru.id_guru
                                      AND jurnal.id_kelas = kelas.id_kelas
                                      AND tgl_mengajar LIKE '%$cari%'  
                                      ORDER BY id_jurnal DESC");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM jurnal, guru, kelas  WHERE jurnal.id_guru = guru.id_guru AND jurnal.id_kelas = kelas.id_kelas ORDER BY id_jurnal DESC");
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-2">
    <h2 class="mb-2 text-center">📚 Data jurnal</h2>

    <!-- Notifikasi -->
    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php 
            if ($_GET['pesan'] == 'tambah') echo "✅ Data jurnal berhasil ditambahkan!";
            if ($_GET['pesan'] == 'edit') echo "✅ Data jurnal berhasil diperbaharui!";
            if ($_GET['pesan'] == 'hapus') echo "✅ Data jurnal berhasil dihapus!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Pencarian + Tombol Tambah -->
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex" method="get" action="">
            <input type="hidden" name="page" value="jurnal">
            <input class="form-control me-2" type="search" name="cari" placeholder="Cari jurnal..." value="<?= htmlspecialchars($cari) ?>">
            <button class="btn btn-outline-primary" type="submit">Cari</button>
        </form>
        <a href="jurnal_tambah.php" class="btn btn-primary">+ Tambah jurnal</a>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Tanggal Mengajar</th>
                    <th>Nama Kelas</th>
                    <th>Materi</th>
                    <th>keterangan</th>
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
                        <td><?= $row['nama_guru'] ?></td>
                        <td><?= $row['tgl_mengajar'] ?></td>
                        <td><?= $row['nama_kelas'] ?></td>
                        <td><?= $row['materi'] ?></td>
                        <td><?= $row['ket'] ?></td>
                        <td>
                            <a href="jurnal_edit.php?id=<?= $row['id_jurnal'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="jurnal_hapus.php?id=<?= $row['id_jurnal'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin ingin menghapus jurnal ini?')">Hapus</a>
                        </td>
                    </tr>
            <?php } 
            } else { ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">⚠️ Data tidak ditemukan</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

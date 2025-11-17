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
    <a href ="../../data.php" class="btn-secondary">Home</a>
    <a href="absen.php" class="btn-secondary">Absen</a>
    <a href="../../Data/jurnal/jurnal.php" class="btn-secondary">Jurnal</a>
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
include "../../koneksi.php";
if (isset($_POST['simpan'])) {
    $tgl_absensi = $_POST['tgl_absensi'];
    $id_siswa = $_POST['id_siswa'];
    $keterangan    = $_POST['keterangan'];

    mysqli_query($koneksi, "INSERT INTO absensi (tgl_absensi, id_siswa, Keterangan) VALUES ('$tgl_absensi','$id_siswa','$keterangan')");
    header("Location: absen.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah Absen</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tanggal Absensi</label>
            <input type="date" name="tgl_absensi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <select name="id_siswa" class="form-select" required>
                <option value="">-- Pilih Nama Siswa --</option>
                <?php 
                    $siswa = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama_siswa ASC");
                    while ($row = mysqli_fetch_assoc($siswa)) { ?>
                    <option value="<?= $row['id_siswa']; ?>">
                        <?= $row['nama_siswa']; ?> 
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php?page=kelas" class="btn btn-secondary">Kembali</a>
    </form>
</div>

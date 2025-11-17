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
    <a href="../../Data/absen/absen.php" class="btn-secondary">Absen</a>
    <a href="../../Data/jurnal/jurnal.php" class="btn-secondary">Jurnal</a>
    <a href="pembayaran.php" class="btn-secondary">Bayar</a>
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
    $id_siswa       = $_POST['id_siswa'];
    $tgl_pembayaran = $_POST['tgl_pembayaran'];
    $bulan          = $_POST['bulan'];
    $nominal        = $_POST['nominal'];
    $metode         = $_POST['metode'];
    $id_pegawai     = $_POST['id_pegawai'];

    mysqli_query($koneksi, "INSERT INTO pembayaran (id_siswa, tgl_pembayaran, bulan, nominal, metode, id_pegawai) VALUES ('$id_siswa','$tgl_pembayaran','$bulan','$nominal','$metode','$id_pegawai')");
    header("Location: pembayaran.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah Pembayaran</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <select name="id_siswa" class="form-select" required>
                <option value="">-- Pilih Nama siswa --</option>
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
            <label class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tgl_pembayaran" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">nominal</label>
            <input type="text" name="nominal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Metode</label>
            <input type="text" name="metode" class="form-control" required>

        <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <select name="id_pegawai" class="form-select" required>
                <option value="">-- Pilih Nama Pegawai --</option>
                <?php 
                    $pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
                    while ($row = mysqli_fetch_assoc($pegawai)) { ?>
                    <option value="<?= $row['id_pegawai']; ?>">
                        <?= $row['nama_pegawai']; ?> 
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="pembayaran.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

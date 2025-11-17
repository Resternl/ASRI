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
    <a href="../../Data/bayar/pembayaran.php" class="btn-secondary">Bayar</a>
  </div>

  <div class="sidebar" id="sidebar">
    <a href="../../Data/siswa/siswa.php">Siswa</a>
    <a href="kelas.php">Kelas</a>
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
    $nama_kelas = $_POST['nama_kelas'];
    $id_jurusan = $_POST['id_jurusan'];
    $id_guru    = $_POST['id_guru'];

    mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas, id_jurusan, id_guru) VALUES ('$nama_kelas','$id_jurusan','$id_guru')");
    header("Location: kelas.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah Kelas</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="id_jurusan" class="form-select" required>
                <option value="">-- Pilih Jurusan --</option>
                <?php 
                    $jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
                    while ($row = mysqli_fetch_assoc($jurusan)) { ?>
                    <option value="<?= $row['id_jurusan']; ?>">
                        <?= $row['nama_jurusan']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php 
                    $guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama_guru ASC");
                    while ($row = mysqli_fetch_assoc($guru)) { ?>
                    <option value="<?= $row['id_guru']; ?>">
                        <?= $row['nama_guru']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="kelas.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

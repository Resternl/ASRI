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
    <a href="../../Data/kelas/kelas.php">Kelas</a>
    <a href="jurusan.php">Jurusan</a>
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
    $nama_jurusan = $_POST['nama_jurusan'];
    $singkatan    = $_POST['singkatan'];

    mysqli_query($koneksi, "INSERT INTO jurusan (nama_jurusan, singkatan) VALUES ('$nama_jurusan','$singkatan')");
    header("Location: jurusan.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah Jurusan</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Singkatan</label>
            <input type="text" name="singkatan" maxlength="5" class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="jurusan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

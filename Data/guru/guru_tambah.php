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
    <a href="../../Data/jurusan/jurusan.php">Jurusan</a>
    <a href="../../Data/MPK/mpk.php">MPK</a>
    <a href="guru.php">Guru</a>
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
    $nama_guru = $_POST['nama_guru'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $telp      = $_POST['telp'];
    $alamat    = $_POST['alamat'];
    $username  = $_POST['username'];
    $password  = md5($_POST['password']);

    mysqli_query($koneksi, "INSERT INTO guru (nama_guru, tgl_lahir, telp, alamat, username, password) VALUES ('$nama_guru','$tgl_lahir','$telp','$alamat','$username','$password')");
    header("Location: guru.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah guru</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama guru</label>
            <input type="text" name="nama_guru" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">tanggal lahir</label>
            <input type="date" name="tgl_lahir"  class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">telpon</label>
            <input type="number" name="telp"  class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">alamat</label>
            <input type="text" name="alamat"  class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">username</label>
            <input type="text" name="username"  class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">password</label>
            <input type="text" name="password"  class="form-control" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="guru.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

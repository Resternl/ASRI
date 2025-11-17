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
include "../../koneksi.php";
if (isset($_POST['simpan'])) {
    $id_guru      = $_POST['id_guru'];
    $tgl_mengajar = $_POST['tgl_mengajar'];
    $id_kelas     = $_POST['id_kelas'];
    $materi       = $_POST['materi'];
    $ket          = $_POST['ket'];

    mysqli_query($koneksi, "INSERT INTO jurnal (id_guru, tgl_mengajar, id_kelas, materi, ket) VALUES ('$id_guru','$tgl_mengajar','$id_kelas','$materi','$ket')");
    header("Location: jurnal.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Tambah Jurnal</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Guru</label>
            <select name="id_guru" class="form-select" required>
                <option value="">-- Pilih Nama Guru --</option>
                <?php 
                    $guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama_guru ASC");
                    while ($row = mysqli_fetch_assoc($guru)) { ?>
                    <option value="<?= $row['id_guru']; ?>">
                        <?= $row['nama_guru']; ?> 
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Mengajar</label>
            <input type="date" name="tgl_mengajar" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Nama kelas --</option>
                <?php 
                    $kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
                    while ($row = mysqli_fetch_assoc($kelas)) { ?>
                    <option value="<?= $row['id_kelas']; ?>">
                        <?= $row['nama_kelas']; ?> 
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Materi</label>
            <input type="text" name="materi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="ket" class="form-control" required>
        </div>

        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="jurnal.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

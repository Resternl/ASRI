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
if (!isset($_GET['id'])) {
    header("Location: pembayaran.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_pembayaran=$id"));

if (isset($_POST['update'])) {
    $id_siswa       = $_POST['id_siswa'];
    $tgl_pembayaran = $_POST['tgl_pembayaran'];
    $bulan          = $_POST['bulan'];
    $nominal        = $_POST['nominal'];
    $metode         = $_POST['metode'];
    $id_pegawai     = $_POST['id_pegawai'];

    mysqli_query($koneksi, "UPDATE pembayaran SET id_siswa='$id_siswa', tgl_pembayaran='$tgl_pembayaran', bulan='$bulan', nominal='$nominal', metode='$metode', id_pegawai='$id_pegawai' WHERE id_pembayaran=$id");
    header("Location: pembayaran.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Edit Pembayaran</h2>
    <form method="post">

        <div class="mb-3">
            <label class="form-label">Nama Siswa</label>
            <select name="id_siswa" class="form-control" required>
                <option value="">-- Pilih Nama Siswa --</option>
                <?php
                $qKelas = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama_siswa ASC");
                while ($siswa = mysqli_fetch_assoc($qKelas)) {
                    $selected = ($siswa['id_siswa'] == $data['id_siswa']) ? "selected" : "";
                    echo "<option value='{$siswa['id_siswa']}' $selected>{$siswa['nama_siswa']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tgl_pembayaran" class="form-control" value="<?= $data['tgl_pembayaran'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" value="<?= $data['bulan'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nominal</label>
            <input type="text" name="nominal" class="form-control" value="<?= $data['nominal'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Metode</label>
            <input type="text" name="metode" class="form-control" value="<?= $data['metode'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Pegawai</label>
            <select name="id_pegawai" class="form-control" required>
                <option value="">-- Pilih Nama Pegawai --</option>
                <?php
                $qKelas = mysqli_query($koneksi, "SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
                while ($pegawai = mysqli_fetch_assoc($qKelas)) {
                    $selected = ($pegawai['id_pegawai'] == $data['id_pegawai']) ? "selected" : "";
                    echo "<option value='{$pegawai['id_pegawai']}' $selected>{$pegawai['nama_pegawai']}</option>";
                }
                ?>
            </select>
        </div>  

        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="pembayaran.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
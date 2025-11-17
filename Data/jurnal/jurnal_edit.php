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
if (!isset($_GET['id'])) {
    header("Location: jurnal.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM jurnal WHERE id_jurnal=$id"));

if (isset($_POST['update'])) {
    $id_guru      = $_POST['id_guru'];
    $tgl_mengajar = $_POST['tgl_mengajar'];
    $id_kelas     = $_POST['id_kelas'];
    $materi       = $_POST['materi'];
    $ket          = $_POST['ket'];

    mysqli_query($koneksi, "UPDATE jurnal SET id_guru='$id_guru', tgl_mengajar='$tgl_mengajar', id_kelas='$id_kelas', materi='$materi', ket='$ket' WHERE id_jurnal=$id");
    header("Location: jurnal.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4">Edit Jurnal</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Guru</label>
            <select name="id_guru" class="form-control" required>
                <option value="">-- Pilih Nama Guru --</option>
                <?php
                $qKelas = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY nama_guru ASC");
                while ($guru = mysqli_fetch_assoc($qKelas)) {
                    $selected = ($guru['id_guru'] == $data['id_guru']) ? "selected" : "";
                    echo "<option value='{$guru['id_guru']}' $selected>{$guru['nama_guru']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Mengajar</label>
            <input type="date" name="tgl_mengajar" class="form-control" value="<?= $data['tgl_mengajar'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="id_kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php
                $qKelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
                while ($kelas = mysqli_fetch_assoc($qKelas)) {
                    $selected = ($kelas['id_kelas'] == $data['id_kelas']) ? "selected" : "";
                    echo "<option value='{$kelas['id_kelas']}' $selected>{$kelas['nama_kelas']}</option>";
                }
                ?>
            </select>
        </div>  
        
        <div class="mb-3">
            <label class="form-label">Materi</label>
            <input type="text" name="materi" class="form-control" value="<?= $data['materi'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="ket" class="form-control" value="<?= $data['ket'] ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="jurnal.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
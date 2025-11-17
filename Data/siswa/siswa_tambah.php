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

// Ambil data kelas untuk dropdown
$qKelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas ASC");

// Proses simpan data siswa
if (isset($_POST['simpan'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $no_absen   = $_POST['no_absen'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $alamat     = $_POST['alamat'];
    $telp       = $_POST['telp'];
    $nis        = $_POST['nis'];
    $nisn       = $_POST['nisn'];
    $id_kelas   = $_POST['id_kelas'];

    // Query simpan ke tabel siswa
    $query = "INSERT INTO siswa (nama_siswa, no_absen, tgl_lahir, alamat, telp, nis, nisn, id_kelas)
              VALUES ('$nama_siswa', '$no_absen', '$tgl_lahir', '$alamat', '$telp', '$nis', '$nisn', '$id_kelas')";
    mysqli_query($koneksi, $query);

    // Redirect setelah berhasil tambah
    header("Location: siswa.php");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <h2 class="mb-4 text-center">🧾 Tambah Data Siswa</h2>

    <form method="post" class="border rounded p-4 shadow-sm bg-light">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">No Absen</label>
                <input type="number" name="no_absen" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Telepon</label>
                <input type="text" name="telp" maxlength="15" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">NIS</label>
                <input type="number" name="nis" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">NISN</label>
                <input type="text" name="nisn" maxlength="15" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Kelas</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php while ($kelas = mysqli_fetch_assoc($qKelas)) { ?>
                    <option value="<?= $kelas['id_kelas'] ?>">
                        <?= htmlspecialchars($kelas['nama_kelas']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" name="simpan" class="btn btn-success me-2">💾 Simpan</button>
            <a href="siswa.php" class="btn btn-secondary">↩️ Kembali</a>
        </div>
    </form>
</div>

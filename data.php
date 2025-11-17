<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>ASRI</title>
  <link rel="stylesheet" href="admin.css">

</head>
<body>

  <header>
    <div class="logo">
      <img src="image/lgo.png" alt="Logo">
      <h1>ASRI</h1>
    </div>
    <a href="index.php" class="logout">Log Out</a>
  </header>

  <div class="navbar">
    <button class="menu-toggle" onclick="toggleSidebar()">☰ Menu</button>
    <a href ="data.php" class="btn-secondary">Home</a>
    <a href="../Data/absen/absen.php" class="btn-secondary">Absen</a>
    <a href="../Data/jurnal/jurnal.php" class="btn-secondary">Jurnal</a>
    <a href="../Data/bayar/pembayaran.php" class="btn-secondary">Bayar</a>
  </div>

  <div class="sidebar" id="sidebar">
    <a href="../Data/siswa/siswa.php">Siswa</a>
    <a href="../Data/kelas/kelas.php">Kelas</a>
    <a href="../Data/jurusan/jurusan.php">Jurusan</a>
    <a href="../Data/MPK/mpk.php">MPK</a>
    <a href="../Data/guru/guru.php">Guru</a>
    <a href="../Data/pegawe/Pegawai.php">Pegawai</a>
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

<main style="padding: 20px;">
  <h2 style="margin-bottom: 20px;">📊 Dashboard</h2>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
    <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
      <h3 style="margin:0; font-size: 18px;">👨‍🎓 Siswa</h3>
      <p style="font-size: 28px; font-weight: bold; margin: 10px 0;">534</p>
      <small>Total Siswa</small>
    </div>

    <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
      <h3 style="margin:0; font-size: 18px;">👩‍🏫 Guru</h3>
      <p style="font-size: 28px; font-weight: bold; margin: 10px 0;">36</p>
      <small>Total Guru</small>
    </div>

    <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
      <h3 style="margin:0; font-size: 18px;">🏫 Kelas</h3>
      <p style="font-size: 28px; font-weight: bold; margin: 10px 0;">8</p>
      <small>Total Jurusan</small>
    </div>

    <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
      <h3 style="margin:0; font-size: 18px;">💰 Pembayaran</h3>
      <p style="font-size: 28px; font-weight: bold; margin: 10px 0;">95%</p>
      <small>Sudah Lunas</small>
    </div>
  </div>
</main>

</body>
</html>

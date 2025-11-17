<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
 }
include 'konekin.php';

if (isset($_GET['id_kelas'])) {
    $_SESSION['id_kelas'] = $_GET['id_kelas'];
    header("Location: absen.php");
    exit;
}

$id_kelas = $_SESSION['id_kelas'] ?? null;

if (!$id_kelas) {
    echo "<p style='color:red;'>ID kelas tidak ditemukan!</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['absen'] ?? [];

    $tgl = date('Y-m-d');
    $inserted = 0;

    foreach ($data as $id_siswa => $keterangan) {
        $keterangan = mysqli_real_escape_string($koneksi, $keterangan);
        $id_siswa = (int)$id_siswa;

        $cek = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_siswa='$id_siswa' AND tgl_absensi='$tgl'");
        if (mysqli_num_rows($cek) > 0) {
            continue; 
        }

        $sql = "INSERT INTO absensi (id_siswa, tgl_absensi, keterangan)
                VALUES ('$id_siswa', '$tgl', '$keterangan')";

        if (!mysqli_query($koneksi, $sql)) {
            echo "SQL Error: " . mysqli_error($koneksi);
            echo "<br>Query: " . $sql;
            exit;
        } else {
            $inserted++;
        }
    }

    echo "<script>alert('Absensi berhasil disimpan ($inserted siswa)!'); window.location='absen.php?id_kelas=$id_kelas';</script>";
    exit;
}

$cariSiswa = mysqli_query($koneksi, "SELECT siswa.*, kelas.nama_kelas 
                                     FROM siswa, kelas 
                                     WHERE siswa.id_kelas = kelas.id_kelas 
                                     AND siswa.id_kelas = '$id_kelas'
                                     ORDER BY nama_siswa ASC");

$siswaData = [];
while ($row = mysqli_fetch_assoc($cariSiswa)) {
    $siswaData[] = $row;
}

$filter_tgl = $_GET['tgl'] ?? date('Y-m-d');
$filter_bulan = $_GET['bulan'] ?? date('Y-m');

$querySummary = "
    SELECT keterangan, COUNT(*) AS jumlah 
    FROM absensi 
    JOIN siswa ON absensi.id_siswa = siswa.id_siswa
    WHERE siswa.id_kelas = '$id_kelas'
      AND DATE_FORMAT(tgl_absensi, '%Y-%m') = '$filter_bulan'
    GROUP BY keterangan
";
$resSummary = mysqli_query($koneksi, $querySummary);

$summary = [];
while ($row = mysqli_fetch_assoc($resSummary)) {
    $summary[$row['keterangan']] = $row['jumlah'];
}

$detail_ket = $_GET['detail'] ?? null;
$detailData = [];

if ($detail_ket) {
    $qDetail = "
        SELECT siswa.nama_siswa, absensi.tgl_absensi, absensi.keterangan
        FROM absensi
        JOIN siswa ON absensi.id_siswa = siswa.id_siswa
        WHERE siswa.id_kelas = '$id_kelas'
          AND absensi.keterangan = '$detail_ket'
          AND DATE_FORMAT(absensi.tgl_absensi, '%Y-%m') = '$filter_bulan'
        ORDER BY absensi.tgl_absensi DESC
    ";
    $resDetail = mysqli_query($koneksi, $qDetail);
    while ($r = mysqli_fetch_assoc($resDetail)) {
        $detailData[] = $r;
    }
}

?>

<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Absen Siswa</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="absen.css">
</head>

<body>

  <div class="frame" role="application" aria-label="Absen Siswa">
    <table>
    <div class="top">
      <div class="title">
        <h1>Absensi</h1>
        <div class="subtitle"><?= date('d M Y'); ?></div>
      </div>

      <div style="display:flex;align-items:center;gap:12px">
        <div><h1 style="font-size: 15px; color: green;"><?= $_SESSION['username'] ?? 'Guru'; ?></h1></div>
        <div class="avatar" title="profile"></div>
      </div>
    </div>

    <div class="toolbar">
      <div class="legend">
        <div class="item"><span class="dot hadir"></span> Hadir</div>
        <div class="item"><span class="dot izin"></span> Izin</div>
        <div class="item"><span class="dot sakit"></span> Sakit</div>
        <div class="item"><span class="dot dispen"></span> Terlambat</div>
        <div class="item"><span class="dot alpha"></span> Alpha</div>
      </div>
    </div>

    <form method="post">
  <div class="list" id="listDesktop">
    <?php if (count($siswaData) === 0): ?>
      <p style="color:red;">Tidak ada siswa pada kelas ini.</p>
    <?php else: ?>
      <?php foreach ($siswaData as $s): ?>
        <div class="student">
          <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:8px 0">
            <div style="display:flex;align-items:center;gap:12px">
              <div class="avatar"></div>
              <div class="info">
                <div class="name" style="font-weight:600;"><?= htmlspecialchars($s['nama_siswa']); ?></div>
                <div class="class" style="font-size:12px;color:#555;">Absen : <?= htmlspecialchars($s['no_absen']); ?></div>
              </div>
            </div>

            <select name="absen[<?= $s['id_siswa']; ?>]"
              style="padding:6px 10px;border-radius:8px;border:1px solid #ccc;background:#fff;font-size:14px;cursor:pointer;">
              <option value="hadir">Hadir</option>
              <option value="izin">Izin</option>
              <option value="sakit">Sakit</option>
              <option value="telat">Terlambat</option>
              <option value="alpha">Alpha</option>
            </select>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <div class="footer">
    <div class="count"><?= count($siswaData); ?> siswa</div>
    <div class="buttons">
      <button type="reset" class="btn ghost">Kosongkan</button>
      <button type="submit" class="btn primary">Kirim</button>
    </div>
  </div>
</form>
</table>

<div class="summary" 
      style="background:#fff;padding:20px;border-radius:12px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);margin-bottom:30px; margin-top:40px;">

  <h2 style="margin-bottom:15px;color:#333;font-size:20px;">
    📊 Rekap Absensi Bulan <?= date('F Y', strtotime($filter_bulan . '-01')); ?>
  </h2>

  <!-- Filter bulan -->
  <form method="get" style="margin-bottom:20px;display:flex;align-items:center;gap:10px;">
    <input type="month" name="bulan" 
           value="<?= htmlspecialchars($filter_bulan); ?>" 
           style="padding:8px 10px;border:1px solid #ccc;border-radius:8px;font-size:14px;">
    <button type="submit" class="btn primary" 
            style="padding:8px 14px;border-radius:8px;">Filter</button>
  </form>

  <!-- List Summary -->
  <div class="list" id="summaryList" style="display:flex;flex-direction:column;gap:10px;">
    <?php if (count($summary) === 0): ?>
      <p style="color:red;">Belum ada absensi di bulan ini.</p>
    <?php else: ?>
      <?php foreach ($summary as $ket => $jumlah): ?>
        <div class="student" 
             style="background:#f9f9f9;border:1px solid #ddd;padding:10px 15px;
                    border-radius:10px;display:flex;align-items:center;
                    justify-content:space-between;">
          <div style="display:flex;align-items:center;gap:10px;">
            <span class="dot <?= htmlspecialchars($ket); ?>"></span>
            <div class="info">
              <div class="name" style="font-weight:600;text-transform:capitalize;">
                <?= htmlspecialchars($ket); ?>
              </div>
              <div class="class" style="font-size:12px;color:#555;">
                Total: <?= $jumlah; ?> siswa
              </div>
            </div>
          </div>
          <a href="?detail=<?= urlencode($ket); ?>" 
             class="btn primary" 
             style="padding:6px 12px;border-radius:6px;text-decoration:none;">Detail</a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php if ($detail_ket): ?>
    <hr style="margin:25px 0;border:none;border-top:1px solid #eee;">
    <h3 style="margin-bottom:10px;color:#333;">Detail siswa dengan status: 
      <strong style="text-transform:capitalize;"><?= htmlspecialchars($detail_ket); ?></strong>
    </h3>

    <div class="list" id="detailList" style="display:flex;flex-direction:column;gap:10px;">
      <?php if (count($detailData) === 0): ?>
        <p style="color:red;">Belum ada siswa dengan keterangan ini.</p>
      <?php else: ?>
        <?php foreach ($detailData as $d): ?>
          <div class="student" 
               style="background:#f9f9f9;border:1px solid #ddd;padding:10px 15px;
                      border-radius:10px;display:flex;align-items:center;
                      justify-content:space-between;">
            <div>
              <div class="name" style="font-weight:600;"><?= htmlspecialchars($d['nama_siswa']); ?></div>
              <div class="class" style="font-size:12px;color:#555;">Tanggal: <?= htmlspecialchars($d['tgl_absensi']); ?></div>
            </div>
            <span class="dot <?= htmlspecialchars($d['keterangan']); ?>"></span>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div style="margin-top:15px;text-align:right;">
      <a href="absen.php" 
         class="btn ghost" 
         style="padding:6px 12px;border-radius:6px;text-decoration:none;">Kembali</a>
    </div>
  <?php endif; ?>

  </div>
  </div>
</body>
</html>
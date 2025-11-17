<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ASRI</title>
  <link rel="stylesheet" href="login.css">
</head>

<body class="login-body">

  <div class="auth-container">
    <input type="radio" id="guru" name="tab" checked hidden>
    <input type="radio" id="mpk" name="tab" hidden>
    <input type="radio" id="ortu" name="tab" hidden>

    <div class="switch-tab">
      <label for="guru" class="tab">Guru</label>
      <label for="mpk" class="tab">MPK</label>
      <label for="ortu" class="tab">Orang Tua</label>
    </div>

    <div class="form-container">

      <div class="form-box guru-box">
        <h2>Login Guru</h2>
        <?php if (isset($_GET['error']) && $_GET['role'] == 'guru'): ?>
          <div class="error-message"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <form action="jurnal/jurnal.php" method="POST">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" class="btn">Masuk</button>
        </form>
      </div>

      <div class="form-box mpk-box">
        <h2>Login MPK</h2>
        <?php if (isset($_GET['error']) && $_GET['role'] == 'mpk'): ?>
          <div class="error-message"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <form action="proses_login.php" method="POST">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" class="btn">Masuk</button>
        </form>
      </div>

      <div class="form-box ortu-box">
        <h2>Login Orang Tua</h2>
        <?php if (isset($_GET['error']) && $_GET['role'] == 'ortu'): ?>
          <div class="error-message"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <form action="bayar/bayar.php" method="POST">
          <input type="text" name="username" placeholder="Username" required>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit" class="btn">Masuk</button>
        </form>
      </div>

    </div>

    <div class="exit-btn">
      <a href="index.php" class="btn-secondary">← Kembali</a>
    </div>

  </div>

</body>
</html>

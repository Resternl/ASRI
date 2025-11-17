<?php
session_start();
include 'koneksi.php'; 

$username = isset($_POST['username']) ? mysqli_real_escape_string($koneksi, $_POST['username']) : '';
$password = md5($_POST['password']); 

$sql = "SELECT * FROM mpk WHERE username = '$username' AND password = '$password' LIMIT 1";
$query = mysqli_query($koneksi, $sql);

if ($query === false) {
    die("Query error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);

    $_SESSION['username'] = $data['username'];
    $_SESSION['id_kelas'] = $data['id_kelas'];
    $_SESSION['login'] = true;

    header("Location: mpk/absen.php?id_kelas=" . urlencode($data['id_kelas']));
    exit;
} else {
    header("Location: login.php?error=1&role=mpk");
    exit;
}
?>

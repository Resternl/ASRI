<?php
include "../../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM siswa WHERE id_siswa=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: siswa.php");
    exit;
} else {
    header("Location: siswa.php");
    exit;
}
?>
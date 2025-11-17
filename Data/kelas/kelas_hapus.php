<?php
include "../../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM kelas WHERE id_kelas=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: kelas.php");
    exit;
} else {
    header("Location: kelas.php");
    exit;
}

?>
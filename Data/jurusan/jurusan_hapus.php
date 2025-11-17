<?php
include "../../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM jurusan WHERE id_jurusan=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: jurusan.php");
    exit;
} else {
    header("Location: jurusan.php");
    exit;
}

?>
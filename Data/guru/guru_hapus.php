<?php
include "../../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM guru WHERE id_guru=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: guru.php");
    exit;
} else {
    header("Location: guru.php");
    exit;
}

?>
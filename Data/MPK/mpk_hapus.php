<?php
include "../../koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("DELETE FROM mpk WHERE id_mpk=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: mpk.php");
    exit;
} else {
    header("Location: mpk.php");
    exit;
}
?>
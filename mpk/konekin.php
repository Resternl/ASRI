<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "rekap_data";

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    http_response_code(500);
    exit();  
}
?>
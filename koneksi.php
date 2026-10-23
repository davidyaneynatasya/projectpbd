<?php
$host     = "localhost";
$user     = "root";
$password = "davidya080707";         
$database = "uts";

// Melakukan koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
<?php
$koneksi = mysqli_connect("localhost", "root", "", "tokobunga");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

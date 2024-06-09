<?php
$servername = "localhost"; // Ganti dengan nama host database Anda
$username = "root";    // Ganti dengan username database Anda
$password = "";    // Ganti dengan password database Anda
$dbname = "sijakul"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

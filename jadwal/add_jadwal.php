<?php
require 'db_connection.php';

$hari = $_POST['hari'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$id_kelas = $_POST['id_kelas'];
$id_matkul = $_POST['id_matkul'];
$id_dosen = $_POST['id_dosen'];
$id_ruangan = $_POST['id_ruangan'];

// Check for duplicate schedule for the same class
$query = "SELECT COUNT(*) as count FROM jadwal WHERE hari = ? AND id_kelas = ? AND (jam_mulai BETWEEN ? AND ? OR jam_selesai BETWEEN ? AND ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $hari, $id_kelas, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo 'duplicate_kelas';
    exit;
}

// Check for duplicate schedule for the same lecturer
$query = "SELECT COUNT(*) as count FROM jadwal WHERE hari = ? AND id_dosen = ? AND (jam_mulai BETWEEN ? AND ? OR jam_selesai BETWEEN ? AND ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $hari, $id_dosen, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo 'duplicate_dosen';
    exit;
}

// Check for duplicate schedule for the same room
$query = "SELECT COUNT(*) as count FROM jadwal WHERE hari = ? AND id_ruangan = ? AND (jam_mulai BETWEEN ? AND ? OR jam_selesai BETWEEN ? AND ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $hari, $id_ruangan, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo 'duplicate_ruangan';
    exit;
}

$query = "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_kelas, id_matkul, id_dosen, id_ruangan) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss", $hari, $jam_mulai, $jam_selesai, $id_kelas, $id_matkul, $id_dosen, $id_ruangan);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'success';
} else {
    echo 'error';
}

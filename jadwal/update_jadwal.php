<?php
require 'db_connection.php';

$id_jadwal = $_POST['id_jadwal'];
$hari = $_POST['hari'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];
$id_kelas = $_POST['id_kelas'];
$id_matkul = $_POST['id_matkul'];
$id_dosen = $_POST['id_dosen'];
$id_ruangan = $_POST['id_ruangan'];

// Check for duplicate schedule for the same lecturer
$query = "SELECT COUNT(*) as count FROM jadwal WHERE hari = ? AND id_dosen = ? AND id_jadwal != ? AND ((jam_mulai BETWEEN ? AND ?) OR (jam_selesai BETWEEN ? AND ?))";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss", $hari, $id_dosen, $id_jadwal, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo 'duplicate_dosen';
    exit;
}

// Check for duplicate schedule for the same room
$query = "SELECT COUNT(*) as count FROM jadwal WHERE hari = ? AND id_ruangan = ? AND id_jadwal != ? AND ((jam_mulai BETWEEN ? AND ?) OR (jam_selesai BETWEEN ? AND ?))";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss", $hari, $id_ruangan, $id_jadwal, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row['count'] > 0) {
    echo 'duplicate_ruangan';
    exit;
}

$query = "UPDATE jadwal SET hari = ?, jam_mulai = ?, jam_selesai = ?, id_kelas = ?, id_matkul = ?, id_dosen = ?, id_ruangan = ? WHERE id_jadwal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssi", $hari, $jam_mulai, $jam_selesai, $id_kelas, $id_matkul, $id_dosen, $id_ruangan, $id_jadwal);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'success';
} else {
    echo 'error';
}

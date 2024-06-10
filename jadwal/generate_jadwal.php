<?php
require 'db_connection.php';

// Hapus semua data jadwal sebelumnya
$sql = "DELETE FROM jadwal";
if (!$conn->query($sql)) {
    echo "Error: " . $conn->error;
    exit;
}

// Fetch kelas dan matkul terkait dari tabel kelas_matkul
$sql = "SELECT id_kelas, id_matkul FROM kelas_matkul";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

$kelas_matkul = [];
while ($row = $result->fetch_assoc()) {
    $kelas_matkul[$row['id_kelas']][] = $row['id_matkul'];
}

// Fetch daftar ruangan yang valid
$sql = "SELECT id_ruangan FROM ruangan";
$result = $conn->query($sql);
if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

$ruangan_list = [];
while ($row = $result->fetch_assoc()) {
    $ruangan_list[] = $row['id_ruangan'];
}

// Fetch daftar dosen yang valid berdasarkan mata kuliah
$dosen_matkul = [];
$sql = "SELECT id_dosen, id_matkul FROM dosen_matkul";
$result = $conn->query($sql);
if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

while ($row = $result->fetch_assoc()) {
    $dosen_matkul[$row['id_matkul']][] = $row['id_dosen'];
}

// Function to check if a room is available at a given time
function isRoomAvailable($conn, $id_ruangan, $hari, $jam_mulai, $jam_selesai)
{
    $query = "SELECT COUNT(*) as count FROM jadwal 
              WHERE id_ruangan = ? AND hari = ? 
              AND ((jam_mulai < ? AND jam_selesai > ?) 
              OR (jam_mulai < ? AND jam_selesai > ?) 
              OR (jam_mulai >= ? AND jam_selesai <= ?))";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssssss', $id_ruangan, $hari, $jam_selesai, $jam_mulai, $jam_mulai, $jam_selesai, $jam_mulai, $jam_selesai);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] == 0;
}

// Generate jadwal
$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$time_slots = [
    ['08:00', '09:30'],
    ['10:00', '11:30'],
    ['13:00', '14:30'],
    ['15:00', '16:30']
];
$max_classes_per_day = count($time_slots); // Maksimal kelas per hari sesuai dengan slot waktu

foreach ($kelas_matkul as $id_kelas => $matkuls) {
    shuffle($matkuls); // Acak urutan matkul
    $week_schedule = []; // Untuk menyimpan jadwal mingguan kelas ini
    $class_count = 0;

    foreach ($days as $day) {
        if ($class_count >= count($matkuls)) break;

        foreach ($time_slots as $slot) {
            if ($class_count >= count($matkuls)) break;

            $id_matkul = $matkuls[$class_count];

            // Pastikan matkul tidak sama dalam satu hari
            if (isset($week_schedule[$day]) && in_array($id_matkul, $week_schedule[$day])) {
                continue;
            }

            $id_dosen = $dosen_matkul[$id_matkul][array_rand($dosen_matkul[$id_matkul])];
            $id_ruangan = $ruangan_list[array_rand($ruangan_list)];

            // Pengecekan bentrok ruangan
            if (!isRoomAvailable($conn, $id_ruangan, $day, $slot[0], $slot[1])) {
                continue; // Jika bentrok, lanjutkan ke slot waktu berikutnya
            }

            // Simpan jadwal
            $sql = "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_kelas, id_matkul, id_dosen, id_ruangan)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssiisi', $day, $slot[0], $slot[1], $id_kelas, $id_matkul, $id_dosen, $id_ruangan);
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error . "\n";
                exit; // Hentikan proses jika terjadi kesalahan
            } else {
                $week_schedule[$day][] = $id_matkul;
                $class_count++;
            }
        }
    }
}

echo "Jadwal berhasil digenerate";

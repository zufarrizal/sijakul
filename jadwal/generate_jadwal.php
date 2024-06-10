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

// Generate jadwal
$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$start_time = new DateTime('08:00');
$interval = new DateInterval('PT1H30M');
$max_classes_per_day = 4; // Maksimal 4 kelas per hari

foreach ($kelas_matkul as $id_kelas => $matkuls) {
    shuffle($matkuls); // Acak urutan matkul
    $week_schedule = []; // Untuk menyimpan jadwal mingguan kelas ini
    $class_count = 0;

    foreach ($days as $day) {
        if ($class_count >= count($matkuls)) break;

        for ($i = 0; $i < $max_classes_per_day; $i++) {
            if ($class_count >= count($matkuls)) break;

            $id_matkul = $matkuls[$class_count];

            // Pastikan matkul tidak sama dalam satu hari
            if (isset($week_schedule[$day]) && in_array($id_matkul, $week_schedule[$day])) {
                continue;
            }

            // Cek waktu untuk memastikan tidak berada di antara 11:30 dan 13:00
            $start = clone $start_time;
            $end = clone $start_time;
            $end->add($interval);

            if ($start->format('H:i') >= '11:30' && $start->format('H:i') < '13:00') {
                $start_time->setTime(13, 0);
                $end->setTime(13, 0)->add($interval);
            }

            // Tambahkan ke jadwal mingguan
            $week_schedule[$day][] = $id_matkul;

            // Pilih dosen dan ruangan secara acak untuk matkul ini dari daftar yang valid
            if (isset($dosen_matkul[$id_matkul]) && count($dosen_matkul[$id_matkul]) > 0) {
                $id_dosen = $dosen_matkul[$id_matkul][array_rand($dosen_matkul[$id_matkul])];
            } else {
                echo "Error: No dosen found for matkul id $id_matkul";
                exit;
            }
            $id_ruangan = $ruangan_list[array_rand($ruangan_list)];

            // Insert ke tabel jadwal
            $sql = "INSERT INTO jadwal (hari, jam_mulai, jam_selesai, id_kelas, id_matkul, id_dosen, id_ruangan) 
                    VALUES ('$day', '" . $start->format('H:i') . "', '" . $end->format('H:i') . "', $id_kelas, $id_matkul, $id_dosen, $id_ruangan)";
            if (!$conn->query($sql)) {
                echo "Error: " . $conn->error;
                exit;
            }

            $start_time->add(new DateInterval('PT15M')); // Tambahkan jeda 15 menit
            $class_count++;
        }
        $start_time = new DateTime('08:00'); // Reset start time untuk hari berikutnya
    }
}

echo "success";

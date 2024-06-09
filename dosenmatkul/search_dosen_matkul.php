<?php
include 'db_connection.php'; // Menghubungkan ke database

$query = strtolower($_GET['query']);
$column = $_GET['column'];

$allowed_columns = ['dosen', 'matkul']; // Kolom yang diizinkan untuk pencarian
if (!in_array($column, $allowed_columns)) {
    die('Kolom pencarian tidak valid.');
}

$search_query = "
    SELECT dm.id_dosenmatkul, d.nama_dosen, m.nama_matkul
    FROM dosen_matkul dm
    JOIN dosen d ON dm.id_dosen = d.id_dosen
    JOIN matkul m ON dm.id_matkul = m.id_matkul
    WHERE LOWER(d.nama_dosen) LIKE ? OR LOWER(m.nama_matkul) LIKE ?
";

// Debugging: Tampilkan query yang digunakan
// echo "Query: " . $search_query;

$stmt = $conn->prepare($search_query);

if (!$stmt) {
    die('Prepare statement error: ' . $conn->error); // Pesan error untuk debugging
}

$like_query = '%' . $query . '%';
$stmt->bind_param("ss", $like_query, $like_query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<tr>
        <td>' . $row['id_dosenmatkul'] . '</td>
        <td>' . strtoupper($row['nama_dosen']) . '</td>
        <td>' . strtoupper($row['nama_matkul']) . '</td>
        <td>
            <button class="btn btn-warning edit-btn" data-id="' . $row['id_dosenmatkul'] . '"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-danger delete-btn" data-id="' . $row['id_dosenmatkul'] . '"><i class="fas fa-trash-alt"></i> Hapus</button>
        </td>
    </tr>';
}

$stmt->close();
$conn->close();

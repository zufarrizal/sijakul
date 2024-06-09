<?php
include 'db_connection.php';

$sql = "SELECT id_ruangan, nama_ruangan, kapasitas FROM ruangan";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id_ruangan"] . "</td>
                <td>" . $row["nama_ruangan"] . "</td>
                <td>" . $row["kapasitas"] . "</td>
                <td>
                    <button class='btn btn-warning edit-btn' data-id='" . $row["id_ruangan"] . "'><i class='fas fa-edit'></i> Edit</button>
                    <button class='btn btn-danger delete-btn' data-id='" . $row["id_ruangan"] . "'><i class='fas fa-trash'></i> Hapus</button>
                </td>
              </tr>";
    }
} else {
    echo "0 results";
}
$conn->close();

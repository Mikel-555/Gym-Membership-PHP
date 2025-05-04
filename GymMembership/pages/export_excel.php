<?php
include('../config/db.php');

// Atur header agar browser mengunduh sebagai file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=daftar_member_" . date('Y-m-d') . ".xls");

// Mulai tabel HTML (Excel bisa membacanya)
echo "<table border='1'>";
echo "<tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Paket</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Kadaluarsa</th>
      </tr>";

// Ambil data dari database
$result = $conn->query("SELECT * FROM members ORDER BY expiry_date ASC");

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
    echo "<td>" . htmlspecialchars($row['package']) . "</td>";
    echo "<td>" . htmlspecialchars($row['registration_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['expiry_date']) . "</td>";
    echo "</tr>";
}

echo "</table>";
exit;
?>
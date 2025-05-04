<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include('config/db.php');

$where = '';
if (isset($_GET['before_date']) && $_GET['before_date'] !== '') {
    $before_date = $_GET['before_date'];
    $where = "WHERE expiry_date = '$before_date'";
}
// Ambil data member
$result = $conn->query("SELECT * FROM members $where ORDER BY expiry_date ASC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .filter-form {
            margin-top: 20px;
            text-align: center;
        }

        .filter-form input {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter-form button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            background-color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .expired {
            color: red;
        }

        .btn-extend {
            background-color: #28a745;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-extend:hover {
            background-color: #218838;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .left-links a {
            margin-right: 10px;
        }

        .filter-inline-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-inline-form input,
        .filter-inline-form button {
            padding: 6px 8px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter-inline-form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .filter-inline-form button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

<h2>Daftar Member</h2>

<div class="action-bar">
    <div class="left-links">
        <a href="pages/add_member.php" class="btn">+ Tambah Member</a>
        <a href="pages/export_excel.php" class="btn" target="_blank">📁 Export ke Excel</a>
        <a href="logout.php" class="btn" style="background-color:#dc3545;">Logout</a>
    </div>

    <form method="GET" class="filter-inline-form">
        <label>Filter Kadaluarsa sebelum:</label>
        <input type="date" name="before_date">
        <button type="submit">Filter</button>
    </form>
</div>

<table>
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Paket</th>
        <th>Tanggal Daftar</th>
        <th>Tanggal Kadaluarsa</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td><?= $row['package'] ?></td>
        <td><?= $row['registration_date'] ?></td>
        <td><?= $row['expiry_date'] ?></td>
        <td>
            <a href="pages/edit_member.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="pages/delete_member.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus member ini?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

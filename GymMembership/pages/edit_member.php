<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include('../config/db.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ../members.php");
    exit;
}

$result = $conn->query("SELECT * FROM members WHERE id = $id");
$member = $result->fetch_assoc();

if (!$member) {
    echo "Member tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $package = $_POST['package'];

    // Hitung ulang tanggal kadaluarsa jika paket diubah
    $registration_date = $member['registration_date'];
    $expiry_date = match($package) {
        '1 bulan' => date('Y-m-d', strtotime($registration_date . " +1 month")),
        '3 bulan' => date('Y-m-d', strtotime($registration_date . " +3 month")),
        default => $member['expiry_date']
    };

    $conn->query("UPDATE members SET name='$name', email='$email', phone='$phone', package='$package', expiry_date='$expiry_date' WHERE id=$id");
    header("Location: ../members.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            padding: 40px;
        }
        .form-container {
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        label {
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px 12px;
            margin: 8px 0 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Data Member</h2>
    <form method="POST">
        <label>Nama</label>
        <input type="text" name="name" value="<?= $member['name'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $member['email'] ?>" required>

        <label>No HP</label>
        <input type="text" name="phone" value="<?= $member['phone'] ?>" required>

        <label>Paket</label>
        <select name="package" required>
            <option value="1 bulan" <?= $member['package'] == '1 bulan' ? 'selected' : '' ?>>1 bulan</option>
            <option value="3 bulan" <?= $member['package'] == '3 bulan' ? 'selected' : '' ?>>3 bulan</option>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="../members.php">← Kembali ke Daftar Member</a>
</div>

</body>
</html>

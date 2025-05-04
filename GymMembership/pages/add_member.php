<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $package = $_POST['package'];
    $reg_date = date('Y-m-d');
    
    // Hitung tanggal kadaluarsa
    $exp_date = match($package) {
        'bulanan' => date('Y-m-d', strtotime("+1 month")),
        '3 bulan' => date('Y-m-d', strtotime("+3 month")),
        default => $reg_date
    };

    $conn->query("INSERT INTO members (name, email, phone, package, registration_date, expiry_date)
                  VALUES ('$name', '$email', '$phone', '$package', '$reg_date', '$exp_date')");
    header("Location: ../members.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Member</title>
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
            background: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
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
    <h2>Tambah Member Baru</h2>
    <form method="POST">
        <label>Nama</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>No HP</label>
        <input type="text" name="phone" required>

        <label>Paket</label>
        <select name="package" required>
            <option value="">-- Pilih Paket --</option>
            <option value="bulanan">1 bulan</option>
            <option value="3 bulan">3 bulan</option>
        </select>

        <button type="submit">Simpan</button>
    </form>
    <a href="../members.php">← Kembali ke Daftar Member</a>
</div>

</body>
</html>

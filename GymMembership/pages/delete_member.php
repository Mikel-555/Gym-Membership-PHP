<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

include('../config/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ../members.php"); // Ganti jika nama file daftar member berbeda
    exit;
} else {
    echo "ID tidak ditemukan!";
}
?>

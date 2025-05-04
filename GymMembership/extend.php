<?php
include('config/db.php');
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_POST['id'];
$extend = $_POST['extend'];

$member = $conn->query("SELECT expiry_date FROM members WHERE id = $id")->fetch_assoc();
$new_expiry = date('Y-m-d', strtotime($member['expiry_date'] . " + $extend"));

$conn->query("UPDATE members SET expiry_date = '$new_expiry' WHERE id = $id");
header("Location: members.php");
?>

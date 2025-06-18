<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}

include '../includes/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: admin-dashboard.php');
exit();

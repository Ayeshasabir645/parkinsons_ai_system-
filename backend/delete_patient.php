<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

include 'db.php';

$id = (int)$_GET['id'];


$sql = "DELETE FROM patients WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: dashboard.php?success=deleted");
} else {
    header("Location: dashboard.php?error=delete_failed");
}
exit();
?>

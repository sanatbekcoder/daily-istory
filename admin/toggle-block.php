<?php

require_once "middleware/admin-auth.php";

if (!isset($_GET["id"])) {
    exit;
}

$id = $_GET["id"];

$query = $pdo->prepare("
    SELECT status
    FROM users
    WHERE id = ?
");

$query->execute([$id]);

$user = $query->fetch(PDO::FETCH_ASSOC);

$newStatus =

    $user["status"] == "active"

    ? "blocked"

    : "active";

$update = $pdo->prepare("
    UPDATE users
    SET status = ?
    WHERE id = ?
");

$update->execute([
    $newStatus,
    $id
]);

header("Location: users.php");
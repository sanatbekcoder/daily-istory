<?php

require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET["id"])) {
    die("Plan ID missing!");
}

$id = $_GET["id"];

$update = $pdo->prepare("
    UPDATE plans
    SET status = 'completed'
    WHERE id = ?
    AND user_id = ?
");

$update->execute([
    $id,
    $_SESSION["user_id"]
]);

header("Location: ../dashboard.php");
exit;
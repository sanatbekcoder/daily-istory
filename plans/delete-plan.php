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


/*
|--------------------------------------------------------------------------
| Check plan owner
|--------------------------------------------------------------------------
*/

$query = $pdo->prepare("
    SELECT *
    FROM plans
    WHERE id = ?
    AND user_id = ?
");

$query->execute([
    $id,
    $_SESSION["user_id"]
]);

$plan = $query->fetch(PDO::FETCH_ASSOC);

if (!$plan) {
    die("Plan not found!");
}


/*
|--------------------------------------------------------------------------
| Delete plan
|--------------------------------------------------------------------------
*/

$delete = $pdo->prepare("
    DELETE FROM plans
    WHERE id = ?
");

$delete->execute([$id]);

header("Location: ../dashboard.php");
exit;
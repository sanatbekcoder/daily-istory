<?php

require_once __DIR__ . "/../../config/database.php";

require_once __DIR__ . "/../../config/session.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION["role"] != "admin") {

    die("Access denied 🚫");
}
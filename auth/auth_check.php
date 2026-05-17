<?php

require_once "../config/session.php";

/*
|--------------------------------------------------------------------------
| Security Headers
|--------------------------------------------------------------------------
*/

header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer-when-downgrade");

/*
|--------------------------------------------------------------------------
| Session Check
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["user_id"]) ||
    empty($_SESSION["user_id"])
) {

    header("Location: ../auth/login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Optional Session Security
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["user_agent"])
) {

    $_SESSION["user_agent"] =
        $_SERVER["HTTP_USER_AGENT"];

} elseif (
    $_SESSION["user_agent"] !==
    $_SERVER["HTTP_USER_AGENT"]
) {

    session_destroy();

    header("Location: ../auth/login.php");
    exit;
}
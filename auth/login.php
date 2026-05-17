<?php

require_once "../config/database.php";
require_once "../config/session.php";
require_once "../config/timezone.php";

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
| Redirect if logged in
|--------------------------------------------------------------------------
*/

if (isset($_SESSION["user_id"])) {

    if (
        isset($_SESSION["role"]) &&
        $_SESSION["role"] == "admin"
    ) {

        header("Location: ../admin/index.php");

    } else {

        header("Location: ../dashboard.php");
    }

    exit;
}

$message = "";

/*
|--------------------------------------------------------------------------
| Login System
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username =
        trim($_POST["username"]);

    $password =
        trim($_POST["password"]);

    if (
        !empty($username) &&
        !empty($password)
    ) {

        $query = $pdo->prepare("
            SELECT *
            FROM users
            WHERE username = ?
            LIMIT 1
        ");

        $query->execute([
            $username
        ]);

        $user =
            $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {

            /*
            |--------------------------------------------------------------------------
            | Block Check
            |--------------------------------------------------------------------------
            */

            if (
                isset($user["status"]) &&
                $user["status"] == "blocked"
            ) {

                $message =
                    "Akkaunt bloklangan 🚫";

            } else {

                /*
                |--------------------------------------------------------------------------
                | Password Verify
                |--------------------------------------------------------------------------
                */

                if (
                    password_verify(
                        $password,
                        $user["password"]
                    )
                ) {

                    session_regenerate_id(true);

                    /*
                    |--------------------------------------------------------------------------
                    | Sessions
                    |--------------------------------------------------------------------------
                    */

                    $_SESSION["user_id"] =
                        $user["id"];

                    $_SESSION["fullname"] =
                        $user["fullname"];

                    $_SESSION["username"] =
                        $user["username"];

                    $_SESSION["role"] =
                        $user["role"];

                    /*
                    |--------------------------------------------------------------------------
                    | Redirect
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $user["role"] == "admin"
                    ) {

                        header(
                            "Location: ../admin/index.php"
                        );

                    } else {

                        header(
                            "Location: ../dashboard.php"
                        );
                    }

                    exit;

                } else {

                    $message =
                        "Parol noto‘g‘ri!";
                }
            }

        } else {

            $message =
                "Foydalanuvchi topilmadi!";
        }

    } else {

        $message =
            "Barcha maydonlarni to‘ldiring!";
    }
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Kirish • Daily-Istory
    </title>

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-block-size: 100vh;
            background:
                linear-gradient(135deg,
                    #dbeafe,
                    #f8fbff);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        a {
            text-decoration: none;
        }

        .login-container {
            inline-size: 100%;
            max-inline-size: 450px;
            background: white;
            border-radius: 30px;
            padding: 45px;
            box-shadow:
                0 20px 50px rgba(37, 99, 235, 0.12);
        }

        .logo {
            text-align: center;
            font-size: 34px;
            font-weight: 800;
            color: #2563eb;
            margin-block-end: 10px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-block-end: 35px;
            line-height: 1.7;
        }

        .message {
            background: #eff6ff;
            color: #2563eb;
            padding: 14px;
            border-radius: 12px;
            margin-block-end: 20px;
            text-align: center;
            font-size: 14px;
        }

        .input-group {
            margin-block-end: 20px;
        }

        .input-group label {
            display: block;
            margin-block-end: 8px;
            color: #0f172a;
            font-weight: 600;
        }

        .input-group input {
            inline-size: 100%;
            padding: 15px;
            border: 2px solid #dbeafe;
            border-radius: 14px;
            font-size: 15px;
            transition: 0.3s;
            outline: none;
        }

        .input-group input:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .login-btn {
            inline-size: 100%;
            padding: 16px;
            border: none;
            border-radius: 14px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 30px rgba(37, 99, 235, 0.25);
        }

        .bottom-text {
            margin-block-start: 25px;
            text-align: center;
            color: #64748b;
        }

        .bottom-text a {
            color: #2563eb;
            font-weight: 600;
        }

        @media(max-inline-size:500px) {

            .login-container {
                padding: 30px;
            }

            .logo {
                font-size: 28px;
            }
        }
    </style>

</head>

<body>

    <div class="login-container">

        <div class="logo">
            Daily-Istory 📔
        </div>

        <p class="subtitle">

            Kunlik rejalaringizni boshqaring,
            vazifalaringizni kuzating
            va maqsadlaringiz sari harakat qiling.

        </p>



        <!-- Message -->

        <?php if (!empty($message)): ?>

            <div class="message">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php endif; ?>



        <!-- Login Form -->

        <form method="POST" autocomplete="off">

            <div class="input-group">

                <label>
                    Foydalanuvchi nomi
                </label>

                <input type="text" name="username" placeholder="Username kiriting" required>

            </div>



            <div class="input-group">

                <label>
                    Parol
                </label>

                <input type="password" name="password" placeholder="Parol kiriting" required>

            </div>



            <button type="submit" class="login-btn">
                Tizimga Kirish
            </button>

        </form>



        <div class="bottom-text">

            Akkauntingiz yo‘qmi?

            <a href="register.php">

                Ro‘yxatdan o‘tish

            </a>

        </div>

    </div>

</body>

</html>
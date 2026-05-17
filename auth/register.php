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
    header("Location: ../dashboard.php");
    exit;
}

$message = "";

/*
|--------------------------------------------------------------------------
| Register System
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (
        !empty($fullname) &&
        !empty($username) &&
        !empty($password)
    ) {

        /*
        |--------------------------------------------------------------------------
        | Username Validation
        |--------------------------------------------------------------------------
        */

        if (
            strlen($username) < 3 ||
            strlen($username) > 20
        ) {

            $message =
                "Username 3-20 ta belgidan iborat bo‘lishi kerak!";

        } elseif (
            !preg_match('/^[a-zA-Z0-9_]+$/', $username)
        ) {

            $message =
                "Username faqat harf, raqam va _ dan iborat bo‘lishi mumkin!";

        } elseif (
            strlen($password) < 6
        ) {

            $message =
                "Parol kamida 6 ta belgidan iborat bo‘lishi kerak!";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Check Username
            |--------------------------------------------------------------------------
            */

            $check = $pdo->prepare("
                SELECT id
                FROM users
                WHERE username = ?
                LIMIT 1
            ");

            $check->execute([$username]);

            if ($check->rowCount() > 0) {

                $message =
                    "Bu username band!";

            } else {

                /*
                |--------------------------------------------------------------------------
                | Hash Password
                |--------------------------------------------------------------------------
                */

                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                /*
                |--------------------------------------------------------------------------
                | Insert User
                |--------------------------------------------------------------------------
                */

                $insert = $pdo->prepare("
                    INSERT INTO users
                    (
                        fullname,
                        username,
                        password
                    )
                    VALUES (?, ?, ?)
                ");

                $insert->execute([
                    $fullname,
                    $username,
                    $hashedPassword
                ]);

                header("Location: login.php");
                exit;
            }
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

    <title>Ro‘yxatdan o‘tish • Daily-Istory</title>

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

        .register-container {
            inline-size: 100%;
            max-inline-size: 500px;
            background: white;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 20px 50px rgba(37, 99, 235, 0.12);
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
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .register-btn {
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

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.25);
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

        .info-box {
            margin-block-start: 30px;
            background: #f8fbff;
            padding: 18px;
            border-radius: 16px;
            border-inline-start: 5px solid #2563eb;
        }

        .info-box h4 {
            color: #0f172a;
            margin-block-end: 10px;
        }

        .info-box p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        @media(max-inline-size:500px) {

            .register-container {
                padding: 30px;
            }

            .logo {
                font-size: 28px;
            }
        }
    </style>

</head>

<body>

    <div class="register-container">

        <div class="logo">
            Daily-Istory
        </div>

        <p class="subtitle">

            Rejalaringizni boshqarish uchun
            yangi akkaunt yarating va
            samarali hayot sari qadam tashlang.

        </p>

        <?php if (!empty($message)): ?>

            <div class="message">

                <?php echo htmlspecialchars($message); ?>

            </div>

        <?php endif; ?>



        <!-- Register Form -->

        <form method="POST" autocomplete="off">

            <div class="input-group">

                <label>
                    To‘liq ism
                </label>

                <input type="text" name="fullname" placeholder="Ismingizni kiriting" required>

            </div>



            <div class="input-group">

                <label>
                    Username
                </label>

                <input type="text" name="username" placeholder="Username yarating" required>

            </div>



            <div class="input-group">

                <label>
                    Parol
                </label>

                <input type="password" name="password" placeholder="Parol yarating" required>

            </div>



            <button type="submit" class="register-btn">
                Ro‘yxatdan o‘tish
            </button>

        </form>



        <div class="bottom-text">

            Akkauntingiz bormi?

            <a href="login.php">
                Tizimga kirish
            </a>

        </div>



        <!-- Info -->

        <div class="info-box">

            <h4>
                🚀 Smart Rejalashtirish
            </h4>

            <p>

                Daily-Istory yordamida
                kunlik vazifalaringizni yozing,
                bajarilgan ishlarni kuzating
                va vaqtni samarali boshqaring.

            </p>

        </div>

    </div>

</body>

</html>
<?php

require_once "config/database.php";
require_once "config/session.php";
require_once "config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;
}

$userId = $_SESSION["user_id"];

/*
|--------------------------------------------------------------------------
| Get User
|--------------------------------------------------------------------------
*/

$query = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$query->execute([$userId]);

$user = $query->fetch(PDO::FETCH_ASSOC);

$message = "";
$passwordMessage = "";

/*
|--------------------------------------------------------------------------
| Update Fullname Only
|--------------------------------------------------------------------------
*/

if (isset($_POST["update_profile"])) {

    $fullname =
        trim($_POST["fullname"]);

    if (!empty($fullname)) {

        $update = $pdo->prepare("
            UPDATE users
            SET fullname = ?
            WHERE id = ?
        ");

        $update->execute([
            $fullname,
            $userId
        ]);

        $_SESSION["fullname"] =
            $fullname;

        $message =
            "Profil yangilandi ✅";

        header("Refresh:1");

    } else {

        $message =
            "Ism bo‘sh bo‘lmasligi kerak!";
    }
}

/*
|--------------------------------------------------------------------------
| Change Password
|--------------------------------------------------------------------------
*/

if (isset($_POST["change_password"])) {

    $currentPassword =
        trim($_POST["current_password"]);

    $newPassword =
        trim($_POST["new_password"]);

    $confirmPassword =
        trim($_POST["confirm_password"]);

    if (
        !empty($currentPassword) &&
        !empty($newPassword) &&
        !empty($confirmPassword)
    ) {

        if (
            password_verify(
                $currentPassword,
                $user["password"]
            )
        ) {

            if (
                strlen($newPassword) < 6
            ) {

                $passwordMessage =
                    "Parol kamida 6 ta belgidan iborat bo‘lishi kerak!";

            } elseif (
                $newPassword ==
                $confirmPassword
            ) {

                $hashedPassword =
                    password_hash(
                        $newPassword,
                        PASSWORD_DEFAULT
                    );

                $updatePassword =
                    $pdo->prepare("
                        UPDATE users
                        SET password = ?
                        WHERE id = ?
                    ");

                $updatePassword->execute([
                    $hashedPassword,
                    $userId
                ]);

                $passwordMessage =
                    "Parol muvaffaqiyatli o‘zgartirildi ✅";

            } else {

                $passwordMessage =
                    "Yangi parollar mos emas!";
            }

        } else {

            $passwordMessage =
                "Joriy parol noto‘g‘ri!";
        }

    } else {

        $passwordMessage =
            "Barcha maydonlarni to‘ldiring!";
    }
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil</title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
        }

        .profile-card {
            max-inline-size: 850px;
            margin: auto;
            margin-block-start: 60px;
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
            margin-block-end: 30px;
        }

        .page-title {
            font-size: 40px;
            font-weight: 700;
            color: #2563eb;
            margin-block-end: 10px;
        }

        .page-subtitle {
            color: #64748b;
            margin-block-end: 35px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #0f172a;
            margin-block-end: 25px;
        }

        .form-control {
            padding: 14px;
            border-radius: 14px;
        }

        .form-label {
            font-weight: 600;
            color: #0f172a;
        }

        .btn-custom {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 14px;
            padding: 14px;
            inline-size: 100%;
            font-weight: 600;
        }

        .btn-custom:hover {
            background: #1d4ed8;
            color: white;
        }

        .username-box {
            background: #f1f5f9;
            padding: 14px;
            border-radius: 14px;
            color: #64748b;
        }

        .security-box {
            background: #eff6ff;
            border-inline-start: 5px solid #2563eb;
            padding: 20px;
            border-radius: 18px;
            margin-block-start: 30px;
        }
    </style>

</head>

<body>

    <?php
    include "includes/navbar.php";
    ?>

    <div class="container py-5">

        <!-- Profile -->

        <div class="profile-card">

            <h1 class="page-title">
                Profil 👤
            </h1>

            <p class="page-subtitle">

                Profil ma’lumotlaringizni
                boshqaring va xavfsizlikni nazorat qiling.

            </p>



            <!-- Message -->

            <?php if (!empty($message)): ?>

                <div class="alert alert-primary">

                    <?php echo $message; ?>

                </div>

            <?php endif; ?>



            <!-- User Info -->

            <h2 class="section-title">

                Foydalanuvchi Ma’lumotlari

            </h2>

            <form method="POST">

                <div class="mb-4">

                    <label class="form-label">
                        To‘liq ism
                    </label>

                    <input type="text" name="fullname" class="form-control" value="<?php
                    echo htmlspecialchars(
                        $user["fullname"]
                    );
                    ?>" required>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Username
                    </label>

                    <div class="username-box">

                        @<?php
                        echo htmlspecialchars(
                            $user["username"]
                        );
                        ?>

                    </div>

                </div>



                <button type="submit" name="update_profile" class="btn-custom">
                    Profilni Yangilash
                </button>

            </form>

        </div>



        <!-- Password -->

        <div class="profile-card">

            <h2 class="section-title">

                Parolni O‘zgartirish 🔐

            </h2>



            <?php if (!empty($passwordMessage)): ?>

                <div class="alert alert-primary">

                    <?php
                    echo $passwordMessage;
                    ?>

                </div>

            <?php endif; ?>



            <form method="POST">

                <div class="mb-4">

                    <label class="form-label">
                        Joriy parol
                    </label>

                    <input type="password" name="current_password" class="form-control" required>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Yangi parol
                    </label>

                    <input type="password" name="new_password" class="form-control" required>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Yangi parolni tasdiqlang
                    </label>

                    <input type="password" name="confirm_password" class="form-control" required>

                </div>



                <button type="submit" name="change_password" class="btn-custom">
                    Parolni Yangilash
                </button>

            </form>



            <!-- Security -->

            <div class="security-box">

                <h5>
                    🔒 Xavfsizlik
                </h5>

                <p class="mb-0 mt-2">

                    Kuchli parol ishlating
                    va akkauntingizni himoyalang.

                </p>

            </div>

        </div>

    </div>

    <?php
    include "includes/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
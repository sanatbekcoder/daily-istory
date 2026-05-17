<?php

require_once "../config/database.php";
require_once "../config/session.php";
require_once "../config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: ../auth/login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Check Plan ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"])) {

    die("Reja ID topilmadi!");
}

$id = $_GET["id"];

/*
|--------------------------------------------------------------------------
| Get Plan
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

    die("Reja topilmadi!");
}

/*
|--------------------------------------------------------------------------
| Time Check
|--------------------------------------------------------------------------
*/

$currentDateTime = date("Y-m-d H:i:s");

$planDateTime =
    $plan["plan_date"] . " " .
    $plan["plan_time"] . ":00";

$isPast =
    strtotime($currentDateTime) >
    strtotime($planDateTime);

if (!$isPast) {

    die("Bu rejani hali missed qilib bo‘lmaydi!");
}

$message = "";

/*
|--------------------------------------------------------------------------
| Missed Plan
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $comment = trim($_POST["comment"]);

    if (!empty($comment)) {

        $update = $pdo->prepare("
            UPDATE plans
            SET
                status = 'missed',
                comment = ?
            WHERE id = ?
        ");

        $update->execute([
            $comment,
            $id
        ]);

        header("Location: ../dashboard.php");
        exit;

    } else {

        $message =
            "Sabab yozilishi majburiy!";
    }
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reja bajarilmadi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
        }

        .missed-card {
            max-inline-size: 700px;
            margin: auto;
            margin-block-start: 70px;
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #dc2626;
            margin-block-end: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-block-end: 30px;
            line-height: 1.7;
        }

        .plan-box {
            background: #fef2f2;
            border-inline-start: 5px solid #dc2626;
            padding: 20px;
            border-radius: 16px;
            margin-block-end: 25px;
        }

        .plan-box h4 {
            margin-block-end: 10px;
            color: #0f172a;
        }

        textarea {
            inline-size: 100%;
            min-block-size: 160px;
            border: 1px solid #dbeafe;
            border-radius: 16px;
            padding: 16px;
            resize: none;
            outline: none;
        }

        textarea:focus {
            border-color: #2563eb;
        }

        .btn-custom {
            inline-size: 100%;
            background: #dc2626;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 14px;
            font-weight: 600;
            margin-block-start: 20px;
        }

        .btn-custom:hover {
            background: #b91c1c;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="missed-card">

            <h1 class="title">
                Reja bajarilmadi ❌
            </h1>

            <p class="subtitle">

                Reja nima sababdan bajarilmaganini yozing.
                Bu ma’lumot keyinchalik tarixda saqlanadi.

            </p>



            <!-- Message -->

            <?php if (!empty($message)): ?>

                <div class="alert alert-danger">

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>



            <!-- Plan Info -->

            <div class="plan-box">

                <h4>

                    <?php
                    echo htmlspecialchars($plan["title"]);
                    ?>

                </h4>

                <p>

                    📅
                    <?php echo $plan["plan_date"]; ?>

                    |

                    ⏰
                    <?php echo $plan["plan_time"]; ?>

                </p>

            </div>



            <!-- Form -->

            <form method="POST">

                <label class="form-label mb-2">

                    Sabab yozing

                </label>

                <textarea name="comment"
                    placeholder="Masalan: vaqt yetmadi, internet bo‘lmadi, boshqa ish chiqib qoldi..."
                    required></textarea>

                <button type="submit" class="btn-custom">
                    Sababni Saqlash
                </button>

            </form>



            <div class="text-center mt-4">

                <a href="../dashboard.php" class="text-primary">
                    ← Dashboardga qaytish
                </a>

            </div>

        </div>

    </div>

</body>

</html>
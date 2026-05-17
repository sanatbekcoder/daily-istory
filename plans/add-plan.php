<?php

require_once "../config/database.php";
require_once "../config/session.php";
require_once "../config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: ../auth/login.php");
    exit;
}

$message = "";

/*
|--------------------------------------------------------------------------
| Add Plan
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $plan_date = $_POST["plan_date"];
    $plan_time = $_POST["plan_time"];

    if (
        !empty($title) &&
        !empty($plan_date) &&
        !empty($plan_time)
    ) {

        /*
        |--------------------------------------------------------------------------
        | DateTime Validation
        |--------------------------------------------------------------------------
        */

        $currentDateTime = date("Y-m-d H:i:s");

        $planDateTime =
            $plan_date . " " .
            $plan_time . ":00";

        if (
            strtotime($planDateTime) <
            strtotime($currentDateTime)
        ) {

            $message =
                "O‘tib ketgan vaqt uchun reja qo‘shib bo‘lmaydi!";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Insert Plan
            |--------------------------------------------------------------------------
            */

            $insert = $pdo->prepare("
                INSERT INTO plans
                (
                    user_id,
                    title,
                    description,
                    plan_date,
                    plan_time
                )
                VALUES (?, ?, ?, ?, ?)
            ");

            $insert->execute([
                $_SESSION["user_id"],
                $title,
                $description,
                $plan_date,
                $plan_time
            ]);

            $message =
                "Reja muvaffaqiyatli qo‘shildi ✅";
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

    <title>Reja qo‘shish</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
        }

        .plan-card {
            max-inline-size: 700px;
            margin: auto;
            margin-block-start: 60px;
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #2563eb;
            margin-block-end: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-block-end: 30px;
        }

        .form-control {
            padding: 14px;
            border-radius: 14px;
        }

        textarea {
            resize: none;
            min-block-size: 140px;
        }

        .btn-custom {
            background: #2563eb;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 14px;
            inline-size: 100%;
            font-weight: 600;
        }

        .btn-custom:hover {
            background: #1d4ed8;
            color: white;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="plan-card">

            <h1 class="title">
                Yangi Reja Qo‘shish 📔
            </h1>

            <p class="subtitle">

                Kunlik vazifalaringizni yozing
                va rejalaringizni boshqaring.

            </p>



            <?php if (!empty($message)): ?>

                <div class="alert alert-primary">

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>



            <!-- Form -->

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Reja nomi
                    </label>

                    <input type="text" name="title" class="form-control" placeholder="Masalan: PHP dars qilish"
                        required>

                </div>



                <div class="mb-3">

                    <label class="form-label">
                        Tavsif
                    </label>

                    <textarea name="description" class="form-control"
                        placeholder="Reja haqida qisqacha yozing..."></textarea>

                </div>



                <div class="mb-3">

                    <label class="form-label">
                        Sana
                    </label>

                    <div class="d-flex gap-2">

                        <input type="date" name="plan_date" id="planDate" class="form-control" required>

                        <button type="button" class="btn btn-outline-primary" id="todayBtn">
                            Bugun
                        </button>

                    </div>

                </div>



                <div class="mb-4">

                    <label class="form-label">
                        Vaqt
                    </label>

                    <input type="time" name="plan_time" class="form-control" required>

                </div>



                <button type="submit" class="btn-custom">
                    Reja Qo‘shish
                </button>

            </form>



            <div class="text-center mt-4">

                <a href="../dashboard.php" class="text-primary">
                    ← Dashboardga qaytish
                </a>

            </div>

        </div>

    </div>
    <script>

        /*
        |--------------------------------------------------------------------------
        | Today Button
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("todayBtn")
            .addEventListener("click", () => {

                let today = new Date();

                let year =
                    today.getFullYear();

                let month =
                    String(
                        today.getMonth() + 1
                    ).padStart(2, "0");

                let day =
                    String(
                        today.getDate()
                    ).padStart(2, "0");

                let formattedDate =
                    year + "-" + month + "-" + day;

                document
                    .getElementById("planDate")
                    .value = formattedDate;

            });

    </script>
</body>

</html>
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

    die("Reja topilmadi!");
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

    die("Reja mavjud emas!");
}

/*
|--------------------------------------------------------------------------
| Time Lock System
|--------------------------------------------------------------------------
*/

$currentTimestamp = time();

$planTimestamp = strtotime(

    $plan["plan_date"] . " " .
    $plan["plan_time"]

);

/*
|--------------------------------------------------------------------------
| Lock Only Past Plans
|--------------------------------------------------------------------------
*/

$isLocked =
    $currentTimestamp >
    $planTimestamp;
$message = "";

/*
|--------------------------------------------------------------------------
| Update Plan
|--------------------------------------------------------------------------
*/

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    !$isLocked
) {

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
        | Future Validation
        |--------------------------------------------------------------------------
        */

        $newPlanDateTime =
            $plan_date . " " .
            $plan_time . ":00";

        if (
            strtotime($newPlanDateTime) <
            strtotime($currentDateTime)
        ) {

            $message =
                "O‘tib ketgan vaqtni tanlab bo‘lmaydi!";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Update Database
            |--------------------------------------------------------------------------
            */

            $update = $pdo->prepare("
                UPDATE plans
                SET
                    title = ?,
                    description = ?,
                    plan_date = ?,
                    plan_time = ?
                WHERE id = ?
            ");

            $update->execute([
                $title,
                $description,
                $plan_date,
                $plan_time,
                $id
            ]);

            header("Location: ../dashboard.php");
            exit;
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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Rejani Tahrirlash</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>

        body{
            font-family:'Poppins', sans-serif;
            background:#f8fbff;
        }

        .edit-card{
            max-inline-size:700px;
            margin:auto;
            margin-block-start:60px;
            background:white;
            padding:40px;
            border-radius:25px;
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
        }

        .title{
            font-size:32px;
            font-weight:700;
            color:#2563eb;
            margin-block-end:10px;
        }

        .subtitle{
            color:#64748b;
            margin-block-end:30px;
        }

        .form-control{
            padding:14px;
            border-radius:14px;
        }

        textarea{
            resize:none;
            min-block-size:140px;
        }

        .btn-custom{
            background:#2563eb;
            color:white;
            padding:14px;
            border:none;
            border-radius:14px;
            inline-size:100%;
            font-weight:600;
        }

        .btn-custom:hover{
            background:#1d4ed8;
            color:white;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="edit-card">

        <h1 class="title">
            Rejani Tahrirlash ✏️
        </h1>

        <p class="subtitle">

            Rejangizni yangilang
            va o‘zgarishlarni saqlang.

        </p>



        <!-- Locked Warning -->

        <?php if ($isLocked): ?>

            <div class="alert alert-danger">

                Bu reja bloklangan ⛔
                Chunki belgilangan vaqt o‘tib ketgan.

            </div>

        <?php endif; ?>



        <!-- Message -->

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

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="<?php echo htmlspecialchars($plan['title']); ?>"
                    <?php echo $isLocked ? 'disabled' : ''; ?>
                >

            </div>



            <div class="mb-3">

                <label class="form-label">
                    Tavsif
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    <?php echo $isLocked ? 'disabled' : ''; ?>
                ><?php echo htmlspecialchars($plan['description']); ?></textarea>

            </div>



            <div class="mb-3">

    <label class="form-label">
        Sana
    </label>

    <div class="d-flex gap-2">

        <input
            type="date"
            name="plan_date"
            id="planDate"
            class="form-control"
            value="<?php echo $plan['plan_date']; ?>"
            <?php echo $isLocked ? 'disabled' : ''; ?>
        >

        <?php if (!$isLocked): ?>

            <button
                type="button"
                class="btn btn-outline-primary"
                id="todayBtn"
            >
                Bugun
            </button>

        <?php endif; ?>

    </div>

</div>



            <div class="mb-4">

                <label class="form-label">
                    Vaqt
                </label>

                <input
                    type="time"
                    name="plan_time"
                    class="form-control"
                    value="<?php echo $plan['plan_time']; ?>"
                    <?php echo $isLocked ? 'disabled' : ''; ?>
                >

            </div>



            <?php if (!$isLocked): ?>

                <button
                    type="submit"
                    class="btn-custom"
                >
                    Rejani Yangilash
                </button>

            <?php endif; ?>

        </form>



        <div class="text-center mt-4">

            <a
                href="../dashboard.php"
                class="text-primary"
            >
                ← Dashboardga qaytish
            </a>

        </div>

    </div>

</div>
<script>

const todayBtn =
    document.getElementById("todayBtn");

if (todayBtn) {

    todayBtn.addEventListener(
        "click",
        () => {

            let today =
                new Date();

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

                year + "-" +
                month + "-" +
                day;

            document
            .getElementById("planDate")
            .value = formattedDate;
        }
    );
}

</script>
</body>
</html>
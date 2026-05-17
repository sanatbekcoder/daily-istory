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
| Check ID
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
| Status Class
|--------------------------------------------------------------------------
*/

$statusClass = "";

if ($plan["status"] == "pending") {

    $statusClass = "pending";
}

if ($plan["status"] == "completed") {

    $statusClass = "completed";
}

if ($plan["status"] == "missed") {

    $statusClass = "missed";
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rejani Ko‘rish</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
        }

        .view-card {
            max-inline-size: 850px;
            margin: auto;
            margin-block-start: 60px;
            background: white;
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-block-end: 30px;
        }

        .title {
            font-size: 38px;
            font-weight: 700;
            color: #0f172a;
        }

        .status {
            padding: 10px 18px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .missed {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-box {
            background: #f8fbff;
            border-radius: 20px;
            padding: 25px;
            margin-block-end: 25px;
        }

        .info-title {
            color: #64748b;
            font-size: 14px;
            margin-block-end: 8px;
        }

        .info-content {
            color: #0f172a;
            font-size: 18px;
            line-height: 1.8;
        }

        .btn-custom {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-custom:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-danger-custom {
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-danger-custom:hover {
            background: #b91c1c;
            color: white;
        }

        .button-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-block-start: 30px;
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="view-card">

            <!-- Top -->

            <div class="top">

                <h1 class="title">

                    <?php
                    echo htmlspecialchars($plan["title"]);
                    ?>

                </h1>



                <div class="status <?php echo $statusClass; ?>">

                    <?php

                    if ($plan["status"] == "pending") {
                        echo "Jarayonda";
                    }

                    if ($plan["status"] == "completed") {
                        echo "Bajarilgan";
                    }

                    if ($plan["status"] == "missed") {
                        echo "Bajarilmagan";
                    }

                    ?>

                </div>

            </div>



            <!-- Description -->

            <div class="info-box">

                <div class="info-title">
                    Tavsif
                </div>

                <div class="info-content">

                    <?php

                    if (!empty($plan["description"])) {

                        echo nl2br(
                            htmlspecialchars(
                                $plan["description"]
                            )
                        );

                    } else {

                        echo "Tavsif mavjud emas.";
                    }

                    ?>

                </div>

            </div>



            <!-- Date -->

            <div class="info-box">

                <div class="info-title">
                    Sana
                </div>

                <div class="info-content">

                    📅
                    <?php echo $plan["plan_date"]; ?>

                </div>

            </div>



            <!-- Time -->

            <div class="info-box">

                <div class="info-title">
                    Vaqt
                </div>

                <div class="info-content">

                    ⏰
                    <?php echo $plan["plan_time"]; ?>

                </div>

            </div>



            <!-- Missed Comment -->

            <?php if (!empty($plan["comment"])): ?>

                <div class="info-box">

                    <div class="info-title">
                        Bajarilmaganlik sababi
                    </div>

                    <div class="info-content">

                        💬

                        <?php
                        echo nl2br(
                            htmlspecialchars(
                                $plan["comment"]
                            )
                        );
                        ?>

                    </div>

                </div>

            <?php endif; ?>



            <!-- Created -->

            <?php if (isset($plan["created_at"])): ?>

                <div class="info-box">

                    <div class="info-title">
                        Qo‘shilgan vaqt
                    </div>

                    <div class="info-content">

                        🕒
                        <?php echo $plan["created_at"]; ?>

                    </div>

                </div>

            <?php endif; ?>



            <!-- Buttons -->

            <div class="button-group">

                <a href="edit-plan.php?id=<?php echo $plan['id']; ?>" class="btn-custom">
                    Rejani Tahrirlash
                </a>

                <a href="delete-plan.php?id=<?php echo $plan['id']; ?>" class="btn-danger-custom"
                    onclick="return confirm('Rejani o‘chirmoqchimisiz?')">
                    Rejani O‘chirish
                </a>

                <a href="../dashboard.php" class="btn btn-outline-primary">
                    Dashboard
                </a>

            </div>

        </div>

    </div>

</body>

</html>
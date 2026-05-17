<?php

require_once "config/database.php";
require_once "config/session.php";
require_once "config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Get Plans
|--------------------------------------------------------------------------
*/

$query = $pdo->prepare("
    SELECT *
    FROM plans
    WHERE user_id = ?
    ORDER BY
    plan_date ASC,
    plan_time ASC
");

$query->execute([
    $_SESSION["user_id"]
]);

$plans = $query->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$totalPlans = count($plans);

$completedPlans = 0;
$missedPlans = 0;
$pendingPlans = 0;

foreach ($plans as $plan) {

    if ($plan["status"] == "completed") {
        $completedPlans++;
    }

    if ($plan["status"] == "missed") {
        $missedPlans++;
    }

    if ($plan["status"] == "pending") {
        $pendingPlans++;
    }
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

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

        .hero-box {
            background: linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            border-radius: 30px;
            padding: 40px;
            color: white;
            margin-block-end: 35px;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            margin-block-end: 10px;
        }

        .hero-text {
            color: #dbeafe;
            font-size: 18px;
        }

        .stats-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-number {
            font-size: 36px;
            font-weight: 700;
            color: #2563eb;
        }

        .stats-title {
            color: #64748b;
            margin-block-start: 8px;
        }

        .section-title {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-block-end: 25px;
        }

        .plan-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            margin-block-end: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .plan-card:hover {
            transform: translateY(-4px);
        }

        .plan-title {
            font-size: 28px;
            font-weight: 600;
            color: #0f172a;
            margin-block-end: 10px;
        }

        .plan-description {
            color: #64748b;
            line-height: 1.8;
            margin-block-end: 18px;
        }

        .plan-info {
            color: #475569;
            margin-block-end: 10px;
        }

        .status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-block-start: 10px;
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

        .button-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-block-start: 20px;
        }

        .btn-custom {
            border: none;
            border-radius: 14px;
            padding: 12px 20px;
            font-weight: 600;
        }

        .empty-box {
            background: white;
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .comment-box {
            background: #f8fbff;
            padding: 18px;
            border-radius: 16px;
            margin-block-start: 20px;
        }
    </style>

</head>

<body>

    <?php
    include "includes/navbar.php";
    ?>

    <div class="container py-5">

        <!-- Hero -->

        <div class="hero-box">

            <h1 class="hero-title">

                Xush kelibsiz,
                <?php
                echo htmlspecialchars(
                    $_SESSION["fullname"]
                );
                ?> 🚀

            </h1>

            <p class="hero-text">

                Bugungi rejalaringizni kuzating,
                maqsadlaringizni boshqaring
                va samaradorlikni oshiring.

            </p>

        </div>



        <!-- Statistics -->

        <div class="row g-4 mb-5">

            <div class="col-md-3">

                <div class="stats-card">

                    <div class="stats-number">
                        <?php echo $totalPlans; ?>
                    </div>

                    <div class="stats-title">
                        Jami Rejalar
                    </div>

                </div>

            </div>



            <div class="col-md-3">

                <div class="stats-card">

                    <div class="stats-number">
                        <?php echo $completedPlans; ?>
                    </div>

                    <div class="stats-title">
                        Bajarilgan
                    </div>

                </div>

            </div>



            <div class="col-md-3">

                <div class="stats-card">

                    <div class="stats-number">
                        <?php echo $pendingPlans; ?>
                    </div>

                    <div class="stats-title">
                        Jarayonda
                    </div>

                </div>

            </div>



            <div class="col-md-3">

                <div class="stats-card">

                    <div class="stats-number">
                        <?php echo $missedPlans; ?>
                    </div>

                    <div class="stats-title">
                        Bajarilmagan
                    </div>

                </div>

            </div>

        </div>



        <!-- Add Button -->

        <div class="mb-4">

            <a href="plans/add-plan.php" class="btn btn-primary btn-lg rounded-4">
                + Yangi Reja Qo‘shish
            </a>

        </div>



        <!-- Plans -->

        <h2 class="section-title">
            Sizning Rejalaringiz 📅
        </h2>



        <?php if ($plans): ?>

            <?php foreach ($plans as $plan): ?>

                <?php

                $currentDateTime =
                    date("Y-m-d H:i:s");

                $planDateTime =
                    $plan["plan_date"] . " " .
                    $plan["plan_time"] . ":00";

                $isPast =
                    strtotime($currentDateTime) >
                    strtotime($planDateTime);

                ?>

                <div class="plan-card">

                    <h3 class="plan-title">

                        <?php
                        echo htmlspecialchars(
                            $plan["title"]
                        );
                        ?>

                    </h3>



                    <p class="plan-description">

                        <?php
                        echo htmlspecialchars(
                            $plan["description"]
                        );
                        ?>

                    </p>



                    <div class="plan-info">

                        📅
                        <?php echo $plan["plan_date"]; ?>

                    </div>



                    <div class="plan-info">

                        ⏰
                        <?php echo $plan["plan_time"]; ?>

                    </div>



                    <!-- Status -->

                    <div class="status

                    <?php
                    echo $plan["status"];
                    ?>

                ">

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



                    <!-- Missed Comment -->

                    <?php if (!empty($plan["comment"])): ?>

                        <div class="comment-box">

                            <strong>
                                💬 Sabab:
                            </strong>

                            <p class="mt-2 mb-0">

                                <?php
                                echo htmlspecialchars(
                                    $plan["comment"]
                                );
                                ?>

                            </p>

                        </div>

                    <?php endif; ?>



                    <!-- Buttons -->

                    <div class="button-group">

                        <a href="plans/view-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-outline-primary btn-custom">
                            Ko‘rish
                        </a>



                        <a href="plans/edit-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-primary btn-custom">
                            Tahrirlash
                        </a>



                        <a href="plans/delete-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-danger btn-custom"
                            onclick="return confirm('Rejani o‘chirmoqchimisiz?')">
                            O‘chirish
                        </a>



                        <?php if (
                            $isPast &&
                            $plan["status"] == "pending"
                        ): ?>

                            <a href="plans/complete-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-success btn-custom">
                                ✅ Bajarildi
                            </a>



                            <a href="plans/missed-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-warning btn-custom">
                                ❌ Bajarilmadi
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-box">

                <h3>
                    Hozircha rejalar mavjud emas 📭
                </h3>

                <p class="mt-3 text-muted">

                    Yangi reja qo‘shib
                    kuningizni rejalashtirishni boshlang.

                </p>

            </div>

        <?php endif; ?>

    </div>

    <?php
    include "includes/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
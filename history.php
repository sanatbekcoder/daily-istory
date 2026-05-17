<?php

require_once "config/database.php";
require_once "config/session.php";
require_once "config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: auth/login.php");
    exit;
}

$currentDate =
    date("Y-m-d");

$currentMonth =
    date("m");

$currentYear =
    date("Y");

/*
|--------------------------------------------------------------------------
| Selected Day
|--------------------------------------------------------------------------
*/

$selectedDay =
    isset($_GET["day"])
    ? (int) $_GET["day"]
    : date("d");

/*
|--------------------------------------------------------------------------
| Days In Month
|--------------------------------------------------------------------------
*/

$daysInMonth =
    cal_days_in_month(
        CAL_GREGORIAN,
        $currentMonth,
        $currentYear
    );

/*
|--------------------------------------------------------------------------
| Selected Date
|--------------------------------------------------------------------------
*/

$selectedDate =

    $currentYear . "-" .
    $currentMonth . "-" .
    str_pad($selectedDay, 2, "0", STR_PAD_LEFT);

/*
|--------------------------------------------------------------------------
| Get Plans
|--------------------------------------------------------------------------
*/

$query = $pdo->prepare("
    SELECT *
    FROM plans
    WHERE user_id = ?
    AND plan_date = ?
    ORDER BY
    plan_time DESC
");

$query->execute([
    $_SESSION["user_id"],
    $selectedDate
]);

$plans = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
        }

        .hero-text {
            color: #dbeafe;
            margin-block-start: 10px;
        }

        .days-container {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-block-end: 10px;
            margin-block-end: 40px;
        }

        .day-btn {
            min-inline-size: 65px;
            block-size: 65px;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .day-btn:hover {
            transform: translateY(-4px);
        }

        .active-day {
            background: #2563eb;
            color: white;
        }

        .today {
            border: 3px solid #facc15;
        }

        .plan-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            margin-block-end: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
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

        .status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-block-start: 10px;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .missed {
            background: #fee2e2;
            color: #991b1b;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .empty-box {
            background: white;
            padding: 50px;
            border-radius: 25px;
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
                Rejalar Tarixi 📚
            </h1>

            <p class="hero-text">

                Kun bo‘yicha tarixni ko‘ring
                va o‘tgan rejalarni kuzating.

            </p>

        </div>



        <!-- Days -->

        <div class="days-container">

            <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>

                <?php

                $isToday =
                    $day == date("d");

                ?>

                <a href="?day=<?php echo $day; ?>" class="day-btn

                <?php

                if ($selectedDay == $day) {
                    echo "active-day";
                }

                if ($isToday) {
                    echo " today";
                }

                ?>
            ">

                    <?php echo $day; ?>

                </a>

            <?php endfor; ?>

        </div>



        <!-- Selected Date -->

        <h2 class="mb-4">

            📅
            <?php echo $selectedDate; ?>

        </h2>



        <!-- Plans -->

        <?php if ($plans): ?>

            <?php foreach ($plans as $plan): ?>

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



                    <p>
                        ⏰
                        <?php echo $plan["plan_time"]; ?>
                    </p>



                    <!-- Status -->

                    <div class="status

                    <?php
                    echo $plan["status"];
                    ?>

                ">

                        <?php

                        if ($plan["status"] == "completed") {
                            echo "Bajarilgan";
                        }

                        if ($plan["status"] == "missed") {
                            echo "Bajarilmagan";
                        }

                        if ($plan["status"] == "pending") {
                            echo "Jarayonda";
                        }

                        ?>

                    </div>



                    <!-- Comment -->

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



                    <!-- Button -->

                    <div class="mt-4">

                        <a href="plans/view-plan.php?id=<?php echo $plan['id']; ?>" class="btn btn-outline-primary rounded-4">
                            Ko‘rish
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-box">

                <h3>
                    Bu kunda rejalar yo‘q 📭
                </h3>

            </div>

        <?php endif; ?>

    </div>

    <?php
    include "includes/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
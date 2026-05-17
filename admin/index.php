<?php

require_once "middleware/admin-auth.php";

/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

$totalUsers = $pdo
    ->query("
    SELECT COUNT(*)
    FROM users
")
    ->fetchColumn();

$totalPlans = $pdo
    ->query("
    SELECT COUNT(*)
    FROM plans
")
    ->fetchColumn();

$totalCompleted = $pdo
    ->query("
    SELECT COUNT(*)
    FROM plans
    WHERE status = 'completed'
")
    ->fetchColumn();

$totalMissed = $pdo
    ->query("
    SELECT COUNT(*)
    FROM plans
    WHERE status = 'missed'
")
    ->fetchColumn();

$totalPending = $pdo
    ->query("
    SELECT COUNT(*)
    FROM plans
    WHERE status = 'pending'
")
    ->fetchColumn();

/*
|--------------------------------------------------------------------------
| Recent Users
|--------------------------------------------------------------------------
*/

$recentUsers = $pdo
    ->query("
    SELECT *
    FROM users
    ORDER BY id DESC
    LIMIT 5
")
    ->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Recent Plans
|--------------------------------------------------------------------------
*/

$recentPlans = $pdo
    ->query("
    SELECT plans.*,
           users.username
    FROM plans
    JOIN users
    ON plans.user_id = users.id
    ORDER BY plans.id DESC
    LIMIT 5
")
    ->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Admin Dashboard
    </title>

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
            background:
                linear-gradient(135deg,
                    #0f172a,
                    #1e293b);
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
            color: #cbd5e1;
            font-size: 18px;
        }

        .stats-card {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            block-size: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-title {
            color: #64748b;
            font-size: 15px;
            margin-block-end: 15px;
        }

        .stats-number {
            font-size: 42px;
            font-weight: 700;
            color: #0f172a;
        }

        .section-box {
            background: white;
            border-radius: 25px;
            padding: 30px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);
            margin-block-start: 35px;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            margin-block-end: 25px;
            color: #0f172a;
        }

        .user-card,
        .plan-card {
            padding: 20px;
            border-radius: 18px;
            background: #f8fbff;
            margin-block-end: 18px;
        }

        .badge-role {
            background: #dbeafe;
            color: #2563eb;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .status {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
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
    </style>

</head>

<body>

    <?php
    include "includes/admin-navbar.php";
    ?>

    <div class="container py-5">

        <!-- Hero -->

        <div class="hero-box">

            <h1 class="hero-title">

                Admin Dashboard 👑

            </h1>

            <p class="hero-text">

                Daily-Istory platformasini
                boshqaring va foydalanuvchilarni
                nazorat qiling.

            </p>

        </div>



        <!-- Statistics -->

        <div class="row g-4">

            <div class="col-md-4">

                <div class="stats-card">

                    <div class="stats-title">
                        Jami Foydalanuvchilar
                    </div>

                    <div class="stats-number">

                        <?php
                        echo $totalUsers;
                        ?>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="stats-card">

                    <div class="stats-title">
                        Jami Rejalar
                    </div>

                    <div class="stats-number">

                        <?php
                        echo $totalPlans;
                        ?>

                    </div>

                </div>

            </div>



            <div class="col-md-4">

                <div class="stats-card">

                    <div class="stats-title">
                        Jarayondagi Rejalar
                    </div>

                    <div class="stats-number">

                        <?php
                        echo $totalPending;
                        ?>

                    </div>

                </div>

            </div>



            <div class="col-md-6">

                <div class="stats-card">

                    <div class="stats-title">
                        Bajarilgan Rejalar
                    </div>

                    <div class="stats-number">

                        <?php
                        echo $totalCompleted;
                        ?>

                    </div>

                </div>

            </div>



            <div class="col-md-6">

                <div class="stats-card">

                    <div class="stats-title">
                        Bajarilmagan Rejalar
                    </div>

                    <div class="stats-number">

                        <?php
                        echo $totalMissed;
                        ?>

                    </div>

                </div>

            </div>

        </div>



        <!-- Recent Users -->

        <div class="section-box">

            <h2 class="section-title">

                So‘nggi Foydalanuvchilar 👥

            </h2>



            <?php foreach ($recentUsers as $user): ?>

                <div class="user-card">

                    <div class="d-flex
                            justify-content-between
                            align-items-center
                            flex-wrap
                            gap-3">

                        <div>

                            <h5 class="mb-1">

                                <?php
                                echo htmlspecialchars(
                                    $user["fullname"]
                                );
                                ?>

                            </h5>

                            <p class="mb-0 text-muted">

                                @
                                <?php
                                echo htmlspecialchars(
                                    $user["username"]
                                );
                                ?>

                            </p>

                        </div>



                        <div class="badge-role">

                            <?php
                            echo $user["role"];
                            ?>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
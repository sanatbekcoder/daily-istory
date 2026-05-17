<?php

require_once "../config/database.php";
require_once "../config/session.php";

if (!isset($_SESSION["user_id"])) {
    exit;
}

$search =
    isset($_GET["search"])
    ? trim($_GET["search"])
    : "";

$status =
    isset($_GET["status"])
    ? trim($_GET["status"])
    : "";

$sql = "
    SELECT *
    FROM plans
    WHERE user_id = ?
";

$params = [$_SESSION["user_id"]];

if (!empty($search)) {

    $sql .= "
        AND title LIKE ?
    ";

    $params[] = "%$search%";
}

if (!empty($status)) {

    $sql .= "
        AND status = ?
    ";

    $params[] = $status;
}

$sql .= "
    ORDER BY
    plan_date DESC,
    plan_time DESC
";

$query = $pdo->prepare($sql);

$query->execute($params);

$plans = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php if ($plans): ?>

    <?php foreach ($plans as $plan): ?>

        <div class="plan-card">

            <h2 class="plan-title">

                <?php
                echo htmlspecialchars($plan["title"]);
                ?>

            </h2>

            <p class="plan-description">

                <?php
                echo htmlspecialchars($plan["description"]);
                ?>

            </p>

            <p>
                📅 <?php echo $plan["plan_date"]; ?>
            </p>

            <p>
                ⏰ <?php echo $plan["plan_time"]; ?>
            </p>

            <p>

                Status:

                <span class="status
                    <?php echo $plan["status"]; ?>
                ">

                    <?php echo $plan["status"]; ?>

                </span>

            </p>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="empty-box">

        <h3>
            Reja topilmadi 😕
        </h3>

    </div>

<?php endif; ?>
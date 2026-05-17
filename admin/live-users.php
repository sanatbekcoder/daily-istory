<?php

require_once "middleware/admin-auth.php";

$search = "";

$sql = "
    SELECT *
    FROM users
    WHERE 1
";

$params = [];

if (!empty($_GET["search"])) {

    $search =
        trim($_GET["search"]);

    $sql .= "
        AND (
            fullname LIKE ?
            OR username LIKE ?
        )
    ";

    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= "
    ORDER BY id DESC
";

$query = $pdo->prepare($sql);

$query->execute($params);

$users =
    $query->fetchAll(PDO::FETCH_ASSOC);

?>

<?php if ($users): ?>

    <?php foreach ($users as $user): ?>

        <div class="user-card">

            <div class="row align-items-center g-4">

                <div class="col-md-1">

                    <div class="avatar">

                        <?php

                        echo strtoupper(
                            substr(
                                $user["fullname"],
                                0,
                                1
                            )
                        );

                        ?>

                    </div>

                </div>



                <div class="col-md-5">

                    <div class="user-name">

                        <?php
                        echo htmlspecialchars(
                            $user["fullname"]
                        );
                        ?>

                    </div>

                    <div class="username">

                        @
                        <?php
                        echo htmlspecialchars(
                            $user["username"]
                        );
                        ?>

                    </div>

                </div>



                <div class="col-md-2">

                    <span class="badge-role">

                        <?php
                        echo ucfirst(
                            $user["role"]
                        );
                        ?>

                    </span>

                </div>



                <div class="col-md-2">

                    <?php if (
                        $user["status"] == "active"
                    ): ?>

                        <span class="badge-active">

                            Active

                        </span>

                    <?php else: ?>

                        <span class="badge-blocked">

                            Blocked

                        </span>

                    <?php endif; ?>

                </div>



                <div class="col-md-2">

                    <div class="d-flex gap-2 flex-wrap">

                        <a href="view-user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-custom">
                            Profile
                        </a>

                        <a href="toggle-block.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-custom">

                            <?php

                            if (
                                $user["status"] == "active"
                            ) {

                                echo "Block";

                            } else {

                                echo "Unblock";
                            }

                            ?>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="empty-box">

        <h3>
            Foydalanuvchi topilmadi 📭
        </h3>

    </div>

<?php endif; ?>
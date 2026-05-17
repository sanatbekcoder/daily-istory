<?php

require_once "middleware/admin-auth.php";

if (!isset($_GET["id"])) {
    exit;
}

$id = $_GET["id"];

$message = "";

/*
|--------------------------------------------------------------------------
| Update Username
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username =
        trim($_POST["username"]);

    if (!empty($username)) {

        /*
        |--------------------------------------------------------------------------
        | Check Username Exists
        |--------------------------------------------------------------------------
        */

        $check = $pdo->prepare("
            SELECT id
            FROM users
            WHERE username = ?
            AND id != ?
        ");

        $check->execute([
            $username,
            $id
        ]);

        if ($check->rowCount() > 0) {

            $message =
                "Bu username band ❌";

        } else {

            $update = $pdo->prepare("
                UPDATE users
                SET username = ?
                WHERE id = ?
            ");

            $update->execute([
                $username,
                $id
            ]);

            $message =
                "Username yangilandi ✅";
        }
    }
}

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

$query->execute([$id]);

$user = $query->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        User Profile
    </title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f8fbff;
            font-family: 'Poppins', sans-serif;
        }

        .profile-card {
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .avatar {
            inline-size: 120px;
            block-size: 120px;
            border-radius: 50%;
            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 42px;
            font-weight: 700;
            margin: auto;
            margin-block-end: 25px;
        }

        .profile-title {
            text-align: center;
            font-size: 36px;
            font-weight: 700;
            color: #0f172a;
            margin-block-end: 10px;
        }

        .profile-subtitle {
            text-align: center;
            color: #64748b;
            margin-block-end: 35px;
        }

        .info-box {
            background: #f8fbff;
            border-radius: 20px;
            padding: 20px;
            margin-block-end: 20px;
        }

        .info-label {
            color: #64748b;
            font-size: 14px;
            margin-block-end: 8px;
        }

        .info-value {
            color: #0f172a;
            font-size: 18px;
            font-weight: 600;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .blocked {
            background: #fee2e2;
            color: #991b1b;
        }

        .role-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            background: #dbeafe;
            color: #2563eb;
        }

        .form-control {
            padding: 14px;
            border-radius: 14px;
            border: 2px solid #dbeafe;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .btn-save {
            background: #2563eb;
            color: white;
            border: none;
            padding: 14px;
            inline-size: 100%;
            border-radius: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-save:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
    </style>

</head>

<body>

    <?php
    include "includes/admin-navbar.php";
    ?>

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="profile-card">

                    <!-- Avatar -->

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



                    <!-- Title -->

                    <h1 class="profile-title">

                        <?php
                        echo htmlspecialchars(
                            $user["fullname"]
                        );
                        ?>

                    </h1>

                    <p class="profile-subtitle">

                        User management panel 👤

                    </p>



                    <!-- Message -->

                    <?php if (!empty($message)): ?>

                        <div class="alert alert-primary rounded-4">

                            <?php
                            echo $message;
                            ?>

                        </div>

                    <?php endif; ?>



                    <!-- Username Form -->

                    <form method="POST">

                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Username

                            </label>

                            <input type="text" name="username" class="form-control" value="<?php
                            echo htmlspecialchars(
                                $user["username"]
                            );
                            ?>">

                        </div>

                        <button class="btn-save">

                            Username Saqlash

                        </button>

                    </form>



                    <hr class="my-5">



                    <!-- Info -->

                    <div class="row g-4">

                        <!-- ID -->

                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    User ID
                                </div>

                                <div class="info-value">

                                    #<?php
                                    echo $user["id"];
                                    ?>

                                </div>

                            </div>

                        </div>



                        <!-- Role -->

                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Role
                                </div>

                                <div class="info-value">

                                    <span class="role-badge">

                                        <?php
                                        echo $user["role"];
                                        ?>

                                    </span>

                                </div>

                            </div>

                        </div>



                        <!-- Status -->

                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Status
                                </div>

                                <div class="info-value">

                                    <span class="status-badge

                                    <?php
                                    echo $user["status"];
                                    ?>

                                ">

                                        <?php
                                        echo ucfirst(
                                            $user["status"]
                                        );
                                        ?>

                                    </span>

                                </div>

                            </div>

                        </div>



                        <!-- Created -->

                        <div class="col-md-6">

                            <div class="info-box">

                                <div class="info-label">
                                    Created At
                                </div>

                                <div class="info-value">

                                    <?php

                                    if (
                                        isset(
                                        $user["created_at"]
                                    )
                                    ) {

                                        echo $user["created_at"];

                                    } else {

                                        echo "Noma’lum";
                                    }

                                    ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
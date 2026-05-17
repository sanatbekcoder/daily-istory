<?php

require_once "middleware/admin-auth.php";

$search = "";

$sql = "
    SELECT *
    FROM users
    WHERE 1
";

$params = [];

/*
|--------------------------------------------------------------------------
| Search System
|--------------------------------------------------------------------------
*/

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

<!DOCTYPE html>
<html lang="uz">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Users
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
            font-size: 17px;
        }

        .search-box {
            background: white;
            padding: 25px;
            border-radius: 25px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);
            margin-block-end: 35px;
        }

        .search-input {
            border-radius: 16px;
            padding: 14px;
            border: 2px solid #dbeafe;
        }

        .search-input:focus {
            border-color: #2563eb;
            box-shadow:
                0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .search-btn {
            border-radius: 16px;
            padding: 14px;
            font-weight: 600;
        }

        .user-card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            margin-block-end: 25px;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .user-card:hover {
            transform: translateY(-5px);
        }

        .avatar {
            inline-size: 70px;
            block-size: 70px;
            border-radius: 50%;
            background:
                linear-gradient(135deg,
                    #2563eb,
                    #1d4ed8);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            font-weight: 700;
        }

        .user-name {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            margin-block-end: 5px;
        }

        .username {
            color: #64748b;
        }

        .badge-role {
            background: #dbeafe;
            color: #2563eb;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-blocked {
            background: #fee2e2;
            color: #991b1b;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-custom {
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 600;
        }

        .empty-box {
            background: white;
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.05);
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

                Foydalanuvchilar 👥

            </h1>

            <p class="hero-text">

                Foydalanuvchilarni qidiring,
                profilini ko‘ring
                va akkauntlarni boshqaring.

            </p>

        </div>



        <!-- Search -->

        <div class="search-box">

            <div class="row g-3">

                <div class="col-12">

                    <input type="text" id="searchInput" class="form-control search-input"
                        placeholder="Username yoki fullname qidirish...">

                </div>

            </div>

        </div>



        <!-- Users Container -->

        <div id="usersContainer">

            <?php include "live-users.php"; ?>

        </div>

    </div>



    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Live Search -->

    <script>

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const searchInput =

            document.getElementById(
                "searchInput"
            );

        const usersContainer =

            document.getElementById(
                "usersContainer"
            );

        /*
        |--------------------------------------------------------------------------
        | Live Search
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(

            "keyup",

            () => {

                let search =

                    searchInput.value;

                /*
                |--------------------------------------------------------------------------
                | Fetch Users
                |--------------------------------------------------------------------------
                */

                fetch(

                    "live-users.php?search=" +

                    encodeURIComponent(search)

                )

                    .then(response =>

                        response.text()

                    )

                    .then(data => {

                        /*
                        |--------------------------------------------------------------------------
                        | Render Users
                        |--------------------------------------------------------------------------
                        */

                        usersContainer.innerHTML =

                            data;

                    });

            }

        );

    </script>

</body>

</html>
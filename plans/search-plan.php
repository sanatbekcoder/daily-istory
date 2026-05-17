<?php

require_once "../config/database.php";
require_once "../config/session.php";
require_once "../config/timezone.php";

if (!isset($_SESSION["user_id"])) {

    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rejalarni Qidirish</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fbff;
        }

        .search-card {
            max-inline-size: 1100px;
            margin: auto;
            margin-block-start: 50px;
        }

        .top-box {
            background: white;
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
            margin-block-end: 30px;
        }

        .title {
            font-size: 34px;
            font-weight: 700;
            color: #2563eb;
            margin-block-end: 10px;
        }

        .subtitle {
            color: #64748b;
            margin-block-end: 25px;
        }

        .form-control,
        .form-select {
            padding: 14px;
            border-radius: 14px;
        }

        .plan-card {
            background: white;
            border-radius: 22px;
            padding: 25px;
            margin-block-end: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .plan-card:hover {
            transform: translateY(-4px);
        }

        .plan-title {
            color: #0f172a;
            font-size: 24px;
            font-weight: 600;
            margin-block-end: 10px;
        }

        .plan-description {
            color: #64748b;
            line-height: 1.8;
            margin-block-end: 15px;
        }

        .status {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
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

        .empty-box {
            background: white;
            padding: 40px;
            border-radius: 25px;
            text-align: center;
            color: #64748b;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .loader {
            text-align: center;
            padding: 30px;
            color: #2563eb;
            font-weight: 600;
        }
    </style>

</head>

<body>
    <?php
    include "../includes/navbar.php";
    ?>
    <div class="container">

        <div class="search-card">

            <!-- Search -->

            <div class="top-box">

                <h1 class="title">
                    Rejalarni Qidirish 🔎
                </h1>

                <p class="subtitle">

                    Rejalarni real vaqtda qidiring.

                </p>



                <div class="row g-3">

                    <div class="col-md-8">

                        <input type="text" id="searchInput" class="form-control" placeholder="Reja nomini yozing...">

                    </div>



                    <div class="col-md-4">

                        <select id="statusSelect" class="form-select">

                            <option value="">
                                Barcha statuslar
                            </option>

                            <option value="pending">
                                Jarayonda
                            </option>

                            <option value="completed">
                                Bajarilgan
                            </option>

                            <option value="missed">
                                Bajarilmagan
                            </option>

                        </select>

                    </div>

                </div>

            </div>



            <!-- Results -->

            <div id="results">

                <div class="loader">

                    Rejalar yuklanmoqda...

                </div>

            </div>

        </div>

    </div>



    <script>

        const searchInput =
            document.getElementById("searchInput");

        const statusSelect =
            document.getElementById("statusSelect");

        const results =
            document.getElementById("results");

        /*
        |--------------------------------------------------------------------------
        | Live Search Function
        |--------------------------------------------------------------------------
        */

        async function loadResults() {

            let search =
                searchInput.value;

            let status =
                statusSelect.value;

            results.innerHTML = `

        <div class="loader">
            Yuklanmoqda...
        </div>

    `;

            try {

                let response = await fetch(

                    "live-search.php?search=" +

                    encodeURIComponent(search) +

                    "&status=" +

                    encodeURIComponent(status)

                );

                let data =
                    await response.text();

                results.innerHTML =
                    data;

            } catch (error) {

                results.innerHTML = `

            <div class="empty-box">

                <h3>
                    Xatolik yuz berdi 😕
                </h3>

            </div>

        `;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        searchInput.addEventListener(
            "input",
            loadResults
        );

        statusSelect.addEventListener(
            "change",
            loadResults
        );

        /*
        |--------------------------------------------------------------------------
        | First Load
        |--------------------------------------------------------------------------
        */

        loadResults();

    </script>

</body>

</html>
<?php

$currentPage =
    basename($_SERVER["PHP_SELF"]);

?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm py-3">

    <div class="container">

        <!-- Logo -->

        <a class="navbar-brand fw-bold text-primary" href="/daily-istory/dashboard.php" style="font-size:28px;">
            Daily-Istory 📔
        </a>



        <!-- Mobile Button -->

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>



        <!-- Menu -->

        <div class="collapse navbar-collapse" id="navbarNav">

            <div class="ms-auto d-flex gap-2 flex-wrap">

                <!-- Dashboard -->

                <a href="/daily-istory/dashboard.php" class="btn

                    <?php

                    if ($currentPage == "dashboard.php") {

                        echo "btn-primary";

                    } else {

                        echo "btn-outline-primary";
                    }

                    ?>
                ">
                    Dashboard
                </a>



                <!-- History -->

                <a href="/daily-istory/history.php" class="btn

                    <?php

                    if ($currentPage == "history.php") {

                        echo "btn-primary";

                    } else {

                        echo "btn-outline-primary";
                    }

                    ?>
                ">
                    History
                </a>



                <!-- Search -->

                <a href="/daily-istory/plans/search-plan.php" class="btn

                    <?php

                    if ($currentPage == "search-plan.php") {

                        echo "btn-primary";

                    } else {

                        echo "btn-outline-primary";
                    }

                    ?>
                ">
                    Search
                </a>



                <!-- Profile -->

                <a href="/daily-istory/profile.php" class="btn

                    <?php

                    if ($currentPage == "profile.php") {

                        echo "btn-primary";

                    } else {

                        echo "btn-outline-primary";
                    }

                    ?>
                ">
                    Profile
                </a>



                <!-- Logout -->

                <a href="/daily-istory/auth/logout.php" class="btn btn-danger">
                    Logout
                </a>

            </div>

        </div>

    </div>

</nav>
<?php

$currentPage =
    basename($_SERVER["PHP_SELF"]);

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">

    <div class="container">

        <!-- Logo -->

        <a
            href="/daily-istory/admin/index.php"
            class="navbar-brand fw-bold"
            style="font-size:28px;"
        >
            Admin 👑
        </a>



        <!-- Mobile Button -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#adminNavbar"
        >

            <span class="navbar-toggler-icon"></span>

        </button>



        <!-- Navbar -->

        <div
            class="collapse navbar-collapse"
            id="adminNavbar"
        >

            <div class="ms-auto d-flex gap-2 flex-wrap">

                <!-- Users -->

                <a
                    href="/daily-istory/admin/users.php"

                    class="btn

                    <?php

                    if (
                        $currentPage == "users.php" ||
                        $currentPage == "view-user.php"
                    ) {

                        echo "btn-light";

                    } else {

                        echo "btn-outline-light";
                    }

                    ?>
                    "
                >

                    Users

                </a>
                <!-- Logout -->

                <a
                    href="/daily-istory/auth/logout.php"
                    class="btn btn-danger"
                >

                    Logout

                </a>

            </div>

        </div>

    </div>

</nav>
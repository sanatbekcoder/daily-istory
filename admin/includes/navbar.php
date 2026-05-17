<?php

$currentPage =
    basename($_SERVER["PHP_SELF"]);

?>

<?php if (
    isset($_SESSION["role"]) &&
    $_SESSION["role"] == "admin"
): ?>

    <a href="/daily-istory/admin/users.php" class="btn

    <?php

    if (
        strpos(
            $_SERVER["REQUEST_URI"],
            "/admin/"
        ) !== false
    ) {

        echo "btn-dark";

    } else {

        echo "btn-outline-dark";
    }

    ?>

    ">

        Admin 👑

    </a>

<?php endif; ?>
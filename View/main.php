<?php

// Inclure la classe User si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    require_once './Model/User.class.php';  // Inclure la définition de la classe User
    $user = $_SESSION['user'];  // Vous pouvez maintenant utiliser $_SESSION['user'] en toute sécurité
    include_once "headerlog.php";  // Inclure l'en-tête avec les informations de l'utilisateur connecté
} else {
    include_once "header.php";  // Inclure l'en-tête pour les utilisateurs non connectés
}

?>

<section id="main-section">
    <?php
    if (isset($page)) {
        if ($page == 'home') {
            require("./View/home.php");
        } else {
            require("./View/".$page.".php");
        }
    }
    ?>
</section>

<?php include_once "footer.php" ?>

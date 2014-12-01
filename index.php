<?php
    //affiche les erreurs
    ini_set('error_reporting', E_ALL);

    // démarre la session
    session_start();

    // charge le fichier des fonctions PHP
    require_once 'model/functions.php';

    // Liste blanche, c'est notre routing qui correspont à nos pages
    $routing = [
        'home' => [
            'controller' => 'home',
            'secure' => false,
            ],
        'inscription' => [
            'controller' => 'subscription',
            'secure' => false,
            ],
        'login' => [
            'controller' => 'login',
            'secure' => false,
            ],

        'message' => [
            'controller' => 'message',
            'secure' => false,
            ],
        'logout' => [
            'controller' => 'logout',
            'secure' => false,
            ],
        '404' => [
            'controller' => '404',
            'secure' => false,
            ],
    ];

    // verifions la pertinance de la page en GET
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if (!isset($routing[$page])) {
            // la page n'existe pas
            $page = '404';
        }
    } else {
        //page par defaut
        $page = 'home';
    }

    //check pour la sécurité : si la page à la clée 'secure' est true et que $_SESSION['name'] n'est pas définis
    if ($routing[$page]['secure'] === true && !isset($_SESSION['name'])) {
        //Met en session un message informatif
        addMessageFlash('info', 'Veuillez-vous connecter afin d\'accéder à cette page');

        //redirection
        header("location: index.php?page=login");
        exit;
    }

?>
<!doctype html>
<html lang="fr">
<head>
</head>
<body>

Vous pouvez faire évoluer l'HTML

<ul>
    <li><a href="?page=home" title="home">Home</a></li>
    <li><a href="?page=message" title="message">Message</a></li>
    <li><a href="?page=inscription" title="inscription">inscription</a></li>
    <?php
    if (isset($_SESSION['name'])) {
        echo '<li><a href="?page=logout" title="logout">logout</a></li>';
    } else {
        echo '<li><a href="?page=login" title="login">login</a></li>';
    }
    ?>
</ul>

<?php


    // Affiche les flashBag : des messages informatif du genre "votre message a bien été envoyé"
    if (isset($_SESSION['flashBag'])) {
        foreach ($_SESSION['flashBag'] as $type => $flash) {
            foreach ($flash as $key => $message) {
                echo '<div class="'.$type.'" role="'.$type.'" >'.$message.'</div>';
                // un fois affiché le message doit être supprimé
                unset($_SESSION['flashBag'][$type][$key]);
            }
        }
    }

    // Charge la page demandée
    $fileController = 'page/'.$routing[$page]['controller'].'.php';
    if (file_exists($fileController)) {
        require $fileController;
    } else {
        echo 'File is missing';
    }

?>
</body>
</html>

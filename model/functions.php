<?php

/**
 * Ajoute une valeur (array) dans un fichier, le fichier est créé s'il n'existe pas
 *
 * @param $file
 * @param array $value
 * @return int
 */
function writeFile($file, array $value)
{
    // Vérifie si le fichier existe déjà
    if (file_exists($file)) {
        // Si oui on récupère son contenu
        $data = json_decode(file_get_contents($file), true);
    } else {
        $data = [];
    }

    /**
    * Rajoute les infos au début du tableau
    * Si on avait voulu à la fin : $data[] = $value
    */
    array_unshift($data, $value);

    // Insère les nouvelles données dans le fichier
    $status = file_put_contents($file, json_encode($data));

    // on informe si l'opération c'est bien passé en retournant ce que retourne file_put_content
    return  $status;
}

/**
 * ajoute un message en session
 *
 * @param $type
 * @param $message
 */
function addMessageFlash($type, $message)
{
    // autorise que 4 types de messages flash
    $types = ['success','error','alert','info'];
    if (!in_array($type, $types)) {
        return false;
    }

    // on vérifie que le type existe
    if (!isset($_SESSION['flashBag'][$type])) {
        //si non on le créé avec un Array vide
        $_SESSION['flashBag'][$type] = [];
    }

    // on ajoute le message
    $_SESSION['flashBag'][$type][] = $message;
}

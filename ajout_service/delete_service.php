<?php

// Récupération du service à supprimer
$nom = $_GET['nom'];

// Récupération du fichier JSON
$repertoire = __DIR__;
$jsonFilePath = $repertoire . '/../assets/json/data.json';

$json = file_get_contents($jsonFilePath);

if ($json === false) {
    // Gérer l'erreur si le fichier ne peut pas être lu
    die('Erreur de lecture du fichier JSON');
}

$data = json_decode($json, true);

if ($data === null) {
    // Gérer l'erreur si le JSON ne peut pas être décodé
    die('Erreur de décodage du fichier JSON');
}

// Suppression du service
foreach ($data['SERVICES'] as $key => $service) {
    if ($service == $nom) {
        unset($data['SERVICES'][$key]);
    }
}

// Réindexer le tableau pour enlever les clés vides
$data['SERVICES'] = array_values($data['SERVICES']);

// Écriture du nouveau fichier JSON
$newJson = json_encode($data, JSON_PRETTY_PRINT);

if ($newJson === false) {
    // Gérer l'erreur si le JSON ne peut pas être encodé
    die('Erreur d\'encodage du JSON');
}

if (file_put_contents($jsonFilePath, $newJson) === false) {
    // Gérer l'erreur si le fichier ne peut pas être écrit
    die('Erreur d\'écriture du fichier JSON');
}

// Redirection vers la page d'ajout de service
header('Location: index.php');
exit;
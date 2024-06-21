<?php

// Récupération du nom du service depuis le formulaire
$nom = $_POST['nom'];

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

// Vérifions si 'SERVICES' existe déjà, sinon on le crée
if (!isset($data['SERVICES'])) {
    $data['SERVICES'] = [];
}

// Ajout du nouveau service
$data['SERVICES'][] = $nom;

// Configuration de la locale pour le tri
setlocale(LC_COLLATE, 'fr_FR.UTF-8');

// Tri du tableau par ordre alphabétique en tenant compte des locales
usort($data['SERVICES'], 'strcoll');

// Encodage et écriture du nouveau fichier JSON
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
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$repertoire = __DIR__;
$jsonFilePath = $repertoire . '/../assets/json/data.json';

// Vérifiez si le fichier existe et peut être lu
if (!file_exists($jsonFilePath)) {
    die("Le fichier JSON n'existe pas : " . $jsonFilePath);
}

$json = file_get_contents($jsonFilePath);

// Vérifiez si la lecture du fichier a réussi
if ($json === false) {
    die("Impossible de lire le fichier JSON.");
}

$json = json_decode($json, true);

// Vérifiez si le JSON a été correctement décodé
if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
    die("Erreur lors du décodage JSON : " . json_last_error_msg());
}

$services = [];

if (isset($json['SERVICES']) && is_array($json['SERVICES'])) {
    $services = $json['SERVICES'];
}

// Trier les services par ordre alphabétique
sort($services);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Liste des services</h1>
        <?php if (empty($services)) : ?>
        <p>Aucun service trouvé.</p>
        <?php else : ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nom du service</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service) : ?>
                <tr>
                    <td><?= htmlspecialchars($service, ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="delete_service.php?nom=<?= urlencode($service) ?>" class="btn btn-danger">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <form action="add_service.php" method="post">
            <h3>Ajouter un service</h3>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du service</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>

</html>
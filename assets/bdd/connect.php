<?php

// connexion à la base de données

$servername = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

$conn = null;

try {
    $conn = new PDO("sqlsrv:Server=$servername;Database=$dbname", $username, $password);
    // définir le mode d'erreur PDO sur l'exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données établie avec succès.";
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur de connexion à la base de données : " . $e->getMessage() . "</div>";
}
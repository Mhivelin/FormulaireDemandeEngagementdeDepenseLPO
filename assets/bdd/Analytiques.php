<?php
require_once 'connect.php';

$connectionEstablished = false;
$dataAvailable = false;
$data = [];

$fournisseurs = [];

try {
    // Assurez-vous que $conn est un objet PDO valide
    if ($conn instanceof PDO) {

        $connectionEstablished = true;

        $sql = "SELECT * FROM dbo.AC_DOCUWARE_COMPTE_FOURNISSEUR ORDER BY concat";

        $result = $conn->query($sql);

        $fournisseurs = [];

        //var_dump($result);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //var_dump($row);
            $fournisseurs[] = $row["concat"];
        }
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur de base de données : " . $e->getMessage() . "</div>";
}
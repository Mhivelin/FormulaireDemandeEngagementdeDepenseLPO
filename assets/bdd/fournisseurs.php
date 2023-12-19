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
        $sql = "CREATE VIEW [dbo].[AC_DOCUWARE_COMPTE_FOURNISSEUR] AS 
        SELECT CT_Num AS compte, CT_Intitule AS intitule, 
               CT_Num + substring(' - ',1,3) + CT_Intitule AS concat
        FROM dbo.F_COMPTET
        WHERE CT_Type = 1
        AND ct_sommeil = '0'";


        $result = $conn->query($sql);
        
        if ($result) {
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            $dataAvailable = true;
        }
    }
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur de base de données : " . $e->getMessage() . "</div>";
}



if (!$dataAvailable) {
    echo "<div class='alert alert-danger' role='alert'>Aucun fournisseur disponible.</div>";
} else {
    echo "<div class='alert alert-success' role='alert'>Données disponibles.</div>";
    $fournisseurs = [];
}
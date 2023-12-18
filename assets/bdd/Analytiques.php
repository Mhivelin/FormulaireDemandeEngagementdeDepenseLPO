<?php

require_once 'connect.php';

$connectionEstablished = false;
$dataAvailable = false;
$data = [];

try {
    if ($conn instanceof PDO) {
        $connectionEstablished = true;
        $sql = "CREATE VIEW [dbo].[AC_DOCUWARE_COMPTE_ANALYTIQUE] AS SELECT dbo.F_COMPTEA.CA_Num AS section, dbo.F_COMPTEA.CA_Intitule AS intitule, dbo.F_COMPTEA.CA_Num + substring(' - ',1,3) + dbo.F_COMPTEA.CA_Intitule AS concat, dbo.P_ANALYTIQUE.A_Intitule AS [plan] FROM dbo.F_COMPTEA INNER JOIN dbo.P_ANALYTIQUE ON dbo.F_COMPTEA.N_Analytique = dbo.P_ANALYTIQUE.cbIndice where dbo.F_COMPTEA.Ca_sommeil <> '1' and dbo.F_COMPTEA.catégorie <> 'salariés' and dbo.F_COMPTEA.N_Analytique = '1'";
        
        // Exécuter la requête pour créer la vue
        $conn->exec($sql);

        // Exécuter une nouvelle requête pour récupérer les données de la vue
        $analytiques = $conn->query("SELECT * FROM [dbo].[AC_DOCUWARE_COMPTE_ANALYTIQUE]");
        if ($analytiques) {
            $data = $analytiques->fetchAll(PDO::FETCH_ASSOC);
            $dataAvailable = true;
        }
    }
} catch(PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Erreur de base de données : " . $e->getMessage() . "</div>";
}

if (!$dataAvailable) {
    echo "<div class='alert alert-danger' role='alert'>Aucun analytique disponible.</div>";

} else {
    echo "<div class='alert alert-success' role='alert'>Données disponibles.</div>";
    $analytiques = [];
}

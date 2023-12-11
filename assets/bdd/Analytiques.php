<?php

require_once 'connect.php';


try {
    $sql = "CREATE VIEW [dbo].[AC_DOCUWARE_COMPTE_ANALYTIQUE] AS SELECT dbo.F_COMPTEA.CA_Num AS section, dbo.F_COMPTEA.CA_Intitule AS intitule, dbo.F_COMPTEA.CA_Num + substring(' - ',1,3) + dbo.F_COMPTEA.CA_Intitule AS concat, dbo.P_ANALYTIQUE.A_Intitule AS [plan] FROM dbo.F_COMPTEA INNER JOIN dbo.P_ANALYTIQUE ON dbo.F_COMPTEA.N_Analytique = dbo.P_ANALYTIQUE.cbIndice where dbo.F_COMPTEA.Ca_sommeil <> '1' and dbo.F_COMPTEA.catégorie <> 'salariés' and dbo.F_COMPTEA.N_Analytique = '1'";

    // Exécuter la requête
    $conn->exec($sql);
    
    $analytiques = $conn->query($sql);
    $analytiques->setFetchMode(PDO::FETCH_ASSOC);

    


} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

<?php

require_once 'connect.php';

try {
    $sql = "CREATE VIEW [dbo].[AC_DOCUWARE_COMPTE_FOURNISSEUR] AS 
            SELECT CT_Num AS compte, CT_Intitule AS intitule, 
                   CT_Num + substring(' - ',1,3) + CT_Intitule AS concat
            FROM dbo.F_COMPTET
            WHERE CT_Type = 1
            AND ct_sommeil = '0'";

    // Exécuter la requête
    $conn->exec($sql);

    $fournisseurs = $conn->query($sql);
    $fournisseurs->setFetchMode(PDO::FETCH_ASSOC);


    
    
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}



$conn = null;
?>

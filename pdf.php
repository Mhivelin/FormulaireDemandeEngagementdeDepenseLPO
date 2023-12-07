<?php
require_once('tcpdf/tcpdf.php'); // Assurez-vous que le chemin d'accès à TCPDF est correct

function creerPDFDepuisHTML($html, $nomDuFichier)
{
    // Créer un nouvel objet PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Définir les informations du document
    $pdf->SetCreator(PDF_CREATOR);


    // Définir l'en-tête et le pied de page
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // Définir les marges
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Définir les sauts de page automatiques
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Définir la police par défaut
    $pdf->SetFont('dejavusans', '', 10);

    // Ajouter une page
    $pdf->AddPage();

    // Écrire le contenu HTML
    $pdf->writeHTML($html, true, false, true, false, '');

    // Enregistrer le document sur le serveur au nom du fichier indiqué
    $cheminDuFichier = $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $nomDuFichier . '.pdf';

    $pdf->Output($cheminDuFichier, 'F');
}

require_once 'vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;

function concatenerPDF($fichier1, $fichier2, $fichierSortie)
{




    $pdf = new Fpdi();

    // Charger le premier PDF
    $pageCount = $pdf->setSourceFile($fichier1);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $tplId = $pdf->importPage($pageNo);
        $pdf->AddPage();
        $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
    }



    // page de séparation
    $pdf->AddPage();
    $pdf->SetFont('Helvetica');
    $pdf->Cell(0, 10, 'DECOUPER ICI', 0, 1, 'C');



    // Charger le deuxième PDF
    $pageCount = $pdf->setSourceFile($fichier2);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $tplId = $pdf->importPage($pageNo);
        $pdf->AddPage();
        $pdf->useTemplate($tplId, ['adjustPageSize' => true]);
    }





    // Enregistrer le nouveau PDF
    $fichierSortie = $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $fichierSortie . '.pdf';
    $pdf->Output($fichierSortie, 'F');
}


function telechargerPDF($fichier, $nomDuFichier)
{
    $fichier = $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $fichier . '.pdf';
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fichier . '"');
    readfile($fichier);
}



// generation du pdf
// recuperaion des données

if (isset($_POST['demandeur']) && isset($_POST['service']) && isset($_POST['date']) && isset($_POST['montant']) && isset($_POST['fournisseur']) && isset($_POST['mail']) && isset($_POST['analytique']) && isset($_POST['LPODEDNUMBER'])) {
    $demandeur = $_POST['demandeur'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $montant = $_POST['montant'];
    $fournisseur = $_POST['fournisseur'];
    $mail = $_POST['mail'];
    $analytique = $_POST['analytique'];
    $commentaire = $_POST['commentaire'];
    $LPODEDNUMBER = $_POST['LPODEDNUMBER'];





    $html = '
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    p {
        font-family: helvetica, sans-serif;
        font-size: 12pt;
        color: #333333;
        bo
    }

    label {
        font-family: helvetica, sans-serif;
        font-weight: bold;
        font-size: 14pt;
        color: #000000;
    }

    td {
        height: 100px;
    }



    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    </style>
</head>

<body>
    <div class = container>

    <table>
        <tr>
            <td width="20%">
                <img src="assets/img/logoLPO.png" alt="logo LPO" />
            </td>
            <td width="10%"></td>
            <td width="70%">
                <h1>Demande d\'Engagement de Dépense</h1>
                <h4>LPO - DED N° ' . $LPODEDNUMBER . '</h4>
                <p>Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
            </td>
        </tr>
        
    </table>

    
    <br>

    <hr>
    <table>
        
        <tr width="100%">
            <td width="40%">
                <label for="demandeur">Demandeur </label>
                <p>' . $demandeur . '</p>
            </td>
            <td width="40%">
                <label for="service">Service </label>
                <p>' . $service . '</p>
            </td>
            <td width="40%">
                <label for="date">Date de la demande </label>
                <p>' . $date . '</p>
            </td>
        </tr>
    </table>
    <hr>
    <table>
        <tr width="100%">
            <td width="40%">
                <label for="montant">Montant TTC </label>
                <p>' . $montant . '</p>
            </td>
            <td width="40%">
                <label for="fournisseur">Fournisseur </label>
                <p>' . $fournisseur . '</p>
            </td>
            <td width="40%">
                <label for="mail">Mail du fournisseur </label>
                <p>' . $mail . '</p>
            </td>
        </tr>
    </table>
    <hr>
    <table>
        <tr width="100%">
            <td width="50%">
                <label for="analytique">Analytique </label>
                <p>' . $analytique . '</p>
            </td>
            <td width="50%">
                <label for="commentaire">Commentaire</label>
                <p>' . $commentaire . '</p>
            </td>
        </tr>
    </table>

    </div>

</body>

</html>

        ';



    creerPDFDepuisHTML($html, $LPODEDNUMBER . "(1)");




    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Traitement pour chaque devis
        for ($i = 1; $i <= 3; $i++) {
            if ($_FILES["devis$i"]["name"] != "") {
                $fileTmpPath = $_FILES["devis$i"]['tmp_name'];
                $fileName = $_FILES["devis$i"]['name'];
                $dest_path = $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(" . ($i + 1) . ").pdf";

                echo $dest_path;
                // Déplacer le fichier dans le dossier de destination
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    echo "Le devis $i a été uploadé avec succès.<br />";
                } else {
                    echo "Erreur lors de l'upload du devis $i.<br />";
                }
            }
        }
    }

    // Concatener les fichiers
        
    // recuperer tout les pdfs contenant le numéro de la demande
    $files = glob($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/*' . $LPODEDNUMBER . "*.pdf");


    concatenerPDF($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(1).pdf", $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(2).pdf", $LPODEDNUMBER . "tmp");

    // parcourir les fichiers sauf les deux premiers
    for ($i = 2; $i < count($files); $i++) {
        concatenerPDF($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf", $files[$i], $LPODEDNUMBER . "tmp");
    }

    // renommer le fichier tmp en pdf
    rename($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf", $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/LPO-DED-' . $LPODEDNUMBER . ".pdf");
  

    
    

    


    



    /*
    concatenerPDF($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(1).pdf", $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(2).pdf", $LPODEDNUMBER . "tmp");
    if ($_FILES["devis3"]["name"] != "") {
        concatenerPDF($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf", $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(3).pdf", $LPODEDNUMBER);
    } else {
        rename($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf", $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . ".pdf");
    }*/

    
    
    // Supprimer les fichiers temporaires
    
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(1).pdf")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(1).pdf");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(2).pdf")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(2).pdf");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(3).pdf")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(3).pdf");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(4).pdf")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "(4).pdf");
    }
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf")) {
        unlink($_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/' . $LPODEDNUMBER . "tmp.pdf");
    }

    

    


    // telecharger le fichier dans le navigateur TEMPORAIRE

    $cheminDuFichier = $_SERVER['DOCUMENT_ROOT'] . 'FormulaireDemandeEngagementdeDepenseLPO/pdfs/LPO-DED-' . $LPODEDNUMBER . ".pdf";

    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($cheminDuFichier) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($cheminDuFichier));

    ob_clean(); // Clean output buffer

    flush(); // Flush system output buffer

    readfile($cheminDuFichier);
}

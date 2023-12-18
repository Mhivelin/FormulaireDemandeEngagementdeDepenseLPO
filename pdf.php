<?php



require __DIR__ . '/vendor/autoload.php';



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
    $cheminDuFichier = __DIR__ . '/pdfs/DED/' . $nomDuFichier . '.pdf';

	echo $cheminDuFichier;

    $pdf->Output($cheminDuFichier, 'F');
}

require_once 'vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;




function telechargerPDF($fichier, $nomDuFichier)
{
    $fichier = __DIR__ . '/pdfs/' . $fichier . '.pdf';
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fichier . '"');
    readfile($fichier);
}



// generation du pdf
// recuperaion des données

/*
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
*/


// Validation et nettoyage des données d'entrée
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Vérification des données POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["demandeur"])) {
        $demandeurErr = "Le nom du demandeur est requis";
    } else {
        $demandeur = clean_input($_POST["demandeur"]);
    
    }

    if (empty($_POST["service"])) {
        $serviceErr = "Le service est requis";
    } else {
        $service = clean_input($_POST["service"]);
    }

    if (empty($_POST["date"])) {
        $dateErr = "La date est requise";
    } else {
        $date = clean_input($_POST["date"]);
    }

    if (empty($_POST["montant"])) {
        $montantErr = "Le montant est requis";
    } else {
        $montant = clean_input($_POST["montant"]);
    }

    if (empty($_POST["fournisseur"])) {
        $fournisseurErr = "Le fournisseur est requis";
    } else {
        $fournisseur = clean_input($_POST["fournisseur"]);
    }

    if (empty($_POST["mail"])) {
        $mailErr = "Le mail du fournisseur est requis";
    } else {
        $mail = clean_input($_POST["mail"]);
    }

    if (empty($_POST["analytique"])) {
        $analytiqueErr = "L'analytique est requis";
    } else {
        $analytique = clean_input($_POST["analytique"]);
    }

    if (empty($_POST["commentaire"])) {
        $commentaire = "";
    } else {
        $commentaire = clean_input($_POST["commentaire"]);
    }

    if (empty($_POST["LPODEDNUMBER"])) {
        $LPODEDNUMBERErr = "Le numéro de la demande est requis";
    } else {
        $LPODEDNUMBER = clean_input($_POST["LPODEDNUMBER"]);
    }

    
    





    $html = '
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    body {
        font-family: helvetica, sans-serif;
        color: #333333;
    }

    .container {
        width: 90%;
        margin: 0 auto;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .group {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 10px;
        margin-bottom: 20px;
    }

    .group label {
        font-weight: bold;
        font-size: 14pt;
        display: block;
        margin-bottom: 5px;
        margin-top: 10px;
    }

    .group p {
        font-size: 12pt;
        margin: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    td {
        padding: 10px;
        border: 1px solid #ddd;
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
            <td width="70%">
                <h1>Demande d\'Engagement de Dépense</h1>
                <h4>LPO - DED N° ' . $LPODEDNUMBER . '</h4>
                <p>Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
            </td>
        </tr>
        
    </table>

    <br>
    <hr class="separateur">
    <br>

    <table class="group">
                <tr>
                    <td>
                        <label for="demandeur">Demandeur :</label>
                        <p>' . htmlspecialchars($demandeur) . '</p>
                    </td>
                    <td>
                        <label for="service">Service :</label>
                        <p>' . htmlspecialchars($service) . '</p>
                    </td>
                    <td>
                        <label for="date">Date de la demande :</label>
                        <p>' . htmlspecialchars($date) . '</p>
                    </td>
                </tr>
            </table>

            <br>
    
            <table class="group">
                <tr>
                    <td>
                        <label for="montant">Montant TTC :</label>
                        <p>' . htmlspecialchars($montant) . '</p>
                    </td>
                    <td>
                        <label for="fournisseur">Fournisseur :</label>
                        <p>' . htmlspecialchars($fournisseur) . '</p>
                    </td>
                    <td>
                        <label for="mail">Mail du fournisseur :</label>
                        <p>' . htmlspecialchars($mail) . '</p>
                    </td>
                </tr>
            </table>

            <br>
    
            <table class="group">
                <tr>
                    <td>
                        <label for="analytique">Analytique :</label>
                        <p>' . htmlspecialchars($analytique) . '</p>
                    </td>
                    <td colspan="2">
                        <label for="commentaire">Commentaire :</label>
                        <p>' . htmlspecialchars($commentaire) . '</p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    </html>

        ';


        

    creerPDFDepuisHTML($html, $LPODEDNUMBER);


    // verification dossier pdfs/devis
    $dossier = __DIR__ . '/pdfs/devis';
    if (!is_dir($dossier)) {
        mkdir($dossier);
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Traitement pour chaque devis
        for ($i = 1; $i <= 3; $i++) {
            if ($_FILES["devis$i"]["name"] != "") {
                echo "<br />";
                var_dump($_FILES["devis$i"]);
                

                $fileTmpPath = $_FILES["devis$i"]['tmp_name'];
                $fileName = $_FILES["devis$i"]['name'];
                $dest_path = __DIR__ . '/pdfs/devis/' . $LPODEDNUMBER . "(" . ($i) . ").pdf";

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




    


    // telecharger le fichier dans le navigateur TEMPORAIRE
/*
    $cheminDuFichier = __DIR__ . '/pdfs/LPO-DED-' . $LPODEDNUMBER . ".pdf";
	


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

    */


    // redirection vers la page d'accueil
    header('Location: index.php');
	
	

}
<?php

require __DIR__ . '/vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF;

function creerPDFDepuisHTML($html, $nomDuFichier)
{
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->SetFont('dejavusans', '', 10);
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');

    $cheminDuFichier = __DIR__ . '/pdfs/DED/' . $nomDuFichier . '.pdf';
    $pdf->Output($cheminDuFichier, 'F');
}

function telechargerPDF($fichier, $nomDuFichier)
{
    $fichier = __DIR__ . '/pdfs/' . $fichier . '.pdf';
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $nomDuFichier . '.pdf"');
    readfile($fichier);
}

function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $required_fields = ['demandeur', 'service', 'date', 'montant', 'fournisseur', 'mail', 'analytique', 'LPODEDNUMBER'];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Le champ $field est requis";
        } else {
            ${$field} = clean_input($_POST[$field]);
        }
    }

    if (empty($errors)) {
        $montant = str_replace('.', ',', $montant);
        $commentaire = !empty($_POST["commentaire"]) ? clean_input($_POST["commentaire"]) : '';

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
    <div class="container">
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
                    <p>' . $demandeur . '</p>
                </td>
                <td>
                    <label for="service">Service :</label>
                    <p>' . $service . '</p>
                </td>
                <td>
                    <label for="date">Date de la demande :</label>
                    <p>' . $date . '</p>
                </td>
            </tr>
        </table>
        <br>
        <table class="group">
            <tr>
                <td>
                    <label for="montant">Montant TTC :</label>
                    <p>' . $montant . '</p>
                </td>
                <td>
                    <label for="fournisseur">Fournisseur :</label>
                    <p>' . $fournisseur . '</p>
                </td>
                <td>
                    <label for="mail">Mail du fournisseur :</label>
                    <p>' . $mail . '</p>
                </td>
            </tr>
        </table>
        <br>
        <table class="group">
            <tr>
                <td>
                    <label for="analytique">Analytique :</label>
                    <p>' . $analytique . '</p>
                </td>
                <td colspan="2">
                    <label for="commentaire">Objet de la demande :</label>
                    <p>' . $commentaire . '</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>';

        creerPDFDepuisHTML($html, $LPODEDNUMBER);

        // verification dossier pdfs/devis
        $dossier = __DIR__ . '/pdfs/devis';
        if (!is_dir($dossier)) {
            mkdir($dossier, 0777, true);
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

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        echo "Le devis $i a été uploadé avec succès.<br />";
                    } else {
                        echo "Erreur lors de l'upload du devis $i.<br />";
                    }
                }
            }
        }

        // redirection vers la page d'accueil
        header('Location: index.php?success=1&ded_number=' . urlencode($LPODEDNUMBER));
        exit;
    }
}
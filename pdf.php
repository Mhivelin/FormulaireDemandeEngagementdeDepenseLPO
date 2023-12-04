<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;


function mergePDF($pdf1, $pdf2, $output)
{
    $pdf = new \setasign\Fpdi\Fpdi();
    $pageCount = $pdf->setSourceFile($pdf1);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
        $pdf->AddPage($orientation, array($size['width'], $size['height']));
        $pdf->useTemplate($templateId);
    }

    $pageCount = $pdf->setSourceFile($pdf2);
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);
        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
        $pdf->AddPage($orientation, array($size['width'], $size['height']));
        $pdf->useTemplate($templateId);
    }

    $pdf->Output($output, 'F');
}


// exemple d'utilisation
mergePDF('LPO - formulaire.pdf', 'LPO - formulaire.pdf', 'merged.pdf');








if (isset($_POST['demandeur'])) {


    /* ----------------------------------------------- partie 1 : récupération des données du formulaire ----------------------------------------------- */
    $demandeur = $_POST['demandeur'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $montant = $_POST['montant'];
    $fournisseur = $_POST['fournisseur'];
    $mail = $_POST['mail'];
    $analytique = $_POST['analytique'];
    $LPODEDNUMBER = $_POST['LPODEDNUMBER'];

    $demande = '
        <div class="container" id="pdf">
            <div class="row align-items-center mb-4">
                <div class="col-md-4">
                    <img src="assets/img/logoLPO.png" alt="logo LPO" class="img-fluid" />
                </div>
                <div class="col-md-8 ">
                    <h1>Demande d\'Engagement de Dépense</h1>
                    <h4 id="lpo-ded">LPO - DED N° ' . $LPODEDNUMBER . '</h4>
                    <p> Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
                </div>
            </div>

            <hr class="separateur">

            <form id="monFormulaire" action="./pdf.php" method="POST" enctype="multipart/form-data">
                <!-- 1. Identification du demandeur champs : demandeur, service, date de la demande -->
                <div class="row">
                    <div class="col-md-4">
                        <label for="demandeur">Demandeur </label>
                        <input type="text" class="form-control" id="demandeur" name="demandeur" placeholder="Demandeur"
                            required value=' . $demandeur . '>
                    </div>
                    <div class="col-md-4">
                        <label for="service">Service </label>
                        <select class="form-select" id="service" name="service" required>
                            <option selected>Choisir un service</option>
                            
                            <option value="' . $service . '">' . $service . '</option>
            
                        </select>

                    </div>
                    <div class="col-md-4">
                        <label for="date">Date de la demande </label>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date"
                            value=' . $date . ' required>
                    </div>

                    </div>

                    <hr class="separateur">

                    <!-- 2. champs : Montant TTC, Fournisseur, mail du fournisseur, analytique -->

                    <div class="mb-3">
                        <label for=" montant">Montant TTC </label>
                        <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant TTC" required value=' . $montant . '>
                    </div>
                    <div class="row mb-3">
                        <div class=" col-md">
                            <label for="fournisseur">Fournisseur </label>
                            <input type="text" class="form-control" id="fournisseur" name="fournisseur" placeholder="Fournisseur" required value=' . $fournisseur . '>
                        </div>
                        <div class="col-md">
                            <label for="mail">Mail du fournisseur </label>
                            <input type="email" class="form-control" id="mail" name="mail" placeholder="Mail du fournisseur" required value=' . $mail . '>
                        </div>
                    </div>
                    <div class="col-md">
                        <label for="analytique">Analytique </label>
                        <input type="text" class="form-control" id="analytique" name="analytique" placeholder="Analytique" required value=' . $analytique . '>
                    </div>
                    <hr class="separateur">

                    <div class="mb-3">
                        <label for="commentaire">Commentaire</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea value=' . $commentaire . '>
                    </div>
                    </form>
                    </div>';


    /* ----------------------------------------------- partie 2 : recupération des pdfs déposés ----------------------------------------------- */

    if (isset($_FILES['devis1'])) {
        $devis1 = $_FILES['devis1'];
        $devis1Name = $_FILES['devis1']['name'];
        $devis1TmpName = $_FILES['devis1']['tmp_name'];
        $devis1Size = $_FILES['devis1']['size'];
        $devis1Error = $_FILES['devis1']['error'];
        $devis1Type = $_FILES['devis1']['type'];

        $devis1Ext = explode('.', $devis1Name);
        $devis1ActualExt = strtolower(end($devis1Ext));

        $allowed = array('pdf');




    $html = '
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulaire LPO</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">

    </head>

    <body>';

    $html .= $demande;


    $html .= '
    </body>
    </html>';


    echo $html;

    // Output the generated PDF (Exemple : le télécharger)
    $dompdf->stream("document.pdf", array("Attachment" => 1));
}
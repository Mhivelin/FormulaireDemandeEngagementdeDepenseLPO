<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;



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

        if (in_array($devis1ActualExt, $allowed)) {
            if ($devis1Error === 0) {
                if ($devis1Size < 1000000) {
                    $devis1NameNew = uniqid('', true) . "." . $devis1ActualExt;
                    $devis1Destination = 'uploads/' . $devis1NameNew;
                    move_uploaded_file($devis1TmpName, $devis1Destination);
                } else {
                    echo "Votre fichier est trop volumineux !";
                }
            } else {
                echo "Il y a eu une erreur lors du téléchargement de votre fichier !";
            }
        } else {
            echo "Vous ne pouvez pas télécharger ce type de fichier !";
        }
    }


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

        <style>
    /* Container */
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    /* Row */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    /* Col */
    .col-md-4, .col-md-8, .col-md {
        position: relative;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }

    /* Spécifique pour col-md-4 et col-md-8 */
    .col-md-4 {
        flex: 0 0 auto;
        width: 33.33333%;
    }
    .col-md-8 {
        flex: 0 0 auto;
        width: 66.66667%;
    }

    /* Form Control */
    .form-control {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }

    /* Form Select */
    .form-select {
        display: block;
        width: 100%;
        padding: .375rem .75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .25rem;
    }

    /* Margin Bottom */
    .mb-3 {
        margin-bottom: 1rem;
    }

    /* Separateur */
    .separateur {
        border-top: 1px solid #e9ecef;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
</head>

    <body>


        ' . $demande . '
        
        <!-- saut de page -->
        <div class="page-break"></div>

        <!--  affichage des pdfs déposés -->
        <div class="row">
            <div class="col-md-6">
                <h3>Devis</h3>
                <embed src="' . $devis1Destination . '" width="100%" height="100%" />
            </div>
            <div class="col-md-6">
                <h3>Facture</h3>
                <embed src="' . $facture1Destination . '" width="100%" height="100%" />
            </div>


    

    </body>
    </html>';


    // generate pdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("document.pdf", array("Attachment" => true));
}

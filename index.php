<?php

// recupération des variables du fichier json 
$json = file_get_contents('assets/json/data.json');

$numDED = json_decode($json)->LPODEDNUMBER;

// completer le numero de DED avec des 0 pour avoir 4 chiffres
$number = str_pad($numDED, 4, '0', STR_PAD_LEFT);

$LPODEDNUMBER = date("Y") . $number;

// incrementation du numero de DED
$json = json_decode($json, true);
$json['LPODEDNUMBER'] = $numDED + 1;

// ecriture du nouveau numero de DED dans le fichier json
file_put_contents('assets/json/data.json', json_encode($json));

$services = [];

foreach ($json['SERVICES'] as $service) {
    $services[] = $service;
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire LPO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>




</head>

<body>
    <div class="container" id="pdf">
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
                <img src="assets/img/logoLPO.png" alt="logo LPO" class="img-fluid" />
            </div>
            <div class="col-md-8 ">
                <h1>Demande d'Engagement de Dépense</h1>
                <h4 id="lpo-ded">LPO - DED N° <?= $LPODEDNUMBER ?></h4>
                <p> Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
            </div>
        </div>

        <hr class="separateur">

        <form id="monFormulaire" action="./pdf.php" method="POST" enctype="multipart/form-data">
            <!-- 1. Identification du demandeur champs : demandeur, service, date de la demande -->
            <div class="row">
                <div class="col-md-4">
                    <label for="demandeur">Demandeur *</label>
                    <input type="text" class="form-control" id="demandeur" name="demandeur" placeholder="Demandeur"
                        required>
                </div>
                <div class="col-md-4">
                    <label for="service">Service *</label>
                    <select class="form-select" id="service" name="service" required>
                        <option selected>Choisir un service</option>
                        <?php foreach ($services as $service) : ?>
                        <option value="<?= $service ?>"><?= $service ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="col-md-4">
                    <label for="date">Date de la demande </label>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Date"
                        value=<?= date("Y-m-d") ?> required>
                </div>

            </div>

            <hr class="separateur">

            <!-- 2. champs : Montant TTC, Fournisseur, mail du fournisseur, analytique -->

            <div class="mb-3">
                <label for=" montant">Montant TTC *</label>
                <input type="number" class="form-control" id="montant" name="montant" placeholder="Montant TTC"
                    required>
            </div>
            <div class="row mb-3">
                <div class=" col-md">
                    <label for="fournisseur">Fournisseur *</label>
                    <input type="text" class="form-control" id="fournisseur" name="fournisseur"
                        placeholder="Fournisseur" required>
                </div>
                <div class="col-md">
                    <label for="mail">Mail du fournisseur *</label>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="Mail du fournisseur"
                        required>
                </div>

            </div>


            <div class="col-md">
                <label for="analytique">Analytique *</label>
                <input type="text" class="form-control" id="analytique" name="analytique" placeholder="Analytique"
                    required>
            </div>

            <hr class="separateur">

            <!-- 3. Devis : champs : devis 1 *, devis 2 *, devis 3 -->

            <div class="row mb-3">
                <div class="col-md">
                    <label for="devis1">Devis 1 *</label>
                    <input type="file" class="form-control" id="devis1" name="devis1" accept=".pdf" required>
                </div>
                <div class="col-md">
                    <label for="devis2">Devis 2 *</label>
                    <input type="file" class="form-control" id="devis2" name="devis2" accept=".pdf" required>
                </div>
                <div class="col-md">
                    <label for="devis3">Devis 3</label>
                    <input type="file" class="form-control" id="devis3" name="devis3" accept=".pdf">
                </div>

            </div>

            <hr class="separateur">

            <!-- 4. commentaire : champs : commentaire -->

            <div class="mb-3">
                <label for="commentaire">Commentaire</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
            </div>


            <!-- 5. les champs cachés : LPODEDNUMBER -->

            <input type="hidden" id="LPODEDNUMBER" name="LPODEDNUMBER" value="<?= $LPODEDNUMBER ?>">
            <input type="hidden" id="html" name="html" value="">




            <!-- 6. bouton : envoyer vers pdf.php -->

            <button class="btn btn-primary" id="envoyer">Envoyer</button>







        </form>
    </div>




    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/pdf-lib@^1.16.0/dist/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.3/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>



    <script>
    /*
        // event.preventDefault()
        const envoyer = document.querySelector('#envoyer');

        envoyer.addEventListener('click', (event) => {
            event.preventDefault();

            // recupération l'eement <html> du document
            const html = document.querySelector('html').outerHTML;

            // injection de la page html dans le champ caché html
            document.querySelector('#html').value = html;

            // envoi du formulaire
            document.querySelector('#monFormulaire').submit();

        })*/

    const envoyer = document.querySelector('#envoyer');

    envoyer.addEventListener('click', (event) => {

        event.preventDefault();



        var element = document.body;

        // Options pour la conversion PDF
        var options = {
            margin: 10,
            filename: 'mon_fichier.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        // Utiliser html2pdf pour générer le PDF
        html2pdf(element, options);


    })
    </script>






</body>

</html>
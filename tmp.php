<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire LPO</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    p {
        font-family: helvetica, sans-serif;
        font-size: 12pt;
        color: #333333;
    }

    label {
        font-family: helvetica, sans-serif;
        font-weight: bold;
        font-size: 14pt;
        color: #000000;
    }
    </style>
</head>

<body>

    <table>
        <tr>
            <td width="20%">
                <img src="assets/img/logoLPO.png" alt="logo LPO" />
            </td>
            <td width="10%"></td>
            <td width="70%">
                <h1>Demande d\'Engagement de Dépense</h1>
                <h4>LPO - DED N° [LPODEDNUMBER]</h4>
                <p>Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
            </td>
        </tr>
        <hr>
        <tr>
            <td>
                <label for="demandeur">Demandeur </label>
                <p>' . $demandeur . '</p>
            </td>
            <td>
                <label for="service">Service </label>
                <p>' . $service . '</p>
            </td>
            <td>
                <label for="date">Date de la demande </label>
                <p>' . $date . '</p>
            </td>
        </tr>
        <hr>
        <tr>
            <td>
                <label for="montant">Montant TTC </label>
                <p>' . $montant . '</p>
            </td>
            <td>
                <label for="fournisseur">Fournisseur </label>
                <p>' . $fournisseur . '</p>
            </td>
            <td>
                <label for="mail">Mail du fournisseur </label>
                <p>' . $mail . '</p>
            </td>
        </tr>
        <hr>
        <tr>
            <td>
                <label for="analytique">Analytique </label>
                <p>' . $analytique . '</p>
            </td>
            <td>
                <label for="commentaire">Commentaire</label>
                <p>' . $commentaire . '</p>
            </td>
        </tr>
    </table>

</body>

</html>
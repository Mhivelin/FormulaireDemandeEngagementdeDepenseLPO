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
            <div class="header">
                <img src="assets/img/logoLPO.png" alt="logo LPO" />
                <h1>Demande d\'Engagement de Dépense</h1>
                <h4>LPO - DED N° ' . htmlspecialchars($LPODEDNUMBER) . '</h4>
                <p>Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !</p>
            </div>
    
            <table class="group">
                <tr>
                    <td>
                        <label for="demandeur">Demandeur</label>
                        <p>' . htmlspecialchars($demandeur) . '</p>
                    </td>
                    <td>
                        <label for="service">Service</label>
                        <p>' . htmlspecialchars($service) . '</p>
                    </td>
                    <td>
                        <label for="date">Date de la demande</label>
                        <p>' . htmlspecialchars($date) . '</p>
                    </td>
                </tr>
            </table>
    
            <table class="group">
                <tr>
                    <td>
                        <label for="montant">Montant TTC</label>
                        <p>' . htmlspecialchars($montant) . '</p>
                    </td>
                    <td>
                        <label for="fournisseur">Fournisseur</label>
                        <p>' . htmlspecialchars($fournisseur) . '</p>
                    </td>
                    <td>
                        <label for="mail">Mail du fournisseur</label>
                        <p>' . htmlspecialchars($mail) . '</p>
                    </td>
                </tr>
            </table>
    
            <table class="group">
                <tr>
                    <td>
                        <label for="analytique">Analytique</label>
                        <p>' . htmlspecialchars($analytique) . '</p>
                    </td>
                    <td colspan="2">
                        <label for="commentaire">Commentaire</label>
                        <p>' . htmlspecialchars($commentaire) . '</p>
                    </td>
                </tr>
            </table>
        </div>
    </body>
    </html>
    
        ';
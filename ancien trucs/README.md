


## cahier des charges
### Accès au Formulaire type:

* URL : https://demo1-gdb.docuware.cloud/DocuWare/Forms/lpo-ded?orgID=1d5df794-8205-492a-807f-bc53df0681a0
* Les champs marqués d'un astérisque (*) doivent être obligatoires.


### Champs du Formulaire:

* Chrono: Généré automatiquement avec le préfixe "LPO – DED N°[202300001]".
* Phrase informative: "Merci de reprendre en compte le numéro de la demande ci-dessus dans vos factures !".
* Demandeur: Champ de texte libre pour l'inscription du nom et prénom de l'acheteur.
* Service: Connecté à leur base SQL, à configurer ultérieurement.
* Date de demande: Champ avec la date du jour préremplie.
* Montant TTC: Champ numérique.
* Fournisseur: Champ connecté à leur base SQL, prérempli avec un astérisque (*), à configurer ultérieurement.
* Mail fournisseur: Champ pour l'adresse e-mail du fournisseur.
* Analytique: Champ connecté à leur base SQL, à configurer ultérieurement.
* Devis 1/2/3: Champs pour pièces jointes, obligatoires pour les deux premiers devis.
* Commentaire: Champ facultatif.
* Bouton "Envoyer" pour soumettre le formulaire.
* Traitement Post-Envoi:

### Transformation du formulaire en PDF après l'envoi.

* Fusion des devis avec le PDF du formulaire.
* Ajout de la mention "Découpez ici" en haut de chaque première page des devis.
* Option de découpage automatisé dans DocuWare, à déterminer (par code-barres, mot-clé, etc.).


### Design et Expérience Utilisateur:

* Interface claire et intuitive.
* Indications visuelles pour les champs obligatoires.
* Validation des champs pour s'assurer de la saisie correcte des informations.


### Sécurité et Conformité:

* Protection des données saisies.
* Conformité avec les réglementations en vigueur concernant la protection des données personnelles. (aucune donnée n'etant enrégistrée ailleurs que sur l'ordinateur de l'utilisateur pas de soucis de ce coté la)



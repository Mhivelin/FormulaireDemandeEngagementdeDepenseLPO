/*document.getElementById('add-file').addEventListener('click', function () {
    var newInput = document.createElement('input');
    newInput.setAttribute('type', 'file');
    newInput.setAttribute('class', 'form-control mb-2');
    newInput.setAttribute('name', 'files[]');
    newInput.setAttribute('onchange', 'addFileToTable(this)');

    var fileSection = document.getElementById('file-upload-section');
    fileSection.insertBefore(newInput, this);
});*/

console.log('Script chargé !');


function addFileToTable(inputElement) {
    if (inputElement.files.length > 0) {
        var tableBody = document.getElementById('file-table').querySelector('tbody');
        var row = tableBody.insertRow();

        var cellFileName = row.insertCell();
        cellFileName.textContent = inputElement.files[0].name;

        selectedPDFs.push(inputElement.files[0]);

        var cellAction = row.insertCell();
        var removeButton = document.createElement('button');
        removeButton.textContent = 'Retirer';
        removeButton.className = 'btn btn-danger btn-sm';
        removeButton.onclick = function () {
            row.remove();
            inputElement.value = ''; // Reset the file input
        };

        cellAction.appendChild(removeButton);

        var file = inputElement.files[0];
        var fileReader = new FileReader();

        // Définir ce qui doit se passer une fois le fichier lu
        fileReader.onload = function (e) {
            // Traitement du fichier lu, si nécessaire
            console.log("Fichier lu avec succès");
        };

        // Lire le contenu du fichier
        fileReader.readAsArrayBuffer(file)


    }
}



// Obtenir la date actuelle
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); // Janvier est 0 !
var yyyy = today.getFullYear();

today = dd + '/' + mm + '/' + yyyy;
// Définir la valeur de l'élément de saisie de la date
document.getElementById('date-demande').value = today;







var selectedPDFs = [];


document.getElementById('monFormulaire').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche le rechargement de la page
    console.log('Formulaire soumis !');

    // Créer un objet FormData
    var formData = {};
    // Collecter les données
    formData['service'] = document.getElementById('service').value;
    formData['lpo-ded'] = document.getElementById('lpo-ded').value;
    formData['commentaire'] = document.getElementById('commentaire').value;
    formData['mail-fournisseur'] = document.getElementById('mail-fournisseur').value;
    formData['date-demande'] = document.getElementById('date-demande').value;

    //collecter les documents
    var tableBody = document.getElementById('file-table').querySelector('tbody');
    var rows = tableBody.querySelectorAll('tr');
    var files = [];
    rows.forEach(function (row) {
        var fileName = row.querySelector('td:first-child').textContent;
        files.push(fileName);
    });
    formData['files'] = files;

    //creation du pdf
    // Créer une instance de jsPDF
    const doc = new jspdf.jsPDF();


    // Ajouter du texte au PDF
    doc.text('Service: ' + formData['service'], 10, 10);
    doc.text('LPO/DED: ' + formData['lpo-ded'], 10, 20);
    doc.text('Commentaire: ' + formData['commentaire'], 10, 30);
    doc.text('Mail fournisseur: ' + formData['mail-fournisseur'], 10, 40);
    doc.text('Date demande: ' + formData['date-demande'], 10, 50);

    // recuperation des fichiers pdf
    var files = formData['files'];
    var y = 60;
    files.forEach(function (file) {
        doc.text('Fichier: ' + file, 10, y);
        y += 10;
    });

    selectedPDFs.push(doc.output('blob'));

    // Fusionner les PDF
    const mergedPdfBytes = mergePDFs(selectedPDFs);

    // Télécharger le PDF
    // creation du titre : Demande d'Engagement de Dépense {date de la demande} {nom du service}
    doc.save('Demande d\'Engagement de Dépense ' + formData['date-demande'] + ' ' + formData['service'] + '.pdf');
});



async function mergePDFs(files) {
    const mergedPdf = await PDFLib.PDFDocument.create();

    for (const file of files) {
        const arrayBuffer = await file.arrayBuffer();
        const pdfDoc = await PDFLib.PDFDocument.load(arrayBuffer);

        const numPages = pdfDoc.getPageCount();
        for (let i = 0; i < numPages; i++) {
            const [copiedPage] = await mergedPdf.copyPages(pdfDoc, [i]);
            mergedPdf.addPage(copiedPage);
        }
    }

    const mergedPdfBytes = await mergedPdf.save();
    return mergedPdfBytes;
}



/*console.log('Script chargé !');





document.getElementById('monFormulaire').addEventListener('submit', function (event) {
    event.preventDefault(); // Empêche le rechargement de la page
    console.log('Formulaire soumis !');

    window.print();

    
    // Créer un objet FormData
    var formData = {};


    //creation du pdf
    // Créer une instance de jsPDF
    const doc = new jspdf.jsPDF();

    // parametrage du pdf
    doc.setProperties({
        title: document.getElementById('lpo-ded').innerHTML,
        subject: 'DED',
        // taille du pdf
        format: 'a4',
        // orientation du pdf
        orientation: 'portrait'
    });






    // Ajouter les elements html au pdf
    elements = document.getElementById('pdf').innerHTML;
    doc.html(elements, {
        callback: function (doc) {
            doc.save();
        }
    });

    // sauvegarder le pdf

    //doc.save(document.getElementById('lpo-ded').innerHTML + '.pdf');

});*/




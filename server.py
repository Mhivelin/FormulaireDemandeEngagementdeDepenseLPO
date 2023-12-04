from flask import Flask, request, send_file
import PyPDF2
import io

app = Flask(__name__)

@app.route('/fusionner-pdf', methods=['POST'])
def fusionner_pdf():
    # Récupération des fichiers PDF depuis la requête
    pdf1 = request.files['pdf1']
    pdf2 = request.files['pdf2']

    # Lecture des fichiers PDF
    pdf1_reader = PyPDF2.PdfFileReader(pdf1)
    pdf2_reader = PyPDF2.PdfFileReader(pdf2)

    # Création d'un nouveau PDF pour la fusion
    pdf_writer = PyPDF2.PdfFileWriter()

    # Ajout des pages du premier PDF
    for page in range(pdf1_reader.getNumPages()):
        pdf_writer.addPage(pdf1_reader.getPage(page))

    # Ajout des pages du deuxième PDF
    for page in range(pdf2_reader.getNumPages()):
        pdf_writer.addPage(pdf2_reader.getPage(page))

    # Sauvegarde du PDF fusionné dans un buffer
    output = io.BytesIO()
    pdf_writer.write(output)

    # Retour du PDF fusionné
    output.seek(0)
    return send_file(output, attachment_filename="Fusion.pdf", as_attachment=True)

if __name__ == '__main__':
    app.run(debug=True)

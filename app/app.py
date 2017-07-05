from flask import Flask, render_template, request
import ftp


app = Flask(__name__)


@app.route('/send', methods=['GET', 'POST'])
def send():
    if request.method == 'POST':
        file = request.form['fileToUpload']
        ftp.storeFile(file)
        return render_template('fileupload.html', file=file)
    return render_template('index.html')


if __name__ == "__main__":
    app.run()

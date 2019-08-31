from flask import Flask
from flask_httpauth import HTTPBasicAuth
from werkzeug.security import generate_password_hash, check_password_hash

app = Flask(__name__)
auth = HTTPBasicAuth()

users = {
    "igor": generate_password_hash("igor"),
    "leonardo": generate_password_hash("leonardo"),
    "fabio": generate_password_hash("fabio"),
    "felipe": generate_password_hash("felipe"),
    "xekao": generate_password_hash("xekao")
}

@auth.verify_password
def verify_password(username, password):
    if username in users:
        return check_password_hash(users.get(username), password)
    return False

@app.route('/')
def index():
   return '<h1>Raiz, livre acesso</h1>'

@app.route('/protegido1')
@auth.login_required
def prot1():
   return '<h1>Conteudo protegido 1</h1>'

@app.route('/protegido2')
@auth.login_required
def prot2():
   return '<h1>Outro conteudo protegido 2</h1>'

if __name__ == '__main__':
    app.run(debug=True)
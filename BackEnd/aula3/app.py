from flask import Flask, jsonify, request, make_response

app = Flask(__name__)

@app.route('/')
def index():
    auth = request.authorization

    if auth and  auth.username == 'user' and auth.password == 'pass':
        return '<h1>Você está no root</h1>'

    return '<h1>Você não está no root</h1>'

@app.route('/auth')
def protegido():
    auth = request.authorization

    if auth and  auth.username == 'user' and auth.password == 'pass':
        return '<h1>Você está logado</h1>'

    return make_response( '<h1>Você não está logado</h1>', 401, {'WWW-Authenticate':'Basic realm="host"'} )

if __name__ == '__main__':
    app.run(debug=True)
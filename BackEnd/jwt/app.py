from flask import Flask, request, jsonify
from flask_httpauth import HTTPBasicAuth
from werkzeug.security import safe_str_cmp
from flask_restful import Resource, Api
from flask_jwt import JWT, jwt_required, current_identity

livros = [
    {
        "id_livro":1,
        "nome":"O Homem de Giz",
        "autor":"C.J.Tudor",
        "genero":"Suspense"
    },
    {
        "id_livro":2,
        "nome":"O Homem de Giz2",
        "autor":"C.J.Tudor2",
        "genero":"Suspense2"
    }
]

class User(object):
    def __init__(self, id, username, password):
        self.id = id
        self.username = username
        self.password = password

    def __str__(self):
        return "User(id='%s')" % self.id

users = [
    User(1, 'igor', '123'),
    User(2, 'tiago', '456')
]

username_table = {u.username: u for u in users}
userid_table = {u.id: u for u in users}

def authenticate(username, password):
    user = username_table.get(username, None)
    if user and safe_str_cmp(user.password.encode('utf-8'), password.encode('utf-8')):
        return user
    return False

def identity(payload):
    user_id = payload['identity']
    return userid_table.get(user_id, None)

app = Flask(__name__)
app.debug = True
app.config['SECRET_KEY'] = 'segredo_secreto'
jwt = JWT(app, authenticate, identity)
api = Api(app)

class Livro(Resource):
    @jwt_required()
    def get(self, id):
        retorno = None
        for livro in livros:
            if livro['id_livro'] == id:
                retorno = livro
        return retorno

    @jwt_required()
    def post(self, id):
        data = request.get_json(force=True)
        data['id_livro'] = id
        livros.append(data)
        return data, 201

    @jwt_required()
    def put(self, id):
        retorno = None
        for livro in livros:
            if livro['id_livro'] == id:
                livros.remove(livro)
                data = request.get_json(force=True)
                data['id_livro'] = id
                livros.append(data)
                retorno = data
        return retorno

    @jwt_required()
    def delete(self, id):
        retorno = None
        for livro in livros:
            if livro['id_livro'] == id:
                livros.remove(livro)
                retorno = livro
        return retorno

class Livros(Resource):
    @jwt_required()
    def get(self):
        return { "livros":livros }

api.add_resource(Livro, '/livro/<int:id>')
api.add_resource(Livros, '/livros')

if __name__ == '__main__':
    app.run(debug=True)
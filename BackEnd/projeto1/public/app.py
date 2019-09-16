from flask import Flask, request, jsonify
from flask_restful import Resource, Api

app = Flask(__name__)
api = Api(app)

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
    },
    {
        "id_livro":3,
        "nome":"O Homem de Giz3",
        "autor":"C.J.Tudor3",
        "genero":"Suspense3"
    }
]

class Livro(Resource):
    def get(self, id):
        retorno = None
        for livro in livros:
            if livro['id_livro'] == id:
                retorno = livro
        return retorno

    def post(self, id):
        data = request.get_json(force=True)
        data['id_livro'] = id
        livros.append(data)
        return data, 201

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

    def delete(self, id):
        retorno = None
        for livro in livros:
            if livro['id_livro'] == id:
                livros.remove(livro)
                retorno = livro
        return retorno

class Livros(Resource):
    def get(self):
        return { "livros":livros }

api.add_resource(Livro, '/livro/<int:id>')
api.add_resource(Livros, '/livros')

if __name__ == '__main__':
    app.run(debug=True)
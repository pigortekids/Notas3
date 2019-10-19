from flask import Flask, request, jsonify
from flask_restful import Resource, Api

app = Flask(__name__)
api = Api(app)

from Livro import Livro, Livros

api.add_resource(Livro, '/livro')
api.add_resource(Livros, '/livros')

if __name__ == '__main__':
    app.run(debug=True)
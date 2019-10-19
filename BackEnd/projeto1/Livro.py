from flask import request
from flask_restful import Resource
import mysql.connector
from DAO import DAO

class Livro(Resource):
    def get(self):
        sql = "SELECT * FROM livro WHERE biblioteca.id_livro = 1;"
        return DAO.consulta(sql)

    def post(self):
        data = request.get_json(force=True)
        sql = "INSERT INTO livro ( nome, autor, genero )"
        sql += " VALUES ( '" + data['nome'] + "', '" + data['autor'] + "', '" + data['genero'] + "' )"
        DAO.consulta(sql)
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
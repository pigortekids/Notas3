from flask import request
from flask_restful import Resource
from flask_jwt import jwt_required
from DAO import DAO

class Livro(Resource):
    @jwt_required()
    def get(self, id):
        sql = "SELECT * FROM livro WHERE id_livro = %s;"
        val = (id,)
        return DAO.select(sql, val)

    @jwt_required()
    def post(self, id):
        data = request.get_json(force=True)
        if ('nome' in data) and ('autor' in data) and ('genero' in data):
            sql = "INSERT INTO livro ( nome, autor, genero ) VALUES ( %s, %s, %s )"
            val = (data['nome'], data['autor'], data['genero'])
            DAO.execute(sql, val)
            return "sucesso", 201
        else:
            return None

    @jwt_required()
    def put(self, id):
        data = request.get_json(force=True)
        sql = "UPDATE livro SET"
        val = ()
        i = 0

        campos = ['nome', 'autor', 'genero']
        for campo in campos:
            if campo in data:
                if i != 0:
                    sql += ","
                sql += " " + campo + " = %s"
                val = val + (data[campo],)
                i += 1
        
        if i != 0:
            sql += " WHERE id_livro = %s"
            val = val + (id,)
            print(sql)
            print(val)
            DAO.execute(sql, val)
        return "sucesso", 200

    @jwt_required()
    def delete(self, id):
        sql = "DELETE FROM livro WHERE id_livro = %s"
        DAO.execute(sql, (id, ))
        return "sucesso", 200

class Livros(Resource):
    @jwt_required()
    def get(self):
        sql = "SELECT * FROM livro;"
        return DAO.select(sql)



"""
{
    "nome":"teste",
    "autor":"C.J.Tudor",
    "genero":"Suspense"
}
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzIzOTEyMTEsImlhdCI6MTU3MjM5MDkxMSwibmJmIjoxNTcyMzkwOTExLCJpZGVudGl0eSI6M30.rrjUH1Q8929OcNaFq849A7Ng6PFk2TgCZFIrbV07qG8
"""
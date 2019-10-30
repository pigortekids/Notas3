from flask import request
from flask_restful import Resource
from flask_jwt import jwt_required
from DAO import DAO
from datetime import datetime, timedelta

class Aluguel(Resource):
    @jwt_required()
    def get(self, id):
        sql = "SELECT cliente.nome, livro.nome, aluguel.dia_aluguel, aluguel.dia_devolucao"
        sql += " FROM aluguel, cliente, livro"
        sql += " WHERE (aluguel.id_cliente = cliente.id_cliente AND aluguel.id_livro = livro.id_livro AND aluguel.id_aluguel = %s);"
        val = (id,)
        retorno = DAO.select(sql, val)[0]
        retorno = (retorno[0], retorno[1], str(retorno[2]), str(retorno[3]))
        return retorno

    @jwt_required()
    def post(self, id):
        data = request.get_json(force=True)
        if ('id_cliente' in data) and ('id_livro' in data):
            sql = "INSERT INTO aluguel ( id_cliente, id_livro, dia_aluguel, dia_devolucao ) VALUES ( %s, %s, %s, %s )"
            hoje = datetime.today()
            devolucao = datetime.today() + timedelta(days=7)
            val = (data['id_cliente'], data['id_livro'], hoje, devolucao)
            DAO.execute(sql, val)
            return "sucesso", 201
        else:
            return None

    @jwt_required()
    def put(self, id):
        data = request.get_json(force=True)
        sql = "UPDATE aluguel SET"
        val = ()
        i = 0

        campos = ['id_cliente', 'id_livro', 'dia_aluguel', 'dia_devolucao']
        for campo in campos:
            if campo in data:
                if i != 0:
                    sql += ","
                sql += " " + campo + " = %s"
                val = val + (data[campo],)
                i += 1
        
        if i != 0:
            sql += " WHERE id_aluguel = %s"
            val = val + (id,)
            print(sql)
            print(val)
            DAO.execute(sql, val)
        return "sucesso", 200

    @jwt_required()
    def delete(self, id):
        sql = "DELETE FROM aluguel WHERE id_aluguel = %s"
        DAO.execute(sql, (id, ))
        return "sucesso", 200

class Alugueis(Resource):
    @jwt_required()
    def get(self):
        sql = "SELECT cliente.nome AS cliente, livro.nome AS livro, aluguel.dia_aluguel, aluguel.dia_devolucao"
        sql += " FROM aluguel, cliente, livro"
        sql += " WHERE (aluguel.id_cliente = cliente.id_cliente AND aluguel.id_livro = livro.id_livro);"
        return DAO.select(sql)



"""
{
	"id_cliente":1,
	"id_livro":1
}
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzIzOTEyMTEsImlhdCI6MTU3MjM5MDkxMSwibmJmIjoxNTcyMzkwOTExLCJpZGVudGl0eSI6M30.rrjUH1Q8929OcNaFq849A7Ng6PFk2TgCZFIrbV07qG8
"""
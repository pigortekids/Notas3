from flask import request
from flask_restful import Resource
from flask_jwt import jwt_required
from werkzeug import generate_password_hash
from DAO import DAO

class Cliente(Resource):
    @jwt_required()
    def get(self, id):
        sql = "SELECT * FROM cliente WHERE id_cliente = %s;"
        val = (id,)
        return DAO.select(sql, val)

    @jwt_required()
    def post(self, id):
        data = request.get_json(force=True)
        if ('nome' in data) and ('idade' in data) and ('cpf' in data) and ('username' in data) and ('password' in data):
            sql = "INSERT INTO cliente ( nome, idade, cpf, username, password ) VALUES ( %s, %s, %s, %s, %s )"
            val = (data['nome'], data['idade'], data['cpf'], data['username'], generate_password_hash(data['password']))
            DAO.execute(sql, val)
            return "sucesso", 201
        else:
            return None

    @jwt_required()
    def put(self, id):
        data = request.get_json(force=True)
        sql = "UPDATE cliente SET"
        val = ()
        i = 0

        campos = ['nome', 'cpf', 'idade', 'username', 'password']
        for campo in campos:
            if campo in data:
                if i != 0:
                    sql += ","
                sql += " " + campo + " = %s"
                val = val + (data[campo],)
                i += 1
        
        if i != 0:
            sql += " WHERE id_cliente = %s"
            val = val + (id,)
            print(sql)
            print(val)
            DAO.execute(sql, val)
        return "sucesso", 200

    @jwt_required()
    def delete(self, id):
        sql = "DELETE FROM cliente WHERE id_cliente = %s"
        DAO.execute(sql, (id, ))
        return "sucesso", 200

class Clientes(Resource):
    @jwt_required()
    def get(self):
        sql = "SELECT * FROM cliente;"
        return DAO.select(sql)



"""
{
	"nome":"igor",
	"cpf":"123",
	"idade":18,
	"username":"igor4",
	"password":"123"
}
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzIzOTEyMTEsImlhdCI6MTU3MjM5MDkxMSwibmJmIjoxNTcyMzkwOTExLCJpZGVudGl0eSI6M30.rrjUH1Q8929OcNaFq849A7Ng6PFk2TgCZFIrbV07qG8
"""
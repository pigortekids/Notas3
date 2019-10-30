from flask import Flask, request, jsonify
from flask_restful import Resource, Api
from flask_jwt import JWT, jwt_required, current_identity
from werkzeug import generate_password_hash, check_password_hash
from DAO import DAO


app = Flask(__name__)
app.debug = True
app.config['SECRET_KEY'] = 'segredo_secreto'
api = Api(app)


from Livro import Livro, Livros
api.add_resource(Livro, '/livro/<int:id>')
api.add_resource(Livros, '/livros')


from Cliente import Cliente, Clientes
api.add_resource(Cliente, '/cliente/<int:id>')
api.add_resource(Clientes, '/clientes')


from Aluguel import Aluguel, Alugueis
api.add_resource(Aluguel, '/aluguel/<int:id>')
api.add_resource(Alugueis, '/alugueis')


#Usuário para JWT
class User(object):
	def __init__(self, id, username):
		self.id = id
		self.username = username

	def __str__(self):
		return "User(id='%s')" % self.id


#caminho para checar se está com autorização
@app.route('/autorizado')
@jwt_required()
def get_response():
	return jsonify('You are an authenticate person to see this message')


def authenticate(username, password):
    valores = DAO.select("SELECT id_cliente, username, password FROM cliente WHERE username = %s", (username,))[0]
    if valores:
        print(valores[2])
        if check_password_hash(valores[2], password):
            print(valores)
            return User(valores[0], valores[1])
    else:
        return None


def identity(payload):
    valores = DAO.select("SELECT id_cliente, username FROM cliente WHERE id_cliente = %s", (payload['identity'],))[0]
    if valores:
        return (valores[0], valores[1])
    else:
        return None


jwt = JWT(app, authenticate, identity)


if __name__ == '__main__':
    app.run(debug=True)
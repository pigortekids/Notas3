from flask import Flask, request
from flask_restful import Resource, Api

produtos = [
    {
        "id":1,
        "nome":"batata",
        "preco":4
    },
    {
        "id":2,
        "nome":"mandioca",
        "preco":2
    },
    {
        "id":3,
        "nome":"coxinha",
        "preco":3
    }
]

app = Flask(__name__)
api = Api(app)

class Produto(Resource):
    def get(self, id):
        retorno = None
        for produto in produtos:
            if produto['id'] == id:
                retorno = produto
        return retorno

    def post(self, id):
        data = request.get_json()
        print(data)
        produto = { "id":id, "nome":data['nome'], "preco":data['preco'] }
        produtos.append(produto)
        return produto, 201

    def put(self, id):
        pass

    def delete(self, id):
        pass

class ListaProdutos(Resource):
    def get(self):
        return { "produtos":produtos }

api.add_resource(Produto, '/produto/<int:id>')
api.add_resource(ListaProdutos, '/produtos')

"""
@app.route('/produtos', methods=['GET'])
def get_produtos():
    prod_list = { 'itens':lista }
    return jsonify( prod_list )

@app.route('/produto/<int:id>', methods=['GET'])
def get_produto(id):
    prod = { 'id':'nome' }
    for produto in lista:
        if produto['id'] == id:
            prod = produto
    return jsonify( prod )

@app.route('/produto/<int:id>', methods=['POST'])
def post_produto(id):
    data = request.get_json()
    prod = { 'id':id, 'nome':data['nome'], 'preco':data['preco'] }
    lista.append(prod)
    return jsonify( prod )

@app.route('/produto/<int:id>', methods=['DELETE'])
def del_produto(id):
    for produto in lista:
        if produto['id'] == id:
            lista.remove(produto)
    prod_list = { 'itens':lista }
    return jsonify( prod_list )
"""

if __name__ == '__main__':
    app.run(debug=True)
from flask import Flask, request, jsonify

app = Flask(__name__)

lista = []

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

if __name__ == "__main__":
    app.run( debug = True )
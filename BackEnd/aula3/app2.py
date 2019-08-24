from flask import Flask
from my_decorator import my_auth

app = Flask(__name__)

@app.route('/')
@my_auth
def index():
   return '<h1>Index</h1>'

@app.route('/v1')
@my_auth
def v1():
   return '<h1>Pagina v1</h1>'

@app.route('/sem_auth')
def livre():
   return '<h1>Pagina livre</h1>'

if __name__ == '__main__':
    app.run(debug=True)
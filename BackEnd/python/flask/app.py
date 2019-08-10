from flask import Flask

app = Flask(__name__)

@app.route("/")
def index():
    return "root"

@app.route("/morri")
def func_morri():
    return "morri"

if __name__ == "__main__":
    app.run( debug=True )
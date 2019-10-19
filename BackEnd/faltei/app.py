from flask import Flask, request, jsonify
import tensorflow as tf
from tensorflow import keras
from tensorflow.keras import layers, Sequential
import numpy as np
import os


print(tf.__version__)

print(keras.__version__)

#model = keras.models.load_model('./model.h5')
#print(os.path.join(os.path.dirname(__file__),'model.h5'))


app = Flask(__name__)

@app.route('/previsao/', methods=['GET'])
@app.route('/previsao/m4', methods=['GET'])
def pred_wheater():

    RainToday = float(request.args.get('RainToday'))
    Humidity3pm = float(request.args.get('Humidity3pm'))
    Rainfall = float(request.args.get('Rainfall'))
    Humidity9am = float(request.args.get('Humidity9am'))


    model = keras.models.load_model(os.path.join(os.path.dirname(__file__),'model_top4.h5'))

    x = np.array([[RainToday, Humidity3pm, Rainfall, Humidity9am]])

    y_pred = model.predict(x)

    if ( y_pred > 0.5 ):
        resp = {'prev':1}
    else:
        resp = {'prev':0}

    return jsonify(resp)


if __name__ == "__main__":
    app.run(debug=True)
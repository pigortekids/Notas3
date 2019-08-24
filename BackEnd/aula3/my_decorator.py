import functools
from flask import request, make_response

def my_auth( f ):
    @functools.wraps( f ) #puxa o my decorator
    def func_que_escuta_f(*args, **kwargs):
        auth = request.authorization

        if auth and  auth.username == 'user' and auth.password == 'pass':
            return f(*args, **kwargs)

        return make_response( '<h1>Login incorreto</h1>', 401, {'WWW-Authenticate':'Basic realm="host"'} )

    return func_que_escuta_f
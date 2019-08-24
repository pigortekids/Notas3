import functools

def my_decorator( f ):
    @functools.wraps( f ) #puxa o my decorator
    def func_que_escuta_f(*args, **kwargs): #para colocar parametros, usa args e kwargs
        print('Decorator: Antes da execucao da func')
        f(*args, **kwargs) #tem que chamar a função com os parametros args e kwargs
        print('Decorator: Depois da execucao da func')
    return func_que_escuta_f

@my_decorator
def funcao_qualquer(x, y):
    print('Valor da soma = {}'.format(x+y))

if __name__ == '__main__':
    x = int(input('digite valor de x: '))
    y = int(input('digite valor de y: '))
    funcao_qualquer(x, y)
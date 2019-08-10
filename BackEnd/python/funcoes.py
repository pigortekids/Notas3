def argumentos( *args ):
    print(type(args))
    print(args)
    print(args[0])

def key_word_argumentos( **kwargs ):
    print(type(kwargs))
    print(kwargs)
    print(kwargs["nome"])

if __name__ == "__main__":
    argumentos(1, 2, 3, 4, 5, 6, 7)
    key_word_argumentos(nome="teste")
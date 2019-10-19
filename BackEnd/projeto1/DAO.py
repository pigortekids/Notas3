import mysql.connector

class DAO():

    @staticmethod
    def consulta(sql):
        retorno = None

        try:
            connection = mysql.connector.connect(host='localhost',
                                            database='biblioteca',
                                            user='root',
                                            password='')
            
            cursor = connection.cursor()
            cursor.execute(sql)
            if sql[:7] == "SELECT":
                retorno = cursor.fetchall()
        except Exception as exp:
            print(exp)
        finally:
            cursor.close()
            connection.close()

        return retorno
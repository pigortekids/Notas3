import mysql.connector

class DAO():

    @staticmethod
    def select(sql, val=None):
        retorno = None

        try:
            connection = mysql.connector.connect(host='localhost',
                                            database='biblioteca',
                                            user='root',
                                            password='')
            
            cursor = connection.cursor()
            cursor.execute(sql, val)
            retorno = cursor.fetchall()
        except Exception as exp:
            print(exp)
        finally:
            if 'cursor' in locals():
                cursor.close()
            if 'connection' in locals():
                connection.close()

        return retorno

    @staticmethod
    def execute(sql, val):
        retorno = None

        try:
            connection = mysql.connector.connect(host='localhost',
                                            database='biblioteca',
                                            user='root',
                                            password='')
            
            cursor = connection.cursor()
            cursor.execute(sql, val)
            connection.commit()
        except Exception as exp:
            print(exp)
        finally:
            if 'cursor' in locals():
                cursor.close()
            if 'connection' in locals():
                connection.close()

        return retorno
"""
import mysql.connector

connection = mysql.connector.connect(host='localhost',
                                         database='biblioteca',
                                         user='root',
                                         password='')

if connection.is_connected():
    cursor = connection.cursor()
    cursor.execute("SELECT * FROM livro;")
    record = cursor.fetchall()
    print("Your connected to database: ", record)

if (connection.is_connected()):
    cursor.close()
    connection.close()
"""

sql = "SELECT * FROM"
print(sql[:7])
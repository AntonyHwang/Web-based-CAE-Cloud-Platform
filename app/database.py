##  @file   database.py
#   @title  database
#   @author
#   @date   7/5/2017

import mysql.connector as mariadb

_mariadb_connection = mariadb.connect(user='root', password='root', database='test_database')
_cursor = _mariadb_connection.cursor()

# retrieving data from db
def retrieveFromDB(cursor = _cursor):
    cursor.execute("SELECT job_id FROM job")
    for job_id,job_description in cursor:
        print("Job ID: {}".format(job_id))

# inserting data into db
def writeToDB(job_id, cursor = _cursor, mariadb_connection = _mariadb_connection):
    try:
        cursor.execute("INSERT INTO job (job_id) VALUE (%s)", (job_id,))
    except mariadb.Error as error:
        print("Error: {}".format(error))

    mariadb_connection.commit()
    print "Inserted: ", cursor.lastrowid
    mariadb_connection.close()

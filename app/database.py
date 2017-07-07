##  @file   database.py
#   @title  database
#   @author
#   @date   7/5/2017

import mysql.connector as mariadb

mariadb_connection = mariadb.connect(user='root', password='root', database='test_db')
cursor = mariadb_connection.cursor()

# retrieving data from db
def retrieveFromDB(cursor = cursor):
    cursor.execute("SELECT job_id FROM job")
    for job_id,job_description in cursor:
        print("Job ID: {}".format(job_id))

# inserting data into db
def writeToDB(filename):
    try:
        cursor.execute("INSERT INTO job (stp_filename, finished) VALUE ('%s', 0)" % (filename))
    except mariadb.Error as error:
        print("Error: {}".format(error))

    mariadb_connection.commit()
    job_id = cursor.lastrowid
    print "Inserted: ", job_id
    mariadb_connection.close()
    return job_id



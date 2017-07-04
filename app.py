# We need to import request to access the details of the POST request
# and render_template, to render our templates (form and response)
# we'll use url_for to get some URLs for the app on the templates
import os, sys
from flask import Flask, render_template, request, url_for
from flask.ext.script import Manager
import mysql.connector as mariadb  ## For MariaDB
from ftplib import FTP  ## For FTP

## flush buffer
#sys.stdout.flush()

#default_path = "/var/www/fastcap-proj/upload"
default_path = "/tmp/fastcap"

# Initialize the Flask application
app = Flask(__name__)

## MariaDB https://mariadb.com/blog/how-connect-python-programs-mariadb
##   IP : 140.110.27.125
##   ID/Pass=root/fastcap
##   DB : fast_cap
##   Table : job
def Get_JobInfo(job_id):
    mariadb_connection = mariadb.connect(user='root', password='fastcap', host='140.110.27.125', port='3306', database='fast_cap')
    cursor = mariadb_connection.cursor()
  
    select_elementsize = "select size from job where jid='%s'" % job_id
    try:
      cursor.execute( select_elementsize )
    except mariadb.Error as error:
      print("Error: {}".format(error))
      os._exit(0)  

    count = 0
    for size in cursor:
      print "Elelment size=%s" % size
      sys.stdout.flush()
      count += 1

    cursor.close()
    mariadb_connection.close()
    if( count == 0 ):
      print "Can't got job_id=%s info from DB\n" % job_id
      sys.stdout.flush()
      return 0

    return size[0]
   
def Update_JobInfo(job_id):
    mariadb_connection = mariadb.connect(user='root', password='fastcap', host='140.110.27.125', port='3306', database='fast_cap')
    cursor = mariadb_connection.cursor()

    sql = "update job set finished='1' where jid='%s'" % job_id
    cursor.execute( sql )

    mariadb_connection.commit()
    cursor.close()
    mariadb_connection.close()

## FTP, http://www.java2s.com/Tutorial/Python/0420__Network/0480__ftp.htm
##  IP: 140.110.27.125
##  Port : 21
##  ID/Pass=david/fastcap
def Get_JobFromFTP(job_id):
    FILE1="%s_1.igs" % job_id
    FILE2="%s_2.igs" % job_id

    ftp = FTP('140.110.27.125', 'david', 'fastcap')
    #print "File List: "
    #files = ftp.dir()
    #print files

    ## Check file is exist on FTP
    if( not FILE1 in ftp.nlst() ):
      print "%s not exist" % FILE1
      sys.stdout.flush()
      ftp.quit()
      return 1

    if( not FILE2 in ftp.nlst() ):
      print "%s not exist" % FILE2
      sys.stdout.flush()
      ftp.quit()
      return 1

    ## download file1
    ftp.retrbinary('RETR %s' % FILE1,
                    open(FILE1, 'wb').write)

    ## download file2
    ftp.retrbinary('RETR %s' % FILE2,
                    open(FILE2, 'wb').write)

    ## close ftp session
    ftp.quit()
    return 0

## 1. Capacitance matrix(text output): capacitance_matrix.dat
## 2. Distribution of charge density(graphics output): jobname_post.png
## 3. Mesh of model(graphics output): jobname_mesh.png
def Upload_JobToFTP(job_id):
    file1 = "capacitance_matrix.dat"
    upfilename = "%s_matrix.txt" % job_id
    file2 = "%s_post.png" % job_id
    file3 = "%s_mesh.png" % job_id

    ## connect to ftp
    ftp = FTP('140.110.27.125', 'david', 'fastcap')

    ## upload file1
    fd = open(file1, 'rb')
    ftp.storbinary('STOR %s' % os.path.basename(upfilename), fd)
    fd.close()

    fd = open(file2, 'rb')
    ftp.storbinary('STOR %s' % os.path.basename(file2), fd)
    fd.close()

    fd = open(file3, 'rb')
    ftp.storbinary('STOR %s' % os.path.basename(file3), fd)
    fd.close()
    print "Uploaded file %s, %s" % (file2, file3)

def child(my_cmd, job_id):
   ##print 'A new child ',  os.getpid( )
   os.system(my_cmd)
   Update_JobInfo(job_id)
   Upload_JobToFTP(job_id)
   os._exit(0)  

# Define a route for the default URL, which loads the form
@app.route('/')
def form():
    return render_template('index.html')

#@app.route('/fastcap', methods=['POST'])
@app.route('/fastcap/<id>', methods=['GET'])
def fastcap(id):
    fastcap_cmd = "/pkg/fastcapsub/fastcapsub"
    job_id=id

    print "job_id=%s!!" % job_id
    sys.stdout.flush()
    
    ## Change to work directory
    if(not os.path.isdir(default_path) ):
      os.mkdir(default_path)

    path = default_path + "/" + job_id
    if(not os.path.isdir(path) ):
      os.mkdir(path)
    os.chdir(path)

    ## DEBUG: check current working directory.
    #retval = os.getcwd()
    #print retval

    ## Get job information from MariaDB
    element_size = Get_JobInfo(job_id)
    if( element_size == 0 ):
      return render_template('fail.html')

    ## Get job file from FTP
    ret = Get_JobFromFTP(job_id)
    if( ret ):
      return render_template('fail.html')

    my_cmd = fastcap_cmd + " %s %s_1 %s_2 %s > 1.out 2> 1.err" % (job_id, job_id, job_id, element_size)
    print "CMD: %s" % my_cmd
    sys.stdout.flush()

    pid = os.fork()
    if pid == 0: ## child()
      child(my_cmd, job_id)
    else: ## parent
      return render_template('form_action.html', jid=job_id)
      #return render_template('form_action.html', job_name=job_name, file1=file1, file2=file2, element_size=element_size)

'''
@app.route("/fastcap/<id>", methods=['GET'])
def Get_job(id):
  my_path = default_path + "/" + id
  if( not os.path.isdir(my_path) ):
    return 1 ## Path not exist
  else:
    for file in os.listdir(my_path):
      if file.endswith(".png"):
        print file
    return "Success!!"
'''

@app.route("/fastcap/<id>/view", methods=['GET'])
def View(id):
  list = []
  my_path = default_path + "/" + id
  if( not os.path.isdir(my_path) ):
    return 1 ## Path not exist
  else:
    for file in os.listdir(my_path):
      if file.endswith(".png"):
        list.append(file)
    
    for i in list:
      print i
    
    ##print os.getcwd()
    return render_template( 'job_view.html', files=list )
    #return "Success!!"

# Run the app :)
if __name__ == '__main__':
  if(not os.path.isdir(default_path) ):
      os.mkdir(default_path)
  app.run( host = "0.0.0.0",
           port = int("88"),
           threaded = True,
           debug=True           
         )

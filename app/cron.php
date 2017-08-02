<?php
 
Class Ssh2_crontab_manager {
 
    private $connection;
    private $path;
    private $handle;
    private $cron_file;
 
    function __construct($host=NULL, $port=NULL, $username=NULL,$password=NULL)
    {
        $path_length        = strpos(__FILE__,"/");
        $this->path         = substr(__FILE__, 0, $path_length) . '/';
        $this->handle       = 'crontab.txt';
        $this->cron_file    = "{$this->path}{$this->handle}";

        try
        {
            if (is_null($host) || is_null($port) || is_null($username) || is_null($password)) throw new Exception("Please specify the host, port, username and password!");
            
            $this->connection = @ssh2_connect($host, $port);
        }
        catch(|)
        {
            return false;
        }
    }
 
    // public function exec() {...}
 
    // public function write_to_file() {...}
 
    // public function remove_file() {...}
 
    // public function append_cronjob() {...}
 
    // public function remove_cronjob() {...}
 
    // public function remove_crontab() {...}
 
    // private function crontab_file_exists() {...}
 
    // private function error_message() {...}
 
}
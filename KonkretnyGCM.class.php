<?php

/*
Author: Marcin Romanowicz
URL: http://konkretny.pl/
License: MIT
Version: 1.0.1
*/

class KonkretnyGCM{
    
    //main settings
    private $token;
    private $token_array;
    private $api_server_key;
    private $messeage;
    
    //db settings
    private $database_type;
    private $pqsqlschema;
    private $host;
    private $db_name;
    private $port;
    private $db_user;
    private $db_password;
    
    //tokens table settings
    private $tablename;
    private $columnname_tokens;
    
    public function __construct() {
        $this->token='';
        $this->token_array=array();
        $this->api_server_key='';
        $this->messeage='';
        
        $this->database_type=0;
        $this->pqsqlschema='';
        $this->host='';
        $this->db_name='';
        $this->port='';
        $this->db_user='';
        $this->db_password='';
        
        $this->tablename='';
        $this->columnname_tokens='';
    }

    public function pdo_insert(){
        
         $query = 'INSERT IGNORE INTO '.$this->tablename.' ('.$this->columnname_tokens.') VALUES (?)';
         $var = array($this->token);
        
        //PDO connect
        if(strlen($this->db_name)>0){
            if($this->port==''){$port_nr='';}else{$port_nr=';port='.$this->port;}
            if($this->database_type==0){$database_type='mysql:';}elseif($this->database_type==1){$database_type='pgsql:';}else{echo 'error database type';exit;}
            try {
                      $PDO = new PDO($database_type.'host='.$this->host.$port_nr.';dbname='.$this->db_name, $this->db_user, $this->db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                      if(strlen($this->pqsqlschema)>0){$PDO->exec('SET search_path TO '.$this->pqsqlschema);}
            }
            catch(PDOException $e) {
                     echo 'Connection error: ' . $e->getMessage();
            }
        }
        //save tokens to DB - Important! The column in the table must be defined as a unique
        try{

                $qr = $PDO->prepare($query);
                $i=1;
                foreach($var as $value){
                        $qr->bindValue($i, $value);
                        $i++;
                }

                $qr->execute();
                if($database_type == 'mysql:'){$last_id = $PDO->lastInsertId();}
                if($database_type == 'pgsql:'){$last_id = $qr->fetch(PDO::FETCH_ASSOC);}
                $qr->closeCursor();
                if($last_id>0){echo json_encode(array('result'=>'ok'));}

            }
            catch(PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();
        }
    }
    
    
    public function pdo_read(){
        
        //query
        $query = 'SELECT '.$this->columnname_tokens.' FROM '.$this->tablename;    
        
        //PDO connect
        if(strlen($this->db_name)>0){
            if($this->port==''){$port_nr='';}else{$port_nr=';port='.$this->port;}
            if($this->database_type==0){$database_type='mysql:';}elseif($this->database_type==1){$database_type='pgsql:';}else{echo 'error database type';exit;}
            try {
                      $PDO = new PDO($database_type.'host='.$this->host.$port_nr.';dbname='.$this->db_name, $this->db_user, $this->db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                      if(strlen($this->pqsqlschema)>0){$PDO->exec('SET search_path TO '.$this->pqsqlschema);}
            }
            catch(PDOException $e) {
                     echo 'Connection error: ' . $e->getMessage();
            }
        }
        //get tokens from DB
        try{
                $qr = $PDO->prepare($query);
                $qr->execute();
                $result = array_filter($qr->fetchAll());
                $qr->closeCursor();
                foreach($result as $value){
                    $this->token_array[] = $value[$this->columnname_tokens];
                }

            }
            catch(PDOException $e) {
                echo 'Connection error: ' . $e->getMessage();
        }
    }
    
    
    public function sendPush($tokens=array(), $data=array()){
        $post_data = array('registration_ids'=> $tokens,'data'=>$data);
        $headers = array('Authorization: key=' . $this->api_server_key,'Content-Type: application/json');
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode($post_data));
        $result = curl_exec($curl);
        // If curl error
        if (curl_errno($curl) )
        {
            echo 'GCM error: ' . curl_error( $curl );
        }
        curl_close( $curl );
        echo $result;
    }
    
    
    public function setToken($token) {
        $this->token = $token;
    }

    public function setDatabase_type($database_type) {
        $this->database_type = $database_type;
    }

    public function setPqsqlschema($pqsqlschema) {
        $this->pqsqlschema = $pqsqlschema;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function setDb_name($db_name) {
        $this->db_name = $db_name;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function setDb_user($db_user) {
        $this->db_user = $db_user;
    }

    public function setDb_password($db_password) {
        $this->db_password = $db_password;
    }

    public function setTablename($tablename) {
        $this->tablename = $tablename;
    }

    public function setColumnname_tokens($columnname_tokens) {
        $this->columnname_tokens = $columnname_tokens;
    }

    public function setApi_server_key($api_server_key) {
        $this->api_server_key = $api_server_key;
    }

    public function setMesseage($messeage) {
        $this->messeage = $messeage;
    }

    public function getToken_array() {
        return $this->token_array;
    }

    public function getMesseage() {
        return $this->messeage;
    }

}
<?php
define('HOST',      'localhost');
define('USERNAME',  'root');
define('DBNAME',    'loja_etec');
define('PASSWORD',  '');
define('PORT',      '3306');


class Conexao {
    private $lastInsertId=0;
    private $error='';

    public function getLastInsertId() {
        return $this->lastInsertId;
    }

    public function getError() {
        return $this->error;
    }

    private function connect(){
        try {        
            $pdo = new PDO('mysql:host='.HOST.';port='.PORT.';dbname='.DBNAME,USERNAME,PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch(PDOException $error){
            $this->error = $error;
        }        
    }

    public function select($cmdSql,$arrayDados){
        try{
            $result = $this->connect()->prepare($cmdSql);
            $result->execute($arrayDados);
            $countRows = $result->rowCount();
            if($countRows){                
                return $result;
            } 
        }catch(PDOException $error){
            $this->error = $error;
        }                   
        return FALSE;
    }

    public function delete($cmdSql,$arrayDados){
        try{
            $result = $this->connect()->prepare($cmdSql);
            $result->execute($arrayDados);
            return $result->rowCount(); 
        }catch(PDOException $error){
            $this->error = $error;
        }                   
        return FALSE;
    }

    public function update($cmdSql,$arrayDados){
        try{
            $result = $this->connect()->prepare($cmdSql);
            $result->execute($arrayDados);            
            return $result->rowCount();            
        }catch(PDOException $error){
            $this->error = $error;
        }                   
        return FALSE;
    }

    public function insert($cmdSql,$arrayDados){
        try{
            $cx = $this->connect();
            $result = $cx->prepare($cmdSql);           
            $result->execute($arrayDados);
            $countRows = $result->rowCount();
            if($countRows){
                $last_id = $cx->prepare('SELECT LAST_INSERT_ID() as id');
                $last_id->execute();
                $this->lastInsertId = $last_id->fetchAll()[0]['id'];
            }
            return $countRows;
        }catch(PDOException $error){
            $this->error = $error;
            return FALSE;
        }       
    }
}
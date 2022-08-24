<?php
require_once 'Conexao.php';
class Administrador{    
    public $matricula;	
    public $email;	
    public $senha;	
    public $nome;

    public function cadastrar(){
        $cx = new Conexao();
        $cmdSql = 'INSERT INTO administrador(matricula, email, senha, nome) VALUES (:matricula, :email, :senha, :nome)';
        $dados = [
            ':matricula' => $this->matricula, 
            ':email' => $this->email, 
            ':senha' => $this->criptografarSenha($this->senha), 
            ':nome' => $this->nome
        ];

        if($cx->insert($cmdSql,$dados)){
            return true;
        }
        else{
            return false;
        }
    }

    public function consultarTodos($filtro=''){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM administrador WHERE administrador.nome LIKE concat('%',:filtro,'%') OR administrador.matricula LIKE concat('%',:filtro,'%') OR administrador.email LIKE concat('%',:filtro,'%');";
        $dados = [
            ':filtro' => $filtro            
        ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            return $result->fetchAll(PDO::FETCH_CLASS, 'Administrador');
        }
        return false;        
    }

    public function consultarPorEmail($email){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM administrador WHERE administrador.email = :email;";
        $dados = [
            ':email' => $email            
        ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            $result->setFetchMode(PDO::FETCH_CLASS, 'Administrador');
            $adm = $result->fetch();
            $this->matricula = $adm->matricula;
            $this->email = $adm->email;	
            $this->senha = $adm->senha;	
            $this->nome = $adm->nome;
            return true;
        }
        return false;        
    }

    public function consultarPorMatricula($matricula){
        $cx = new Conexao();
        $cmdSql = "SELECT * FROM administrador WHERE administrador.matricula = :m;";
        $dados = [
            ':m' => $matricula            
        ];
        $result = $cx->select($cmdSql,$dados);
        if($result){
            $result->setFetchMode(PDO::FETCH_CLASS, 'Administrador');
            $adm = $result->fetch();
            $this->matricula = $adm->matricula;
            $this->email = $adm->email;	
            $this->senha = $adm->senha;	
            $this->nome = $adm->nome;
            return true;
        }
        return false;        
    }

    private function criptografarSenha($senha): string{
        return password_hash($senha,PASSWORD_BCRYPT,['cost' => 12]);
    }

    private function decriptografarSenha($senha, $criptografia):bool{
        return password_verify($senha, $criptografia);
    }

    public function login($usuario,$senha):bool{
        if($this->consultarPorEmail($usuario) or $this->consultarPorMatricula($usuario)){
            return $this->decriptografarSenha($senha,$this->senha);
        }
        return false;
    }
}
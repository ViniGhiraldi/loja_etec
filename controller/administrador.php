<?php
    header('Content-type: application/json');
    $dadosRecebidos = file_get_contents('php://input');

    $dadosRecebidos = json_decode($dadosRecebidos, true);

    require_once '../model/Administrador.php';
    if($dadosRecebidos['acao'] == 'cadastrar'){
        $adm = new Administrador();
        $adm->matricula = $dadosRecebidos['matricula'];
        $adm->email = $dadosRecebidos['email'];
        $adm->senha = $dadosRecebidos['senha'];
        $adm->nome = $dadosRecebidos['nome'];        

        $result = [
            'result' => $adm->cadastrar(),
            'dados' => $adm       
        ];
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consutarTodos'){
        $adm = new Administrador();
        $filtro = $dadosRecebidos['filtro'];
        $dados = $adm->consultarTodos($filtro);
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($dados){
            $result['result'] = true;
            $result['dados'] = $dados;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consutarPorEmail'){
        $adm = new Administrador();
        $email = $dadosRecebidos['email'];        
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->consultarPorEmail($email)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consutarPorMatricula'){
        $adm = new Administrador();
        $matric = $dadosRecebidos['matricula'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->consultarPorMatricula($matric)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'logar'){
        $adm = new Administrador();
        $usuario = $dadosRecebidos['usuario'];
        $senha = $dadosRecebidos['senha'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($adm->login($usuario,$senha)){
            $result['result'] = true;
            $result['dados'] = $adm;
        }        
        echo json_encode($result);
    }

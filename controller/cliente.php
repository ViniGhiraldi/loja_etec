<?php
    header('Content-type: application/json');
    $dadosRecebidos = file_get_contents('php://input');

    $dadosRecebidos = json_decode($dadosRecebidos, true);

    require_once '../model/Cliente.php';
    if($dadosRecebidos['acao'] == 'cadastrar'){
        $cliente = new Cliente();
        $cliente->email = $dadosRecebidos['email'];
        $cliente->senha = $dadosRecebidos['senha'];
        $cliente->nome = $dadosRecebidos['nome']; 
        $cliente->endereco = $dadosRecebidos['endereco'];
        $cliente->telefone = $dadosRecebidos['telefone'];

        $result = [
            'result' => $cliente->cadastrar(),
            'dados' => $cliente  
        ];
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarTodos'){
        $cliente = new Cliente();
        $filtro = $dadosRecebidos['filtro'];
        $dados = $cliente->consultarTodos($filtro);
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($dados){
            $result['result'] = true;
            $result['dados'] = $dados;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarPorEmail'){
        $cliente = new Cliente();
        $email = $dadosRecebidos['email'];        
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($cliente->consultarPorEmail($email)){
            $result['result'] = true;
            $result['dados'] = $cliente;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'consultarPorTelefone'){
        $cliente = new Cliente();
        $telefone = $dadosRecebidos['telefone'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($cliente->consultarPorTelefone($telefone)){
            $result['result'] = true;
            $result['dados'] = $cliente;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'deletar'){
        $cliente = new Cliente();
        $id = $dadosRecebidos['id'];
        $result['result'] = false;                  
        $result['dados'] = "";
        if($cliente->deletar($id)){
            $result['result'] = true;
            $result['dados'] = $cliente;
        }        
        echo json_encode($result);
    }
    elseif($dadosRecebidos['acao'] == 'logar'){
        $cliente = new Cliente();
        $usuario = $dadosRecebidos['usuario'];
        $senha = $dadosRecebidos['senha'];
        $result['result'] = false;                  
        $result['dados'] = "";                  
        if($cliente->login($usuario,$senha)){
            $result['result'] = true;
            $result['dados'] = $cliente;
        }        
        echo json_encode($result);
    }

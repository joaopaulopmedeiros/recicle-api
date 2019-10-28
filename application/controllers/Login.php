<?php
require APPPATH . '/libraries/CreatorJwt.php';

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }
    
    function logon()
    {
        $this->form_validation->set_rules("login", "Email", "required");
        $this->form_validation->set_rules("senha", "Senha", "required");
        $response = array();

        if($this->form_validation->run())
        {
            $login = trim($this->input->post('login'));
            $senha = trim($this->input->post('senha'));

            if ($this->Cidadao_model->autenticar($login, $senha))
            {
                $type = "cidadao";
                $this->gerarToken($login,$senha,$type);
            }
            else if($this->CriadorDesafio_model->autenticar($login,$senha))
            {
                $type = "criador";
                $this->gerarToken($login,$senha,$type);
            }
            else
            {
                $response = array(
                    'error'  => true,
                    'erro' => 'O email ou senha digitados estão incorretos.'
                );
                echo json_encode($response,true);
            }
        }
        else
        {
            $response = array(
                'error' => true,
                'erro' => 'Preencha os dados corretamente.'
            );
            echo json_encode($response,true);
        }   
    }
    
    function gerarToken($l,$p,$t)
    {
        if($t == "cidadao"){
            $doc = $this->Cidadao_model->getDoc($l);
            $cep = $this->Cidadao_model->getCEP($l);
            $nome = $this->Cidadao_model->getNome($l);
        }
        if($t == "criador"){
            $doc = $this->CriadorDesafio_model->getDoc($l);
            $cep = $this->CriadorDesafio_model->getCEP($l);
            $nome = $this->CriadorDesafio_model->getNome($l);
        }

        $tokenData['doc'] = $doc;
        $tokenData['cep'] = $cep;
        $tokenData['nome'] = $nome;
        $tokenData['login'] = $l;
        $tokenData['senha'] = $p;
        $tokenData['tipo'] = $t;
        $tokenData['timeStamp'] = Date('d/m/Y');
        
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        $response = array(
            'success' => true,
            'Token' => $jwtToken
        );
        
        echo json_encode($response,true);
    }

}
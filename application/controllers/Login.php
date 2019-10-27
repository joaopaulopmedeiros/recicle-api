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
        $array = array();

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
                    'erro' => 'email ou senha incorretos'
                );
                echo json_encode($response,true);
            }
        }
        else
        {
            $array = array(
                'error'       => true,
                'login_error' => form_error('login'),
                'senha_error' => form_error('senha')
            );
        }

    }

    function logoff()
    {

    }

    
    function gerarToken($l,$p,$t)
    {
        $doc = ""; 

        if($t == "cidadao"){
             $doc = $this->Cidadao_model->getDoc($l);
        }
        if($t == "criador"){
           $doc = $this->CriadorDesafio_model->getDoc($l);
        }

        $tokenData['doc'] = $doc;
        $tokenData['login'] = $l;
        $tokenData['senha'] = $p;
        $tokenData['timeStamp'] = Date('d/m/Y');
        
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        $response = array('Token'=>$jwtToken);
        
        echo json_encode($response,true);
    }

}
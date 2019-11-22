<?php
require APPPATH . '/libraries/CreatorJwt.php';

class Cidadao extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cidadao_model');
        $this->load->library('form_validation');
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }

    function index() 
    {
        $data = $this->cidadao_model->fetch_all();
        echo json_encode($data->result_array());
    }
 
    function inserir() 
    {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("login", "Login", "required");
        $this->form_validation->set_rules("docCadastrado", "CPF", "required|exact_length[11]");
        $this->form_validation->set_rules("cep", "CEP", "required|exact_length[8]");
        $this->form_validation->set_rules("senha", "Senha", "required|min_length[6]|max_length[20]");
        $this->form_validation->set_rules("confirmarSenha", "Confirmar senha", "required|min_length[6]|max_length[20]");
        $response = array();

        if($this->form_validation->run()) 
        {
            $senha = $this->input->post('senha');
            $confirmarSenha = $this->input->post('confirmarSenha');
            $doc = $this->input->post('docCadastrado');
            $login = $this->input->post('login');

            if ($senha == $confirmarSenha)
            {
                if ($this->cidadao_model->verificarDocCadastrado($doc) == null)
                {
                    if ($this->cidadao_model->verificarEmail($login) == null)
                    {
                        $data = array(
                            'nome' => trim($this->input->post('nome')),
                            'login' => trim($this->input->post('login')),
                            'docCadastrado' => trim($this->input->post('docCadastrado')),
                            'cep' => trim($this->input->post('cep')),
                            'senha' => trim($this->input->post('senha'))
                        );
                        $this->cidadao_model->insert_api($data);
                        $type = "cidadao";
                        $this->gerarToken($login,$senha,$type);
                    }
                    else
                    {
                        $response = array(
                            'error' => true,
                            'msg_erro' => 'O email inserido no formulário já está cadastrado no sistema.'
                        ); 
                        echo json_encode($response, true);
                    }
                }
                else
                {
                    $response = array(
                        'error' => true,
                        'msg_erro' => 'O documento de identificação inserido no formulário já está cadastrado no sistema.'
                    );        
                    echo json_encode($response, true);
                }
            }
            else
            {
                $response = array(
                    'error' => true,
                    'msg_erro' => 'Os campos da senha não estão iguais.'
                );    
                echo json_encode($response, true);
            }
        }
        else 
        {
            $response = array(
                'error' => true,
                'msg_erro' => 'Preencha todos os dados corretamente. Verifique se todos os campos estão devidamente preenchidos.'
            );
            echo json_encode($response,true);
        }
    }

    function gerarToken($l,$p,$t)
    {
        $doc = $this->cidadao_model->getDoc($l);
        $cep = $this->cidadao_model->getCEP($l);
        $nome = $this->cidadao_model->getNome($l);    

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

    function fetch_single()
    {
        if($this->input->post('docCadastrado'))
        {
            $data = $this->Cidadao_model->fetch_single_user($this->input->post('docCadastrado'));
            foreach($data as $row) {
                $output['nome'] = $row["nome"];
                $output['login'] = $row["login"];
                $output['docCadastrado'] = $row["docCadastrado"];
                $output['cep'] = $row["cep"];
                $output['senha'] = $row["senha"];
            }
            echo json_encode($output);
        }
    }

    function update()
    {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("login", "Login", "required");
        $this->form_validation->set_rules("docCadastrado", "CPF", "required");
        $this->form_validation->set_rules("cep", "CEP", "required|exact_length[8]");
        $this->form_validation->set_rules("senha", "Senha", "required|min_length[6]|max_length[20]");
        $response = array();

        if($this->form_validation->run())
        {
            $login = $this->input->post('login');
            $email_user = $this->input->post('email_user');
            $docCadastrado = $this->input->post('docCadastrado');

            if ($this->Cidadao_model->verificarEmail($login) == null || $login == $email_user)
            {
                $data = array(
                    'nome' => trim($this->input->post('nome')),
                    'login'  => trim($this->input->post('login')),
                    'cep'  => trim($this->input->post('cep')),
                    'senha'  => trim($this->input->post('senha'))
                );
                $this->Cidadao_model->update_api($docCadastrado, $data);
                $response = array(
                    'success'  => true
                );
            }
            else
            {
                $response = array(
                    'error' => true,
                    'msg_erro' => "O email inserido no formulário já está cadastrado no sistema."
                );
            }
        }
        else
        {
            $response = array(
                'error' => true,
                'msg_erro' => 'Verifique os campos e tente novamente.'
            );
        }
        echo json_encode($response, true);
    }

    function delete()
    {
        if($this->input->post('docCadastrado'))
        {
            if($this->cidadao_model->delete_single_user($this->input->post('docCadastrado'))) {
                $response = array(
                    'success' => true
                );
            }
            else
            {
                $response = array(
                    'error' => true
                );
            }
            echo json_encode($response);
        }
    }
}
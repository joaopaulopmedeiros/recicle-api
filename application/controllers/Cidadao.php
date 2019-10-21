<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidadao extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cidadao_model');
        $this->load->library('form_validation');
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
        $array = array();

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
                        $array = array(
                            'success' => true
                        );
                    }
                    else
                    {
                        $array = array(
                            'error' => true,
                            'msg_erro' => 'O email inserido no formulário já está cadastrado no sistema.'
                        );
                    }
                }
                else
                {
                    $array = array(
                        'error' => true,
                        'msg_erro' => 'O documento de identificação inserido no formulário já está cadastrado no sistema.'
                    );
                }
            }
            else
            {
                $array = array(
                    'error' => true,
                    'msg_erro' => 'Os campos da senha não estão iguais.'
                );
            }
        }
        else 
        {
            $array = array(
                'error' => true,
                'msg_erro' => 'Preencha todos os dados corretamente.'
            );
        }
        echo json_encode($array, true);
    }

    function fetch_single()
    {
        if($this->input->post('docCadastrado'))
        {
            $data = $this->cidadao_model->fetch_single_user($this->input->post('id'));
            foreach($data as $row) {
                $output['nome'] = $row["nome"];
                $output['email'] = $row["email"];
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
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("docCadastrado", "CPF", "required");
        $this->form_validation->set_rules("cep", "CEP", "required");
        $this->form_validation->set_rules("senha", "Senha", "required");
        $array = array();

        if($this->form_validation->run())
        {
            $data = array(
                'nome' => trim($this->input->post('nome')),
                'email'  => trim($this->input->post('email')),
                'docCadastrado' => trim($this->input->post('docCadastrado')),
                'cep'  => trim($this->input->post('cep')),
                'senha'  => trim($this->input->post('senha'))
            );
            $this->cidadao_model->update_api($this->input->post('docCadastrado'), $data);
            $array = array(
                'success'  => true
            );
        }
        else
        {
            $array = array(
                'error' => true,
                'nome_error' => form_error('nome'),
                'email_error'  => form_error('email'),
                'docCadastrado_error' => form_error('docCadastrado'),
                'cep_error'  => form_error('cep'),
                'senha_error' => form_error('senha')
            );
        }
        echo json_encode($array, true);
    }

    function delete()
    {
        if($this->input->post('docCadastrado'))
        {
            if($this->cidadao_model->delete_single_user($this->input->post('docCadastrado'))) {
                $array = array(
                    'success' => true
                );
            }
            else
            {
                $array = array(
                    'error' => true
                );
            }
            echo json_encode($array);
        }
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CriadorDesafio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CriadorDesafio_model');
        $this->load->library('form_validation');
    }

    function index() {
        $data = $this->CriadorDesafio_model->fetch_all();
        echo json_encode($data->result_array());
    }
 
    function inserir() {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("login", "Login", "required");
        $this->form_validation->set_rules("docCadastrado", "Documento de identificação", "required|min_length[11]|max_length[14]");
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
                if ($this->CriadorDesafio_model->verificarDocCadastrado($doc) == null)
                {
                    if ($this->CriadorDesafio_model->verificarEmail($login) == null)
                    {
                        $data = array(
                            'nome' => trim($this->input->post('nome')),
                            'login' => trim($this->input->post('login')),
                            'docCadastrado' => trim($this->input->post('docCadastrado')),
                            'cep' => trim($this->input->post('cep')),
                            'senha' => trim($this->input->post('senha'))
                        );
                        $this->CriadorDesafio_model->insert_api($data);
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
                        'msg_erro' => 'O CPF ou CNPJ inserido no formulário já está cadastrado no sistema.'
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
                'msg_erro' => 'Preencha todos os dados corretamente. Verifique se todos os campos estão devidamente preenchidos.'
            );
        }
        echo json_encode($array, true);
    }

    function fetch_single()
    {
        if($this->input->post('docCadastrado'))
        {
            $data = $this->CriadorDesafio_model->fetch_single_user($this->input->post('docCadastrado'));
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
        $this->form_validation->set_rules("docCadastrado", "Documento de identificação", "required");
        $this->form_validation->set_rules("cep", "CEP", "required|exact_length[8]");
        $this->form_validation->set_rules("senha", "Senha", "required|min_length[6]|max_length[20]");
        $array = array();

        if($this->form_validation->run())
        {
            $login = $this->input->post('login');
            $email_user = $this->input->post('email_user');
            $docCadastrado = $this->input->post('docCadastrado');

            if ($this->CriadorDesafio_model->verificarEmail($login) == null || $login == $email_user)
            {
                $data = array(
                    'nome' => trim($this->input->post('nome')),
                    'login'  => trim($this->input->post('login')),
                    'cep'  => trim($this->input->post('cep')),
                    'senha'  => trim($this->input->post('senha'))
                );
                $this->CriadorDesafio_model->update_api($docCadastrado, $data);
                $array = array(
                    'success'  => true
                );
            }
            else
            {
                $array = array(
                    'error' => true,
                    'msg_erro' => "O email inserido no formulário já está cadastrado no sistema."
                );
            }
        }
        else
        {
            $array = array(
                'error' => true,
                'msg_erro' => 'Verifique os campos e tente novamente.'
            );
        }
        echo json_encode($array, true);
    }

    function delete() {
        if($this->input->post('docCadastrado')) {
            if($this->CriadorDesafio_model->delete_single_user($this->input->post('docCadastrado'))) {
                $array = array(
                    'success' => true
                );
            } else {
                $array = array(
                    'error' => true
                );
            }
            echo json_encode($array);
        }
    }
}
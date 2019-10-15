<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidadao extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cidadao_model');
        $this->load->library('form_validation');
    }

    function index() {
        $data = $this->cidadao_model->fetch_all();
        echo json_encode($data->result_array());
    }
 
    function inserir() {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("login", "Login", "required");
        $this->form_validation->set_rules("cpf", "CPF", "required");
        $this->form_validation->set_rules("cep", "CEP", "required");
        $this->form_validation->set_rules("senha", "Senha", "required");
        $array = array();

        if($this->form_validation->run()) {
            $data = array(
                'nome'   => trim($this->input->post('nome')),
                'login'  => trim($this->input->post('login')),
                'cpf'    => trim($this->input->post('cpf')),
                'cep'    => trim($this->input->post('cep')),
                'senha'  => trim($this->input->post('senha'))
            );
            $this->cidadao_model->insert_api($data);
            $array = array(
                'success'  => true
            );
        } else {
            $array = array(
                'error'       => true,
                'nome_error'  => form_error('nome'),
                'login_error' => form_error('login'),
                'cpf_error'   => form_error('cpf'),
                'cep_error'   => form_error('cep'),
                'senha_error' => form_error('senha')
            );
        }
        echo json_encode($array, true);
    }

    function fetch_single() {
        if($this->input->post('cpf')) {
            $data = $this->cidadao_model->fetch_single_user($this->input->post('id'));
            foreach($data as $row) {
                $output['nome'] = $row["nome"];
                $output['email'] = $row["email"];
                $output['cpf'] = $row["cpf"];
                $output['cep'] = $row["cep"];
                $output['senha'] = $row["senha"];
            }
            echo json_encode($output);
        }
    }

    function update() {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("cpf", "CPF", "required");
        $this->form_validation->set_rules("cep", "CEP", "required");
        $this->form_validation->set_rules("senha", "Senha", "required");
        $array = array();

        if($this->form_validation->run()) {
            $data = array(
                'nome' => trim($this->input->post('nome')),
                'email'  => trim($this->input->post('email')),
                'cpf' => trim($this->input->post('cpf')),
                'cep'  => trim($this->input->post('cep')),
                'senha'  => trim($this->input->post('senha'))
            );
            $this->cidadao_model->update_api($this->input->post('cpf'), $data);
            $array = array(
                'success'  => true
            );
        } else {
            $array = array(
                'error'            => true,
                'nome_error' => form_error('nome'),
                'email_error'  => form_error('email'),
                'cpf_error' => form_error('cpf'),
                'cep_error'  => form_error('cep'),
                'senha_error' => form_error('senha')
            );
        }
        echo json_encode($array, true);
    }

    function delete() {
        if($this->input->post('cpf')) {
            if($this->cidadao_model->delete_single_user($this->input->post('cpf'))) {
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
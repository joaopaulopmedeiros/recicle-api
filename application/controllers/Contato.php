<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contato extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('contato_model');
        $this->load->library('form_validation');
    }

    function index() 
    {
        $data = $this->contato_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function insert()
    {
        $this->form_validation->set_rules("nome", "Nome", "required");
        $this->form_validation->set_rules("sobrenome", "Sobrenome", "required");
        $this->form_validation->set_rules("email", "Email", "required");
        $this->form_validation->set_rules("assunto", "Assunto", "required");
        $this->form_validation->set_rules("mensagem", "Mensagem", "required");
        $array = array();

        if($this->form_validation->run()) 
        {
            $data = array(
                'nome' => trim($this->input->post('nome')),
                'sobrenome' => trim($this->input->post('sobrenome')),
                'email' => trim($this->input->post('email')),
                'assunto' => trim($this->input->post('assunto')),
                'mensagem' => trim($this->input->post('mensagem'))
            );
            $this->contato_model->insert_api($data);
            $array = array(
                'success' => true
            );
        }
        else 
        {
            $array = array(
                'error' => true,
                'msg_erro' => 'Preencha todos os campos.'
            );
        }
        echo json_encode($array, true);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desafios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('desafio_model');
        $this->load->library('form_validation');
    }

    function exibirTodosOsDesafios() 
    {
        $data = $this->desafio_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function exibirMeusDesafios()
    {
        $user_id = $this->input->post('user_id');
        $data = $this->desafio_model->exibir_meus_desafios($user_id);
        echo json_encode($data->result_array());
    }

    function inserir()
    {
        
    }
}
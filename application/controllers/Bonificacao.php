<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bonificacao extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bonificacao_model');
        $this->load->library('form_validation');
    }

    function index() 
    {
        $data = $this->bonificacao_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function insert()
    {
        $this->form_validation->set_rules("nome", " Nome", "required");
        $array = array();

        if($this->form_validation->run()) 
        {
            $nome = $this->input->post('nome');

            if ($this->bonificacao_model->verificarBonificacao($nome) == null)
            {
                $data = array(
                    'nome' => trim($this->input->post('nome'))
                );
                $this->bonificacao_model->insert_api($data);
                $array = array(
                    'success' => true
                );
            }
            else
            {
                $array = array(
                    'error' => true,
                    'msg_erro' => 'A bonificação inserida já está cadastrada no sistema.'
                );
            }
        }
        else 
        {
            $array = array(
                'error' => true,
                'msg_erro' => 'Este campo deve ser preenchido.'
            );
        }
        echo json_encode($array, true);
    }
}
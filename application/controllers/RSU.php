<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RSU extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('rsu_model');
        $this->load->library('form_validation');
    }

    function index() 
    {
        $data = $this->rsu_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function insert()
    {
        $this->form_validation->set_rules("tipo", " Tipo", "required");
        $array = array();

        if($this->form_validation->run()) 
        {
            $tipo = $this->input->post('tipo');

            if ($this->rsu_model->verificarTipoRSU($tipo) == null)
            {
                $data = array(
                    'tipo' => trim($this->input->post('tipo'))
                );
                $this->rsu_model->insert_api($data);
                $array = array(
                    'success' => true
                );
            }
            else
            {
                $array = array(
                    'error' => true,
                    'msg_erro' => 'O tipo de lixo informado já está cadastrado no sistema.'
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DesafiosAceitos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DesafioAceito_model');
    }

    function index() 
    {
        $data = $this->DesafioAceito_model->fetch_all();
        echo json_encode($data->result_array());
    }

    function inserir(){
        $this->form_validation->set_rules("idCriadorDesafio","idCriadorDesafio","required");
        $this->form_validation->set_rules("idCidadao","idCidadao","required");
        $this->form_validation->set_rules("idTipoRSU","idTipoRSU","required");
        $this->form_validation->set_rules("idTipoBonificacao","idTipoBonificacao","required");
        $this->form_validation->set_rules("idDesafio","idDesafio","required");

        $data = array(
            "idCriadorDesafio" => trim($this->input->post("idCriadorDesafio"));
            "idCidadao" => trim($this->input->post("idCidadao"));
            "idTipoRSU" => trim($this->input->post("idTipoRSU"));
            "idTipoBonificacao" => trim($this->input->post("idTipoBonificacao"));
            "idDesafio" => trim($this->input->post("idDesafio"));
            "cumprido" => 0;
        );

        $this->DesafioAceito_model->insert_api($data);
    }
}

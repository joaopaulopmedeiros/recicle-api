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
        $id_user = $this->input->post("id_user");
        $id_desafio = $this->input->post("id_desafio");
        $data = $this->DesafioAceito_model->fetch_all($id_user, $id_desafio);
        echo json_encode($data->result_array());
    }

    function ver_meus_desafios() 
    {
        $id_user = $this->input->post("id_user");
        $data = $this->DesafioAceito_model->ver_desafios_aceitos($id_user);
        echo json_encode($data->result_array());
    }

    function ver_meus_desafios_concluidos() 
    {
        $id_user = $this->input->post("id_user");
        $data = $this->DesafioAceito_model->ver_desafios_concluidos($id_user);
        echo json_encode($data->result_array());
    }

    function inserir(){
        $this->form_validation->set_rules("idCriadorDesafio","idCriadorDesafio","required");
        $this->form_validation->set_rules("idCidadao","idCidadao","required");
        $this->form_validation->set_rules("idTipoRSU","idTipoRSU","required");
        $this->form_validation->set_rules("idTipoBonificacao","idTipoBonificacao","required");
        $this->form_validation->set_rules("idDesafio","idDesafio","required");

        $data = array(
            "idCriadorDesafio" => trim($this->input->post("idCriadorDesafio")),
            "idCidadao" => trim($this->input->post("idCidadao")),
            "idTipoRSU" => trim($this->input->post("idTipoRSU")),
            "idTipoBonificacao" => trim($this->input->post("idTipoBonificacao")),
            "idDesafio" => trim($this->input->post("idDesafio")),
            "cumprido" => 0
        );

        if ($this->DesafioAceito_model->insert_api($data)) {
            $array = array(
                'success' => true
            );
        }
        else{
            $array = array(
                'error' => true
            );
        }
        
        echo json_encode($array, true);
    }

    function deletar()
    {
        $idCidadao = trim($this->input->post("idCidadao"));
        $idDesafio = trim($this->input->post("idDesafio"));

        if($this->DesafioAceito_model->delete_single($idDesafio, $idCidadao)) {
            $array = array('success' => true); 
        }
        else {
            $array = array('error' => true); 
        }

        echo json_encode($array, true);
    }
    
    function ver_concorrentes_desafio()
    {
        $id_desafio = $this->input->post("idDesafio");
        $data = $this->DesafioAceito_model->ver_concorrentes_desafio($id_desafio);
        echo json_encode($data->result_array());
    }

    function cumprirDesafio()
    {
        $id = $this->input->post("idDesafioAceito");
        $cumprido = $this->input->post("status");
        $data = array("cumprido" => $cumprido);
        
        if($this->DesafioAceito_model->update_api($id,$data)){
            $array = array('success' => true); 
        }
        else {
            $array = array('error' => true); 
        }

        echo json_encode($array, true);
    }

    function resgatarPremio()
    {
        $id = $this->input->post("idDesafioAceito");
        $premio_resgatado = $this->input->post("status");
        $data = array("premio_resgatado" => $premio_resgatado);
        
        if($this->DesafioAceito_model->update_api($id,$data)){
            $array = array('success' => true); 
        }
        else {
            $array = array('error' => true); 
        }

        echo json_encode($array, true);
    }
}

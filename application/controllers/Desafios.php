<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desafios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('desafio_model');
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

    function verDesafio()
    {
        $id_desafio = $this->input->post('id_desafio');

        if ($this->input->post('user') == 'user_criadordesafio') {
            $data = $this->desafio_model->fetch_single_criador($id_desafio);
        }
        else {
            $data = $this->desafio_model->fetch_single($id_desafio);
        }
        
        $dataArray = $data->result_array();

        if ($dataArray[0]['dataLimite'] == '0000-00-00' || $dataArray[0]['dataLimite'] == ' ' || $dataArray[0]['dataLimite'] == null) {
            $dataArray[0]['dataLimite'] = 'Sem data limite';
        }
        else {
            $date = $dataArray[0]['dataLimite'];
            $dataArray[0]['dataLimite'] = nice_date($date, 'd/m/Y');
        }

        if ($dataArray[0]['qtdRSU'] == '0') {
            $dataArray[0]['qtdRSU'] = 'Sem quantidade definida';
        }
        
        echo json_encode($dataArray);
    }

    function inserir()
    {
        $this->form_validation->set_rules("titulo", "titulo", "required");
        $this->form_validation->set_rules("descricao", "descricao", "required");
        $this->form_validation->set_rules("idCriadorDesafio", "idCriadorDesafio", "required");
        $this->form_validation->set_rules("idTipoRSU", "idTipoRSU", "required");
        
        $array = array();

        if ($this->form_validation->run())
        {
            $data = array(
                'titulo' => trim($this->input->post('titulo')),
                'descricao' => trim($this->input->post('descricao')),
                'idCriadorDesafio' => trim($this->input->post('idCriadorDesafio')),
                'idTipoBonificacao' => trim($this->input->post('idTipoBonificacao')),
                'idTipoRSU' => trim($this->input->post('idTipoRSU')),
                'qtdRSU' => trim($this->input->post('qtdRSU')),
                'descricaoBonificacao' => trim($this->input->post('descricaoBonificacao')),
                'dataLimite' => trim($this->input->post('dataLimite'))
            );
            $this->desafio_model->insert_api($data);
            $array = array('success' => true);
        }
        else
        {
            $array = array(
                'error' => true,
                'msg_erro' => 'Preencha todos os dados corretamente'
            );
        }

        echo json_encode($array, true);
    }

    function filtrar_desafios()
    {
       $idCriadorDesafio = $this->input->post('idCriadorDesafio');
       $idTipoBonificacao = $this->input->post('idTipoBonificacao');
       $idTipoRSU = $this->input->post('idTipoRSU');

       $data = $this->desafio_model->filtrar_desafios($idCriadorDesafio,$idTipoBonificacao,$idTipoRSU);
       echo json_encode($data->result_array());
    }

}
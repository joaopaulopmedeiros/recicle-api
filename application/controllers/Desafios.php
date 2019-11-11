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

    function inserir()
    {
        $this->form_validation->set_rules("titulo", "titulo", "required");
        $this->form_validation->set_rules("descricao", "descricao", "required");
        $this->form_validation->set_rules("idCriadorDesafio", "idCriadorDesafio", "required");
        $this->form_validation->set_rules("idTipoRSU", "idTipoRSU", "required");
        
        $array = array();

        if ($this->form_validation->run())
        {
            if ($this->upload->do_upload('img'))
            {
                $data_img = $this->upload->data();
                $image = $data_img['file_name']; 
                
                $data = array(
                    'titulo' => trim($this->input->post('titulo')),
                    'descricao' => trim($this->input->post('descricao')),
                    'idCriadorDesafio' => trim($this->input->post('idCriadorDesafio')),
                    'idTipoBonificacao' => trim($this->input->post('idTipoBonificacao')),
                    'idTipoRSU' => trim($this->input->post('idTipoRSU')),
                    'qtdRSU' => trim($this->input->post('qtdRSU')),
                    'descricaoBonificacao' => trim($this->input->post('descricaoBonificacao')),
                    'dataLimite' => trim($this->input->post('dataLimite')),
                    'img' => $data_img
                );
                $this->desafio_model->insert_api($data);
                $array = array('success' => true);
            }
            else
            {
                $array = array(
                    'error' => true,
                    'msg_erro' => $this->upload->display_errors()
                );
            }
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
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cidadao_model');
        $this->load->model('CriadorDesafio_model');
        //$this->load->model('PontoColeta_model');
        $this->load->library('form_validation');
    }
 
    function logon()
    {
        $this->form_validation->set_rules("login", "Email", "required");
        $this->form_validation->set_rules("senha", "Senha", "required");
        $array = array();

        if($this->form_validation->run())
        {
            $login = trim($this->input->post('login'));
            $senha = trim($this->input->post('senha'));

            if ($this->Cidadao_model->autenticar($login, $senha))
            {
                $array = array(
                    'success'  => true,
                    'conta' => 'cidadao'
                );
            }
            /*else if($this->CriadorDesafio_model->autenticar($data))
            {
                $array = array(
                    'success'  => true,
                    'conta' => 'criador de desafios'
                );
            }*/
            /*else if($this->PontosColeta_model->autenticar($data))
            {
                $array = array(
                    'success'  => true,
                    'conta' => 'ponto de coleta (ecoponto)'
                );
            }*/
            else
            {
                $array = array(
                    'error'  => true,
                    'erro' => 'email ou senha incorretos'
                );
            }
        }
        else
        {
            $array = array(
                'error'       => true,
                'login_error' => form_error('login'),
                'senha_error' => form_error('senha')
            );
        }
        echo json_encode($array, true);
    }

    function logoff()
    {

    }
}
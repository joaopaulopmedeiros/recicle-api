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
}

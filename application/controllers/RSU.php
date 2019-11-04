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
}
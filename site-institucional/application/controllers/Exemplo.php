<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Exemplo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Examplo_model');
        $this->load->library('form_validation');
    }

    function Index(){
        $this->load->view('home');
    }
    function Login(){
        $this->load->view('login');
    }
}
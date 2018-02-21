<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Institucional extends CI_Controller
{
    public function index(){
        $data['title'] = "LCI | HOME";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";

        $this->load->view('home',$data);
    }
    public function Empresa(){
        $data['title'] = "LCI | A Empresa";
        $data['description'] = "Informações sobre a empresa";

        $this->load->view('commons/header', $data);
        $this->load->view('empresa');
        $this->load->view('commons/footer');
    }
    public function Servicos(){
        $data['title'] = "LCI | Serviços";
        $data['description'] = "Informações sobre os serviços prestados";

        $this->load->view('commons/header', $data);
        $this->load->view('servicos');
        $this->load->view('commons/footer');
        
    }
}
?>
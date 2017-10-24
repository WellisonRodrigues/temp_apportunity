<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 30/09/2017
 * Time: 13:44
 */
class Painel_admin extends CI_Controller
{
//    public function __construct()
//    {
//        parent::__construct();
//        if(!$this->session->userdata("logado")){
//            redirect('sair');
//        }
//    }

    public function index()
    {
       $response = $this->session->userdata("logado");
        $data['view'] = 'home';
        $data['response'] = $response;
        $this->load->view('template_admin/core', $data);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 00:00
 */
class Pesquisar extends CI_Controller{

    public function index(){

        $data['view'] = 'forms/pesquisar_filtro';
        $this->load->view('template_admin/core', $data);

    }


}
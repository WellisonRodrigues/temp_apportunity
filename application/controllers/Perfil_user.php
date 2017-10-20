<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:33
 */
class Perfil_user extends CI_Controller
{


    public function editar()
    {
        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);


    }


}
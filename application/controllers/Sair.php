<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 30/09/2017
 * Time: 14:32
 */
class Sair extends CI_Controller
{
    public function index()
    {
        $this->session->sess_destroy();
        
        $data['alert'] =
            [
                'type' => 'erro',
                'message' => 'Você saiu do sistema'
            ];
        $this->session->set_flashdata('alert', $data['alert']);
        redirect('Login');
    }

}
?>
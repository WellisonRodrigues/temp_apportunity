<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 28/10/2017
 * Time: 16:06
 */
class Anuncios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }
    }

    public function index()
    {

        $this->anuncios_list();
    }

    public function anuncios_list()
    {

        $data['view'] = 'forms/anuncios_list';
        $this->load->view('template_admin/core', $data);

    }

    public function anuncios_cadastro()
    {

        $data['view'] = 'forms/anuncios_cadastro';
        $this->load->view('template_admin/core', $data);

    }
    public function anuncios_edit()
    {

        $data['view'] = 'forms/anuncios_edit';
        $this->load->view('template_admin/core', $data);

    }

    public function arrayCastRecursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->arrayCastRecursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = $this->arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return $this->arrayCastRecursive((array)$array);
        }
        return $array;
    }

}
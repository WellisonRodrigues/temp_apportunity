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
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }
    }

    public function index()

    {

        //$retorno = $this->sign_in('ingressoscaldas@gmail.com','icnTDC');

        $retorno = $this->get_jobs();


        /*
         * Erro no curl
         */
        if (isset($retorno["err"]) && !empty($retorno["err"])) {
            $data['alert'] =
                [
                    'type' => 'erro',
                    'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
                ];
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('Login');
        }

        /*
         * erro de login e senha
         */
//        if (isset(json_decode($retorno["response"])->errors[0])) {
//            $data['alert'] =
//                [
//                    'type' => 'erro',
//                    'message' => 'Erro ao cadastrar usuario'
//                ];
//            $this->session->set_flashdata('alert', $data['alert']);
//            redirect('Login');
//
//        } else {
//
//            $data['alert'] =
//                [
//                    'type' => 'sucesso',
//                    'message' => 'Usuário cadastrado com sucesso.'
//                ];
//
//            $this->session->set_flashdata('alert', $data['alert']);
////                $this->session->set_userdata('logado', $userAPI);
//
//            redirect('Login');
//        }


        $response = $this->session->userdata("logado");
        $jobs = $retorno;
//        print_r();
//        print_r($jobs['response']['data']);
//die;

        $data ['jobs'] = $jobs['response']['data'];
        $data ['includes'] = $jobs['response']['included'];
//        print_r($data['jobs']);
//        die;
        $data['view'] = 'home';
        $data['response'] = $response;
        $this->load->view('template_admin/core', $data);
    }

    private function get_jobs()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/jobs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: c577f669-4e40-1385-a44f-ee66d310f3be",
                "x-auth-token: $aut_code"
            ),
        ));

        $headers = [];
        curl_setopt($curl, CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $name = strtolower(trim($header[0]));
                if (!array_key_exists($name, $headers))
                    $headers[$name] = [trim($header[1])];
                else
                    $headers[$name][] = trim($header[1]);

                return $len;
            }
        );

        $response = curl_exec($curl);
        $resposta = json_decode($response);
        $err = curl_error($curl);
        curl_close($curl);
        $array = $this->arrayCastRecursive($resposta);
        $resp['response'] = $array;
        $resp['headers'] = $headers;
        $resp['err'] = $err;
        return $resp;
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
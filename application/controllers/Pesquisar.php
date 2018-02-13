<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 00:00
 */
class Pesquisar extends CI_Controller
{
    private $url;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
            $this->load->helper('url');
        }
        $this->load->library('Geturl');
        $this->url = $this->geturl->get_url();

    }

    public function index()
    {
//        echo $aut_code = $this->session->userdata('verify')['auth_token'];
        $data['view'] = 'forms/pesquisar_filtro';
        $this->load->view('template_admin/core', $data);
    }

    public function listar()
    {
        
        $type = $this->input->post('type');
        $regiao = $this->input->post('regiao');

        if ($type == 'users') {
            $retorno = $this->listar_ws_users($regiao);
        } elseif ($type == 'companies') {
            $retorno = $this->listar_ws_companies($regiao);
        }

//        print_r($this->input->post());
//        print_r($retorno);

        if (isset($retorno["err"]) && !empty($retorno["err"])) {
            $data['alert'] = [
                'type' => 'erro',
                'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
            ];

            $this->session->set_flashdata('alert', $data['alert']);
        }

        $data['view'] = 'forms/pesquisar_filtro';
        $data['response'] = $retorno['response'];
        $this->load->view('template_admin/core', $data);

    }

    private function listar_ws_users($regiao)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->url/api/v1/users?filter%5Bregion%5D=%7B$regiao%7D",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: a1bf8aa1-8b88-bada-389f-fde1564e11b3",
                "x-auth-token: $aut_code"
            ),
//        ));
//        curl_setopt_array($curl, array(
////            CURLOPT_PORT => "3000",
//            CURLOPT_URL => "$this->url/api/v1/users?filter[region]={'$regiao'}",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_SSL_VERIFYPEER => 0,
//            CURLOPT_SSL_VERIFYHOST => 0,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "accept: application/vnd.api+json",
//                "cache-control: no-cache",
//                "postman-token: c8ded2be-172d-f095-775f-3cfda71520cf",
//                "x-auth-token: $aut_code"
//            ),
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

    private function listar_ws_companies($regiao)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->url/api/v1/companies?filter%5Bregion%5D=%7B$regiao%7D",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 9e059a5f-a7cf-f4e1-8fcf-c28e4ba5efdb",
                "x-auth-token: JCBMLf8nXo4GQsZuoc_9"
            ),
        ));
//        curl_setopt_array($curl, array(
////            CURLOPT_PORT => "3000",
//            CURLOPT_URL => "$this->url/api/v1/companies?filter%5Bregion%5D=%7B$regiao%7D",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_SSL_VERIFYPEER => 0,
//            CURLOPT_SSL_VERIFYHOST => 0,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_HTTPHEADER => array(
//                "accept: application/vnd.api+json",
//                "cache-control: no-cache",
//                "postman-token: c8ded2be-172d-f095-775f-3cfda71520cf",
//                "x-auth-token: $aut_code"
//            ),
//        ));

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
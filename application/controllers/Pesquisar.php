<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 21/11/2017
 * Time: 00:00
 */
class Pesquisar extends CI_Controller
{

    public function index()
    {
        echo $aut_code = $this->session->userdata('verify')['auth_token'];
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

        if (isset($retorno["err"]) && !empty($retorno["err"])) {
            $data['alert'] = [
                 'type' => 'erro',
                 'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
            ];

            $this->session->set_flashdata('alert', $data['alert']);
        }

        $data['view'] = 'forms/pesquisar_filtro';
        $data['response'] = $retorno['response'];
        $this->load->view('template_admin/core',$data);

    }

    private function listar_ws_users($regiao)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => 'http://34.229.150.76:3000/api/v1/users?filter[region]={' . urlencode($regiao) . '}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: c8ded2be-172d-f095-775f-3cfda71520cf",
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

    private function listar_ws_companies($regiao)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => 'http://34.229.150.76:3000/api/v1/companies?filter[region]={' . urlencode($regiao) . '}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: c8ded2be-172d-f095-775f-3cfda71520cf",
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
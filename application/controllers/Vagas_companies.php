<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 31/10/2017
 * Time: 21:05
 */
class Vagas_companies extends CI_Controller
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
        $retorno = $this->get_vagas_salvas_company();
        $jobs ['vagas_salvas'] = $retorno['response']['data'];
        foreach ($jobs['vagas_salvas'] as $vaga_salva) {
            if ($vaga_salva['relationships']['company']['data']['id'] == $this->session->userdata("logado")['id']) {
                $my_jobs[] = $vaga_salva;
            }
        }
        $data ['includes'] = $retorno['response']['included'];
        $data['my_company_jobs'] = $my_jobs;
        $data['view'] = 'forms/companies_vagas_list';
        $this->load->view('template_admin/core', $data);
    }

    private function get_vagas_salvas_company()
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
                "postman-token: 1a3dea8c-57bd-66f2-185d-62293a8a6515",
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

    public
    function arrayCastRecursive($array)
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
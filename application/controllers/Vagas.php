<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:30
 */
class Vagas extends CI_Controller
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


        $retorno = $this->get_vagas_salvas();
        $retorno_application = $this->get_vagas_application_salvas();
//        $job_salvo = $this->get_job_salvo($idjob);
        $saved_jobs ['vagas_salvas'] = $retorno['response']['data'];
        foreach ($saved_jobs['vagas_salvas'] as $vaga_salva) {

//            print_r($vaga_salva['relationships']['job']['data']['id']);

            $job_salvo = $this->get_job_salvo($vaga_salva['relationships']['job']['data']['id']);
            $jobs[] = $job_salvo['response'];
//            print_r($jobs['jobs']['response']);
        }
//        die;
        $data['jobs'] = $jobs;
        $data['jobs_application'] = $retorno_application;
//        $job_salvo = $this->get_job_salvo($idjob);
        $data['view'] = 'forms/vagas_list';
        $this->load->view('template_admin/core', $data);
    }


    private function get_vagas_salvas()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/users/saved_jobs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 867d450e-ae18-0a3c-2ca0-055e026cb8b2",
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

    private function get_vagas_application_salvas()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/jobs/2/job_applications",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 66cc6aba-918c-c027-3c93-015b79de4342",
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

    public function save_vagas()
    {
        $idjob = $this->input->post('idjob');
        $this->save_saved_jobs($idjob);


    }

    private function save_saved_jobs($idjob)
    {

        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/api/v1/jobs/4/saved_jobs",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"saved_jobs\",\n    \"relationships\": {\n      \"job\": {\n        \"data\": {\n          \"type\": \"jobs\",\n          \"id\": \"$idjob\"\n        }\n      }\n    }\n  }\n}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/vnd.api+json",
                    "postman-token: edfa54eb-1b43-24e9-f2f5-a59afc2e446d",
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

        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }

//      var_dump($resp);
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

    private
    function get_job_salvo($idjob)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/jobs/$idjob",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: 94c50fec-c163-3e33-fe9f-2211e7fe3711",
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

    public function save_job_application($idjob)
    {

        if ($idjob != null) {
            $retorno = $this->save_saved_jobs_application($idjob);
            if (isset($retorno["err"]) && !empty($retorno["err"])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            }
            if (isset(json_decode($retorno["response"])->errors[0])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Erro ao candidatar a Vaga'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas/index');
            } else {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Vaga candidatada com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas/index');
            }
        }


    }

    private function save_saved_jobs_application($idjob)
    {

        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/api/v1/jobs/$idjob/job_applications",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"job_applications\",
                \n    \"relationships\": {\n      \"job\": {\n        \"data\": {\n          \"type\": \"jobs\",
                \n          \"id\": \"$idjob\"\n        }\n      }\n    }\n  }\n}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/vnd.api+json",
                    "postman-token: 5f281ac5-6ac5-8b88-75de-0ac4c28d2756",
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

        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }

//      var_dump($resp);
    }

}
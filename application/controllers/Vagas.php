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
//        $this->output->enable_profiler(TRUE);
        $this->load->library('Geturl');
        $this->url = $this->geturl->get_url();
    }

    public function index()
    {

        $this->load->library('Fetchjob');
        $saved_jobs = $this->get_saved_jobs();
        $jobs_applications = $this->get_job_app_ws();
        $data['jobs'] = $saved_jobs['response']['data'];
        $data['jobs_application'] = $jobs_applications['response']['data'];
        $data['view'] = 'forms/vagas_list';
        $this->load->view('template_admin/core', $data);
    }

    private function get_saved_jobs()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/users/saved_jobs",
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

    private function get_job_app_ws()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/jobs/2/job_applications",
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
        if ($this->input->post('idjob')) {
            $idjob = $this->input->post('idjob');
            if ($idjob) {
                $this->save_saved_jobs($idjob);
            }
        }
    }

    private function save_saved_jobs($idjob)
    {
        if ($idjob) {
            if ($idjob > 0 && !empty($idjob)) {
                $aut_code = $this->session->userdata('verify')['auth_token'];
                $curl = curl_init();

                curl_setopt_array($curl, array(
//                    CURLOPT_PORT => "3000",
                    CURLOPT_URL => "$this->url/api/v1/jobs/4/saved_jobs",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
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
        }
    }

    public function delete_saved_jobs($idjob)
    {

        if ($idjob) {
            $this->delete_saved_jobs_ws($idjob);
            redirect('Vagas/index');
        }
    }

    private function delete_saved_jobs_ws($idjob)
    {
        if ($idjob) {
//            if ($idjob > 0 && !empty($idjob)) {
                $aut_code = $this->session->userdata('verify')['auth_token'];
                $curl = curl_init();

                curl_setopt_array($curl, array(
//                    CURLOPT_PORT => "3000",
                    CURLOPT_URL => "$this->url/api/v1/saved_jobs/$idjob",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "DELETE",
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "postman-token: c28a74d7-211d-1872-5df5-3456ac0602c3",
                        "x-auth-token: $aut_code"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }
//            }
        }
    }

    public function delete_jobs_application($idjob)
    {

        if ($idjob) {
            $this->delete_jobs_application_ws($idjob);
            redirect('Vagas/index');
        }
    }

    private function delete_jobs_application_ws($idjob)
    {
        if ($idjob) {
            if ($idjob > 0 && !empty($idjob)) {
                $aut_code = $this->session->userdata('verify')['auth_token'];
                $curl = curl_init();

                curl_setopt_array($curl, array(
//                    CURLOPT_PORT => "3000",
                    CURLOPT_URL => "$this->url/api/v1/job_applications/$idjob",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "DELETE",
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "postman-token: 99669bb3-e015-c71e-2c2d-71ac9ff2f92e",
                        "x-auth-token: $aut_code"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo $response;
                }
            }
        }
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

    public function create_job_application($idjob)
    {

        if ($idjob != null) {
            $retorno = $this->create_jobs_application_ws($idjob);
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

    private function create_jobs_application_ws($idjob)
    {

        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/jobs/$idjob/job_applications",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
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
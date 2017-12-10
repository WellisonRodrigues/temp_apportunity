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
//        $this->output->enable_profiler(TRUE);
    }


    public function index()
    {
        $retorno = $this->get_company_jobs();
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

    public function create_job()
    {
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $exp_date = $this->input->post('exp_date');
        if ($this->input->post('create_job') == 'salvar') {
            $retorno = $this->create_job_ws($title, $description, $exp_date);
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
                        'message' => 'Erro ao criar publicação de Vaga'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            } else {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Vaga criada com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas_companies/index');
            }
        }
        $data['view'] = 'forms/companies_vagas_list';
        $this->load->view('template_admin/core', $data);
    }

    public function delete_job($idjob)
    {
        if ($idjob != null) {
            if ($this->delete_company_job_ws($idjob)) {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Vaga deletada com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas_companies/index');
            } else {
                $data['alert'] =
                    [
                        'type' => 'error',
                        'message' => 'Falha ao deletar a vaga.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas_companies/index');
            }
        }

    }

    private function delete_company_job_ws($idjob)
    {

        if ($idjob != null) {
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
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: 5f7869da-5ca2-082c-b42c-0e68f882d18a",
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

            return true;
        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }

        //echo json_encode($resp);
    }

    private function get_company_jobs()
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

    private function create_job_ws($title, $description, $exp_date)
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
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"jobs\",
            \n    \"attributes\": {\n      \"title\": \"$title\",
            \n      \"exp-date\": \"$exp_date\",
            \n      \"description\": \"$description\"\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: 2a1a0c5b-5aaa-521a-5560-d437027d5c35",
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

    public function edit_job()
    {
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $exp_date = $this->input->post('exp_date');
        $idjob = $this->input->post('idjob');
        if ($this->input->post('edit_job') == 'salvar' and $this->input->post('idjob') != null) {
            $retorno = $this->edit_vagas($title, $description, $exp_date, $idjob);
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
                        'message' => 'Erro ao criar publicação de Vaga'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            } else {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Vaga criada com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Vagas_companies/index');
            }
        }
        $data['view'] = 'forms/companies_vagas_list';
        $this->load->view('template_admin/core', $data);
    }

    private function edit_job_ws($title, $description, $exp_date, $idjob)
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
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"jobs\",\n    \"id\": \"$idjob\",
            \n    \"attributes\": {\n      \"title\": \"$title\",
            \n      \"exp-date\": \"$exp_date\",\n      \"description\": \"$description\"\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: 3048de7f-7ed0-a446-3205-c4c3822f242b",
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
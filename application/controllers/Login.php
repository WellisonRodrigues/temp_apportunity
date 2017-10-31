<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();


        $this->output->enable_profiler(TRUE);

    }

    public function index()
    {
        $this->entrar();
    }

    public function entrar()
    {
        if ($this->input->post('login') == 'Entrar') {


            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $type = $this->input->post('type_login');
            //$retorno = $this->sign_in('ingressoscaldas@gmail.com','icnTDC');

            $retorno = $this->sign_in($email, $password, $type);
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
            if (isset(json_decode($retorno["response"])->errors[0])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Usuário/Senha inválidos.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Login');

            } else {

                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Usuário logado com sucesso.'
                    ];

                $var = json_decode($retorno["response"]);
                $arry_data = $var->data;
                $attributes = $arry_data->attributes;
                $meta = $arry_data->meta;
//                die;
                $userAPI = array();
//                foreach ($var as $point) {
                $userAPI['id'] = $arry_data->id;
                $userAPI['type'] = $arry_data->type;
                $userAPI['status'] = $attributes->status;
                $userAPI['email'] = $attributes->email;
                $userAPI['name'] = $attributes->name;
                $verify['auth_token'] = $meta->auth_token;
                //                }
//
//                $userAPI['access-token'] = $retorno["headers"]["access-token"][0];
//                $userAPI['clientHeader'] = $retorno["headers"]["client"][0];
//                $userAPI['token-type'] = $retorno["headers"]["token-type"][0];
//                $userAPI['uidHeader'] = $retorno["headers"]["uid"][0];

                $this->session->set_flashdata('alert', $data['alert']);
                $this->session->set_userdata('logado', $userAPI);
                $this->session->set_userdata('verify', $verify);

                redirect('Painel_admin');
            }
        }

        $data['view'] = 'login_form';
        $data['default_template'] = false;
        $this->load->view('template_admin/core', $data);

    }

    public function cadastrar()
    {
        if ($this->input->post('cadastrar') == 'cadastrar') {


            $email = $this->input->post('email');
            $type = $this->input->post('type');
            if ($this->input->post('nome')) {
                $nome = $this->input->post('nome');
            } else {
                $nome = false;
            }
            $password = $this->input->post('password');
            $password_confirmation = $this->input->post('password_confirmation');
            //$retorno = $this->sign_in('ingressoscaldas@gmail.com','icnTDC');

            $retorno = $this->create_acc($type, $email, $password, $password_confirmation, $nome);
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
            if (isset(json_decode($retorno["response"])->errors[0])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Erro ao cadastrar usuario'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Login');

            } else {

                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Usuário cadastrado com sucesso.'
                    ];

                $this->session->set_flashdata('alert', $data['alert']);
//                $this->session->set_userdata('logado', $userAPI);

                redirect('Login');
            }
        }

        $data['view'] = 'login_form';
        $data['default_template'] = false;
        $this->load->view('template_admin/core', $data);

    }

//    public function cadastrar()
//    {
//        if ($this->input->post('login') == 'cadastrar') {
//
//            redirect('painel_admin');
//        }
//
//        $data['view'] = 'login_form';
//        $data['default_template'] = false;
//        $this->load->view('template_admin/core', $data);
//    }

    private function sign_in($email, $pass, $type)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/auth/sign_in",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n      \"data\": {\n        \"type\": \"$type\",\n        \"attributes\": {\n          \"email\": \"$email\",\n          \"password\": \"$pass\"\n        }\n      }\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 578a9b75-6bb2-3e68-5495-d8407420e2ac"
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
        $err = curl_error($curl);
        curl_close($curl);

        $resp['response'] = $response;
        $resp['headers'] = $headers;
        $resp['err'] = $err;

        return $resp;
    }

    private function create_acc($type, $email, $pass, $pass_confirmation, $name)
    {
//        print_r($type);
//        print_r($email);
//        print_r($pass);
//        print_r($pass_confirmation);
//        die;
        $curl = curl_init();
        if ($name != false) {
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/auth",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n      \"data\": {\n        \"type\": \"$type\",\n        \"attributes\": {\n          \"email\": \"$email\",\n          \"password\": \"$pass\",\n          \"password_confirmation\": \"$pass_confirmation\",\n          \"name\": \"$name\",\n          \"status\": \"basic\"\n        }\n      }\n}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: a1551427-1f26-8093-801c-8b9ba28b12e0"
                ),
            ));
        } else {
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/auth",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n      \"data\": {\n        \"type\": \"$type\",\n        \"attributes\": {\n          \"email\": \"$email\",\n          \"password\": \"$pass\",\n          \"password_confirmation\": \"$pass_confirmation\",\n          \"status\": \"basic\"\n        }\n      }\n}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/json",
                    "postman-token: c16ed2bd-2746-f631-1b5e-7a8f395f3a63"
                ),
            ));
        }
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
        $err = curl_error($curl);
        curl_close($curl);

        $resp['response'] = $response;
        $resp['headers'] = $headers;
        $resp['err'] = $err;
//        print_r($response);
//        die;
        return $resp;
    }

    public function recover_accout()
    {
        if ($this->input->post('login') == 'Entrar') {


            $email = $this->input->post('email');
            $retorno = $this->recover_accout_wb($email);
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
            if (isset(json_decode($retorno["response"])->errors[0])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Favor verificar o e-mail digitado.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Login');

            } else {

                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Senha recuperada com sucesso. Verifique sua caixa e-mail.'
                    ];

                redirect('Login');
            }
        }
        $data['view'] = 'recover_acc_form';
        $data['default_template'] = false;
        $this->load->view('template_admin/core', $data);

    }
    private function recover_accout_wb($email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/auth/sign_in",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n      \"data\": {\n        \"type\": \"$type\",\n        \"attributes\": {\n          \"email\": \"$email\",\n          \"password\": \"$pass\"\n        }\n      }\n}",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: 578a9b75-6bb2-3e68-5495-d8407420e2ac"
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
        $err = curl_error($curl);
        curl_close($curl);

        $resp['response'] = $response;
        $resp['headers'] = $headers;
        $resp['err'] = $err;

        return $resp;
    }
}

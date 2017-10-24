<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

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
            //$retorno = $this->sign_in('ingressoscaldas@gmail.com','icnTDC');

            $retorno = $this->sign_in($email, $password);
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
                $userAPI['email'] = $attributes->email;
                $userAPI['name'] = $attributes->name;
                $userAPI['auth_token'] = $meta->auth_token;
                //                }
//
//                $userAPI['access-token'] = $retorno["headers"]["access-token"][0];
//                $userAPI['clientHeader'] = $retorno["headers"]["client"][0];
//                $userAPI['token-type'] = $retorno["headers"]["token-type"][0];
//                $userAPI['uidHeader'] = $retorno["headers"]["uid"][0];

                $this->session->set_flashdata('alert', $data['alert']);
                $this->session->set_userdata('logado', $userAPI);

                redirect('Painel_admin');
            }
        }

        $data['view'] = 'login_form';
        $data['default_template'] = false;
        $this->load->view('template_admin/core', $data);

    }

    public function cadastrar()
    {
        if ($this->input->post('login') == 'cadastrar') {

            redirect('painel_admin');
        }

        $data['view'] = 'login_form';
        $data['default_template'] = false;
        $this->load->view('template_admin/core', $data);
    }

    private function sign_in($email, $pass)
    {
//        print_r($email);
//        print_r($pass);
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
            CURLOPT_POSTFIELDS => "{\n      \"data\": {\n        \"type\": \"companies\",\n        \"attributes\": {\n          \"email\": \"$email\",\n          \"password\": \"$pass\"\n        }\n      }\n}",
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

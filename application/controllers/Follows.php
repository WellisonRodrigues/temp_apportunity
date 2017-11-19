<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 28/10/2017
 * Time: 16:06
 */
class Follows extends CI_Controller
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

        $this->get_conexao();
    }

    public function get_conexao()
    {
//        $retorno = $this->get_profile_conect();
//        $language = $this->get_profile_language();
//        $follows = $this->get_follows();
//
//        /*
//         * Erro no curl
//         */
//        if (isset($retorno["err"]) && !empty($retorno["err"])) {
//            $data['alert'] =
//                [
//                    'type' => 'erro',
//                    'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
//                ];
//            $this->session->set_flashdata('alert', $data['alert']);
//            redirect('Login');
//        }
//        $count = 0;
//        foreach ($follows['response']['data'] as $follow) {
//            $inscritos = $follow['relationships']['followed'];
//            foreach ($inscritos as $inscrito) {
//                $count++;
//            }
//        }
//
//        $data ['inscritos'] = $count;
//        $profile = $retorno;
//        $language_user = $language['response'];
//        $data ['idiomas'] = $language_user['data'];
//        $data ['profile'] = $profile['response']['data'];
//        $data ['relationships'] = $profile['response']['relationships'];
//        $data ['included'] = $profile['response']['included'];
////        print_r($data['jobs']);
////        die;
        $retorno_follows = $this->get_follows();
        $follows = $retorno_follows;
        $count_followed = 0;
        $count_follower = 0;
        foreach ($follows['response']['data'] as $follow) {
            $inscritos = $follow['relationships']['followed'];
            foreach ($inscritos as $inscrito) {
                $count_followed++;
                $seguidor[] = $inscrito['id'];
            }
        }
        foreach ($follows['response']['data'] as $follow) {
            $seguindo = $follow['relationships']['follower'];
            foreach ($seguindo as $seguindo_o) {
                $count_follower++;
                $seguindo_os[] = $inscrito['id'];
            }
        }

        $data ['followers'] =  $seguindo_os;
        $data ['followed'] =  $seguidor;
        $data ['inscritos'] = $count_followed;
        $data ['seguindo'] = $count_follower;
        $data['view'] = 'forms/conexoes_list';
        $this->load->view('template_admin/core', $data);

    }

    public function get_follows()
    {

        $aut_code = $this->session->userdata('verify')['auth_token'];
//    $type = $this->session->userdata("logado")->type;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/users/follows",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: de96bd2e-2ecb-1bf6-1ab5-4b757b2e977b",
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
<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 28/10/2017
 * Time: 16:06
 */
class Follows extends CI_Controller
{
    private $url;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }
        $this->load->library('Geturl');
//        $this->load->library('Getuser');
        $this->url = $this->geturl->get_url();
        $this->load->library('Fetchuser');

    }


    public function index()
    {
        $retorno_follows = $this->get_follows();
        $follows = $retorno_follows;
        $count_seguidores = 0;
        $count_seguindo = 0;

//        print_r($this->session->userdata("logado"));
        foreach ($follows['response']['data'] as $follow) {

//            print_r($follow);

            $follwers = $follow['relationships']['follower'];
            $follweds = $follow['relationships']['followed'];
//            print_r($follwed);

//            $seguindo_list = $follow['relationships']['followed'];
            foreach ($follwers as $follwer) {
                if ($follwer['id'] != $this->session->userdata("logado")['id']) {
                    $seguidor[] = $follwer['id'];
                    $count_seguidores++;

                }

            }
            foreach ($follweds as $follwed) {
                if ($follwed['id'] != $this->session->userdata("logado")['id']) {
                    $seguindo[] = $follwed['id'];
                    $count_seguindo++;
                }
//                if ($seguindo_o['id'] == $this->session->userdata("logado")['id']) {
//                    foreach ($seguindo_list as $seguindo_list_o) {
//                        $count_follower++;
//                        $seguindo_os[] = $seguindo_list_o['id'];
//                    }
//                } else {
//                    $inscritos = $follow['relationships']['followed'];
//                    foreach ($inscritos as $inscrito) {
//
//                        $count_followed++;
//                        $seguidor[] = $inscrito['id'];
//
//                    }
//                }
            }
        }


//        die;
        $data ['followers'] = $seguindo;
        $data ['followed'] = $seguidor;


        $data ['quant_seguidores'] = $count_seguidores;
        $data ['quant_seguindo'] = $count_seguindo;
        $data['view'] = 'forms/conexoes_list';
        $this->load->view('template_admin/core', $data);

    }

    public function get_follows()
    {

        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/users/follows",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
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

    public function get_users_list($iduser, $status)
    {

        $this->fetchuser->setauthtoken($this->session->userdata('verify')['auth_token']);
        $id = $iduser;
        $this->fetchuser->setiduser($id);
        $data['status'] = $status;
        $this->fetchuser->setuserattributes($id, $this->fetchuser->getauthtoken());
//        $data ['status'] = $status;
        $data ['iduser'] = $id;
        $this->load->view('forms/follow_users_list', $data);

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
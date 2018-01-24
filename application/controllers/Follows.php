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
        $this->url = $this->geturl->get_url();
        $this->load->library('Fetchuser');
    }

    public function index()
    {
        $retorno_follows = $this->get_follows();
        $follows = $retorno_follows;
        $count_followers = 0;
        $count_followeds = 0;
        foreach ($follows['response']['data'] as $row) {

        }
        foreach ($follows['response']['data'] as $row) {

            $follwers = $row['relationships']['follower'];
            $follweds = $row['relationships']['followed'];

            //lista de seguidores
            foreach ($follwers as $follower) {

                if ($follwers['data']['id'] != $this->session->userdata("logado")['id']) {
                    $id_follow = $row['id'];
                    $array_follower[$id_follow] = $follower;
                    $count_followers++;
                }
            }
            //lista de seguidos
            foreach ($follweds as $followed) {

                if ($follweds['data']['id'] != $this->session->userdata("logado")['id']) {
                    $id_follow = $row['id'];
                    $array_followed[$id_follow] = $followed;
                    $count_followeds++;
                }
            }
        }
        if ($count_followers >= $count_followers) {

            foreach ($array_follower as $followers) {
                foreach ($array_followed as $followeds) {
                    if ($followers['id'] == $followeds['id']) {
                        $segue_seguido[] = $followeds['id'];
                    }

                }
            }
        } else {
            foreach ($array_followed as $followeds) {
                foreach ($array_follower as $followers) {

                    if ($followeds['id'] == $followers['id']) {
                        $segue_seguido[] = $followers['id'];
                    }
                }
            }

        }
        $data ['followers'] = $array_follower;
        $data ['followed'] = $array_followed;
        $data['followed_follower'] = $segue_seguido;
        $data ['quant_seguidores'] = $count_followers;
        $data ['quant_seguindo'] = $count_followeds;
        $data['view'] = 'forms/conexoes_list';
        $this->load->view('template_admin/core', $data);

    }

    public function follows_funtion()
    {
        if ($this->input->post()) {
            if ($this->input->post('funcao') == 'Seguindo') {
                if ($this->delete_follow_ws($this->input->post('idfollow'))) {
                    echo 'delete follow';
                }
            }
            if ($this->input->post('funcao') == 'Seguir') {

                if ($this->create_follow_ws($this->input->post('iduser'))) {
                    echo 'create follow';
                }
            }

        }

    }

    public
    function get_follows()
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

    private function delete_follow_ws($idfollow)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        if ($idfollow) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$this->url/api/v1/users/follows/$idfollow",
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
                    "postman-token: 64360939-bc06-5c31-c266-ccb9a5151053",
                    "x-auth-token: $aut_code"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            echo $response;
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
            die;
        }
    }

    private function create_follow_ws($id)
    {

        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->url/api/v1/users/follows",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"follows\",\n    \"relationships\": {\n      \"followed\": {\n        \"data\": {\n          \"type\": \"users\",\n          \"id\": \"$id\"\n        }\n      }\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: b933d931-5065-be93-3ca2-78cd1a833ebd",
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
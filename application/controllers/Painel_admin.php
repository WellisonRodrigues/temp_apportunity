<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 30/09/2017
 * Time: 13:44
 */
require_once('Follows.php');

class Painel_admin extends Follows
{
    private $url;

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }

//        print_r($url);


        $this->load->library('Geturl');
        $this->url = $this->geturl->get_url();

//        $this->output->enable_profiler(TRUE);
//        $this->load->library('Fetchcompany');
    }

    public function index()

    {

//        print_r($this->url);
        $this->output->enable_profiler(TRUE);

        $this->load->library('Fetchcompany');
        $retorno = $this->get_jobs();
        $retorno_ads = $this->get_ads();
        $retorno_profile = $this->get_profile_conect();
        $retorno_follows = $this->get_follows();
        $retorno_languages = $this->get_profile_language();

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
        $jobs = $retorno;
        $response = $this->session->userdata("logado");
        $profile = $retorno_profile;
        $follows = $retorno_follows;
        $languages = $retorno_languages['response'];
        $count = 0;
        foreach ($follows['response']['data'] as $follow) {
            $inscritos = $follow['relationships']['followed'];
            foreach ($inscritos as $inscrito) {
                $count++;
            }
        }

        $data ['inscritos'] = $count;
        $data ['idiomas'] = $languages['data'];
        $data ['profile'] = $profile['response']['data'];
        $data ['relationships'] = $profile['response']['relationships'];
        $data ['included'] = $profile['response']['included'];

        $data ['jobs'] = $jobs['response']['data'];
        $data ['ads'] = $retorno_ads['response']['data'];
        $data ['includes'] = $jobs['response']['included'];

        $data['view'] = 'home';
        $data['response'] = $response;

//        print_r($response);

        $data['funcao'] = $this;

        $this->load->view('template_admin/core', $data);
    }


    private function get_jobs()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $url = $this->url . '/api/v1/jobs';
//        print_r($url);
//        die;
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/jobs",
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
                "postman-token: c577f669-4e40-1385-a44f-ee66d310f3be",
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

    private function get_ads()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",

            CURLOPT_URL => "$this->url/api/v1/ads",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: d49844e4-35a9-2741-01a9-7d0b772b9645",
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

    public function get_profile_conect()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $type = $this->session->userdata("logado")->type;
        $curl = curl_init();
//        $url = $this->url . '/api/v1/profile';

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/profile",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"$type\",\n  
              \"attributes\": {\n      \"token\": \"DJWIDH8NSKANLASK\",\n   
               \"provider\": \"facebook\"\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: ec5d0d8b-40a7-196c-256d-9acbcb7cca6c",
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

    private function get_profile_language()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
//        $type = $this->session->userdata("logado")->type;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/profile/languages",
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

    public function like_list_job($idjob)
    {
        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $usuario = $this->session->userdata('logado');
            $iduser = $usuario["id"];
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, "$this->url/api/v1/jobs/$idjob/likes");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: 46dd37d7-3a22-5e4f-74d9-66688975cabb",
                "x-auth-token: $aut_code"
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

            foreach ($array as $jobs) {
                foreach ($jobs as $job) {
                    if ($job["type"] == "likes") {
                        if ($job["relationships"]["job"]["data"]["id"] == $idjob && $job["relationships"]["user"]["data"]["id"] == $iduser) {
                            return $job["id"];
                            break;
                        }
                    }
                }
            }
            return 0;
        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }
    }


    public function like_job()
    {
        $idjob = $this->input->post('idjob');
        $tipo = $this->input->post('tipo');
        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/jobs/$idjob/likes",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"likes\",\n    \"relationships\": {\n      \"job\": {\n        \"data\": {\n          \"type\": \"$tipo\",\n          \"id\": \"$idjob\"\n        }\n      }\n    }\n  }\n}",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/vnd.api+json",
                    "postman-token: 46dd37d7-3a22-5e4f-74d9-66688975cabb",
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

        echo json_encode($resp);
//      var_dump($resp);
    }

    public function dislike_job()
    {
        $idjob = $this->input->post('idjob');
        $idlike = $this->input->post('idlike');

        if ($idlike > 0 && !empty($idlike)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/api/v1/likes/$idlike",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: ab80cc68-e8b2-af87-2242-339ecc98a628",
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

        //echo json_encode($resp);
    }

    public function get_comments_job($idjob)
    {
        if ($idjob > 0 && !empty($idjob)) {

            $aut_code = $this->session->userdata('verify')['auth_token'];
            $usuario = $this->session->userdata('logado');
            $iduser = $usuario["id"];
            $curl = curl_init();

            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/jobs/$idjob/comments",
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
                    "postman-token: 73732512-b90b-161b-8fc4-14a91d1a8429",
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
            $array_comentarios = array();

            if (sizeof($array["data"]) == 0) {
                $resp['err'] = 'Nenhum registro';
            } else {
                foreach ($array["data"] as $comments) {
                    if ($comments["type"] == "comments" && $comments["relationships"]["job"]["data"]["id"] == $idjob) {
                        //var_dump($comments);
                        array_push($array_comentarios, $comments);
                    }
                }
                $data['comentarios'] = $array_comentarios;
                $this->load->library('Fetchuser');
                $this->load->view('forms/list_coments', $data);
            }
        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }

        return $resp;
    }

    public function quantidade_curtidas_jobs($idjob)
    {

        $total = 0;

        if ($idjob > 0 && !empty($idjob)) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $usuario = $this->session->userdata('logado');
            $iduser = $usuario["id"];
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, "$this->url/api/v1/jobs/$idjob/likes");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: 46dd37d7-3a22-5e4f-74d9-66688975cabb",
                "x-auth-token: $aut_code"
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


            foreach ($array as $jobs) {
                foreach ($jobs as $job) {
                    if ($job["type"] == "likes") {
                        if ($job["relationships"]["job"]["data"]["id"] == $idjob) {
                            $total++;
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function insert_comments_job()
    {
        $idjob = $this->input->post('idjob');
        $texto = $this->input->post('texto');
        if ($idjob > 0 && !empty($idjob) && !empty($texto)) {

            $aut_code = $this->session->userdata('verify')['auth_token'];
            $usuario = $this->session->userdata('logado');
            $iduser = $usuario["id"];
            $curl = curl_init();

            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/jobs/$idjob/comments",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"comments\",
                \n    \"attributes\": {\n      \"message\": \"$texto\"\n    },
                \n    \"relationships\": {\n      \"job\": {\n        \"data\": {\n          \"type\": \"jobs\",
                \n          \"id\": \"$idjob\"\n        }\n      }\n      }\n    }\n  }\n",
                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/vnd.api+json",
                    "postman-token: 5bf1b1fa-4961-5432-0a9d-f1b9b917ec9d",
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
            //var_dump($array);
        } else {
            $resp['err'] = "Erro! Job não encontrado.";
        }
    }
}
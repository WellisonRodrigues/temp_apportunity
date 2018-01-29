<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 28/10/2017
 * Time: 16:06
 */
class Anuncios extends CI_Controller
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
    }

    public function index()
    {

        $this->anuncios_list();
    }

    public function anuncios_list()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $type = $this->session->userdata("logado")["type"];
        $id_company = $this->session->userdata("logado")["id"];
		
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/ads",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"$type\",\n  
              \"attributes\": {\n      \"token\": \"$aut_code\",\n   
               \"provider\": \"\"\n    }\n  }\n}",
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
		$anuncios = array();
		foreach($array["data"] as $v1){
			if($v1["relationships"]["company"]["data"]["id"] == $id_company){
				$anuncios[] =  $v1;
			}
		}
        
		$data["anuncios"] = $anuncios;
        $data['view'] = 'forms/anuncios_list';
        $this->load->view('template_admin/core', $data);

    }

    public function cadastro()
    {
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $image = 'data:image/png;base64,' . base64_encode($this->input->post('file'));

        $aut_code = $this->session->userdata('verify')['auth_token'];
        $id_user = $this->session->userdata('logado')['id'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/ads",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n   \"type\": \"ads\",
            \n   \"attributes\": {
            \n      \"title\": \"$title\",
            \n      \"description\": \"$description\",
            \n      \"image\": \"$image\"
                }
            \n  }\n}",

            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: e76d2ba7-3a09-53a2-46d3-fa4215dd792a",
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
        $err = curl_error($curl);
        curl_close($curl);

        $resp['response'] = $response;
        $resp['headers'] = $headers;
        $resp['err'] = $err;

        redirect('Anuncios');
    }

    public function deletar(){
        $idanuncio = $this->input->post('idanuncio');
        if ($idanuncio > 0 && !empty($idanuncio)) {

            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/ads/$idanuncio",
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
        }
    }

    public function anuncios_edit()
    {

        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $id_anuncio = $this->input->post('id_anuncio');
        if($this->input->post('file') != null){
            $image = 'data:image/png;base64,' . base64_encode($this->input->post('file'));
            $image_post = ',
            \n      \"image\": \"'.$image.'\"';
        }

        $aut_code = $this->session->userdata('verify')['auth_token'];

        if ($this->input->post('edit_anuncio') == 'salvar' and $this->input->post('id_anuncio') != null) {

            $curl = curl_init();
            curl_setopt_array($curl, array(
//                CURLOPT_PORT => "3000",
                CURLOPT_URL => "$this->url/api/v1/ads/$id_anuncio",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => "{\n  \"data\": {\n   \"type\": \"ads\", \n   \"id\": \"$id_anuncio\", 
            \n   \"attributes\": {
            \n      \"title\": \"$title\",
            \n      \"description\": \"$description\"
            $image_post
                }
            \n  }\n}",

                CURLOPT_HTTPHEADER => array(
                    "accept: application/vnd.api+json",
                    "cache-control: no-cache",
                    "content-type: application/vnd.api+json",
                    "postman-token: e76d2ba7-3a09-53a2-46d3-fa4215dd792a",
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
            $err = curl_error($curl);
            curl_close($curl);

            $array = $this->arrayCastRecursive($response);
            $retorno['response'] = $array;
            $retorno['headers'] = $headers;
            $retorno['err'] = $err;

            if (isset($retorno["err"]) && !empty($retorno["err"])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Problemas no servidor. Entrar contato com a equipe de ti.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Anuncios');
            }
            if (isset(json_decode($retorno["response"])->errors[0])) {
                $data['alert'] =
                    [
                        'type' => 'erro',
                        'message' => 'Erro ao criar publicação de Vaga'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Anuncios');
            } else {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Anuncio alterado com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Anuncios/index');
            }

        }

        redirect('Anuncios/index');
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
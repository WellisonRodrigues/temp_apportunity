<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 19/10/2017
 * Time: 23:33
 */
require_once('Follows.php');

class Perfil_user extends Follows
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
            $this->load->helper('url');

        }
        $this->load->library('Geturl');
        $this->url = $this->geturl->get_url();
    }

    public function index()
    {

        $this->get_profile();
    }

    public function get_profile()
    {	
		$aut_code = $this->session->userdata('verify')['auth_token'];
        $retorno = $this->get_profile_conect();
        $language = $this->get_profile_language();
        $follows = $this->get_follows();
		$dadosLogado = $this->session->userdata('logado');
		$company_id = $dadosLogado["id"];
        $profile = $retorno;
		
	
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
        $count = 0;
        foreach ($follows['response']['data'] as $follow) {
            $inscritos = $follow['relationships']['followed'];
            foreach ($inscritos as $inscrito) {
                $count++;
            }
        }
		
		
		if($this->session->userdata('logado')['type'] == 'companies'){
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_PORT => "3000",
				CURLOPT_URL => "http://34.229.150.76:3000/api/v1/admin/companies/$company_id",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
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
			$resposta = json_decode($response);
			curl_close($curl);
			
			$array = $this->arrayCastRecursive($resposta);
            $data ['profile'] = $array["data"];
		
			
		}else{
			$data ['profile'] = $profile['response']['data'];
		}			
		
        $data ['inscritos'] = $count;
        $language_user = $language['response'];
        $data ['idiomas'] = $language_user['data'];
        
        $data ['relationships'] = $profile['response']['relationships'];
        $data ['included'] = $profile['response']['included'];
//        print_r($data['jobs']);
//        die;

        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);

    }

    public function editar()
    {

        $name = $this->input->post('name_user');
        $age = $this->input->post('age');
        $image = 'data:image/png;base64,' . base64_encode($this->input->post('file'));
        $carrer = $this->input->post('carrer');
        $region = $this->input->post('region');
        $pdf = 'data:application/pdf;base64,' . base64_encode($this->input->post('pdf'));
        //$retorno = $region->sign_in('ingressoscaldas@gmail.com','icnTDC');

        $retorno = $this->update_user($name, $age, $carrer, $region, $pdf, $image);
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
            redirect('Perfil_user');
        }

        /*
         * erro de login e senha
         */
        if (isset(json_decode($retorno["response"])->errors[0])) {
            $data['alert'] =
                [
                    'type' => 'erro',
                    'message' => 'Erro ao editar usuario'
                ];
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('Perfil_user');
        } else {

            $data['alert'] =
                [
                    'type' => 'sucesso',
                    'message' => 'Usuário editado com sucesso.'
                ];

            $this->session->set_flashdata('alert', $data['alert']);
//                $this->session->set_userdata('logado', $userAPI);
            redirect('Perfil_user');


        }
        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);
//        }


    }

    public function create_idiomas()
    {

        $name = $this->input->post('name_idioma');
        $level = $this->input->post('level');

        //$retorno = $region->sign_in('ingressoscaldas@gmail.com','icnTDC');

        $retorno = $this->create_languages($name, $level);
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
            redirect('Perfil_user');
        }

        /*
         * erro de login e senha
         */
        if (isset(json_decode($retorno["response"])->errors[0])) {
            $data['alert'] =
                [
                    'type' => 'erro',
                    'message' => 'Erro ao criar o idioma'
                ];
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('Perfil_user');
        } else {

            $data['alert'] =
                [
                    'type' => 'sucesso',
                    'message' => 'Idioma criado com sucesso.'
                ];

            $this->session->set_flashdata('alert', $data['alert']);
//                $this->session->set_userdata('logado', $userAPI);
            redirect('Perfil_user');


        }
        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);
//        }


    }

    public function editar_skills()
    {

        $name = $this->input->post('name_user');
        $age = $this->input->post('age');
        $carrer = $this->input->post('carrer');
        $region = $this->input->post('region');
        //$retorno = $region->sign_in('ingressoscaldas@gmail.com','icnTDC');

        $retorno = $this->update_user($name, $age, $carrer, $region);
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
            redirect('Perfil_user');
        }

        /*
         * erro de login e senha
         */
        if (isset(json_decode($retorno["response"])->errors[0])) {
            $data['alert'] =
                [
                    'type' => 'erro',
                    'message' => 'Erro ao editar usuario'
                ];
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('Perfil_user');
        } else {

            $data['alert'] =
                [
                    'type' => 'sucesso',
                    'message' => 'Usuário editado com sucesso.'
                ];

            $this->session->set_flashdata('alert', $data['alert']);
//                $this->session->set_userdata('logado', $userAPI);
            redirect('Perfil_user');


        }
        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);
//        }


    }

    public function get_profile_conect()
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $type = $this->session->userdata("logado")->type;
        $curl = curl_init();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/profile",
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
        return $resp;
    }

    private function update_user($name, $age, $carrer, $region, $pdf, $image)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $id_user = $this->session->userdata('logado')['id'];

//        print_r($id_user);
//        die;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/profile",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n   \"type\": \"profiles\",\n   \"id\" : \"$id_user\",
            \n    \"attributes\": {\n      \"name\": \"$name\",\n      \"region\": \"$region\",
            \n      \"age\": \"$age\",\n      \"carrer\": \"$carrer\",
            \n      \"image\": \"$image\",
            \n      \"document\": \"$pdf\"\n    }\n  }\n}",
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
//        print_r($response);
//        die;
        return $resp;
    }

    public function delete_idioma($ididioma)
    {
        if ($ididioma != null) {
            if ($this->delete_idioma_ws($ididioma)) {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Idioma deletado com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            } else {
                $data['alert'] =
                    [
                        'type' => 'error',
                        'message' => 'Falha ao deletar o Idioma.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            }
        }

    }

    private function delete_idioma_ws($ididioma)
    {

        if ($ididioma != null) {
            $aut_code = $this->session->userdata('verify')['auth_token'];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "3000",
                CURLOPT_URL => "http://34.229.150.76:3000/api/v1/profile/languages/$ididioma",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "DELETE",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "postman-token: d5f30dbf-1d1a-7ab9-3259-a497909e74a9",
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
            $resp['err'] = "Erro! Idioma não encontrado.";
        }

        //echo json_encode($resp);
    }

    public function edit_language()
    {
        $name = $this->input->post('name');
        $level = $this->input->post('level');
        $id_idioma = $this->input->post('id');
        if ($this->input->post('editar') == 'Editar' and $this->input->post('id') != null) {
            $retorno = $this->edit_language_ws($name, $level, $id_idioma);
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
                        'message' => 'Erro ao editar o idioma'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            } else {
                $data['alert'] =
                    [
                        'type' => 'sucesso',
                        'message' => 'Idioma editado com sucesso.'
                    ];
                $this->session->set_flashdata('alert', $data['alert']);
                redirect('Perfil_user');
            }
        }
        $data['view'] = 'forms/companies_vagas_list';
        $this->load->view('template_admin/core', $data);
    }

    private function edit_language_ws($name,$level, $id_idioma)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/profile/languages/$id_idioma",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"languages\",
            \n    \"id\": \"$id_idioma\",\n    \"attributes\": {\n      \"name\": \"$name\",
            \n      \"level\": \"$level\"\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: 715f831f-0763-71c0-2d08-2ee05dfed8a4",
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


    private function update_skills($name, $age, $carrer, $region)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $id_user = $this->session->userdata('logado')['id'];

//        print_r($id_user);
//        die;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/profile",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n   \"type\": \"profiles\",\n   \"id\" : \"$id_user\",
            \n    \"attributes\": {\n      \"name\": \"$name\",\n      \"region\": \"$region\",
            \n      \"age\": \"$age\",\n      \"carrer\": \"$carrer\"\n    }\n  }\n}",
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
//        print_r($response);
//        die;
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

    private function create_languages($name, $level)
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
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"languages\",\n  
              \"attributes\": {\n      \"name\": \"$name\",\n      \"level\": \"$level\"\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: d9dcab3a-4a79-c78f-12e6-d6ab280fb5ca",
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
	
	
	 public function editarEmpresa()
    {

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $image = 'data:image/png;base64,' . base64_encode($this->input->post('file'));
       
        //$retorno = $region->sign_in('ingressoscaldas@gmail.com','icnTDC');

        $retorno = $this->update_empresa($name, $email, $image);
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
            redirect('Perfil_user');
        }

        /*
         * erro de login e senha
         */
        if (isset(json_decode($retorno["response"])->errors[0])) {
            $data['alert'] =
                [
                    'type' => 'erro',
                    'message' => 'Erro ao editar empresa'
                ];
            $this->session->set_flashdata('alert', $data['alert']);
            redirect('Perfil_user');
        } else {

            $data['alert'] =
                [
                    'type' => 'sucesso',
                    'message' => 'Empresa editado com sucesso.'
                ];

            $this->session->set_flashdata('alert', $data['alert']);
//                $this->session->set_userdata('logado', $userAPI);
            redirect('Perfil_user');


        }
        $data['view'] = 'forms/perfil_user';
        $this->load->view('template_admin/core', $data);
//        }

    }
	
	
	private function update_empresa($name, $email, $image)
    {
        $aut_code = $this->session->userdata('verify')['auth_token'];
        $company_id= $this->session->userdata('logado')['id'];

//        print_r($id_user);
//        die;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/admin/companies/$company_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n   \"type\": \"companies\",\n   \"id\" : \"$company_id\",
            \n    \"attributes\": {\n      \"name\": \"$name\",\n      \"email\": \"$email\",
            \n      \"image\": \"$image\"\n    }\n  }\n}",
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
//        print_r($response);
//        die;
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
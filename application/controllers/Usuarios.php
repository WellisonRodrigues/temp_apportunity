<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 03/10/2017
 * Time: 21:03
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }

        // verifica se é manager
        $this->verificaManager();
    }

    public function lista()
    {
        //pode adaptar para apenas um alert delete
        $data['javascript'][] = '$( ".confirm-deletar" ).click(function() {
                                         if($(this).attr(\'ativo\') == \'sim\'){
                                             var txt_ativo = \'desativar\';
                                         }else{
                                            var txt_ativo = \'ativar\';
                                         }
                                         var r = confirm("Tem certeza que deseja "+txt_ativo+" o usuario "+ $(this).attr( "nome" ) +" ?");
                                            if (r == true) {
                                                $.post( "' . base_url('usuarios/deletar') . '",
                                                 { idaluno: $(this).attr( "idaluno" ), status: $(this).attr( "ativo" ) })
                                                  .done(function( data ) {
                                                    alert( "Aviso: " + data );
                                                    window.location.replace("' . base_url('usuarios/lista/') . '");
                                                  });
                                            } else {
                                               alert("Ação cancelada.");
                                            }
                                        });';
        // Ativar na listagem de unidades, um click no pesquisar após selecionar alguma
        $data['javascript'][] = '$( "#select_unidades" ).change(function() {
                                    $( "form:first" ).submit();
                                });';
        $this->load->library('table');


        $data['javascript'][] = 'dataTableInit("#tb_usuarios");';
        $response = $this->session->userdata("logado");

        $usuarios = $this->listarUsuariosWS();
        $data['view'] = 'forms/lista_usuarios_form';
        $data['usuarios'] = $usuarios;
        $this->load->view('template_admin/core', $data);
    }

    public function novo()
    {

        if ($this->input->post("submit") == "salvar_novo_usuario") {

            $usuarios = $this->novoUsuariosWS();

            if (!$usuarios) {
                // error
            }

            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $client = $this->input->post('client');
            $is_manager = $this->input->post('is_manager');
            $is_master = $this->input->post('is_master');

            $data['view'] = 'forms/novo_usuario_form';
            $this->load->view('template_admin/core', $data);
        }
        $data['view'] = 'forms/novo_usuario_form';
        $this->load->view('template_admin/core', $data);
    }

    public function editar()
    {
        $id_usuario = $this->uri->segment(3);
        if (empty($id_usuario)) {
            redirect('usuarios/lista');
        }

        if ($this->input->post("submit") == "salvar_alterar_usuario" && $id_usuario > 0) {

            $id_usuario = $this->uri->segment(3);
            $usuarios = $this->editarUsuariosWS($id_usuario);

            if (!$usuarios) {
                // error
            }
            $client = $this->input->post('client');
            $is_manager = $this->input->post('is_manager');

            redirect('usuarios/lista');
        }

        $data['view'] = 'forms/editar_usuario_form';
        $data['id_usuario'] = $id_usuario;
        $this->load->view('template_admin/core', $data);
    }

    public function excluir()
    {
        $id_usuario = $this->uri->segment(3);
        if ($id_usuario > 0) {
            $usuarios = $this->excluirUsuariosWS($id_usuario);
            if (!$usuarios) {
                // error
            }
            redirect('usuarios/lista');
        }
        redirect('usuarios/lista');
    }

    private function novoUsuariosWS()
    {
        $response = $this->session->userdata("logado");
        $accesstoken = $response["access-token"];
        $clientHeader = $response["clientHeader"];
        $tokentype = $response["token-type"];
        $uid = $response["uidHeader"];

        $email = $this->input->post("email");
        $password = $this->input->post("password");
        $is_manager = $this->input->post("is_manager");
        $client = $this->input->post("client");
        $is_master = $this->input->post("is_master");

        /*'is_manager' => array(
            urlencode(base64_encode('image1')),
            urlencode(base64_encode('image2'))
        )*/

        $fields = array(
            'email' => $email,
            'password' => $password,
            'is_manager' => $is_manager,
            'is_master' => $is_master,
            'client' => $client,

        );

        $field_string = http_build_query($fields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://54.233.182.52:3000/api/admin/users",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $field_string,
            CURLOPT_HTTPHEADER => array(
                "access-token: $accesstoken",
                "client: $clientHeader",
                "token-type: $tokentype",
                "uid: $uid",
                "cache-control: no-cache",
                "host: 54.233.182.52:3000",
            ),
        ));

        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $resposta = json_decode($response2);

        if (isset($resposta->errors) && !empty($resposta->errors)) {
            redirect('sair');
        }

        if (isset($resposta->id)) {
            return false;
        } else {
            return true;
        }
    }

    private function editarUsuariosWS($id_usuario)
    {
        $response = $this->session->userdata("logado");
        $accesstoken = $response["access-token"];
        $clientHeader = $response["clientHeader"];
        $tokentype = $response["token-type"];
        $uid = $response["uidHeader"];

        $is_manager = $this->input->post("is_manager");
        $client = $this->input->post("client");

        /*'is_manager' => array(
            urlencode(base64_encode('image1')),
            urlencode(base64_encode('image2'))
        )*/

        $fields = array(
            'client' => $client,
            'is_manager' => $is_manager,
        );

        $field_string = http_build_query($fields);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://54.233.182.52:3000/api/admin/users/$id_usuario",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $field_string,
            CURLOPT_HTTPHEADER => array(
                "access-token: $accesstoken",
                "client: $clientHeader",
                "token-type: $tokentype",
                "uid: $uid",
                "cache-control: no-cache",
                "host: 54.233.182.52:3000",
            ),
        ));

        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $resposta = json_decode($response2);
        if (isset($resposta->errors) && !empty($resposta->errors)) {
            redirect('sair');
        }

        if (isset($resposta->id)) {
            return false;
        } else {
            return true;
        }
    }

    private function excluirUsuariosWS($id_usuario)
    {

        $response = $this->session->userdata("logado");
        $accesstoken = $response["access-token"];
        $clientHeader = $response["clientHeader"];
        $tokentype = $response["token-type"];
        $uid = $response["uidHeader"];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://54.233.182.52:3000/api/admin/users/$id_usuario",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => array(
                "access-token: $accesstoken",
                "client: $clientHeader",
                "token-type: $tokentype",
                "uid: $uid",
                "cache-control: no-cache",
                "host: 54.233.182.52:3000",
            ),
        ));

        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $resposta = json_decode($response2);

        if (isset($resposta->errors) && !empty($resposta->errors)) {
            redirect('sair');
        }

        if ($resposta == NULL) {
            return true;
        } else {
            return false;
        }
    }

    private function listarUsuariosWS()
    {
        $response = $this->session->userdata("logado");
        $accesstoken = $response["access-token"];
        $client = $response["clientHeader"];
        $tokentype = $response["token-type"];
        $uid = $response["uidHeader"];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://54.233.182.52:3000/api/admin/users",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "access-token: $accesstoken",
                "client: $client",
                "token-type: $tokentype",
                "uid: $uid",
                "cache-control: no-cache",
                "host: 54.233.182.52:3000",
            ),
        ));

        $response2 = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $resposta = json_decode($response2);

        if (isset($resposta->errors) && !empty($resposta->errors)) {
            redirect('sair');
        }

        $array = $this->arrayCastRecursive($resposta->data);
        return $array;
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

    private function verificaManager()
    {
        $response = $this->session->userdata("logado");
        if ($response["is_manager"] != 1) {
            redirect('Painel_admin');
        }
    }
}

?>
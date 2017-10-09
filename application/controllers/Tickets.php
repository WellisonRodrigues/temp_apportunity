<?php

/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 03/10/2017
 * Time: 23:09
 */
class Tickets extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }

        $this->verificaManager();
    }

    public function lista()
    {
//        $data['javascript'][] = '$( ".confirm-deletar" ).click(function() {
//                                         if($(this).attr(\'ativo\') == \'sim\'){
//                                             var txt_ativo = \'desativar\';
//                                         }else{
//                                            var txt_ativo = \'ativar\';
//                                         }
//                                         var r = confirm("Tem certeza que deseja "+txt_ativo+" o aluno "+ $(this).attr( "nome" ) +" ?");
//                                            if (r == true) {
//                                                $.post( "' . base_url('usuarios/inativarAluno') . '",
//                                                 { idaluno: $(this).attr( "idaluno" ), status: $(this).attr( "ativo" ) })
//                                                  .done(function( data ) {
//                                                    alert( "Aviso: " + data );
//                                                    window.location.replace("' . base_url('tickets/lista/') . '");
//                                                  });
//                                            } else {
//                                               alert("Ação cancelada.");
//                                            }
//                                        });';
//        // Ativar na listagem de unidades, um click no pesquisar após selecionar alguma
//        $data['javascript'][] = '$( "#select_unidades" ).change(function() {
//                                    $( "form:first" ).submit();
//                                });';
        $this->load->library('table');


        $data['javascript'][] = 'dataTableInit("#tb_tickets");';
        $tickets = $this->listarTicketsWS();
        $data['tickets'] = $tickets;
        $data['view'] = 'forms/lista_ingressos_form';
        $this->load->view('template_admin/core', $data);
    }

    private function listarTicketsWS()
    {
        $response = $this->session->userdata("logado");
        $accesstoken = $response["access-token"];
        $client = $response["clientHeader"];
        $tokentype = $response["token-type"];
        $uid = $response["uidHeader"];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://54.233.182.52:3000/api/admin/tickets",
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

    private function verificaManager()
    {
        $response = $this->session->userdata("logado");
        if ($response["is_manager"] != 1) {
            redirect('Painel_admin');
        }
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

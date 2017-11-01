<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 28/10/2017
 * Time: 16:06
 */
class Follows extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata("logado")) {
            redirect('sair');
        }
    }
public function get_follows(){

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

}
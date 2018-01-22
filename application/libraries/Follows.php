<?php

class Follows
{
    private $auth_token;
    private $iduser;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('Geturl');

    }

    function setauthtoken($auth_token)
    {
        $this->auth_token = $auth_token;

    }

    function getauthtoken()
    {
        return $this->auth_token;
    }

    function setiduser($iduser)
    {
        $this->auth_token = $iduser;

    }

    function getiduser()
    {
        return $this->iduser;
    }


    function create_follow($iduser, $auth)
    {
        $aut_code = $auth;
        $curl = curl_init();
        $this->url = $this->CI->geturl->get_url();
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
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"data\": {\n    \"type\": \"follows\",
            \n    \"relationships\": {\n      \"followed\": {\n        \"data\": {\n          \"type\": \"users\",
            \n          \"id\": \"$iduser\"\n        }\n      }\n    }\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "content-type: application/vnd.api+json",
                "postman-token: b32a4894-5ab9-0ad4-48d8-89cea2a85e4a",
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

//        $response = curl_exec($curl);
//        $resposta = json_decode($response);
//        $err = curl_error($curl);
        curl_close($curl);
//        $array = $this->arrayCastRecursive($resposta);
//        $resp['response'] = $array;
//        $resp['headers'] = $headers;
//        $resp['err'] = $err;
    }

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

?>
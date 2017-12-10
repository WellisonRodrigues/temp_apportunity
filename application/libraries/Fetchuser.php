<?php

class Fetchuser
{
    private $iduser;
    private $username;
    private $userimage;
    private $auth_token;

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
        $this->iduser = $iduser;

    }

    function getiduser()
    {
        return $this->iduser;
    }


    function getusername()
    {
        return $this->username;
    }

    function getuserimage()
    {
        return $this->userimage;
    }


    function setuserattributes($iduser, $auth)
    {
        $aut_code = $auth;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/admin/users/$iduser",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: 861623c2-5467-35bf-1d77-82d4e3bc8a56",
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
        $this->userimage = $resp['response']['included'][0]['attributes']['image'];
        $this->username = $resp['response']['included'][0]['attributes']['name'];

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
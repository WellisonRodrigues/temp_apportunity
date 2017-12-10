<?php

class Fetchcompany
{
    private $idcompany;
    private $comapanyname;
    private $companyimage;
    private $auth_token;

    function setauthtoken($auth_token)
    {
        $this->auth_token = $auth_token;

    }

    function getauthtoken()
    {
        return $this->auth_token;
    }


    function setidcompany($idcompany)
    {
        $this->idcompany = $idcompany;

    }

    function getidcompany()
    {
        return $this->idcompany;
    }


    function getcompanyname()
    {
        return $this->comapanyname;
    }

    function getcompanyimage()
    {
        return $this->companyimage;
    }


    function setcompanyattributes($idcompany, $auth)
    {
        $aut_code = $auth;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "3000",
            CURLOPT_URL => "http://34.229.150.76:3000/api/v1/admin/companies/$idcompany",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: 22c5a1dc-a439-aafd-ad78-2fa361553f2c",
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
        $this->companyimage = $resp['response']['data']['attributes']['image'];
        $this->comapanyname = $resp['response']['data']['attributes']['name'];

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
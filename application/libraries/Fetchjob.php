<?php

class Fetchjob
{
    private $idjob;
    private $companyname;
    private $companyimage;
    private $auth_token;
    private $publishedat;
    private $title;
    private $description;
    private $companytype;
    private $companyid;

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

    function getcompanytype()
    {
        return $this->companytype;
    }

    function getcompanyid()
    {
        return $this->companyid;
    }

    function setidjob($idjob)
    {
        $this->idjob = $idjob;


        if ($idjob != null) {
//            $this->setjobattributes($idjob);
        }
    }

    function getidjob()
    {
        return $this->idjob;
    }

    function getcompanyname()
    {
        return $this->companyname;
    }

    function getcompanyimage()
    {
        return $this->companyimage;
    }

    function getjobpublishedat()
    {
        return $this->publishedat;
    }

    function getdescription()
    {
        return $this->description;
    }

    function gettitle()
    {
        return $this->title;
    }

    function setjobattributes($idjob, $auth)
    {
        $aut_code = $auth;
        $curl = curl_init();
        $this->url = $this->CI->geturl->get_url();

        curl_setopt_array($curl, array(
//            CURLOPT_PORT => "3000",
            CURLOPT_URL => "$this->url/api/v1/jobs/$idjob",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/vnd.api+json",
                "cache-control: no-cache",
                "postman-token: abc1c97c-9922-fe59-2db8-3e07b8c92216",
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
        $this->companyimage = $resp['response']['included'][0]['attributes']['image'];
        $this->companyname = $resp['response']['included'][0]['attributes']['name'];
        $this->companytype = $resp['response']['included'][0]['type'];
        $this->companyid = $resp['response']['included'][0]['id'];
        $this->publishedat = $resp['response']['data']['attributes']['published-at'];
        $this->title = $resp['response']['data']['attributes']['title'];
        $this->description = $resp['response']['data']['attributes']['description'];


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
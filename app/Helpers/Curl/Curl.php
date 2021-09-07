<?php


namespace App\Helpers\Curl;


class Curl
{

    public function post(string $url, $params) {
        $curl   =   curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    public function get(string $link) {
        $ch =   curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $exec   =   curl_exec($ch);
        curl_close($ch);
        return $exec;
    }

    public function postToken($url,$token = '', $data = [], $status = true) {
        $curl   =   curl_init();
        if ($token !== '') {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json' , 'Authorization: Bearer '.$token]);
        } else {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST, true);
        if (sizeof($data) > 0) {
            if ($status) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            } else {
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    public function getContents($url)
    {
        return file_get_contents($url);
    }

    public function postSend($url,$chat)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL             =>  $url,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_ENCODING        =>  '',
            CURLOPT_MAXREDIRS       =>  10,
            CURLOPT_TIMEOUT         =>  10,
            CURLOPT_FOLLOWLOCATION  =>  true,
            CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   =>  'POST',
            CURLOPT_POSTFIELDS      =>  $chat,
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getSend($url)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL             =>  $url,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_ENCODING        =>  '',
            CURLOPT_MAXREDIRS       =>  10,
            CURLOPT_TIMEOUT         =>  0,
            CURLOPT_FOLLOWLOCATION  =>  true,
            CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   =>  'GET',
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function postTokenReserve($url,$token = '', $data = []) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL             =>  $url,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_ENCODING        =>  '',
            CURLOPT_MAXREDIRS       =>  10,
            CURLOPT_TIMEOUT         =>  0,
            CURLOPT_FOLLOWLOCATION  =>  true,
            CURLOPT_HTTP_VERSION    =>  CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   =>  'POST',
            CURLOPT_POSTFIELDS      =>  json_encode($data),
            CURLOPT_HTTPHEADER      =>  [
                'Authorization: Bearer '.$token,
                'Content-Type: application/json'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}

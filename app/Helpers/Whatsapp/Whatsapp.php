<?php

namespace App\Helpers\Whatsapp;

class Whatsapp
{
    protected $instance =   332066;
    protected $token    =   'l91t7kxjw5dm7cto';

    public function send($data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chat-api.com/instance'.$this->instance.'/message?token='.$this->token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function sendBooking($data)
    {
        $data['body']   =   'https://reserved-app.kz/img/logo/meme.gif';
        $data['filename']   =   'meme.gif';
        file_get_contents('https://api.chat-api.com/instance'.$this->instance.'/message?token='.$this->token,false,stream_context_create(['http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => json_encode($data)
            ]])
        );
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chat-api.com/instance'.$this->instance.'/message?token='.$this->token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        curl_close($curl);*/
    }
}

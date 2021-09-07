<?php

namespace App\Helpers\Whatsapp;

class Whatsapp
{
    protected $instance =   332066;
    protected $token    =   'l91t7kxjw5dm7cto';

    public function send($data)
    {
        $url      =   'https://api.chat-api.com/instance'.$this->instance.'/message?token='.$this->token;
        $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => json_encode($data)
        ]
        ]);
        $result = file_get_contents($url, false, $options);
    }
}

<?php

namespace App\Helpers\Xml;

class Xml
{
    public function loadFromString($xml)
    {
        return simplexml_load_string($xml);
    }

    public function enc($xml)
    {
        return json_decode(json_encode($xml),true);
    }

}

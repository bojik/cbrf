#!/usr/bin/env php
<?php

class Main
{
    /**
     * Url API CBR
     */
    const API_URL = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=%s';

    const TIMEOUT = 10;

    /**
     * @param string $date
     * @return false|string
     * @throws Exception
     */
    public function execute(string $date)
    {
        $date = (new DateTime($date))->format('d/m/Y');
        $url = sprintf(self::API_URL, $date);
        $context = stream_context_create(
            [
                'http' => [
                    'method' => "GET",
                    'timeout' => self::TIMEOUT
                ],
            ]
        );
        if (($xml = @file_get_contents($url, false, $context)) === false) {
            throw new Exception(error_get_last()['message']);
        }
        $object = simplexml_load_string($xml);
        return json_encode($object, JSON_PRETTY_PRINT);
    }
}

echo (new Main())->execute('-1 day');
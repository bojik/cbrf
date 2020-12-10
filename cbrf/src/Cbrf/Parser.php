<?php
declare(strict_types=1);

namespace App\Cbrf;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class Parser
{
    /**
     * Url API CBR
     */
    const API_URL = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=%s';

    const TIMEOUT = 15;

    /**
     * @param DateTime $dateTime
     * @return string
     * @throws GuzzleException
     */
    public function parse(DateTime $dateTime): string
    {
        $url = sprintf(self::API_URL, $dateTime->format('d/m/Y'));
        $client = new Client(['timeout' => self::TIMEOUT]);
        $xml = $client->get($url)->getBody()->getContents();
        $object = simplexml_load_string($xml);

        return json_encode($object, JSON_PRETTY_PRINT);
    }
}

<?php

namespace Mahesa\Verihubs\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
class VerificationManager
{
    protected static $headers = [];
    protected static $body = [];
    protected static $endpoint = 'https://api.verihubs.com/data-verification/certificate-electronic/verify'; // Default endpoint

    public static function setEndpoint($endpoint)
    {
        static::$endpoint = $endpoint;
        return new static;
    }

    public static function withHeaders(string $appId, string $apiKey)
    {
        static::$headers = [
            "app-id: $appId",
            "api-key: $apiKey"
        ];

        return new static;
    }

    public static function withBody(array $body)
    {
        static::$body = $body;
        return new static;
    }

    public static function sendRequest()
    {
        $client = new Client();

        try {
            $response = $client->post(static::$endpoint, [
                'headers' => static::$headers,
                'json' => static::$body,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            } else {
                return $e->getMessage();
            }
        }
    }
}

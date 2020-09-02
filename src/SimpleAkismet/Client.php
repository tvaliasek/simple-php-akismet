<?php

declare(strict_types=1);

namespace SimpleAkismet;

use GuzzleHttp\RequestOptions;
use SimpleAkismet\Exception\InvalidKeyException;
use SimpleAkismet\Exception\InvalidStatusCodeException;

class Client
{
    protected const USER_AGENT = 'PHP/SimplePHPAkismet';
    protected const HEADER_CONTENT_TYPE = 'Content-type';
    protected const CONTENT_TYPE = 'application/x-www-form-urlencoded';
    protected const HEADER_USER_AGENT = 'User-agent';
    protected const VERIFY_KEY_ENDPOINT = 'https://rest.akismet.com/1.1/verify-key';
    protected const RESPONSE_DEBUG_HEADER = 'X-akismet-debug-help';
    protected string $hostName;
    protected string $apiKey;

    public function __construct(
        string $apiKey,
        string $hostName
    ) {
        $this->apiKey = $apiKey;
        $this->hostName = $hostName;
    }

    public function verifyKey(): bool
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            self::VERIFY_KEY_ENDPOINT,
            [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => [
                    self::HEADER_CONTENT_TYPE => self::CONTENT_TYPE,
                    self::HEADER_USER_AGENT => self::USER_AGENT
                ]
            ]
        );
        if ($response->getStatusCode() > 204) {
            throw new InvalidStatusCodeException();
        }
        $body = $response->getBody()->getContents();
        $exceptionHeader = $response->getHeader(self::RESPONSE_DEBUG_HEADER) ?? null;
        if ($body !== 'valid') {
            throw new InvalidKeyException((!empty($exceptionHeader)) ? $exceptionHeader : 'Key is invalid');
        }
        return true;
    }

}
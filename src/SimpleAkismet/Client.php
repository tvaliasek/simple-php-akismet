<?php

declare(strict_types=1);

namespace SimpleAkismet;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use SimpleAkismet\DataObject\Message;
use SimpleAkismet\Exception\AkismetException;
use SimpleAkismet\Exception\InvalidKeyException;
use SimpleAkismet\Exception\InvalidStatusCodeException;

class Client
{
    protected const USER_AGENT = 'PHP/SimplePHPAkismet';
    protected const HEADER_CONTENT_TYPE = 'Content-type';
    protected const CONTENT_TYPE = 'application/x-www-form-urlencoded';
    protected const HEADER_USER_AGENT = 'User-agent';
    protected const ERROR_CODE_HEADER = 'X-akismet-alert-code';
    protected const ERROR_MESSAGE_HEADER = 'X-akismet-alert-msg';
    protected const VERIFY_KEY_ENDPOINT = 'https://rest.akismet.com/1.1/verify-key';
    protected const CHECK_ENDPOINT = 'https://%s.rest.akismet.com/1.1/comment-check';
    protected const SUBMIT_SPAM_ENDPOINT = 'https://%s.rest.akismet.com/1.1/submit-spam';
    protected const SUBMIT_HAM_ENDPOINT = 'https://%s.rest.akismet.com/1.1/submit-ham';
    protected const RESPONSE_DEBUG_HEADER = 'X-akismet-debug-help';
    protected string $hostName;
    protected string $apiKey;
    protected ClientInterface $client;

    public function __construct(
        string $apiKey,
        string $hostName,
        ClientInterface $client
    ) {
        $this->apiKey = $apiKey;
        $this->hostName = $hostName;
        $this->client = $client;
    }

    public function checkSpam(Message $message): bool
    {
        return $this->sendMessage($message, self::CHECK_ENDPOINT, 'true');
    }

    public function submitSpam(Message $message): bool
    {
        return $this->sendMessage($message, self::SUBMIT_SPAM_ENDPOINT, 'Thanks for making the web a better place.');
    }

    public function submitHam(Message $message): bool
    {
        return $this->sendMessage($message, self::SUBMIT_HAM_ENDPOINT, 'Thanks for making the web a better place.');
    }

    public function verifyKey(): bool
    {
        $client = $this->client;
        $response = $client->request(
            'POST',
            self::VERIFY_KEY_ENDPOINT,
            [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => [
                    self::HEADER_CONTENT_TYPE => self::CONTENT_TYPE,
                    self::HEADER_USER_AGENT => self::USER_AGENT
                ],
                RequestOptions::FORM_PARAMS => [
                    'key' => $this->apiKey,
                    'blog' => $this->hostName
                ]
            ]
        );
        $this->checkAkismetError($response);
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

    protected function sendMessage(Message $message, string $endpoint, string $responseString): bool
    {
        $response = $this->client->request(
            'POST',
            sprintf($endpoint, $this->apiKey),
            [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => [
                    self::HEADER_CONTENT_TYPE => self::CONTENT_TYPE,
                    self::HEADER_USER_AGENT => self::USER_AGENT
                ],
                RequestOptions::FORM_PARAMS => $message->toArray()
            ]
        );
        $this->checkAkismetError($response);
        if ($response->getStatusCode() > 204) {
            throw new InvalidStatusCodeException();
        }
        $body = $response->getBody()->getContents();
        return $body === $responseString;
    }

    protected function checkAkismetError(ResponseInterface $response): bool
    {
        $errorCode = $response->getHeader(self::ERROR_CODE_HEADER) ?? null;
        if ($errorCode !== null) {
            $errorMessage = $response->getHeader(self::ERROR_MESSAGE_HEADER);
            throw new AkismetException($errorMessage, $errorCode);
        }
        return false;
    }
}
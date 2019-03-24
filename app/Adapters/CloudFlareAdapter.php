<?php
namespace DnsUpdater\Adapters;

use GuzzleHttp\Client;
use Cloudflare\API\Auth\Auth;
use Cloudflare\API\Adapter\Guzzle;
use Psr\Http\Message\ResponseInterface;

class CloudFlareAdapter extends Guzzle
{
    private $client;

    /**
     * @inheritDoc
     */
    public function __construct(Auth $auth, string $baseUri = '')
    {
        if (!$baseUri) {
            $baseUri = 'https://api.cloudflare.com/client/v4/';
        }

        $headers = $auth->getHeaders();

        $this->client = new Client([
            'base_uri' => $baseUri,
            'headers' => $headers,
            'Accept' => 'application/json',
            'verify' => false,
        ]);
    }

    public function request(string $method, string $uri, array $data = [], array $headers = [])
    {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            throw new \InvalidArgumentException('Request method must be get, post, put, patch, or delete');
        }

        $response = $this->client->$method($uri, [
            'headers' => $headers,
            ($method === 'get' ? 'query' : 'json') => $data,
        ]);

        $this->checkError($response);

        return $response;
    }

    private function checkError(ResponseInterface $response)
    {
        $json = json_decode($response->getBody());

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JSONException();
        }

        if (isset($json->errors) && count($json->errors) >= 1) {
            throw new ResponseException($json->errors[0]->message, $json->errors[0]->code);
        }

        if (isset($json->success) && !$json->success) {
            throw new ResponseException('Request was unsuccessful.');
        }
    }
}

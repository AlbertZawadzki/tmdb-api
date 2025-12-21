<?php

namespace TmdbApi\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TmdbClient
{
    private array $params = [];

    public function __construct(
        private readonly string              $apiKey,
        private readonly HttpClientInterface $client,
    )
    {
        $this->clear();
    }

    private function clear(): void
    {
        $this->params = [
            'language' => 'en-US',
        ];
    }

    public function addParam(string $name, string $value): self
    {
        $this->params[$name] = $value;
        return $this;
    }

    private function getUrl(string $url): string
    {
        $paramsString = array_map(fn($key, $value) => "$key=$value", array_keys($this->params), $this->params);
        $paramsString = implode('&', $paramsString);
        if (!str_starts_with($url, '/')) {
            $url = '/' . $url;
        }

        return "https://api.themoviedb.org/3$url?$paramsString";
    }

    public function fetch(string $url): ResponseInterface
    {
        $absoluteUrl = $this->getUrl($url);

        $response = $this->client->request(
            'GET',
            $absoluteUrl,
            [
                'headers' => [
                    'Authorization' => "Bearer $this->apiKey",
                    'accept' => 'application/json',
                ],
            ]
        );

        $this->clear();

        return $response;
    }
}
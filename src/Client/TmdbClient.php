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
    }

    private function clear(): void
    {
        $this->params = [];
    }

    public function addParam(string $name, string $value): self
    {
        $this->params[] = "$name=$value";
        return $this;
    }

    private function getUrl(string $url): string
    {
        $paramsString = implode('&', $this->params);
        if (!str_starts_with($url, '/')) {
            $url = '/' . $url;
        }

        return "https://api.themoviedb.org/3$url?$paramsString";
    }

    public function fetch(string $url): ResponseInterface
    {
        $this->addParam('language', 'pl-PL');
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
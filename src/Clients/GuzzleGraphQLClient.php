<?php

namespace Kauanslr\GraphThing\Clients;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Kauanslr\GraphThing\Exceptions\GraphQLException;

class GuzzleGraphQLClient extends Client
{
    /** @var \Illuminate\Http\Response|\Illuminate\Foundation\Testing\TestResponse Save the http response */
    protected $response;

    private $guzzle;

    /**
     * WebTestGraphQLClient constructor.
     *
     * @param Application $app
     * @param string      $baseUrl
     */
    public function __construct(string $baseUrl)
    {
        $this->guzzle = new \GuzzleHttp\Client();
        parent::__construct($baseUrl);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function postQuery(array $data): void
    {
        $guzzleResponse = $this->guzzle->post($this->getBaseUrl(), [
            'headers' => $this->getHeaders(),
            'json' => $data
        ]);

        $httpResponse = new Response(
            $guzzleResponse->getBody()->getContents(),
            $guzzleResponse->getStatusCode(),
            $guzzleResponse->getHeaders()
        );

        $this->response = new TestResponse($httpResponse);
    }
}
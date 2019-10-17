<?php

namespace Kauanslr\GraphThing\Clients;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Kauanslr\GraphThing\Exceptions\GraphQLException;

/**
 * Class LaravelTestGraphQLClient
 */
class LaravelTestGraphQLClient extends Client
{
    use MakesHttpRequests;

    /** @var Application */
    private $app;

    /** @var \Illuminate\Http\Response|\Illuminate\Foundation\Testing\TestResponse Save the http response */
    protected $response;

    /**
     * WebTestGraphQLClient constructor.
     *
     * @param Application $app
     * @param string      $baseUrl
     */
    public function __construct(Application $app, string $baseUrl)
    {
        parent::__construct($baseUrl);

        $this->app = $app;
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \Kauanslr\GraphThing\Exceptions\GraphQLException
     */
    protected function postQuery(array $data): void
    {
        $this->response = $this->post($this->getBaseUrl(), $data, $this->getHeaders());
    }
}

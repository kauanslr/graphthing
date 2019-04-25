<?php

namespace Convenia\GraphQLClient;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Application;


/**
 * Class LaravelTestGraphQLClient
 *
 * @package parku\AppBundle\Tests\GraphQL
 */
class LaravelTestGraphQLClient extends Client
{
    use MakesHttpRequests;

    /** @var Application */
    private $app;

    /** @var Save the http response */
    private $response;

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

    protected function postQuery(array $data): array
    {
        $this->response = $this->post($this->getBaseUrl(), $data);

        if ($this->response->getStatusCode() >= 400) {
            throw new GraphQLException(sprintf(
                'Mutation failed with status code %d and error %s',
                $this->response->getStatusCode(),
                $this->response->getContent()
            ));
        }

        $responseBody = json_decode($this->response->getContent(), true);

        if (isset($responseBody['errors'])) {
            throw new GraphQLException(sprintf(
                'Mutation failed with error %s', json_encode($responseBody['errors'])
            ));
        }

        return $responseBody;
    }
}
<?php

namespace Kauanslr\GraphThing\Traits;

use Kauanslr\GraphThing\Field;
use Kauanslr\GraphThing\Query;
use Kauanslr\GraphThing\Clients\Client;
use Kauanslr\GraphThing\Clients\GuzzleGraphQLClient;
use Kauanslr\GraphThing\Clients\LaravelTestGraphQLClient;

/**
 * Trait MakeGraphQLRequests
 *
 * @package \Kauanslr\GraphThing\Traits
 */
trait MakeGraphQLRequests
{
    /**
     * @var \Kauanslr\GraphThing\Clients\Client $graphql
     */
    protected $graphql;

    /**
     * @var Query $query
     */
    private $query;

    /**
     * @param string $name Mutation Name
     * @param array $params Mutation parameters
     * @param array $fields Query fields
     * @param array $headers Custom headers
     *
     * @return mixed
     * @throws \Kauanslr\GraphThing\Exceptions\GraphQLException
     */
    protected function graphqlMutate(
        string $name,
        array $params,
        array $fields,
        $headers = []
    ) {
        $this->makeRequest($name, $params, $fields);

        return $this->graphql->setHeaders($headers)->mutate($this->query)
            ->getData();
    }

    /**
     * @param string $name Query Name
     * @param array $params Query parameters
     * @param array $fields Query fields
     * @param array $headers Custom headers
     *
     * @return mixed
     * @throws \Kauanslr\GraphThing\Exceptions\GraphQLException
     */
    protected function graphqlQuery(
        string $name,
        array $params,
        array $fields,
        $headers = []
    ) {
        $this->makeRequest($name, $params, $fields);

        return $this->graphql->setHeaders($headers)->query($this->query)
            ->getData();
    }

    /**
     * @param $fields
     */
    protected function assertGraphQLFields($fields)
    {
        $this->graphql->assertGraphQLFields($fields, $this->query);
    }

    /**
     * @param $name
     * @param $params
     * @param $fields
     *
     * @return \Kauanslr\GraphThing\Query
     */
    protected function createQuery($name, $params, $fields): Query
    {
        return new Query($name, $params, $this->mapFields($fields));
    }

    /**
     * @param string $name
     * @param array  $params
     * @param array  $fields
     */
    private function makeRequest(
        string $name,
        array $params,
        array $fields
    ) {
        $this->graphql = $this->getClient($this->endpoint ?? '/graphql');

        $fields = $this->mapFields($fields);

        $this->query = new Query($name, $params, $fields);
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    private function mapFields(array $fields): array
    {
        $f = [];

        foreach ($fields as $key => $value) {
            if (is_array($value)) {
                // Sub Query
                $params = $value['params'];
                unset($value['params']);
                $f[] = $this->createQuery($key, $params, $value);
                continue;
            }
            $f[] = new Field($value);
        }

        return $f;
    }

    protected function getClient(string $endpoint): Client
    {
        return $this->isInternal($endpoint)
            ? new LaravelTestGraphQLClient($this->app, $endpoint)
            : new GuzzleGraphQLClient($endpoint);
    }

    private function isInternal(string $endpoint): bool
    {
        $components = parse_url($endpoint);
        return empty($components['host']);
    }
}

<?php

namespace Kauanslr\GraphThing;

use \Kauanslr\GraphThing\Field;
use \Kauanslr\GraphThing\Query;

/**
 * Trait MakeGraphQLRequests
 *
 * @package \Kauanslr\GraphThing\Traits
 */
trait MakeGraphQLRequests
{
    /**
     * @var string $endpoint
     */
	protected $endpoint = '/graphql';

    /**
     * @var \Kauanslr\GraphThing\Client $graphql
     */
	protected $graphql;

    /**
     * @var Query $query
     */
    private $query;

    /**
     * @param string $name
     * @param array  $params
     * @param array  $fields
     *
     * @return mixed
     */
    protected function graphqlMutate(string $name, array $params, array $fields)
    {
        $this->makeRequest($name, $params, $fields);

       	return $this->graphql->mutate($this->query)->getData();
    }

    /**
     * @param string $name
     * @param array  $params
     * @param array  $fields
     *
     * @return mixed
     */
    protected function graphqlQuery(string $name, array $params, array $fields)
    {
        $this->makeRequest($name, $params, $fields);

        return $this->graphql->query($this->query)->getData();
    }

    /**
     * @param string $name
     * @param array  $params
     * @param array  $fields
     */
    private function makeRequest(string $name, array $params, array $fields) {
        $this->graphql = new \Kauanslr\GraphThing\LaravelTestGraphQLClient(
          $this->app,
            $this->endpoint
        );

        $params = $params;

        $fields = $this->mapFields($fields);

        $this->query = new Query($name, $params, $fields);
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
    protected function createQuery($name, $params, $fields): Query {
    	return new Query($name, $params, $this->mapFields($fields));
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    private function mapFields(array $fields): array {
    	$f = [];

    	foreach ($fields as $key => $value) {
    		if(is_array($value)) {
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
}

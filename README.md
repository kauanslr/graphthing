# GraphThing

---

## Instalação - PT-BR

### Composer

Para instalar adicione o seguinte código em seu ```composer.json```

```json
{
    "require": {
        "kauanslr/graphthing": "^0"
    }
}

```

Depois execute ```$ composer update```

ou apenas execute ```$ composer require --dev kauanslr/graphthing```

## Utilização

```php
use Kauanslr\GraphThing\Traits\MakeGraphQLRequests;

class TestMyGraphQL extends TestCase
{
    use MakeGraphQLRequests;

  /** @var Endpoint */
  protected $endpoint = '/your_graphql_endpoint' //Default '/graphql';
  
  public function test_my_first_mutation_endpoint() {
    // Parametros para mutação
    $params = [
        'field' => 'My first endpoint test',
    ];

    // Campos para serem retornados
    $query = ['field_1','field_2', 'field_3'];

    // Campos retornados pela query
    $fields = $this->graphqlMutate('mutationName', $params, $query);

    //  Verifica se todos os campos solicitados foram retornados
    $this->assertGraphQLFields($fields);
  }

  public function test_my_sub_queries_endpoint() {
    // Os parâmetros para a query principal
    $queryParams = [];

    // Campos para serem retornados
    $query = [
        'field_1',
        'field_2',
        'subQueryName' => [
            'params' => [
                'sub_query_param' => 'value'
            ],
            'sub_field_1',
            'sub_field_2',
            'sub_field_3',
        ]
    ];

    // Campos retornados pela query
    $fields = $this->graphqlQuery('queryName', $params, $query, $headers);

    //  Verifica se todos os campos solicitados foram retornados
    $this->assertGraphQLFields($fields);
  }
}
```

Também é possível utilizar a interface padrão do Laravel para Request Testing:

```php
use Kauanslr\GraphThing\Traits\MakeGraphQLRequests;

class TestMyGraphQL extends TestCase
{
    use MakeGraphQLRequests;

  /** @var Endpoint */
  protected $endpoint = '/your_graphql_endpoint' //Default '/graphql';

  public function test_my_first_mutation_endpoint() {
    // Parametros para mutação
    $params = [];

    // Campos para serem retornados
    $query = ['field_1'];

    // Campos retornados pela query
    $fields = $this->graphqlMutate('mutationName', $params, $query);

    //  Retorna uma instancia de \Illuminate\Foundation\Testing\TestResponse
    $response = $this->graphql->getResponse();
    $response->assertStatusCode(403);
  }
}
```

---

## Installation - EN

### Composer

Just add the bellow code to your ```composer.json```

```json
{
    "require": {
        "kauanslr/graphthing": "^0"
    }
}

```

And run ```$ composer update```

or just run ```$ composer require --dev kauanslr/graphthing```

## Using

```php
use Kauanslr\GraphThing\Traits\MakeGraphQLRequests;

class TestMyGraphQL extends TestCase
{
    use MakeGraphQLRequests;

  /** @var Endpoint */
  protected $endpoint = '/your_graphql_endpoint' //Default '/graphql';
  
  public function test_my_first_mutation_endpoint() {
    // MUtation parameters
    $params = [
        'field' => 'My first endpoint test',
    ];

    // To return fields
    $query = ['field_1','field_2', 'field_3'];

    // Get the query result
    $fields = $this->graphqlMutate('mutationName', $params, $query);

    // Check if requested fields is was returned
    $this->assertGraphQLFields($fields);
  }

  public function test_my_sub_queries_endpoint() {
    // Principal query parameters
    $queryParams = [];

    // Requesting fields
    $query = [
        'field_1',
        'field_2',
        'subQueryName' => [
            'params' => [
                'sub_query_param' => 'value'
            ],
            'sub_field_1',
            'sub_field_2',
            'sub_field_3',
        ]
    ];

    // Get query results
    $fields = $this->graphqlQuery('queryName', $params, $query, $headers);

    // Check if requested fields is was returned
    $this->assertGraphQLFields($fields);
  }
}
```

Is also possible to use the Laravel Request testing interface:

```php
use Kauanslr\GraphThing\Traits\MakeGraphQLRequests;

class TestMyGraphQL extends TestCase
{
    use MakeGraphQLRequests;

  /** @var Endpoint */
  protected $endpoint = '/your_graphql_endpoint' //Default '/graphql';

  public function test_my_first_mutation_endpoint() {
    // Mutation parameters
    $params = [];

    // Query fields
    $query = ['field_1'];

    // Execute mutation
    $fields = $this->graphqlMutate('mutationName', $params, $query);

    //Reutur \Illuminate\Foundation\Testing\TestResponse instance
    $response = $this->graphql->getResponse();
    $response->assertStatusCode(403);
  }
}
```

# GraphThing

---

## Instalação

### Composer

Para instalar adicione o seguinte código em seu ```composer.json```

```json
{
    "require": {
        "kauanslr/graphthing": "^0"
    }
}

```

Depois execute ```composer update```

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

Também é possível utilizar as respostas utilizando a interface padrão do Laravel:

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

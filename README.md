# graphql-php-query-builder
PHP Query Builder for GraphQL
====

Simple QueryBuilder to deconstruct array and return GraphQL string can be used to request GraphQL server

Build a QueryBuilder object:

    $query = new QueryBuilder();

Build query, set Requesting field, arguments and query type:

    $query->setField('content');
    $query->setArguments(['id' => '123']);
    $query->setType('query');
    $query->setObject([
        'id',
        'data',
        'detail' => [
            'name',
            'model',
            'year'
            ]
    ]);

Render query and format the string:

    $queryString= $query->buildQuery();

Results in:

    query{
        content(id: "123") {
            id
            data
            detail {
                name
                model
                year
            }
        }
    }

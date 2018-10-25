# graphql-php-query-builder
[![Build Status](https://travis-ci.com/Hearst-Hatchery/graphql-php-query-builder.svg?branch=master)](https://travis-ci.com/Hearst-Hatchery/graphql-php-query-builder)
[![codecov](https://codecov.io/gh/Hearst-Hatchery/graphql-php-query-builder/branch/master/graph/badge.svg)](https://codecov.io/gh/Hearst-Hatchery/graphql-php-query-builder)

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

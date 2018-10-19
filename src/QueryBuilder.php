<?php
namespace GraphQLQueryBuilder;

/**
 * Class QueryBuilder
 *
 * QueryBuilder is a php helper that deconstruct array to build graphQL query
 * than can communicate with graphQL server
 */
class QueryBuilder
{
    /**
     * String of graphQL fields that can refer to Objects
     * @var string
     */
    public $field;

    public function __construct($field = '')
    {
        $this->field = $field;
    }
}

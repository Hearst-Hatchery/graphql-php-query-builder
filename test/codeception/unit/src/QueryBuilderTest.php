<?php
namespace GraphQLQueryBuilder\Tests;

use GraphQLQueryBuilder\QueryBuilder;

/**
 *  @coversDefaultClass GraphQLClient\Client
 */
class QueryBuilderTest extends \Codeception\Test\Unit
{
    protected function _before()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    protected function _after()
    {
        // unset the blank class after each test
        unset($this->queryBuilder);
    }
}

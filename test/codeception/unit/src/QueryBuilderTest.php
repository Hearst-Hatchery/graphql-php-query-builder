<?php
namespace GraphQLQueryBuilder\Tests;

use GraphQLQueryBuilder\QueryBuilder;

/**
 *  @coversDefaultClass GraphQLQueryBuilder\QueryBuilder
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

    /**
     * testConstruct tests that the __construct method
     * properly sets up various class properties.
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        verify($this->queryBuilder->field)->equals('');
    }
}

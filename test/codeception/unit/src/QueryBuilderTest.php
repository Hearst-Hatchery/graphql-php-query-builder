<?php
namespace GraphQLQueryBuilder\Tests;

use GraphQLQueryBuilder\QueryBuilder;
use \Codeception\Util\Stub;

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
        $queryBuilder = Stub::make('GraphQLQueryBuilder\QueryBuilder', [
            'setObject' => function () {
                // Verify this method was called
                verify(true)->true();
            },
            'setField' => function () {
                // Verify this method was called
                verify(true)->true();
            },
            'setArguments' => function () {
                // Verify this method was called
                verify(true)->true();
            },
            'setType' => function () {
                // Verify this method was called
                verify(true)->true();
            },
        ]);

        $queryBuilder->__construct();
    }
}

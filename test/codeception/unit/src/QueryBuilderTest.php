<?php
namespace GraphQLQueryBuilder\Tests;

use GraphQLQueryBuilder\QueryBuilder;
use \Codeception\Util\Stub;

/**
 *  @coversDefaultClass GraphQLQueryBuilder\QueryBuilder
 */
class QueryBuilderTest extends \Codeception\Test\Unit
{
    // An instance of the behavior to be tested
    private $queryBuilder;
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->querybuilder = Stub::make('GraphQLQueryBuilder\QueryBuilder');
    }

    protected function _after()
    {
        // unset the blank class after each test
        unset($this->querybuilder);
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

    /**
     * testSetObject tests that setObject set array object to current QueryBuilder
     *
     * @covers ::setObject()
     */
    public function testSetObject()
    {
        $object = ['id' => 123, 'data'];
        $output = $this->querybuilder->setObject($object);
        verify($output)->equals($this->querybuilder);
    }

    /**
     * testSetField tests that setField set field string to current QueryBuilder
     *
     * @covers ::setField()
     */
    public function testSetField()
    {
        $field = 'foo';
        $output = $this->querybuilder->setField($field);
        verify($output)->equals($this->querybuilder);
    }

    /**
     * testSetArguments tests that setArguments set arguments to current QueryBuilder
     *
     * @covers ::setArguments()
     */
    public function testSetArguments()
    {
        $arguments = ['id' => 123];
        $output = $this->querybuilder->setArguments($arguments);
        verify($output)->equals($this->querybuilder);
    }

    /**
     * testSetType tests that setType set type string to current QueryBuilder
     *
     * @covers ::setType()
     */
    public function testSetType()
    {
        $type = 'query';
        $output = $this->querybuilder->setType($type);
        verify($output)->equals($this->querybuilder);
    }
}

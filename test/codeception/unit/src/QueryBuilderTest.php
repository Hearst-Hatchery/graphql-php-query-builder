<?php
namespace GraphQLQueryBuilder\Tests;

use GraphQLQueryBuilder\QueryBuilder;
use Codeception\Util\Stub;
use Codeception\Util\ReflectionHelper;

/**
 *  @coversDefaultClass GraphQLQueryBuilder\QueryBuilder
 */
class QueryBuilderTest extends \Codeception\Test\Unit
{
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
            'setQueryObject' => function () {
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
     * testBuildQuery tests that buildQuery returns graphQL query
     *
     * @covers ::buildQuery()
     */
    public function testBuildQuery()
    {
        $arguments = ['id' => 123];
        $object = ['id' => 123, 'type', 'data' => ['size', 'date']];

        $this->querybuilder->setQueryObject($object);
        $this->querybuilder->setArguments($arguments);
        $this->querybuilder->setField('image');
        $this->querybuilder->setType('query');

        $output = $this->querybuilder->buildQuery();
        $expected = <<<Query
{
	image (id: "123") {
		id{
			123
		}
		type
		data{
			size
			date
		}
	}
}
Query;
        expect($output)->equals($expected);
    }

    /**
     * testBuildQueryEmpty tests that buildQuery returns empty string when no array passing to be converted
     *
     * @covers ::buildQuery()
     */
    public function testBuildQueryEmpty()
    {
        $object = '';

        $this->querybuilder->setQueryObject($object);

        $output = $this->querybuilder->buildQuery();

        expect($output)->equals('');
    }

    /**
     * testFormatArguments tests that formatArguments format arguments array that is ready to merge into graphQL query
     *
     * @covers ::formatArguments()
     * @dataProvider argumentsProvider
     */
    public function testFormatArguments($arguments, $expected)
    {
        $output = ReflectionHelper::invokePrivateMethod($this->querybuilder, 'formatArguments', [$arguments]);
        expect($output)->equals($expected);
    }

    public function argumentsProvider()
    {
        return [
            'no arguments passed in' => [
                'arguments' => [],
                'expected' => '',
            ],
            'simple array, singular argument pass in' => [
                'arguments' => [
                    'id' => 123,
                ],
                'expected' => '(id: "123") ',
            ],
            'multi arguments array passed in' => [
                'arguments' => [
                    'ids' => [
                        123,
                        456,
                    ],
                    'type' => 'image',
                ],
                'expected' => '(ids: ["123","456"], type: "image") ',
            ],
        ];
    }

    /**
     * testRenderQueryObject tests that renderQueryObject
     *
     * @covers ::renderQueryObject()
     * @dataProvider queryObjectProvider
     */
    public function testRenderQueryObject($queryObject, $expected)
    {
        $output = ReflectionHelper::invokePrivateMethod($this->querybuilder, 'renderQueryObject', [$queryObject]);
        expect($output)->equals($expected);
    }

    public function queryObjectProvider()
    {
        return [
            'empty array passed in' => [
                'queryObject' => [],
                'expected' => '',
            ],
            'simple array, singular argument pass in' => [
                'queryObject' => [
                    'id',
                    'type',
                ],
                'expected' => "id\ntype\n",
            ],
            'multi arguments array passed in' => [
                'queryObject' => [
                    'id' => 123,
                    'type' => [
                        'image',
                        'video',
                    ],
                    'date',
                ],
                'expected' => "id{\n\t123\n}\ntype{\n\timage\n\tvideo\n}\ndate\n",
            ],
        ];
    }

    /**
     * testSetObject tests that setObject set array object to current QueryBuilder
     *
     * @covers ::setQueryObject()
     */
    public function testSetObject()
    {
        $object = ['id' => 123, 'data'];
        $output = $this->querybuilder->setQueryObject($object);
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

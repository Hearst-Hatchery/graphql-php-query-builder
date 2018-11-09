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
            'setObjectField' => function () {
                // Verify this method was called
                verify(true)->true();
            },
            'setArguments' => function () {
                // Verify this method was called
                verify(true)->true();
            },
            'setQueryType' => function () {
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
        $arguments = ['id' => 'foo'];
        $object = ['id' => 123, 'type', 'data' => ['size', 'date']];

        $this->querybuilder->setQueryObject($object);
        $this->querybuilder->setArguments($arguments);
        $this->querybuilder->setObjectField('image');
        $this->querybuilder->setQueryType('query');

        // test query result when prettify is true
        $outputPrettify = $this->querybuilder->buildQuery(true);
        $expected = <<<Query
query {
	image (id: "foo") {
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

        expect($outputPrettify)->equals($expected);

        // test query result when prettify is false
        $output = $this->querybuilder->buildQuery(false);
        $expected = "query {\nimage (id: \"foo\") {\nid{\n123\n}\ntype\ndata{\nsize\ndate\n}\n}\n}";
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
                    'id' => '123',
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
                'expected' => '(ids: [123,456], type: "image") ',
            ],
        ];
    }

    /**
     * testRenderQueryObject tests that renderQueryObject format array object into graphql query without tabs
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
                'expected' => "id{\n123\n}\ntype{\nimage\nvideo\n}\ndate\n",
            ],
        ];
    }

    /**
     * testRenderQueryObjectPrettify tests that renderQueryObjectPrettify format array object into
     * pretty graphql format string with tabs
     *
     * @covers ::renderQueryObjectPrettify()
     * @dataProvider queryObjectPrettifyProvider
     */
    public function testRenderQueryObjectPrettify($queryObject, $expected)
    {
        $output = ReflectionHelper::invokePrivateMethod($this->querybuilder, 'renderQueryObjectPrettify', [$queryObject]);
        expect($output)->equals($expected);
    }

    public function queryObjectPrettifyProvider()
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
     * testSetQueryObject tests that setObject set array object to current QueryBuilder
     *
     * @covers ::setQueryObject()
     */
    public function testSetQueryObject()
    {
        $object = ['id' => 123, 'data'];
        $output = $this->querybuilder->setQueryObject($object);
        verify($output)->equals($this->querybuilder);
    }

    /**
     * testSetObjectField tests that setObjectField set field string to current QueryBuilder
     *
     * @covers ::setObjectField()
     */
    public function testSetObjectField()
    {
        $field = 'foo';
        $output = $this->querybuilder->setObjectField($field);
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
     * testSetQueryType tests that setQueryType set type string to current QueryBuilder
     *
     * @covers ::setQueryType()
     */
    public function testSetQueryType()
    {
        $type = 'query';
        $output = $this->querybuilder->setQueryType($type);
        verify($output)->equals($this->querybuilder);
    }
}

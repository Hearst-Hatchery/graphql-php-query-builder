<?php

namespace GraphQLQueryBuilder\Tests;

use Codeception\Util\Stub;

/**
 *  @coversDefaultClass GraphQLQueryBuilder\Field
 */
class FieldTest extends \Codeception\Test\Unit
{
    /**
     * testConstruct tests that the __construct method
     * properly sets up various class properties.
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $field = Stub::make('GraphQLQueryBuilder\Field', [
            'setAliases' => function () {
                // Verify this method was called
                verify(true)->true();
            },
        ]);

        $field->__construct();
    }

    /**
     * testSetAlias tests that setAlias set field with alias
     *
     * @covers ::setAlias()
     */
    public function testSetAlias()
    {
        $field = Stub::make('GraphQLQueryBuilder\Field');
        $output = $field->setAlias('foo');
        verify($output)->equals($field);
    }

    /**
     * testBuildQuery tests that buildQuery returns graphQL query
     *
     * @covers ::buildQuery()
     */
    public function testBuildQuery()
    {
        $arguments = ['id' => 123];
        $queryObject = ['id' => 123, 'type', 'data' => ['size', 'date']];
        $objectField = 'test';

        $field = Stub::make('GraphQLQueryBuilder\Field');

        $field->setAlias('alias');
        $field->setQueryObject($queryObject);
        $field->setArguments($arguments);
        $field->setObjectField($objectField);

        $output = $field->buildQuery();
        $expected = <<<Query
alias:test (id: "123") {
	id{
		123
	}
	type
	data{
		size
		date
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

        $field = Stub::make('GraphQLQueryBuilder\Field');
        $field->setQueryObject($object);

        $output = $field->buildQuery();

        expect($output)->equals('');
    }
}

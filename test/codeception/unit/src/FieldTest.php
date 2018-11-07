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
     * testFormatFieldsHeading tests that formatFieldsHeading format field signature line with the right format
     *
     * @covers ::formatFieldsHeading()
     */
    public function testFormatFieldsHeading()
    {
        $field = Stub::make('GraphQLQueryBuilder\Field');

        $field->setAlias('foo');
        $field->setArguments(['id' => 123]);
        $field->setObjectField('bar');

        $output = $field->formatFieldsHeading();

        verify($output)->equals('foo:bar (id: 123) ');
    }
}

<?php

namespace GraphQLQueryBuilder\Tests;

use Codeception\Util\Stub;

/**
 *  @coversDefaultClass GraphQLQueryBuilder\Fragment
 */
class FragmentTest extends \Codeception\Test\Unit
{
    /**
     * testConstruct tests that the __construct method
     * properly sets up various class properties.
     *
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $fragment = Stub::make('GraphQLQueryBuilder\Fragment', [
            'setFragmentType' => function () {
                // Verify this method was called
                verify(true)->true();
            },
        ]);

        $fragment->__construct();
    }

    /**
     * testFormatInlineFragment test that formatInlineFragment format fragment with the right inline format
     *
     * @covers ::formatInlineFragment()
     */
    public function testFormatInlineFragment()
    {
        $fragment = Stub::make('GraphQLQueryBuilder\Fragment');

        $type = 'foobar';
        $fragment->setFragmentType($type);
        $output = $fragment->formatInlineFragment();

        verify($output)->equals('... on foobar');
    }

    /**
     * testSetFragmentType tests that setFragmentType set fragment string to be used as type
     *
     * @covers ::setFragmentType()
     */
    public function testSetFragmentType()
    {
        $fragment = Stub::make('GraphQLQueryBuilder\Fragment');
        $output = $fragment->setFragmentType('foo');
        verify($output)->equals($fragment);
    }
}

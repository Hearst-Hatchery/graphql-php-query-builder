<?php

namespace GraphQLQueryBuilder;

/**
 * Class Fragment
 *
 * Fragment is a class that is used to build a fragment that will be part of query body
 * fragment can has it's own defined fields
 */
class Fragment extends QueryBuilder
{
    /**
     * String of type that need to be converted and built as graphQL server supported query
     * @var string
     */
    protected $type;

    /**
     * Fragment constructor
     *
     * @param string $type
     */
    public function __construct($type = '')
    {
        $this->type = $type;
    }

    /**
     * formatInlineFragment is to format inline fragment
     * and return the string that can be formatted along with query
     * @return string fragment string
     */
    protected function formatInlineFragment()
    {
        return '... on ' . $this->type;
    }
}

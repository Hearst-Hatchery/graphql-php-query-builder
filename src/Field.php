<?php

namespace GraphQLQueryBuilder;

/**
 * Class Field
 *
 * Field is a class that is used to build specific fields on object with that will be part of query body
 * Field extends all queryBuilder feature and adds Aliases that can be used to build query as nested field
 */
class Field extends QueryBuilder
{
    /**
     * String of alias that can be added to the field as part of query
     * @var string
     */
    protected $alias;

    /**
     * Field constructor
     *
     * @param string $alias
     */
    public function __construct($alias = '')
    {
        $this->setAliases($alias);
    }

    /**
     * setAliases is to set aliases for defined field
     * so directly query for the same field wth different arguments can be sent the same time
     *
     * @param string $alias
     * @return Field
     */
    public function setAliases($alias)
    {
        $this->alias = $alias ?? '';
        return $this;
    }

    /**
     * buildQuery format query type, field, arguments and rendered query string to build full query
     * that can be used for requesting graphQL server
     *
     * @param string $operationName
     * @param int $depth
     * @return string GraphQl query string
     */
    public function buildQuery($operationName = '', $depth = 1)
    {
        if (empty($this->queryObject)) {
            return '';
        }

        $fieldQuery = $this->objectField;
        $fieldQuery .= $this->arguments ? ' ' . $this->formatArguments($this->arguments) . "{\n" : "{\n";
        $fieldQuery .= $this->alias ? $this->alias . ':' : '';
        $fieldQuery .= $this->renderQueryObject($this->queryObject, $depth);
        $fieldQuery .= str_repeat("\t", $depth - 1) . '}';

        return $fieldQuery;
    }
}

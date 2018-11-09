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
     * @param array  $arguments
     * @param string $objectField
     */
    public function __construct($alias = '', $arguments = [], $objectField = '')
    {
        $this->setAlias($alias);
        $this->setArguments($arguments);
        $this->setObjectField($objectField);
    }

    /**
     * setAliases is to set aliases for defined field
     * so directly query for the same field wth different arguments can be sent the same time
     *
     * @param string $alias
     * @return Field
     */
    public function setAlias($alias)
    {
        $this->alias = $alias ?? '';
        return $this;
    }

    /**
     * formatFieldsHeading is to format heading signature for field
     * and return the string that can be formatted along with query
     *
     * @return string field string
     */
    public function formatFieldsHeading()
    {
        $fieldsHeading = $this->alias ? $this->alias . ':' : '';
        $fieldsHeading .= $this->objectField;
        $fieldsHeading .= $this->arguments ? ' ' . $this->formatArguments($this->arguments): '';

        return $fieldsHeading;
    }
}

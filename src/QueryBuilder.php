<?php

namespace GraphQLQueryBuilder;

/**
 * Class QueryBuilder
 *
 * QueryBuilder is a php helper that deconstruct array to build graphQL query
 * than can communicate with graphQL server
 */
class QueryBuilder
{
    /**
     * PHP array that need to be converted and built as graphQL server supported query
     * @var array
     */
    protected $queryObject;

    /**
     * String of graphQL objectField that can refer to Objects type defined in graphql server
     * @var string
     */
    protected $objectField;

    /**
     * Set of arguments for fetching data eg. content(ID: '1234')
     * @var array
     */
    protected $arguments;

    /**
     * String of graphQL request type that can
     * @var string
     */
    protected $queryType;

    const TYPE_QUERY = 'query';
    const TYPE_MUTATION = 'mutation';

    /**
     * QueryBuilder constructor
     *
     * @param string $objectField
     * @param array  $arguments
     * @param array  $query
     * @param string $queryType
     */
    public function __construct($objectField = '', $arguments = [], $query = [], $queryType = self::TYPE_QUERY)
    {
        $this->setObjectField($objectField);
        $this->setArguments($arguments);
        $this->setQueryObject($query);
        $this->setQueryType($queryType);
    }

    /**
     * buildQuery format query type, field, arguments and rendered query string to build full query
     * that can be used for requesting graphQL server
     *
     * @param boolean $prettify
     * @param string $operationName
     * @return string GraphQl query string
     */
    public function buildQuery($prettify = false, $operationName = '')
    {
        if (empty($this->queryObject)) {
            return '';
        }

        $tab = $prettify === true ? "\t" : '';

        $graphQLQuery = $this->queryType ? $this->queryType . ' ' : 'query ';
        $graphQLQuery .= $operationName ? $operationName : '';

        $graphQLQuery .= "{\n" . $tab . $this->objectField;
        $graphQLQuery .= $this->arguments ? ' ' . $this->formatArguments($this->arguments) . "{\n" : "{\n";
        $graphQLQuery .= $prettify === true ? $this->renderQueryObjectPrettify($this->queryObject, 2) : $this->renderQueryObject($this->queryObject);
        $graphQLQuery .= $tab . "}\n}";

        return $graphQLQuery;
    }

    /**
     * renderQueryObject loop through given query array and convert into graphQL query format string
     *
     * @param array $query
     * @return string rendered query string
     */
    protected function renderQueryObject($query = [])
    {
        $queryString = '';

        foreach ($query as $queryField => $queryFieldValue) {
            // recursive loop through every node
            if (!is_numeric($queryField)) {
                $queryString .= $queryField . "{\n";

                if (is_array($queryFieldValue)) {
                    $queryString .= $this->renderQueryObject($queryFieldValue);
                } else {
                    $queryString .= $queryFieldValue . "\n";
                }
                $queryString .= "}\n" ;
            } else {
                $queryString .= $queryFieldValue . "\n";
            }
        }

        return $queryString;
    }

    /**
     * renderQueryObjectPrettify loop through given query array and convert into graphQL query format string
     *
     * @param array $query
     * @param int $tabCount
     * @return string rendered query string
     */
    protected function renderQueryObjectPrettify($query = [], $tabCount = 0)
    {
        $queryString = '';
        $tab = "\t";

        foreach ($query as $queryField => $queryFieldValue) {
            // recursive loop through every node
            if (!is_numeric($queryField)) {
                $queryString .= str_repeat($tab, $tabCount) . $queryField . "{\n";
                $tabCount++;

                if (is_array($queryFieldValue)) {
                    $queryString .= $this->renderQueryObjectPrettify($queryFieldValue, $tabCount);
                } else {
                    $queryString .= str_repeat($tab, $tabCount) . $queryFieldValue . "\n";
                }
                $tabCount--;
                $queryString .= str_repeat($tab, $tabCount) . "}\n" ;
            } else {
                $queryString .= str_repeat($tab, $tabCount) . $queryFieldValue . "\n";
            }
        }

        return $queryString;
    }

    /**
     * formatArguments loop through arguments array and format it to be ready to concatenate with query string
     * @param array $arguments
     * @return string formatted arguments string
     */
    protected function formatArguments($arguments)
    {
        if ($arguments) {
            $formattedArgument = [];
            foreach ($arguments as $name => $type) {
                if (is_array($type)) {
                    if (count($type) > 0 && is_string($type[0])) {
                        $type = '["' . implode('","', $type) . '"]';
                    } else {
                        $type = '[' . implode(',', $type) . ']' ;
                    }
                } else {
                    $type = gettype($type) === 'string' ? '"' . $type . '"' : $type ;
                }
                $formattedArgument[] = $name . ': ' . $type;
            }
            return '(' . implode(', ', $formattedArgument) . ') ';
        }
        return '';
    }

    /**
     * @param array $queryObject
     * @return QueryBuilder
     */
    public function setQueryObject($queryObject)
    {
        $this->queryObject = $queryObject ?? [];
        return $this;
    }

    /**
     * @param string $objectField
     * @return QueryBuilder
     */
    public function setObjectField($objectField)
    {
        $this->objectField = $objectField ?? '';
        return $this;
    }

    /**
     * @param array $arguments
     * @return QueryBuilder
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments ?? [];
        return $this;
    }

    /**
     * @param string $queryType
     * @return QueryBuilder
     */
    public function setQueryType($queryType)
    {
        $this->queryType = $queryType ?? '';
        return $this;
    }
}

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
    protected $object;

    /**
     * String of graphQL fields that can refer to Objects
     * @var string
     */
    protected $field;

    /**
     * Set of arguments for fetching data eg. content(ID: '1234')
     * @var array
     */
    protected $arguments;

    /**
     * String of graphQL request type that can
     * @var string
     */
    protected $type;

    // TODO: Add Fragments & Variables for full query and mutation
    const TYPE_QUERY = 'query';
    const TYPE_MUTATION = 'mutation';

    /**
     * QueryBuilder constructor
     *
     * @param array $queryObject
     * @param string $field
     * @param array $arguments
     * @param string $type
     */
    public function __construct($queryObject = [], $field = '', $arguments = [], $type = self::TYPE_QUERY)
    {
        $this->setObject($queryObject);
        $this->setField($field);
        $this->setArguments($arguments);
        $this->setType($type);
    }

    /**
     * buildQuery format query type, field, arguments and rendered query string to build full query
     * that can be used for requesting graphql server
     * @return string GraphQl query string
     */
    public function buildQuery()
    {
        if (empty($this->object)) {
            return '';
        }

        $graphQLQuery = $this->type . "{\n\t" . $this->field;
        $graphQLQuery .= $this->arguments ? ' ' . $this->formatArguments($this->arguments) . "{\n" : "{\n";
        $graphQLQuery .= $this->renderQueryObject($this->object, 2);
        $graphQLQuery .= "\t}\n}\n";

        return $graphQLQuery;
    }

    /**
     * renderQueryObject loop through given array and convert into graphql query format string
     * @return string rendered query string
     */
    protected function renderQueryObject($queryObject = [], $tabCount = 1)
    {
        $query = '';
        $tab = "\t";

        foreach ($queryObject as $queryField => $queryFieldValue) {
            // recursive loop through every node
            if (is_array($queryFieldValue)) {
                $query .= str_repeat($tab, $tabCount) . $queryField . "{\n";
                $tabCount++;
                $query .= $this->renderQueryObject($queryFieldValue, $tabCount);
                $tabCount--;
                $query .= str_repeat($tab, $tabCount) . "}\n" ;
            } else {
                $query .= str_repeat($tab, $tabCount) . $queryFieldValue . "\n";
            }
        }

        return $query;
    }

    /**
     * formatArguments loop through arguments array and format it to be ready to concatenate with query string
     * @return string formatted arguments string
     */
    protected function formatArguments($arguments)
    {
        if ($arguments) {
            $formattedArgument = [];
            foreach ($arguments as $name => $type) {
                if (is_array($type)) {
                    $type = '["' . implode('","', $type) . '"]';
                } else {
                    $type = '"' . $type . '"';
                }
                $formattedArgument[] = $name . ': ' . $type;
            }
            return '(' . implode(', ', $formattedArgument) . ') ';
        }
        return '';
    }

    /**
     * @param array $object
     * @return QueryBuilder
     */
    public function setObject($object)
    {
        $this->object = $object ?? [];
        return $this;
    }

    /**
     * @param string $field
     * @return QueryBuilder
     */
    public function setField($field)
    {
        $this->field = $field ?? '';
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
     * @param string $type
     * @return QueryBuilder
     */
    public function setType($type)
    {
        $this->type = $type ?? '';
        return $this;
    }
}

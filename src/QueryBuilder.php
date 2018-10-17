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
     * QueryBuilder constructor.
     *
     * @param array $queryObject
     * @param string $field
     * @param array $arguments
     * @param string $type
     */
    public function __construct($queryObject = [], $field = '', $arguments = [], $type = self::TYPE_QUERY)
    {
        $this->object = $queryObject;
        $this->field = $field;
        $this->arguments = $arguments;
        $this->type = $type;
    }

    protected function buildQuery()
    {
        if (empty($this->object)) {
            return '';
        }

        $graphQLQuery = $this->type . "{\n" . $this->field; //content
        $graphQLQuery .= $this->arguments ? ' ' . $this->formatArguments($this->arguments) . "{\n" : "{\n";
        $graphQLQuery .= $this->renderQueryObject($this->object);
        $graphQLQuery .= "}\n";

        return $graphQLQuery;
    }

    protected function renderQueryObject($queryObject = [])
    {
        $query = '';

        foreach ($queryObject as $queryField) {
            // recursive loop through every node
            if (is_array($queryField)) {
                $query .= $this->renderQueryObject($queryField);
            } else {
                $query .= $queryField . "\n";
            }
        }

        return $query;
    }

    protected function formatArguments($arguments)
    {
        if ($arguments) {
            $formattedArgument = [];
            foreach ($arguments as $name => $type) {
                if (is_array($type)) {
                    $type = '[' . implode(',', $type) . ']';
                }
                $formattedArgument[] = $name . ': ' . $type;
            }
            return '(' . implode(', ', $formattedArgument) . ') ';
        }
        return '';
    }

    /**
     * @param array $arguments
     * @return QueryBuilder
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }
}

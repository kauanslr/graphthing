<?php

namespace Kauanslr\GraphThing;

class Query extends Field
{
    /**
     * @var array
     */
    private $params;

    /**
     * Query constructor.
     *
     * @param string $name
     * @param array  $params
     * @param array  $fields
     */
    public function __construct(
        string $name,
        array $params = [],
        array $fields = []
    ) {
        parent::__construct($name, $fields);
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array|Variable[] $variables
     *
     * @return string
     */
    public function getQueryHeader(array $variables)
    {
        if (!count($variables)) {
            return '';
        }

        $result = 'Header(';
        foreach ($variables as $key => $variable) {
            $result .= '$'.$key.': '.$variable->getType();
        }

        $result .= ')';

        return $result;
    }
}

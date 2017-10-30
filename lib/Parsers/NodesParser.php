<?php
namespace YarnResourceManager\Parsers;

use YarnResourceManager\Definitions;

class NodesParser extends Definitions
{
    /**
     * Resource Manager Nodes API parameters,
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Validate Nodes API state.
     *
     * @return string
     */
    final protected function state()
    {
        if (!array_key_exists('state', $this->parameters))
        {
            return null;
        }

        Definitions::validateNodesStatus($this->parameters['state']);
        return $this->parameters['state'];
    }

    /**
     * Validate Nodes API healthy.
     *
     * @return string
     */
    final protected function healthy()
    {
        if (!array_key_exists('healthy', $this->parameters))
        {
            return null;
        }

        return $this->parameters['healthy'];
    }

    /**
     * Parse/validate Nodes API parameters.
     *
     * @param  array $parameters Application API parameters
     * @return array
     */
    final public function nodesParser(array $parameters)
    {
        $this->parameters = $parameters;
        return [
            'state'     => $this->state(),
            'healthy'   => $this->healthy(),
        ];
    }

}

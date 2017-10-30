<?php
namespace YarnResourceManager\Parsers;

use YarnResourceManager\Definitions;

class AppstatisticsParser extends Definitions
{
    /**
     * Resource Manager Appstatistics API parameters,
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Validate Appstatistics API states.
     *
     * @return string
     */
    final protected function state()
    {
        if (!array_key_exists('states', $this->parameters))
        {
            return null;
        }

        $states = preg_split("/[\s,]+/", $this->parameters['states']);
        foreach ($states as $state)
        {
            Definitions::validateApplicationState($state);
        }
        return implode(',', $states);
    }

    /**
     * Validate Appstatistics API application types.
     *
     * @return string
     */
    final protected function applicationTypes()
    {
        if (!array_key_exists('applicationTypes', $this->parameters))
        {
            return null;
        }
        return $this->parameters['applicationTypes'];
    }

    /**
     * Parse/validate Appstatistics API parameters.
     *
     * @param  array $parameters Appstatistics API parameters
     * @return array
     */
    final public function appstatisticsParser(array $parameters)
    {
        $this->parameters = $parameters;
        return [
            'states'            => $this->state(),
            'applicationTypes'  => $this->applicationTypes(),
        ];
    }

}

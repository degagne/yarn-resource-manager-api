<?php
namespace YarnResourceManager\Parsers;

use YarnResourceManager\Definitions;

class ApplicationParser extends Definitions
{
    /**
     * Resource Manager Application API parameters,
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Validate Application API states.
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
     * Validate Application API final status.
     *
     * @return string
     */
    final protected function finalStatus()
    {
        if (!array_key_exists('finalStatus', $this->parameters))
        {
            return null;
        }

        Definitions::validateApplicationFinalStatus($this->parameters['finalStatus']);
        return $this->parameters['finalStatus'];
    }

    /**
     * Validate Application API user.
     *
     * @return string
     */
    final protected function user()
    {
        if (!array_key_exists('user', $this->parameters))
        {
            return null;
        }
        return $this->parameters['user'];
    }

    /**
     * Validate Application API queue.
     *
     * @return string
     */
    final protected function queue()
    {
        if (!array_key_exists('queue', $this->parameters))
        {
            return null;
        }
        return $this->parameters['queue'];
    }

    /**
     * Validate Application API limit.
     *
     * @return string
     */
    final protected function limit()
    {
        if (!array_key_exists('limit', $this->parameters))
        {
            return null;
        }
        return $this->parameters['limit'];
    }

    /**
     * Validate Application API startedTimeBegin timestamp.
     *
     * @return string
     */
    final protected function startedTimeBegin()
    {
        if (!array_key_exists('startedTimeBegin', $this->parameters))
        {
            return null;
        }

        if (($started_time_begin = strtotime($this->parameters['startedTimeBegin']) * 1000) === false)
        {
            throw new \RuntimeException("Failed to convert/validate startedTimeBegin paramter: {$started_time_begin}");
        }
        return $started_time_begin;
    }

    /**
     * Validate Application API startedTimeEnd timestamp.
     *
     * @return string
     */
    final protected function startedTimeEnd()
    {
        if (!array_key_exists('startedTimeEnd', $this->parameters))
        {
            return null;
        }

        if (($started_time_end = strtotime($this->parameters['startedTimeEnd']) * 1000) === false)
        {
            throw new \RuntimeException("Failed to convert/validate startedTimeEnd paramter: {$started_time_end}");
        }
        return $started_time_end;
    }

    /**
     * Validate Application API finishedTimeBegin timestamp.
     *
     * @return string
     */
    final protected function finishedTimeBegin()
    {
        if (!array_key_exists('finishedTimeBegin', $this->parameters))
        {
            return null;
        }

        if (($finished_from_begin = strtotime($this->parameters['finishedTimeBegin']) * 1000) === false)
        {
            throw new \RuntimeException("Failed to convert/validate finishedTimeBegin paramter: {$finished_from_begin}");
        }
        return $finished_from_begin;
    }

    /**
     * Validate Application API finishedTimeEnd timestamp.
     *
     * @return string
     */
    final protected function finishedTimeEnd()
    {
        if (!array_key_exists('finishedTimeEnd', $this->parameters))
        {
            return null;
        }

        if (($finished_from_end = strtotime($this->parameters['finishedTimeEnd']) * 1000) === false)
        {
            throw new \RuntimeException("Failed to convert/validate finishedTimeEnd paramter: {$finished_from_end}");
        }
        return $finished_from_end;
    }

    /**
     * Validate Application API application types.
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
     * Parse/validate Application API parameters.
     *
     * @param  array $parameters Application API parameters
     * @return array
     */
    final public function applicationParser(array $parameters)
    {
        $this->parameters = $parameters;
        return [
            'states'            => $this->state(),
            'finalStatus'       => $this->finalStatus(),
            'user'              => $this->user(),
            'queue'             => $this->queue(),
            'limit'             => $this->limit(),
            'startedTimeBegin'  => $this->startedTimeBegin(),
            'startedTimeEnd'    => $this->startedTimeEnd(),
            'finishedTimeBegin' => $this->finishedTimeBegin(),
            'finishedTimeEnd'   => $this->finishedTimeEnd(),
            'applicationTypes'  => $this->applicationTypes(),
        ];
    }

}

<?php
namespace YarnResourceManager;

abstract class Definitions
{
    /**
     * Resource Manager API states.
     *
     * @var array
     */
    public static $APPLICATION_STATES = [
        'NEW',
        'NEW_SAVING',
        'SUBMITTED',
        'ACCEPTED',
        'RUNNING',
        'FINISHED',
        'FAILED',
        'KILLED',
    ];

    /**
     * Resource Manager API final statues.
     *
     * @var array
     */
    public static $FINAL_STATUS = [
        'FAILED',
        'KILLED',
        'SUCCEEDED',
        'UNDEFINED'
    ];

    /**
     * Nodes API states.
     *
     * @var array
     */
    public static $NODES_STATES = [
        'NEW',
        'RUNNING',
        'UNHEALTHY',
        'DECOMMISSIONED',
        'LOST',
        'REBOOTED',
    ];

    /**
     * Validate Resource Manager API application state.
     *
     * @param  string $state application state
     * @param  void
     */
    final public static function validateApplicationState($state)
    {
        if (!in_array($state, self::$APPLICATION_STATES))
        {
            throw new \OutofBoundsException("Illegal application state {$state}.");
        }
    }

    /**
     * Validate Resource Manager API application final status.
     *
     * @param  string $final_status application final status
     * @param  void
     */
    final public static function validateApplicationFinalStatus($final_status)
    {
        if (!in_array($final_status, self::$FINAL_STATUS))
        {
            throw new \OutofBoundsException("Illegal application final status {$final_status}.");
        }
    }

    /**
     * Validate Resource Manager API nodes state.
     *
     * @param  string $state nodes state
     * @param  void
     */
    final public static function validateNodesStatus($state)
    {
        if (!in_array($state, self::$NODES_STATES))
        {
            throw new \OutofBoundsException("Illegal nodes API state {$state}.");
        }
    }
}

<?php
namespace YarnResourceManager;

use YarnResourceManager\Parsers\ApplicationParser;
use YarnResourceManager\Parsers\AppstatisticsParser;
use YarnResourceManager\Parsers\NodesParser;

/**
 * ResourceManager class.
 *
 * https://hadoop.apache.org/docs/stable/hadoop-yarn/hadoop-yarn-site/ResourceManagerRest.html
 */
class ResourceManager extends Request
{
    /**
     * Resource Manager REST API URL.
     *
     * @var string
     */
    protected $url;

    /**
     * Resource Manager REST API port.
     *
     * @var int
     */
    protected $port = 8088;

    /**
     * Output format type.
     *
     * @var int
     */
    public $format;

    /**
     * Constructor.
     *
     * @param  string $url    Resource Manager REST API URL
     * @param  int    $port   Resource Manager REST API port
     * @param  string $format output format (default, json or xml)
     * @return void
     */
    public function __construct($url, $port = 8088, $format = null)
    {
        $this->url = $url;
        $this->port = $port;
        $this->format = ($format === null) ? Request::FORMAT_DEFAULT : $format;
    }

    /**
     * An application resource contains information about a particular
     * application that was submitted to a cluster.
     *
     * @param  array $application_id application ID
     * @return mixed information pertaining to a specific application ID
     */
    final public function application($application_id)
    {
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/apps/{$application_id}";
        return $this->request($uri);
    }

    /**
     * With the Applications API, you can obtain a collection of resources,
     * each of which represents an application. When you run a GET operation
     * on this resource, you obtain a collection of Application Objects.
     *
     * Supported parameters include:
     * -    states              applications matching the given application
     *                          states, specified as a comma-separated list
     *                          (NEW, NEW_SAVING, SUBMITTED, ACCEPTED, RUNNING
     *                          FINISHED, FAILED or KILLED).
     * -    finalStatus         the final status of the application - reported
     *                          by the application itself (FAILED, KILLED,
     *                          SUCCEEDED, UNDEFINED).
     * -    user                user name
     * -    queue               queue name
     * -    limit               total number of app objects to be returned
     * -    startedTimeBegin    applications with start time beginning with this
     *                          time, specified in ms since epoch
     * -    startedTimeEnd      applications with start time ending with this time,
     *                          specified in ms since epoch
     * -    finishedTimeBegin   applications with finish time beginning with this time,
     *                          specified in ms since epoch
     * -    finishedTimeEnd     applications with finish time ending with this time,
     *                          specified in ms since epoch
     * -    applicationTypes    applications matching the given application types,
     *                          specified as a comma-separated list (ie TEZ, SPARK).
     *
     * @param  array $parameters api request parameters
     * @return mixed application objects
     */
    final public function applications(array $parameters = [])
    {
        $parser = new ApplicationParser();
        $params = $parser->applicationParser($parameters);
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/apps";
        return $this->request($uri, $params);
    }

    /**
     * With the Application Statistics API, you can obtain a collection of
     * triples, each of which contains the application type, the application
     * state and the number of applications of this type and this state in
     * ResourceManager context. Note that with the performance concern, we
     * currently only support at most one applicationType per query. We may
     * support multiple applicationTypes per query as well as more statistics
     * in the future. When you run a GET operation on this resource, you
     * obtain a collection of statItem objects.
     *
     * Supported parameters include:
     *  -   states              states of the applications, specified as a
     *                          comma-separated list. If states is not
     *                          provided, the API will enumerate all application
     *                          states and return the counts of them.
     * -    applicationTypes    types of the applications, specified as a
     *                          comma-separated list. If applicationTypes is not
     *                          provided, the API will count the applications of
     *                          any application type. In this case, the response
     *                          shows * to indicate any application type.
     *
     * @param  array $parameters api request parameters
     * @return mixed application statistics
     */
    final public function appstatistics(array $parameters = [])
    {
        $parser = new AppstatisticsParser();
        $params = $parser->appstatisticsParser($parameters);

        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/appstatistics";
        return $this->request($uri, $params);
    }

    /**
     * The cluster information resource provides overall
     * information about the cluster.
     *
     * @return mixed cluster information about the cluster
     */
    final public function info()
    {
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/info";
        return $this->request($uri);
    }

    /**
     * The cluster metrics resource provides some overall
     * metrics about the cluster.
     *
     * @return mixed cluster metrics about the cluster
     */
    final public function metrics()
    {
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/metrics";
        return $this->request($uri);
    }

    /**
     * Obtain a collection of resources, each of which represents a node.
     * When you run a GET operation on this resource, you obtain a collection
     * of Node Objects.
     *
     * Supported parameters include:
     *  - state:   the state of the node (NEW, RUNNING, UNHEALTHY,
     *                                    DECOMMISSIONED, LOST, REBOOTED)
     *  - healthy: true | false
     *
     * @param  array $parameters api request parameters
     * @return mixed cluster nodes information | false for error
     */
    final public function nodes(array $parameters)
    {
        $parser = new NodesParser();
        $params = $parser->nodesParser($parameters);
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/nodes";
        return $this->request($uri, $params);
    }

    /**
     * A node resource contains information about a node in the cluster.
     *
     * @param  int $nodeid node ID
     * @return mixed cluster nodes information | false for error
     */
    final public function node($nodeid)
    {
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/nodes/{$nodeid}";
        return $this->request($uri);
    }

    /**
     * A scheduler resource contains information about the current scheduler
     * configured in a cluster. It currently supports both the Fifo and
     * Capacity Scheduler. You will get different information depending on
     * which scheduler is configured so be sure to look at the type information.
     *
     * @return mixed cluster metrics about the cluster
     */
    final public function scheduler()
    {
        $uri = "{$this->url}:{$this->port}/ws/v1/cluster/scheduler";
        return $this->request($uri);
    }
}

<?php

namespace Dlima\LaravelActuator\Repository;
use Dlima\LaravelActuator\Domain\Metrics;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;

class MetricsRepository
{
    private $config;
    private $app;

    public function __construct(ConfigRepository $config, Application $app )
    {
        $this->config   = $config;
        $this->app      = $app;
    }

    public function getMetrics()
    {
        $metrics = new Metrics;
        $metrics->mem       = $this->getMemoryAllocated();
        $metrics->memFree   = $this->getMemoryFree();
        $metrics->uptime    = $this->getUptime();
        return $metrics;
    }

    /**
     * Return the maximum memory allocated to php in kbytes
     */
    public function getMemoryAllocated()
    {
        return ( (int) ini_get('memory_limit') ) * 1024;
    }

    /**
     * Return the memory usage in kbytes
     */
    public function getMemoryUsage()
    {
        return memory_get_usage(true) / 1024;
    }

    /**
     * Return the memory free in kbytes
     */
    public function getMemoryFree()
    {
        return (int) ($this->getMemoryAllocated() - $this->getMemoryUsage());
    }

    /**
     * Return the machine server uptime in miliseconds
     */
    public function getUptime()
    {
        return ((int) (strtok( exec( "cat /proc/uptime" ), "." )) * 1000) ?: 0;
    }
}
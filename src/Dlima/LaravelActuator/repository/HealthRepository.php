<?php

namespace Dlima\LaravelActuator\Repository;
use Dlima\LaravelActuator\Domain\Health;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Application;

class HealthRepository
{
    private $config;
    private $app;

    public function __construct(ConfigRepository $config, Application $app )
    {
        $this->config   = $config;
        $this->app      = $app;
    }

    public function getHealth()
    {
        $health = new Health;
        $health->status   = $this->getStatus();
        $health->database = $this->getDatabase();
        return $health;
    }

    public function getStatus()
    {
        return $this->app->isDownForMaintenance() ? 'DOWN' : 'UP';
    }

    public function getDatabase()
    {
        return $this->config->get('database.default');
    }
}
<?php

namespace Dlima\LaravelActuator;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Dlima\LaravelActuator\Repository\HealthRepository;
use Dlima\LaravelActuator\Repository\MetricsRepository;

class ActuatorController extends Controller
{
    private $healthRepository;
    private $metricsRepository;

    public function __construct(HealthRepository $healthRepository,
                                MetricsRepository $metricsRepository)
    {
        $this->healthRepository = $healthRepository;
        $this->metricsRepository = $metricsRepository;
    }

    public function health()
    {
        return new JsonResponse($this->healthRepository->getHealth());
    }

    public function metrics()
    {
        return new JsonResponse($this->metricsRepository->getMetrics());
    }

    public function responseWhenDown()
    {
        $path = isset($_SERVER['PATH_INFO']) ? explode("/", $_SERVER['PATH_INFO']) : [];

        if (isset($path[0]) && isset($path[1])) {
            if ($path[0] == 'health' || $path[1] == 'health') {
                return $this->health();
            } else if ($path[0] == 'metrics' || $path[1] == 'metrics') {
                return $this->metrics();
            }
        }
    }
}
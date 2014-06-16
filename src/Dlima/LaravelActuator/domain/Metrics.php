<?php

namespace Dlima\LaravelActuator\Domain;

use Illuminate\Support\Contracts\JsonableInterface;

class Metrics implements JsonableInterface
{
    public $mem;
    public $memFree;
    public $uptime;

    public function toJson($options = 0) {
        return json_encode([
            'mem'       => $this->mem,
            'mem.free'  => $this->memFree,
            'uptime'    => $this->uptime,
        ], $options);
    }
}
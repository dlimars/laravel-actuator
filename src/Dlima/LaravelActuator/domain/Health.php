<?php

namespace Dlima\LaravelActuator\Domain;

use Illuminate\Support\Contracts\JsonableInterface;

class Health implements JsonableInterface
{
    public $status;
    public $database;

    public function toJson($options = 0) {
        return json_encode([
            'status'    => $this->status,
            'database'  => $this->database
        ], $options);
    }
}
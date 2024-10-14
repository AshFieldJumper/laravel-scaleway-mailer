<?php

namespace ashfieldjumper\LaravelScalewayMailer\Events;

class ScalewayEmailSent
{
    public $response;

    /**
     * Create a new event instance.
     *
     * @param array $response
     * @return void
     */
    public function __construct(mixed $response)
    {
        $this->response = $response;
    }
}
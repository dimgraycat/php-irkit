<?php

namespace Irkit\Test;

use Irkit\DeviceClient as IrkitClient;

class IrkitClientTest extends IrkitClient {
    public $config = [];
    public $client;
    public function __construct(array $config = []) {
        $this->config   = array_merge($this->config, $this->headers);
        $this->config   = array_merge($this->config, $config);
        $this->client   = new HttpClientTest($this->config);
    }
    public function post($uri, array $config) {
        return parent::post($uri, $config);
    }
}


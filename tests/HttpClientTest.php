<?php
namespace Irkit\Test;

use \GuzzleHttp\Client as HttpClient;

class HttpClientTest extends HttpClient {
    private $__statusCode;
    public function post($uri, $config) {
        return $this;
    }
    public function setStatusCode($code) {
        $this->__statusCode = $code;
    }
    public function getStatusCode() {
        if (!$this->__statusCode) {
            return 200;
        }
        return $this->__statusCode;
    }
    public function getBody() {
        return 'success';
    }
}


<?php
namespace Irkit\Test;

use GuzzleHttp\Client as HttpClient;
use Irkit\DeviceClient as IrkitClient;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends HttpClient {
    private $__statusCode;
    public function post($uri, $config) {
        return $this;
    }
    public function setStatusCode($code) {
        $this->__statusCode = $code;
    }
    public function getStatusCode() {
        return $this->__statusCode;
    }
    public function getBody() {
        return 'success';
    }
}

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

class IrkitDeviceClientTest extends TestCase {
    public function testInstance() {
        $irkit = new IrkitClientTest();
        $this->assertEquals($irkit->config, [
            'timeout'   => 2.0,
            'headers'   => [
                'X-Requested-With'  => 'crul',
                'User-Agent'        => 'PHP-Irkit/'.IrkitClientTest::VERSION,
                'version'           => IrkitClientTest::VERSION
            ]
        ]);

        $irkit = new IrkitClientTest([
            'base_uri' => 'http://127.0.0.1/',
            'timeout'  => 60,
        ]);
        $this->assertEquals($irkit->config, [
            'timeout'   => 60,
            'base_uri'  => 'http://127.0.0.1/',
            'headers'   => [
                'X-Requested-With'  => 'crul',
                'User-Agent'        => 'PHP-Irkit/'.IrkitClientTest::VERSION,
                'version'           => IrkitClientTest::VERSION
            ]
        ]);
    }

    public function testPost() {
        $irkit = new IrkitClientTest([
            'base_uri' => 'http://127.0.0.1/',
            'timeout'  => 60,
        ]);
        $res = $irkit->post('messages', ['messages' => 'hoge']);
        $res->setStatusCode(200);
        $this->assertEquals($res->getStatusCode(), 200);
        $res->setStatusCode(404);
        $this->assertEquals($res->getStatusCode(), 404);
    }

    public function testSend() {
        $irkit = new IrkitClientTest([
            'base_uri' => 'http://127.0.0.1/',
            'timeout'  => 60,
        ]);
        $irkit->client->setStatusCode(200);
        $body = $irkit->send('messages', ['messages' => 'hoge']);
        $this->assertEquals($body, 'success');

        $irkit->client->setStatusCode(404);
        ob_start();
        $irkit->send('messages', ['messages' => 'hoge']);
        $actual = ob_get_clean();
        $expected = 'Transmission failed. The status code is 404.';
        $this->assertEquals($actual, "\033[1;31m{$expected}\033[0m");

        $irkit->client->setStatusCode(403);
        ob_start();
        $irkit->send('messages', ['messages' => 'hoge']);
        $actual = ob_get_clean();
        $expected = 'Transmission failed. The status code is 403.';
        $this->assertEquals($actual, "\033[1;31m{$expected}\033[0m");
    }
}

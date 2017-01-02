<?php
namespace Irkit;

use Garden\Cli\Cli;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ConnectException;
use Irkit\Exception as IrkitException;

class DeviceClient {
    const VERSION = '0.5.1';

    protected $headers = [
        'timeout'   => 2.0,
        'headers'   => [
            'X-Requested-With'  => 'crul',
            'User-Agent'        => 'PHP-Irkit/'.self::VERSION,
            'version'           => self::VERSION,
        ]
    ];
    protected $config = [];
    protected $client;

    public function __construct(array $config = []) {
        $this->config   = array_merge($this->config, $this->headers);
        $this->config   = array_merge($this->config, $config);
        $this->client   = new HttpClient($this->config);
    }

    public function send($uri, array $options = []) {
        try {
            $config = array_merge($this->config, ['json' => $options]);
            $res = $this->post($uri, $config);
            if ($res->getStatusCode() != 200) {
                throw new IrkitException(
                    'Transmission failed. The status code is '.$res->getStatusCode().'.'
                );
            }
            return $res->getBody();
        }
        catch (ConnectException $e) {
            echo Cli::redText($e->getMessage());
        }
        catch (IrkitException $e) {
            echo Cli::redText($e->getMessage());
        }
    }

    protected function post($uri, array $config) {
        return $this->client->post($uri, $config);
    }
}

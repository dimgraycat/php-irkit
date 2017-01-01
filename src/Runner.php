<?php
namespace Irkit;

use Irkit\DeviceClient;

class Runner {
    private $files = [
        'config'    => 'config.json',
        'messages'  => 'messages.json',
    ];

    private static $instance, $irkit;
    private $config = [];

    public function __construct($command, $dir) {
        $file = $this->files[$command];
        foreach(['config', $command] as $key) {
            if (!array_key_exists($key, $this->files)) {
                continue;
            }
            $filePath = vsprintf('%s%s',[
                $dir, $this->files[$key]
            ]);
            $realPath = realpath($filePath);
            $json = file_get_contents(realpath($filePath));
            $this->config = array_merge($this->config, json_decode($json, true));
        }
        if (isset($this->config['php']) && isset($this->config['php']['timezone'])) {
            date_default_timezone_set($this->config['php']['timezone']);
        }
    }

    public static function execute($command, $dir, array $args = []) {
        self::$instance = new self($command, $dir);
        self::$irkit = new DeviceClient(self::$instance->config['http']);
        self::$instance->$command($args);
    }

    protected function messages($args) {
        $settings   = self::$instance->config['settings'];
        foreach ($args as $idx => $value) {
            if ($idx != 0) usleep($this->config['delay'] * 1000);
            list($name, $power) = explode(':', $value);
            $message = json_encode($settings[$name][$power]);
            self::$irkit->send('messages', ['message' => $message]);
        }
    }

    protected function keys() {
        echo self::$irkit->send('keys')."\n";
    }
}

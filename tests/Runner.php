<?php
namespace Irkit\Test;

use Irkit\Test\HttpClientTest;
use Irkit\Test\IrkitClientTest;
use Irkit\Runner;
use PHPUnit\Framework\TestCase;

class IrkitRunnerTest extends Runner {
    public $config = [];
    public static function execute($command, $dir, array $args = []) {
        self::$instance = new self($command, $dir);
        self::$irkit = new IrkitClientTest(self::$instance->config['http']);
        return self::$instance->$command($args);
    }
}

class RunnerTest extends TestCase {
    public function testInstance() {
        $runner = new IrkitRunnerTest('keys', './tests/');
        $this->assertArrayHasKey('http', $runner->config);

        $runner = new IrkitRunnerTest('messages', './tests/');
        $this->assertArrayHasKey('http', $runner->config);
        $this->assertArrayHasKey('delay', $runner->config);
        $this->assertArrayHasKey('settings', $runner->config);
    }

    public function testMessages() {
        $actual = IrkitRunnerTest::execute('messages', './tests/', ['tv:on', 'light:on']);
        $this->assertTrue($actual, true);
    }

    public function testKeys() {
        ob_start();
        IrkitRunnerTest::execute('keys', './tests/');
        $actual = ob_get_clean();
        $expected = "success\n";
        $this->assertEquals($actual, $expected);
    }
}


#!/usr/bin/env php
<?php
require_once __DIR__.'/../vendor/autoload.php';

use Garden\Cli\Cli;
use Irkit\DeviceClient as IrkitClient;
use Irkit\Runner as IrkitRunner;

$cli = new Cli();
if (!isset($argv[1])) {
    $argv[1] = '--help';
}
$res = null;
switch ($argv[1]) {
    case '-?':
    case '--help':
        phpIrkitDefaultHelp($argv, $cli);
        break;
    case 'config':
        $res = phpIrkitConfigGenerator($argv, $cli);
        Irkit\Config::create(
            $res->getOpt('ip-address', '127.0.0.1')
        );
        break;
    case 'messages':
        $res = phpIrkitMessages($argv, $cli);
        break;
    case 'keys':
        $res = phpIrkitKeys($cli);
        break;
    default:
        $argv[1] = '--help';
        phpIrkitDefaultHelp($argv, $cli);
}

IrkitRunner::execute(
    $res->getCommand(),
    $res->getOpt('dir', './'),
    getIrkitArgs($res->getArgs())
);

function getIrkitArgs($values) {
    $args = [];
    foreach ($values as $idx => $data) {
        $args[] = $data;
    }
    return $args;
}

function phpIrkitDefaultHelp($argv, $cli) {
    $cli->description(
        'phpirkit version '.Cli::greenText(IrkitClient::VERSION)."\n".
        "IRKit Device HTTP API Commander\n".
        "See: http://getirkit.com/en/"
    )
        ->arg('config', "[<options>] <args>\n--help\t show config command help.", true)
        ->arg('messages', "[<options>] <args>\n--help\t show messages command help.", true)
        ->arg('keys', "get clienttoken", true);
    $cli->parse($argv, true);
    exit(1);
}

function phpIrkitConfigGenerator($argv, $cli) {
    if (!isset($argv[2])) {
        $argv[2] = '--help';
    }
    $cli->command('config')
        ->description('create create.json and messages.json.')
        ->opt('ip-address:i', 'Specify the IP address of your IRKit.', true);
    return $cli->parse($argv, true);
}

function phpIrkitKeys($cli) {
    $cli->command('keys')
        ->opt('dir:d', 'If specified, use the given directory as working directory.', false);
    return $cli->parse();
}

function phpIrkitMessages($argv, $cli) {
    if (!isset($argv[2])) {
        $argv[2] = '--help';
    }
    $cli->command('messages')
        ->description('Send IR signal.')
        ->opt('dir:d', 'If specified, use the given directory as working directory.', false)
        ->arg('name:power', "e.g.)\n phpirkit messages tv:on\n phpirkit messages tv:on light:on", true);
    return $cli->parse($argv, true);
}

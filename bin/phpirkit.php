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
        ->arg('messages', "[<options>] <args>\n--help\t show messages command help.", true)
        ->arg('keys', "get clienttoken", true);
    $cli->parse($argv, true);
    exit(1);
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
